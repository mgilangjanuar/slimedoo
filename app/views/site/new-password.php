<?php
    use \helpers\Form;
    $this->title = 'New Password';
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
    <?= $form->password('Password') ?>
    <?= $form->password('Password2') ?>
    <?= $form->submitButton('Submit') ?>
    <?= $form->end() ?>

  </div>
</div>