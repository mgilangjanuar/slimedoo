<?php

use \App;

class BaseModel extends App
{
    public $scenario = [];
    
    protected $_cols = [];

    protected $_where = [];

    protected $_join = [];

    public function __construct()
    {
        if ($this->tableName() != null && $this->fields() != null) {
            $this->_cols = array_flip($this->fields());
            foreach ($this->_cols as $key => $value) {
                $this->_cols[$key] = isset($_POST[$this->tableName()][$key]) ? $_POST[$this->tableName()][$key] : null;
            }
            foreach (get_object_vars($this) as $key => $value) {
                if ($key != 'scenario' && $key[0] != '_') {
                    $this->$key = isset($_POST[$this->tableName()][$key]) ? $_POST[$this->tableName()][$key] : null;
                }
            }
            foreach (get_class_methods($this) as $func) {
                if (substr($func, 0, 3) == 'set') {
                    $attribute = lcfirst(substr($func, 3));
                    $this->$attribute = isset($_POST[$this->tableName()][$attribute]) ? $_POST[$this->tableName()][$attribute] : null;
                }
            }
        }
    }

    public function __get($key)
    {
        $attribute = 'get' . $key;
        if (array_key_exists($key, $this->_cols)) {
            return $this->_cols[$key];
        } elseif (method_exists($this, $attribute)) {
            return $this->$attribute();
        } else {
            throw new Exception("Can't get $key");
        }
    }

    public function __set($key, $value)
    {
        $attribute = 'set' . $key;
        if (array_key_exists($key, $this->_cols)) {
            $this->_cols[$key] = $value;
        } elseif (method_exists($this, $attribute)) {
            $this->$attribute($value);
        } else {
            throw new Exception("Can't set $key");
        }
    }

    public static function find($where=[])
    {
        $class = static::className();
        $class = new $class;
        $class->where($where);
        return $class;
    }

    public static function findOne($where=[])
    {
        $class = static::className();
        $class = new $class;
        $class->where($where);
        return $class->one();
    }

    public function tableName()
    {
        return null;
    }

    public function fields()
    {
        if ($this->tableName() != null) {
            $fields = [];
            $datas = $query = App::db()->query("SHOW columns FROM " . $this->tableName() . ";")->fetchAll();
            foreach ($datas as $data) {
                if ($data['Key'] == 'PRI') {
                    $fields[] = $data['Field'];
                }
            }
            foreach ($datas as $data) {
                if (! in_array($data['Field'], $fields)) {
                    $fields[] = $data['Field'];
                }
            }
            return $fields;
        }
    }

    public function attributeLabel($attribute)
    {
        $labels = $this->attributeLabels();
        if (array_key_exists($attribute, $labels)) {
            return $labels[$attribute];
        } elseif (array_key_exists($attribute, $this->_cols)) {
            if ($attribute == 'id') {
                return 'ID';
            } else {
                // http://stackoverflow.com/questions/5546120/php-capitalize-after-dash
                return str_replace('_', ' ', preg_replace_callback('/(\w+)/', create_function('$m','return ucfirst($m[1]);'), $attribute));
            }
        } elseif (method_exists($this, 'get' . $attribute)) {
            // http://stackoverflow.com/questions/6254093/how-to-parse-camel-case-to-human-readable-string
            return ucwords(preg_replace(array('/(?<=[^A-Z])([A-Z])/', '/(?<=[^0-9])([0-9])/'), ' $0', $attribute));
        }
        return $attribute;
    }

    public function attributeLabels()
    {
        return [];
    }

    public function rules()
    {
        return [
            // [['name'], 'required'],
            // [['price'], 'max(3)'],
        ];
    }

    public function validate($attribute)
    {
        $results = [];
        foreach ($this->scenario as $scene) {
            if (is_string($scene[0])) {
                if ($scene[0] == $attribute) {
                    $results[] = $scene[1];
                }
            } else {
                if (in_array($attribute, $scene[0])) {
                    $results[] = $scene[1];
                }
            }
        }
        foreach ($this->rules() as $rule) {
            if (is_string($rule[0])) {
                if ($rule[0] == $attribute) {
                    $results[] = $rule[1];
                }
            } else {
                if (in_array($attribute, $rule[0])) {
                    $results[] = $rule[1];
                }
            }
        }
        $result = implode(',', $results);
        return $result;
    }

