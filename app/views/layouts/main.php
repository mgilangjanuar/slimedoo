<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php foreach (App::autoload('web/assets', '.css', true) as $__css): ?>
        <link rel="stylesheet" href="<?= $__css ?>">
    <?php endforeach ?>

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
                <li class="active">
                    <a href="#">Dashboard</a>
                </li>
                <li>
                    <a href="#">Shortcuts</a>
                </li>
                <li>
                    <a href="#">Overview</a>
                </li>
                <li>
                    <a href="#">Events</a>
                </li>
                <li>
                    <a href="#">About</a>
                </li>
                <li>
                    <a href="#">Services</a>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li>
            </ul>
        </div>

        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 main-content">
                        <?php require $__content; ?>
                        <title><?= $this->title ?> :: <?= App::config()->name ?></title>
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

    <?php foreach (App::autoload('web/assets', '.js', true) as $__js): ?>
        <script src="<?= $__js ?>"></script>
    <?php endforeach ?>

</body>
</html>