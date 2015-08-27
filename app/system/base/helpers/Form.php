<?php 
namespace helpers;

use \App;

class Form extends BaseHtml
{
    public $result = '';

    public $label = '';

    public $help = '';

    public function __construct($options=[])
    {
        App::$assets->addJsFile('verifyjs/verify.min.js');
        App::$assets->addJs("
            $.verify({
                prompt: function(element, text) {
                    element.siblings('.error').html(text || '');
                    element.parent().parent().siblings('.error').html(text || '');
                    if (text != null) {
                        element.parent('.form-group').addClass('has-error');
                        element.parent().parent('.form-group').addClass('has-error');
                        element.parent().parent().parent('.form-group').addClass('has-error');
                    } else {
                        element.parent('.form-group').addClass('has-success');
                        element.parent().parent('.form-group').addClass('has-success');
                        element.parent().parent().parent('.form-group').addClass('has-success');
                    }
                }
            });
        ");
        $this->begin($options);
    }

    public function begin($options=[])
    {
        if (! array_key_exists('method', $options)) {
            $options['method'] = 'post';
        }
        if (! array_key_exists('class', $options)) {
            $options['class'] = 'form-horizontal';
        }
        $this->result = '<form' . BaseHtml::buildOptions($options) . '>';
        return $this;
    }

    public function inputText($model, $field, $options=[])
    {
        $this->registerModel($model);
        $this->result = '<div class="form-group">
            <label class="control-label">' . $this->getLabel($model, $field) . '</label>
                <div>
                    <input id="'. $model->tableName() . '-' . $field .'" data-validate="'. $model->validate($field) .'" type="text" class="form-control" value="' . $model->$field . '" name="' . $model->tableName() . '[' . $field . ']"' . BaseHtml::buildOptions($options) . '/>
                    <span class="text-danger error"></span>
                    ' . $this->getHelp() . '
                </div>
            </div>';
        return $this;
    }

    public function password($model, $field, $options=[])
    {
        $this->registerModel($model);
        $this->result = '<div class="form-group">
            <label class="control-label">' . $this->getLabel($model, $field) . '</label>
                <div>
                    <input id="'. $model->tableName() . '-' . $field .'" data-validate="'. $model->validate($field) .'" type="password" class="form-control" value="' . $model->$field . '" name="' . $model->tableName() . '[' . $field . ']"' . BaseHtml::buildOptions($options) . '/>
                    <span class="text-danger error"></span>
                    ' . $this->getHelp() . '
                </div>
            </div>';
        return $this;
    }

    public function checkBox($model, $field, $options=[])
    {
        $this->registerModel($model);
        $this->result = '<div class="form-group">
            <div class="checkbox"><div>
                <label>
                    <input type="hidden" name="' . $model->tableName() . '[' . $field .']" value="0">
                    <input id="'. $model->tableName() . '-' . $field .'" data-validate="'. $model->validate($field) .'"  value="1" type="checkbox"'. ($model->$field == null || $model->$field == 0 ? '' : ' checked ') . '" name="' . $model->tableName() . '[' . $field . ']"' . BaseHtml::buildOptions($options) . '> ' . $this->getLabel($model, $field) . '
                </label>
            </div><span class="text-danger error"></span>' . $this->getHelp() . '</div>
        </div>';
        return $this;
    }

    public function textArea($model, $field, $options=[])
    {
        $this->registerModel($model);
        $this->result = '<div class="form-group">
            <label for="textArea" class="control-label">' . $this->getLabel($model, $field) . '</label>
            <div>
                <textarea id="'. $model->tableName() . '-' . $field .'" data-validate="'. $model->validate($field) .'" class="form-control" name="' . $model->tableName() . '[' . $field . ']"' . BaseHtml::buildOptions($options) . '>' . $model->$field . '</textarea>
                <span class="text-danger error"></span>
                ' . $this->getHelp() . '
            </div>
        </div>';
        return $this;
    }

    public function radioButton($model, $field, $data, $options=[])
    {
        $this->registerModel($model);
        $this->result = '<div class="form-group">
            <label class="control-label">' . $this->getLabel($model, $field) . '</label>
            <div>';

        foreach ($data as $key => $value) {
            $this->result .= '<div class="radio"' . BaseHtml::buildOptions($options) . '>
                <label>
                    <input id="'. $model->tableName() . '-' . $field .'" data-validate="'. $model->validate($field) .'" type="radio" name="' . $model->tableName() . '[' . $field . ']" value="' . $key . '" checked="">
                    ' . $value . '
                </label>
            </div>';
        }
        $this->result .= '<span class="text-danger error"></span>' . $this->getHelp() . '</div></div>';
        return $this;
    }

    public function select($model, $field, $data, $options=[])
    {
        $this->registerModel($model);
        $this->result = '<div class="form-group">
        <label class="control-label">' . $this->getLabel($model, $field) . '</label>
        <div><select id="'. $model->tableName() . '-' . $field .'" data-validate="'. $model->validate($field) .'" name="' . $model->tableName() . '[' . $field .']" class="form-control"' . BaseHtml::buildOptions($options) . '>';

        foreach ($data as $key => $value) {
            $this->result .= '<option value="' . $key . '"' . ($model->$field == $key ? ' selected ' : '') . '>' . $value . '</option>';
        }

        $this->result .= '</select><span class="text-danger error"></span>' . $this->getHelp() . '</div></div>';
        return $this;
    }

    public function selectMultiple($model, $field, $data, $option=[])
    {
        $this->registerModel($model);
        $this->result = '<div class="form-group">
        <label class="control-label">' . $this->getLabel($model, $field) . '</label>
        <div><select id="'. $model->tableName() . '-' . $field .'" data-validate="'. $model->validate($field) .'" name="' . $model->tableName() . '[' . $field .']" multiple="" class="form-control"' . BaseHtml::buildOptions($options) . '>';

        foreach ($data as $key => $value) {
            $this->result .= '<option value="' . $key . '">' . $value . '</option>';
        }

        $this->result .= '</select><span class="text-danger error"></span>' . $this->getHelp() . '</div></div>';
        return $this;
    }

    public function submitButton($text, $options=[])
    {
        if (! array_key_exists('class', $options)) {
            $options['class'] = 'btn btn-primary';
        }
        $this->result = '<div class="form-group"><button type="submit"' . BaseHtml::buildOptions($options) . '">' . $text . '</button></div>';
        return $this;
    }

    public function label($value)
    {
        $this->label = $value;
        return $this;
    }

    public function getLabel($model, $field)
    {
        if ($this->label != null) {
            $label = $this->label;
            $this->label = '';
            return $label;
        } else {
            return $model->attributeLabel($field);
        }
    }

    public function help($value)
    {
        $this->help = $value;
        return $this;
    }

    public function getHelp()
    {
        if ($this->help != null) {
            $help = $this->help;
            $this->help = '';
            return '<span class="help-block">' . $help . '</span>';
        }
    }

    public function end()
    {
        return '</form>';
    }

    public function registerModel($model)
    {
        App::$assets->addJs($model->loadCustomValidation());
    }

    public function __toString()
    {
        return $this->result;
    }

}