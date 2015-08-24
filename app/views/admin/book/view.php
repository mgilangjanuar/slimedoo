<?php
    use \helpers\BaseHtml;
    use \helpers\Detail;
    $this->title = $model->title;
    $this->breadcrumb = [
        ['label' => 'Book List', 'url' => ['index']],
        ['label' => $this->title]
    ];
?>

<div class="main-title">
    <h1><?= $this->title ?></h1>
</div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <?= BaseHtml::a('Update', ['update/' . $model->id], ['class' => 'btn btn-warning']) ?>
        <?= BaseHtml::a('Delete', ['delete/' . $model->id], [
            'class' => 'btn btn-danger',
            'onclick' => 'if (confirm(\'Are you sure want to delete this item?\') == false) return false'
        ]) ?>
        
        <br /><br />

        <?= Detail::begin([
            'model' => $model,
            'items' => [
                'title',
                'writer'
            ]
        ]) ?>
    </div>
</div>