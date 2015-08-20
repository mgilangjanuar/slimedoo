<?php
    use \helpers\Form;
    use \helpers\BaseHtml;
    $this->title = 'Register';
    $this->breadcrumb = [$this->title];
?>

<div class="main-title">
    <h1><?= $this->title ?></h1>
</div>

<div class="row">
    <div class="col-sm-6 col-sm-offset-3">

    <?php $form = new Form ?>
    <?= $form->begin() ?>
    <?= $form->inputText($model, 'Username') ?>
    <?= $form->inputText($model, 'Email') ?>
    <?= $form->password($model, 'Password') ?>
    <?= $form->password($model, 'Password2') ?>
    <p class="text-right">
        <?= BaseHtml::a('Already have an account?', ['site/login']) ?>
    </p>
    <?= $form->submitButton('Register') ?>
    <?= $form->end() ?>

  </div>
</div>