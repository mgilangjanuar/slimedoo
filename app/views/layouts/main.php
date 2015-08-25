<?php
    use \helpers\Sidebar;
    use \helpers\Url;
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <title><?= $this->title ?> :: <?= App::config()->name ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <?php $this->style() ?>

</head>
<body>

    <div id="wrapper">

        <?php
            if (App::$user->isSigned()) {
                $items = [
                    [
                        'label' => 'Profile',
                        'url' => Url::base('admin/profile/index'),
                        'logo' => 'fa fa-user',
                        'route' => ['/admin', '/admin/profile', '/admin/profile/index']
                    ],
                    [
                        'label' => 'Users',
                        'url' => Url::base('admin/user/index'),
                        'logo' => 'fa fa-users',
                        'route' => ['/admin/user', '/admin/user/index']
                    ],
                    [
                        'label' => 'Logout (' . App::$user->Username . ')',
                        'url' => Url::base('site/logout'),
                        'logo' => 'fa fa-sign-out',
                    ]
                ];
            } else {
                $items = [
                    [
                        'label' => 'Home',
                        'url' => Url::base(),
                        'logo' => 'fa fa-home',
                        'route' => ['/', '/site', '/site/index']
                    ],
                    [
                        'label' => 'About',
                        'url' => Url::base('site/about'),
                        'logo' => 'fa fa-info-circle',
                        'route' => '/site/about'
                    ],
                    [
                        'label' => 'Login',
                        'url' => Url::base('site/login'),
                        'logo' => 'fa fa-sign-in',
                        'route' => '/site/login'
                    ],
                    [
                        'label' => 'Register',
                        'url' => Url::base('site/register'),
                        'logo' => 'fa fa-user',
                        'route' => '/site/register'
                    ]
                ];
            }
        ?>
        
        <?= Sidebar::begin([
            'label' => App::config()->name,
            'url' => Url::base(),
            'items' => $items
        ]) ?>

        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 main-content">
                        <?= $this->getBreadcrumb() ?>
                        <?= $this->getAlert() ?>
                        <?php require $__content; ?>
                    </div>
                </div>
            </div>
            <div class="footer">
                <div class="container-fluid">
                    <p class="pull-right"><?= App::config()->name ?> &copy; <?= date('Y') ?></p>
                </div>
            </div>
        </div>

    </div>

    <?php $this->script() ?>

</body>
</html>