<?php 
namespace helpers;

use \App;
use \helpers\BaseHtml;

class Url extends BaseHtml
{
    public static function autoDecide($url=null)
    {
        if (is_string($url)) {
            if( preg_match( '/^(?:[;\/?:@&=+$,]|(?:[^\W_]|[-_.!~*\()\[\] ])|(?:%[\da-fA-F]{2}))*$/', $url ) == 1 ) {
               return $url;
            }
            return self::base($url);
        } elseif (is_array($url)) {
            if ($url[0][0] == '/') {
                return self::base($url);
            } else {
                return self::to($url);
            }
        }
    }

    public static function base($url=null)
    {
        return App::url(static::buildUrl($url));
    }

    public static function to($url=null)
    {
        $class = App::activeClass();
        return App::url((new $class)->viewDir() . ($url != null ? '/' : '') . self::buildUrl($url));
    }

    public static function buildUrl($url=null)
    {
        if (is_string($url)) {
            return $url;
        } elseif (is_array($url)) {
            $result = '';
            foreach ($url as $i => $segment) {
                $result .= $segment;
                if ($i+1 != count($url)) {
                    $result .= '/';
                }
            }
            return ltrim($result, '/');
        }
    }
}