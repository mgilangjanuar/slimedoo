<?php
    use \helpers\BaseHtml;
    use \helpers\Detail;
    $this->title = $model->title;
    $this->breadcrumb = [
        'Book List' => ['index'],
        $this->title
    ];
?>

<div class="main-title">
    <h1><?= $this->title ?></h1>
</div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <?= BaseHtml::a('Update', $this->siteUrl(['update/' . $model->id]), ['class' => 'btn btn-warning']) ?>
        <?= BaseHtml::a('Delete', $this->siteUrl(['delete/' . $model->id]), [
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