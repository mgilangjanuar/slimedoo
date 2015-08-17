<?php 
namespace helpers;

use \App;

class BaseHtml extends App
{
    protected static function buildOptions($options=[])
    {
        $result = '';
        foreach ($options as $key => $value) {
            $result .= ' ' . $key . '="' . $value . '"';
        }
        return $result;
    }

    public static function urlTo($url)
    {
        if (is_string($url)) {
            if (strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0 || strpos($url, 'www.') === 0) {
                return $url;
            }
            return App::url($url);
        } elseif (is_array($url)) {
            $result = '';
            foreach ($url as $i => $value) {
                if ($i == 0) {
                    $result .= App::url($value);
                } else {
                    $result .= '/' . $value;
                }
            }
            return $result;
        }
    }

    public static function a($text, $url, $options=[])
    {
        return '<a href="' . static::urlTo($url) . '"' . static::buildOptions($options) . '>' . $text . '</a>';
    }

    public static function img($url, $options=[])
    {
        if (! array_key_exists('class', $options)) {
            $options['class'] = 'img-responsive';
        }
        return '<img src="' . static::urlTo($url) . '"' . static::buildOptions($options) . '>';
    }

}