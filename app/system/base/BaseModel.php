<?php

use \App;
use \Valitron\Validator;

class BaseModel extends App
{
    protected $_cols = [];

    protected $_where = [];

    protected $_errors = [];

    public function __construct()
    {
        if ($this->tableName() != null && $this->fields() != null) {
            $this->_cols = array_flip($this->fields());
            foreach ($this->_cols as $key => $value) {
                $this->_cols[$key] = isset($_POST[$key]) ? $_POST[$key] : null;
            }
        }
    }

    public function __get($key)
    {
        if (array_key_exists($key, $this->_cols)) {
            return $this->_cols[$key];
        }
        return $this->canGetAttribute($key);
    }

    public function __set($key, $value)
    {
        if (array_key_exists($key, $this->_cols)) {
            $this->_cols[$key] = $value;
        } else {
            $this->canSetAttribute($key, $value);
        }
    }

    public function canGetAttribute($key)
    {
        $attribute = 'get' . $key;
        if (method_exists($this, $attribute)) {
            return $this->$attribute();
        }
        throw new Exception("Can't get $key");
        
    }

    public function canSetAttribute($key, $value)
    {
        $attribute = 'set' . $key;
        if (method_exists($this, $attribute)) {
            $this->$attribute($value);
        } else {
            throw new Exception("Can't set $key");
        }
        
    }

    public function tableName()
    {
        return null;
    }

    public function fields()
    {
        return [];
    }

    public function attributeLabel($attribute)
    {
        $labels = $this->attributeLabels();
        if (array_key_exists($attribute, $labels)) {
            return $labels[$attribute];
        } elseif (array_key_exists($attribute, $this->_cols)) {
            // http://stackoverflow.com/questions/5546120/php-capitalize-after-dash
            return str_replace('_', ' ', preg_replace_callback('/(\w+)/g', create_function('$m','return ucfirst($m[1]);'), $attribute));
        } elseif (method_exists($this, 'get' . $attribute)) {
            // http://stackoverflow.com/questions/6254093/how-to-parse-camel-case-to-human-readable-string
            return ucwords(preg_replace(array('/(?<=[^A-Z])([A-Z])/', '/(?<=[^0-9])([0-9])/'), ' $0', $attribute));
        }
        return false;
    }

    public function attributeLabels()
    {
        return [
            // example
            // 'created_at' => 'Created At'
        ];
    }

    public function rules()
    {
        /**
        * required - Required field
        * equals - Field must match another field (email/password confirmation)
        * different - Field must be different than another field
        * accepted - Checkbox or Radio must be accepted (yes, on, 1, true)
        * numeric - Must be numeric
        * integer - Must be integer number
        * array - Must be array
        * length - String must be certain length
        * lengthBetween - String must be between given lengths
        * lengthMin - String must be greater than given length
        * lengthMax - String must be less than given length
        * min - Minimum
        * max - Maximum
        * in - Performs in_array check on given array values
        * notIn - Negation of in rule (not in array of values)
        * ip - Valid IP address
        * email - Valid email address
        * url - Valid URL
        * urlActive - Valid URL with active DNS record
        * alpha - Alphabetic characters only
        * alphaNum - Alphabetic and numeric characters only
        * slug - URL slug characters (a-z, 0-9, -, _)
        * regex - Field matches given regex pattern
        * date - Field is a valid date
        * dateFormat - Field is a valid date in the given format
        * dateBefore - Field is a valid date and is before the given date
        * dateAfter - Field is a valid date and is after the given date
        * contains - Field is a string and contains the given string
        * creditCard - Field is a valid credit card number
        * instanceOf - Field contains an instance of the given class
        */ 
        return [
            // example
            // 'required' => ['name', 'email', 'password']
        ];
    }

    public function messages()
    {
        return [
            // example
            // 'required' => '{field} harus diisi gan.'
        ];
    }

