<?php
    use \helpers\BaseHtml;
    use \helpers\Form;
    $this->title = 'Update: ' . $model->Username;
    $this->breadcrumb = [
        'Users' => ['index'],
        $model->Username => ['view/' . $model->Username],
        $this->title
    ];
?>

<div class="main-title">
    <h1><?= $this->title ?></h1>
</div>

<div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        <?php $form = new Form; ?>
        <?= $form->begin() ?>
        <?= $form->inputText($model, 'Username') ?>
        <?= $form->inputText($model, 'Email') ?>
        <?= $form->checkBox($model, 'Activated') ?>
        <?= $form->select($model, 'GroupID', $model->dataRoles) ?>
        <?= $form->submitButton('Update') ?>
    </div>
</div>
