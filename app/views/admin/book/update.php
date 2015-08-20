<?php
    use \helpers\BaseHtml;
    $this->title = 'Update: ' . $model->title;
    $this->breadcrumb = [
        'Book List' => ['index'],
        $model->title => ['view/' . $model->id],
        $this->title
    ];
?>

<div class="main-title">
    <h1><?= $this->title ?></h1>
</div>

<div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        <?= $this->renderExtend('_form', [
            'model' => $model
        ]) ?>
    </div>
</div>