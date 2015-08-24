<?php  
    use \helpers\BaseHtml;
    use \helpers\Detail;
    $this->title = 'My Profile';
    $this->breadcrumb = [
        ['label' => $this->title]
    ];
?>

<div class="main-title">
    <h1><?= $this->title ?></h1>
</div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <?= BaseHtml::a('New Password', ['change-password'], ['class' => 'btn btn-warning']) ?>
        
        <br /><br />

        <?= Detail::begin([
            'model' => $model,
            'items' => [
                'Username',
                'Email',
                'isActivated',
                'regDatePretty',
                'lastLoginPretty',
                [
                    'label' => 'Role',
                    'value' => App::role()
                ],
            ]
        ]) ?>
    </div>
</div>