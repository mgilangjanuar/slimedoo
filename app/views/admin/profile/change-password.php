<?php
    use \helpers\Form;
    $this->title = 'Change Password';
    $this->breadcrumb = [
        ['label' => 'My Profile', 'url' => ['index']],
        ['label' => $this->title]
    ];
?>

<div class="main-title">
    <h1><?= $this->title ?></h1>
</div>

<div class="row">
    <div class="col-sm-6 col-sm-offset-3">

    <?= $form = new Form ?>
    <?= $form->password($model, 'Password') ?>
    <?= $form->password($model, 'Password2') ?>
    <?= $form->submitButton('Submit') ?>
    <?= $form->end() ?>

  </div>
</div>