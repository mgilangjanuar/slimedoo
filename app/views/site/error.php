<?php
    $this->title = $type;
?>

<div class="main-title">
    <div class="text-left">
        <h1><?= $this->title ?></h1>
        <div class="panel panel-danger">
            <div class="panel-heading">
                <?= $message ?>
            </div>
        </div>
        <p>
            The above error occurred while the Web server was processing your request.
        </p>
        <p>
            Please contact us if you think this is a server error. Thank you.
        </p>
    </div>
</div>