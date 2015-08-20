<!DOCTYPE html>
<html lang="en-US">
<head>
    <title><?= $this->title ?> :: <?= App::config()->name ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php $this->style() ?>

</head>
<body>

    <div id="wrapper">
        
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#menu-toggle" id="menu-toggle"><i class="fa fa-bars"></i></a>
                    <a class="navbar-brand" href="<?= App::url() ?>"><?= App::config()->name ?></a>
                </div>
            </div>
        </nav>

        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="<?= App::activeRoute() == '/' || App::activeRoute() == '/site' || App::activeRoute() == '/site/index' ? 'active' : '' ?>">
                    <a href="<?= App::url() ?>">Dashboard</a>
                </li>
                <li class="<?= App::activeRoute() == '/site/about' ? 'active' : '' ?>">
                    <a href="<?= App::url('site/about') ?>">About</a>
                </li>
                <?php if (App::$user->isSigned()): ?>
                    <li>
                        <a href="<?= App::url('site/logout') ?>">Logout (<?= App::$user->Username ?>)</a>
                    </li>
                <?php else: ?>
                    <li class="<?= App::activeRoute() == '/site/login' ? 'active' : '' ?>">
                        <a href="<?= App::url('site/login') ?>">Login</a>
                    </li>
                    <li class="<?= App::activeRoute() == '/site/register' ? 'active' : '' ?>">
                        <a href="<?= App::url('site/register') ?>">Register</a>
                    </li>
                <?php endif ?>
            </ul>
        </div>

        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 main-content">
                        <?= $this->breadcrumb() ?>
                        <?= $this->alert() ?>
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