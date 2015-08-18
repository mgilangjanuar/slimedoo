<?php
    $this->title = 'Login';
    use \helpers\Form;
?>

<div class="main-title">
    <h1><?= $this->title ?></h1>
</div>

<div class="row">
    <div class="col-sm-6 col-sm-offset-3">

    <?php $form = new Form ?>
    <?php $form->begin() ?>
        <?php $form->label('Username or Email')->inputText($model, 'Username') ?>
        <?php $form->password($model, 'Password') ?>
        <?php $form->submitButton('Submit') ?>
    <?= $form->end() ?>

  </div>
</div>