    public function validate()
    {
        /**
        * Load custom rule method(s) and adding to Validator.
        * example method like:
        *
        * public function ruleAlwaysFail() {
        *     return [
        *         'message' => 'Everything you do is wrong. You fail.',
        *         'function' => function($field, $value, array $params) {return false;},
        *     ];
        * }
        */
        foreach (get_class_methods($this) as $func) {
            if (substr($func, 0, 4) == 'rule' && $func != 'rules') {
                Validator::addRule(lcfirst(substr($func, 4)), $this->$func()['function'], $this->$func()['message']);
            }
        }

        $validator = new Validator($this->_cols);
        if (! $this->isNewRecord()) {
            $validator = new Validator(App::db()->get($this->tableName(), '*', $this->_where));
        }
        foreach ($this->rules() as $key => $value) {
            if (array_key_exists($key, $this->messages())) {
                $validator->rule($key, $value)->message($this->messages()[$key]);
                $labels = [];
                foreach ($value as $key1) {
                    if ($this->attributeLabel($key1) === false) {
                        $labels[$key1] = 'This field';
                    } else {
                        $labels[$key1] = $this->attributeLabel($key1);
                    }
                }
                $validator->labels($labels);
            } else {
                $validator->rule($key, $value);
            }
        }
        if ($validator->validate()) {
            return true;
        } else {
            $this->_errors = $validator->errors();
            return false;
        }
    }

    public function load($request)
    {
        if ($request == null) {
            return false;
        }
        foreach ($this->_cols as $key => $value) {
            if (array_key_exists($key, $request)) {
                $this->$key = $request[$key];
            }
        }
        foreach (get_class_methods($this) as $func) {
            if (substr($func, 0, 3) == 'set') {
                $attribute = lcfirst(substr($func, 3));
                if (array_key_exists($attribute, $request)) {
                    $this->$attribute = $request[$attribute];
                }
            }
        }

    }

    public function beforeSave()
    {
        return true;
    }

    public function afterSave()
    {
        return true;
    }

    public function save()
    {
        $data = [];
        foreach ($this->_cols as $key => $value) {
            if ($value != null) {
                $data[$key] = $value;
            }
        }
        if ($this->validate() && $this->beforeSave()) {
            $this->afterSave();
            if ($this->isNewRecord()) {
                return App::db()->insert($this->tableName(), $data);
            } else {
                return App::db()->update($this->tableName(), $data, $this->_where);
            }
        }
        return false;
    }

    public static function find()
    {
        $class = static::className();
        return new $class;

    }

    public function where($where=[])
    {
        $this->_where = $where;
        return $this;
    }

    public function all()
    {
        $results = [];
        foreach (App::db()->select($this->tableName(), '*', $this->_where) as $row) {
            foreach (get_class_methods($this) as $func) {
                if (substr($func, 0, 3) == 'get') {
                    foreach ($this->_cols as $key => $value) {
                        $this->$key = $row[$key];
                    }
                    $row[lcfirst(substr($func, 3))] = $this->$func();
                }
            }
            $results[] = (object) $row;
        }
        return $results;
    }

    public function one()
    {
        $results = App::db()->get($this->tableName(), '*', $this->_where);
        foreach (get_class_methods($this) as $func) {
            if (substr($func, 0, 3) == 'get') {
                foreach ($this->_cols as $key => $value) {
                    $this->$key = $results[$key];
                }
                $results[lcfirst(substr($func, 3))] = $this->$func();
            }
        }
        return (object) $results;
    }

    public function beforeDelete()
    {
        return true;
    }

    public function delete()
    {
        if ($this->_where != null && $this->beforeDelete()) {
            return App::db()->delete($this->tableName(), $this->_where);
        }
        return false;
    }

    public function count()
    {
        return App::db()->count($this->tableName(), $this->_where);
    }

    public function sum($column)
    {
        return App::db()->sum($this->tableName(), $column, $this->_where);
    }

    public function avg($column)
    {
        return App::db()->avg($this->tableName(), $column, $this->_where);
    }

    public function max($column)
    {
        return App::db()->max($this->tableName(), $column, $this->_where);
    }

    public function min($column)
    {
        return App::db()->min($this->tableName(), $column, $this->_where);
    }

    public function isNewRecord()
    {
        return $this->_where == null;
    }

    public function hasErrors()
    {
        return $this->_errors != null;
    }

    public function errors()
    {
        return $this->_errors;
    }

    public function hasOne($class, $datas)
    {
        $where = [];
        foreach ($datas as $key => $value) {
            $where[$key] = $this->$value;
        }
        return $class::find()->where($where)->one();
    }

    public function hasMany($class, $datas)
    {
        $where = [];
        foreach ($datas as $key => $value) {
            $where[$key] = $this->$value;
        }
        return $class::find()->where($where)->all();
    }

    public function timestampBehaviour()
    {
        if (array_key_exists('created_at', $this->_cols)) {
            if ($this->isNewRecord()) {
                $this->created_at = time();
            }
        } elseif (array_key_exists('updated_at', $this->_cols)) {
            $this->updated_at = time();
        }
    }

}