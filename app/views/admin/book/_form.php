<?php 
    use \helpers\Form;
?>

<?= $form = new Form; ?>
<?= $form->inputText($model, 'title') ?>
<?= $form->inputText($model, 'writer') ?>
<?= $form->submitButton($model->isNewRecord() ? 'Create' : 'Update') ?>