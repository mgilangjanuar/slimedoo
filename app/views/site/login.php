<?php
    use \helpers\Form;
    use \helpers\BaseHtml;
    $this->title = 'Login';
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
    <?= $form->label('Username or Email')->inputText($model, 'Username') ?>
    <?= $form->password($model, 'Password') ?>
    <?= $form->checkBox($model, 'rememberMe') ?>
    <p class="text-right">
        <?= BaseHtml::a('Forgot your password?‎', ['reset-password']) ?><br />
        <?= BaseHtml::a('Have no an account?', ['register']) ?>
    </p>
    <?= $form->submitButton('Login') ?>
    <?= $form->end() ?>

  </div>
</div>
