<?php 
namespace helpers;

use \App;

class Detail extends BaseHtml
{
    public static function begin($datas=[])
    {
        $model = $datas['model']->one();
        $items = $datas['items'];

        $result = '<div class="table-responsive"><table class="table table-striped table-hover gridview">';
        foreach ($items as $item) {
            $result .= '<tr>';
            if (is_string($item)) {
                $result .= '<td><label>' . $model->attributeLabel($item) . '</label></td>';
                $result .= '<td>' . $model->$item . '</td>';
            } elseif (is_array($item)) {
                if (array_key_exists('label', $item)) {
                    $result .= '<td><label>' . $item['label'] . '</label></td>';
                } else {
                    $result .= '<td><label>' . $model->attributeLabel($item['attribute']) . '</label></td>';
                }
                if (array_key_exists('attribute', $item)) {
                    $result .= '<td>' . $model->$item['attribute'] . '</td>';
                } elseif (array_key_exists('value', $item)) {
                    $result .= '<td>' . $item['value'] . '</td>';
                }
            }
            $result .= '</tr>';
        }
        $result .= '</table></div>';
        return $result;
    }
}