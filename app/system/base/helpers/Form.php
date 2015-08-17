<?php 
namespace helpers;

use \App;

class Form extends BaseHtml
{
    public $result = '';

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

    public function error($value='')
    {
        if ($value != null) {
            return '<span class="text-danger">' . $value . '</span><br />';
        }
    }

    public function help($value='')
    {
        if ($value != null) {
            return '<span class="help-block">' . $value . '</span>';
        }
    }

    public function inputText($name, $label, $options=[])
    {
        $this->result .= '<div class="form-group">
            <label class="col-lg-2 control-label">' . $label . '</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="' . $name . '"' . static::multiOptionsHelper('options', $options) . ' />
                    ' . $this->error(static::multiOptionsHelper('error', $options)) . '
                    ' . $this->help(static::multiOptionsHelper('help', $options)) . '
                </div>
            </div>';
        return $this;
    }

    public function checkBox($name, $label, $options=[])
    {
        $this->result .= '<div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="' . $name . '"' . static::multiOptionsHelper('options', $options) . '> ' . $label . '
                    ' . $this->error(static::multiOptionsHelper('error', $options)) . '
                    ' . $this->help(static::multiOptionsHelper('help', $options)) . '
                </label>
            </div>
        </div>';
        return $this;
    }

    public function textArea($name, $label, $options=[])
    {
        $this->result .= '<div class="form-group">
            <label for="textArea" class="col-lg-2 control-label">Textarea</label>
            <div class="col-lg-10">
                <textarea class="form-control"' . static::multiOptionsHelper('options', $options) . '></textarea>
                ' . $this->error(static::multiOptionsHelper('error', $options)) . '
                ' . $this->help(static::multiOptionsHelper('help', $options)) . '
            </div>
        </div>';
        return $this;
    }

    public function radioButton($name, $label, $data, $value=null, $options=[])
    {
        $this->result .= '<div class="form-group">
        <label class="col-lg-2 control-label">' . $label . '</label>
        <div class="col-lg-10">
            <div class="radio">
                <label>
                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                    Option one is this
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                    Option two can be something else
                </label>
            </div>
        </div>
        </div>';
        return $this;
    }

    public function submitButton($text, $options=[])
    {
        if (! array_key_exists('class', $options)) {
            $options['class'] = 'btn btn-default';
        }
        $this->result .= '<div class="form-group"><button type="submit"' . BaseHtml::buildOptions($options) . '">' . $text . '</button></div>';
        return $this;
    }

    public static function end()
    {
        return $this->result . '</form>';
    }

    protected static function multiOptionsHelper($key, $options=[])
    {
        if (array_key_exists($key, $options)) {
            if ($key == 'options') {
                return BaseHtml::buildOptions($options[$key]);
            }
            return $options[$key];
        }
    }

}