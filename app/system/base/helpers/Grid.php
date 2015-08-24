<?php 
namespace helpers;

use \App;

class Grid extends BaseHtml
{
    public static function begin($datas)
    {
        $model = $datas['model'];
        $items = $datas['items'];

        $result = '<div class="table-responsive"><table class="table table-striped table-hover gridview"><thead><tr>';
        foreach ($items as $head) {
            if (is_array($head)) {
                if (array_key_exists('attribute', $head) && $head['attribute'] == ':serialColumn') {
                    if (array_key_exists('label', $head)) {
                        $result .= '<th>' . $head['label'] . '</th>';
                    } else {
                        $result .= '<th>#</th>';
                    }
                } elseif (array_key_exists('attribute', $head) && $head['attribute'] == ':actionColumn') {
                    if (array_key_exists('label', $head)) {
                        $result .= '<th>' . $head['label'] . '</th>';
                    } else {
                        $result .= '<th>Actions</th>';
                    }
                } else {
                    if (array_key_exists('label', $head)) {
                        $result .= '<th>' . $head['label'] . '</th>';
                    } else {
                        $result .= '<th>' . $model->attributeLabel($head) . '</th>';
                    }
                }
            } else {
                $result .= '<th>' . $model->attributeLabel($head) . '</th>';
            }
        }
        $result .= '</tr></thead><tbody>';
        foreach ($model->all() as $serial => $row) {
            $result .= '<tr>';
            foreach ($items as $data) {
                if (is_array($data)) {
                    if (array_key_exists('attribute', $data) && $data['attribute'] == ':serialColumn') {
                        $result .= '<td>' . ($serial + 1) . '</td>';
                    } elseif (array_key_exists('attribute', $data) && $data['attribute'] == ':actionColumn') {
                        $result .= '<td>' . static::actionColumn($row, $data['parameter']) . '</td>';
                    } elseif (array_key_exists('value', $data)) {
                        $result .= '<td>' . $data['value']($row) . '</td>';
                    } else {
                        $result .= '<td>' . $row->$data['attribute'] . '</td>';
                    }
                } else {
                    $result .= '<td>' . $row->$data . '</td>';
                }
            }
            $result .= '</tr>';
        }
        $result .= '</tbody></table></div>';
        return $result;
    }

    public static function actionColumn($model, $param)
    {
        return
            '<a href="'. Url::autoDecide(['view/' . $model->$param]) . '"><i class="glyphicon glyphicon-eye-open"></i></a> 
            <a href="'. Url::autoDecide(['update/' . $model->$param]) . '"><i class="glyphicon glyphicon-pencil"></i></a> 
            <a onclick="if (confirm(\'Are you sure want to delete this item?\') == false) return false" href="'. Url::autoDecide(['delete/' . $model->$param]) . '"><i class="glyphicon glyphicon-trash"></i></a>';
    }
}
