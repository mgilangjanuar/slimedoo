<?php
    use \helpers\Form;
    use \helpers\BaseHtml;
    $this->title = 'Register';
    $this->breadcrumb = [
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
    <?= $form->password($model, 'Password') ?>
    <?= $form->password($model, 'Password2') ?>
    <p class="text-right">
        <?= BaseHtml::a('Already have an account?', ['login']) ?>
    </p>
    <?= $form->submitButton('Register') ?>
    <?= $form->end() ?>

  </div>
</div>