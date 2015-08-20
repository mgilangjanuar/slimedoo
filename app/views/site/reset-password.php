<?php
    use \helpers\Form;
    $this->title = 'Reset Password';
    $this->breadcrumb = [$this->title];
?>

<div class="main-title">
    <h1><?= $this->title ?></h1>
</div>

<div class="row">
    <div class="col-sm-6 col-sm-offset-3">

    <?php $form = new Form ?>
    <?= $form->begin() ?>
    <?= $form->inputText($model, 'Email') ?>
    <?= $form->submitButton('Reset Password') ?>
    <?= $form->end() ?>

  </div>
</div>