<?php  
    use \helpers\BaseHtml;
    use \helpers\Grid;
    $this->title = 'Users';
    $this->breadcrumb = [$this->title];
?>

<div class="main-title">
    <h1><?= $this->title ?></h1>
</div>

<?= Grid::begin([
    'model' => $model,
    'items' => [
        ['attribute' => ':serialColumn'],
        'Username',
        'Email',
        'isActivated',
        'regDatePretty',
        'lastLoginPretty',
        [
            'label' => 'Role',
            'value' => function ($model)
            {
                return App::roles()[$model->GroupID - 1];
            }
        ],
        [
            'attribute' => ':actionColumn',
            'parameter' => ['admin/user/', 'Username'],
        ],
    ]
]) ?>