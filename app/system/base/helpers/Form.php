<?php 
namespace helpers;

use \App;

class Form extends BaseHtml
{
    public $result = '';

    public $model = null;

    public $label = '';

    public $help = '';

    public function __construct($model, $options=[])
    {
        $this->model = $model;
        App::$assets->addJsFile('verifyjs/verify.min.js');
        App::$assets->addJs($this->model->loadCustomValidation());
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

    public function inputText($field, $options=[])
    {
        $this->result = '<div class="form-group">
            <label class="control-label">' . $this->getLabel($field) . '</label>
                <div>
                    <input id="'. $this->model->tableName() . '-' . $field .'" data-validate="'. $this->model->validate($field) .'" type="text" class="form-control" value="' . $this->model->$field . '" name="' . $this->model->tableName() . '[' . $field . ']"' . BaseHtml::buildOptions($options) . '/>
                    <span class="text-danger error"></span>
                    ' . $this->getHelp() . '
                </div>
            </div>';
        return $this;
    }

    public function password($field, $options=[])
    {
        $this->result = '<div class="form-group">
            <label class="control-label">' . $this->getLabel($field) . '</label>
                <div>
                    <input id="'. $this->model->tableName() . '-' . $field .'" data-validate="'. $this->model->validate($field) .'" type="password" class="form-control" value="' . $this->model->$field . '" name="' . $this->model->tableName() . '[' . $field . ']"' . BaseHtml::buildOptions($options) . '/>
                    <span class="text-danger error"></span>
                    ' . $this->getHelp() . '
                </div>
            </div>';
        return $this;
    }

    public function checkBox($field, $options=[])
    {
        $this->result = '<div class="form-group">
            <div class="checkbox"><div>
                <label>
                    <input type="hidden" name="' . $this->model->tableName() . '[' . $field .']" value="0">
                    <input id="'. $this->model->tableName() . '-' . $field .'" data-validate="'. $this->model->validate($field) .'"  value="1" type="checkbox"'. ($this->model->$field == null || $this->model->$field == 0 ? '' : ' checked ') . '" name="' . $this->model->tableName() . '[' . $field . ']"' . BaseHtml::buildOptions($options) . '> ' . $this->getLabel($field) . '
                </label>
            </div><span class="text-danger error"></span>' . $this->getHelp() . '</div>
        </div>';
        return $this;
    }

    public function textArea($field, $options=[])
    {
        $this->result = '<div class="form-group">
            <label for="textArea" class="control-label">' . $this->getLabel($field) . '</label>
            <div>
                <textarea id="'. $this->model->tableName() . '-' . $field .'" data-validate="'. $this->model->validate($field) .'" class="form-control" name="' . $this->model->tableName() . '[' . $field . ']"' . BaseHtml::buildOptions($options) . '>' . $this->model->$field . '</textarea>
                <span class="text-danger error"></span>
                ' . $this->getHelp() . '
            </div>
        </div>';
        return $this;
    }

    public function radioButton($field, $data, $options=[])
    {
        $this->result = '<div class="form-group">
            <label class="control-label">' . $this->getLabel($field) . '</label>
            <div>';

        foreach ($data as $key => $value) {
            $this->result .= '<div class="radio"' . BaseHtml::buildOptions($options) . '>
                <label>
                    <input id="'. $this->model->tableName() . '-' . $field .'" data-validate="'. $this->model->validate($field) .'" type="radio" name="' . $this->model->tableName() . '[' . $field . ']" value="' . $key . '" checked="">
                    ' . $value . '
                </label>
            </div>';
        }
        $this->result .= '<span class="text-danger error"></span>' . $this->getHelp() . '</div></div>';
        return $this;
    }

    public function select($field, $data, $options=[])
    {
        $this->result = '<div class="form-group">
        <label class="control-label">' . $this->getLabel($field) . '</label>
        <div><select id="'. $this->model->tableName() . '-' . $field .'" data-validate="'. $this->model->validate($field) .'" name="' . $this->model->tableName() . '[' . $field .']" class="form-control"' . BaseHtml::buildOptions($options) . '>';

        foreach ($data as $key => $value) {
            $this->result .= '<option value="' . $key . '"' . ($this->model->$field == $key ? ' selected ' : '') . '>' . $value . '</option>';
        }

        $this->result .= '</select><span class="text-danger error"></span>' . $this->getHelp() . '</div></div>';
        return $this;
    }

    public function selectMultiple($field, $data, $option=[])
    {
        $this->result = '<div class="form-group">
        <label class="control-label">' . $this->getLabel($field) . '</label>
        <div><select id="'. $this->model->tableName() . '-' . $field .'" data-validate="'. $this->model->validate($field) .'" name="' . $this->model->tableName() . '[' . $field .']" multiple="" class="form-control"' . BaseHtml::buildOptions($options) . '>';

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

    public function getLabel($field)
    {
        if ($this->label != null) {
            $label = $this->label;
            $this->label = '';
            return $label;
        } else {
            return $this->model->attributeLabel($field);
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

    public function __toString()
    {
        return $this->result;
    }

}