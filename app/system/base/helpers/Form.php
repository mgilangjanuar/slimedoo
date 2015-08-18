<?php 
namespace helpers;

use \App;

class Form extends BaseHtml
{
    public $result = '';

    public $label = '';

    public function begin($options=[])
    {
        if (! array_key_exists('method', $options)) {
            $options['method'] = 'post';
        }
        if (! array_key_exists('class', $options)) {
            $options['class'] = 'form-horizontal';
        }
        $this->result .= '<form' . BaseHtml::buildOptions($options) . '>';
        return $this;
    }

    public function error($model, $field)
    {
        if ($model->hasErrors() && array_key_exists($field, $model->errors())) {
            return '<span class="text-danger">' . $model->errors()[$field][0] . '</span><br />';
        }
    }

    public function hasError($model, $field)
    {
        if ($model->hasErrors() && array_key_exists($field, $model->errors())) {
            return ' has-error';
        }
    }

    public function help($value='')
    {
        if ($value != null) {
            return '<span class="help-block">' . $value . '</span>';
        }
    }

    public function inputText($model, $field, $options=[])
    {
        $this->result .= '<div class="form-group' . $this->hasError($model, $field) . '">
            <label class="col-lg-2 control-label">' . $this->getLabel($model, $field) . '</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" value="' . $model->$field . '" name="' . $field . '"' . BaseHtml::buildOptions($options) . '/>
                    ' . $this->error($model, $field) . '
                </div>
            </div>';
        return $this;
    }

    public function password($model, $field, $options=[])
    {
        $this->result .= '<div class="form-group' . $this->hasError($model, $field) . '">
            <label class="col-lg-2 control-label">' . $this->getLabel($model, $field) . '</label>
                <div class="col-lg-10">
                    <input type="password" class="form-control" value="' . $model->$field . '" name="' . $field . '"' . BaseHtml::buildOptions($options) . '/>
                    ' . $this->error($model, $field) . '
                </div>
            </div>';
        return $this;
    }

    public function checkBox($model, $field, $options=[])
    {
        $this->result .= '<div class="form-group' . $this->hasError($model, $field) . '">
            <div class="checkbox"><div class="col-lg-10 col-lg-offset-2">
                <label>
                    <input type="checkbox" value="' . $model->$field . '" name="' . $field . '"' . BaseHtml::buildOptions($options) . '> ' . $this->getLabel($model, $field) . '
                    ' . $this->error($model, $field) . '
                </label>
            </div></div>
        </div>';
        return $this;
    }

    public function textArea($model, $field, $options=[])
    {
        $this->result .= '<div class="form-group' . $this->hasError($model, $field) . '">
            <label for="textArea" class="col-lg-2 control-label">' . $this->getLabel($model, $field) . '</label>
            <div class="col-lg-10">
                <textarea class="form-control" name="' . $field . '"' . BaseHtml::buildOptions($options) . '>' . $model->$field . '</textarea>
                ' . $this->error($model, $field) . '
            </div>
        </div>';
        return $this;
    }

    public function radioButton($model, $field, $data, $options=[])
    {
        $this->result .= '<div class="form-group' . $this->hasError($model, $field) . '">
        <label class="col-lg-2 control-label">' . $this->getLabel($model, $field) . '</label>
        <div class="col-lg-10">';

        foreach ($data as $key => $value) {
            $this->result .= '<div class="radio"' . BaseHtml::buildOptions($options) . '>
                <label>
                    <input type="radio" name="' . $field . '" value="' . $key . '" checked="">
                    ' . $value . '
                </label>
            </div>';
        }

        $this->result .= $this->error($model, $field) . '</div></div>';
        return $this;
    }

    public function select($model, $field, $data, $options=[])
    {
        $this->result .= '<div class="form-group' . $this->hasError($model, $field) . '">
        <label class="col-lg-2 control-label">' . $this->getLabel($model, $field) . '</label>
        <div class="col-lg-10"><select class="form-control"' . BaseHtml::buildOptions($options) . '>';

        foreach ($data as $key => $value) {
            $this->result .= '<option value="' . $key . '">' . $value . '</option>';
        }

        $this->result .= '</select>' . $this->error($model, $field) . '</div></div>';
        return $this;
    }

    public function selectMultiple($model, $field, $data, $option=[])
    {
        $this->result .= '<div class="form-group' . $this->hasError($model, $field) . '">
        <label class="col-lg-2 control-label">' . $this->getLabel($model, $field) . '</label>
        <div class="col-lg-10"><select multiple="" class="form-control"' . BaseHtml::buildOptions($options) . '>';

        foreach ($data as $key => $value) {
            $this->result .= '<option value="' . $key . '">' . $value . '</option>';
        }

        $this->result .= '</select>' . $this->error($model, $field) . '</div></div>';
        return $this;
    }

    public function submitButton($text, $options=[])
    {
        if (! array_key_exists('class', $options)) {
            $options['class'] = 'btn btn-primary';
        }
        $this->result .= '<div class="form-group"><div class="col-lg-10 col-lg-offset-2"><button type="submit"' . BaseHtml::buildOptions($options) . '">' . $text . '</button></div></div>';
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

    public function end()
    {
        return $this->result . '</form>';
    }

}