    public function loadCustomValidation()
    {
        $result = '';
        foreach (get_class_methods($this) as $funcRule) {
            if (substr($funcRule, 0, 4) == 'rule' && $funcRule != 'rules') {
                $result .= '$.verify.addRules({
                    '. lcfirst(substr($funcRule, 4)) .': '. $this->$funcRule() .'
                });';
            }
        }
        return $result;
    }

    public function scenario($value)
    {
        return null;
    }

    public function load($request)
    {
        if ($request == null) {
            return false;
        }
        foreach ($this->_cols as $key => $value) {
            if (array_key_exists($key, $request[$this->tableName()])) {
                $this->$key = $request[$this->tableName()][$key];
            }
        }
        foreach (get_object_vars($this) as $key => $value) {
            if ($key != 'scenario' && $key[0] != '_' && array_key_exists($key, $request[$this->tableName()])) {
                $this->$key = $request[$this->tableName()][$key];
            }
        }
        foreach (get_class_methods($this) as $func) {
            if (substr($func, 0, 3) == 'set') {
                $attribute = lcfirst(substr($func, 3));
                if (array_key_exists($attribute, $request[$this->tableName()])) {
                    $this->$attribute = $request[$this->tableName()][$attribute];
                }
            }
        }
        return true;
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
        if ($this->beforeSave()) {
            if ($this->isNewRecord()) {
                $id = App::db()->insert($this->tableName(), $data);
            } else {
                $id = App::db()->update($this->tableName(), $data, $this->_where);
            }
            $this->afterSave();
            return $this->where([$this->fields()[0] => $id])->one();
        }
        return false;
    }

    public function where($where=[])
    {
        $this->_where = $where;
        return $this;
    }

    public function join($join=[])
    {
        $this->_join = $join;
        return $this;
    }

    public function limit($value='')
    {
        $this->_where['LIMIT'] = $value;
        return $this;
    }

    public function orderBy($value='')
    {
        $this->_where['ORDER'] = $value;
        return $this;
    }

    public function all()
    {
        $results = [];
        if ($this->_join == null) {
            $query = App::db()->select($this->tableName(), '*', $this->_where);
        } else {
            $query = App::db()->select($this->tableName(), $this->_join, '*', $this->_where);
        }
        foreach ($query as $row) {
            foreach ($row as $key => $value) {
                if (array_key_exists($key, $this->_cols) || method_exists($this, 'set' . $key) || isset($this->$key)) {
                    $this->$key = $value;
                }
            }

            foreach (get_class_methods($this) as $func) {
                if (substr($func, 0, 3) == 'get') {
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
        if ($results != null) {
            foreach ($results as $key => $value) {
                if (array_key_exists($key, $this->_cols) || method_exists($this, 'set' . $key) || isset($this->$key)) {
                    $this->$key = $value;
                }
            }
            return $this;
        }
        return null;
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

    public function hasMany($class, $datas)
    {
        if (! isset($datas[0]) && ! isset($datas[1]) && ! isset($datas[2])) {
            $where = [];
            foreach ($datas as $key => $value) {
                $where[$key] = $this->$value;
            }
            return $class::find($where)->all();
        } else {
            $_pri = $this->fields()[0];
            $query = App::db()->select($datas[0], $datas[2], [$datas[1] => $this->$_pri]);
            $_class = new $class;
            return $class::find([$_class->fields()[0] => $query])->all();
        }
    }

    public function hasOne($class, $datas)
    {
        $where = [];
        foreach ($datas as $key => $value) {
            $where[$key] = $this->$value;
        }
        return $class::find()->where($where)->one();
    }

    public function link($class, $datas, $options=[])
    {
        if (count($datas) < 3) {
            $class->$datas[1] = $this->$datas[0];
            foreach ($options as $key => $value) {
                $class->$key = $value;
            }
        } else {
            $fromId = $this->fields()[0];
            $destId = $class->fields()[0];
            $data = [];
            $data[$datas[1]] = $this->$fromId;
            $data[$datas[2]] = $class->$destId;
            foreach ($options as $key => $value) {
                $data[$key] = $value;
            }
            App::db()->insert($datas[0], $data);
        }
        return $class;
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