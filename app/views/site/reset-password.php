<?php
    use \helpers\Form;
    $this->title = 'Reset Password';
    $this->breadcrumb = [
        ['label' => $this->title]
    ];
?>

<div class="main-title">
    <h1><?= $this->title ?></h1>
</div>

<div class="row">
    <div class="col-sm-6 col-sm-offset-3">

    <?= $form = new Form($model) ?>
    <?= $form->inputText('Email') ?>
    <?= $form->inputText('Email2') ?>
    <?= $form->submitButton('Reset Password') ?>
    <?= $form->end() ?>

  </div>
</div>