<?php
    $this->title = 'Reset Password';
    use \helpers\Form;
?>

<div class="main-title">
    <h1><?= $this->title ?></h1>
</div>

<div class="row">
    <div class="col-sm-6 col-sm-offset-3">

    <?php $form = new Form ?>
    <?php $form->begin() ?>
        <?php $form->inputText($model, 'Email') ?>
        <?php $form->submitButton('Reset Password') ?>
    <?= $form->end() ?>

  </div>
</div>