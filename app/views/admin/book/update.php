<?php
    use \helpers\BaseHtml;
    $this->title = 'Update: ' . $model->title;
    $this->breadcrumb = [
        ['label' => 'Book List', 'url' => ['index']],
        ['label' => $model->title, 'url' => ['view', $model->id]],
        ['label' => $this->title]
    ];
?>

<div class="main-title">
    <h1><?= $this->title ?></h1>
</div>

<div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        <?= $this->render('_form', [
            'model' => $model
        ]) ?>
    </div>
</div>