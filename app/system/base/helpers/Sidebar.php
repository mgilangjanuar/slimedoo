<?php 
namespace helpers;

use \App;
use \helpers\BaseHtml;

class Sidebar extends BaseHtml
{
    public static function begin($configs)
    {
        $result = '<nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#menu-toggle" id="menu-toggle"><i class="fa fa-bars"></i></a>
                    <a class="navbar-brand" href="' . $configs['url'] . '">' . $configs['label'] . '</a>
                </div>
            </div>
        </nav>';
        if (array_key_exists('items', $configs)) {
            $result .= self::buildItems($configs['items']);
        }
        return $result;
    }

    public static function buildItems($items)
    {
        $result = '<div id="sidebar-wrapper">
            <ul class="sidebar-nav">';
        foreach ($items as $item) {
            if (array_key_exists('route', $item)) {
                if (is_string($item['route'])) {
                    $result .= '<li class="' . ($item['route'] == App::activeRoute() ? 'active' : '') . '">';
                } elseif (is_array($item['route'])) {
                    $result .= '<li class="' . (in_array(App::activeRoute(), $item['route']) ? 'active' : '') . '">';
                }
            } else {
                $result .= '<li>';
            }
            $result .= '<a href="' . $item['url'] . '">' . (array_key_exists('logo', $item) ? '<i class="' . $item['logo'] . '"></i> ' : '') . $item['label'] . '</a>
            </li>';
        }
        $result .= '</ul>
            </div>';
        return $result;
    }
}