<?php 
    use \helpers\BaseHtml;
    use \helpers\Grid;
    $this->title = 'Book List';
    $this->breadcrumb = [$this->title];
?>

<div class="main-title">
    <h1><?= $this->title ?></h1>
</div>

<?= BaseHtml::a('Create Book', $this->siteUrl(['create']), ['class' => 'btn btn-success']) ?>

<?= Grid::begin([
    'model' => $model,
    'items' => [
        ['attribute' => ':serialColumn'],
        'title',
        'writer',
        [
            'attribute' => ':actionColumn',
            'parameter' => ['admin/book/', 'id'],
        ]
    ]
]) ?>