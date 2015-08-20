<?php
    use \helpers\Form;
    $this->title = 'New Password';
    $this->breadcrumb = [$this->title];
?>

<div class="main-title">
    <h1><?= $this->title ?></h1>
</div>

<div class="row">
    <div class="col-sm-6 col-sm-offset-3">

    <?php $form = new Form ?>
    <?= $form->begin() ?>
    <?= $form->password($model, 'Password') ?>
    <?= $form->password($model, 'Password2') ?>
    <?= $form->submitButton('Submit') ?>
    <?= $form->end() ?>

  </div>
</div>