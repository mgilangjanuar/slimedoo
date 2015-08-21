<?php 
    use \helpers\Form;
?>

<?php $form = new Form; ?>
<?= $form->begin() ?>
<?= $form->inputText($model, 'title') ?>
<?= $form->inputText($model, 'writer') ?>
<?= $form->submitButton($model->isNewRecord() ? 'Create' : 'Update') ?>