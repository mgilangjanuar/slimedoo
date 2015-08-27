<?php
    use \helpers\BaseHtml;
    use \helpers\Form;
    $this->title = 'Update: ' . $model->Username;
    $this->breadcrumb = [
        ['label' => 'Users', 'url' => ['index']],
        ['label' => $model->Username, 'url' => ['view', $model->Username]],
        ['label' => $this->title]
    ];
?>

<div class="main-title">
    <h1><?= $this->title ?></h1>
</div>

<div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        <?= $form = new Form ?>
        <?= $form->inputText($model, 'Username') ?>
        <?= $form->inputText($model, 'Email') ?>
        <?= $form->checkBox($model, 'Activated') ?>
        <?= $form->select($model, 'GroupID', $model->dataRoles) ?>
        <?= $form->submitButton('Update') ?>
    </div>
</div>
