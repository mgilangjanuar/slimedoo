<?php 
    use \helpers\BaseHtml;
    $this->title = 'About';
    $this->breadcrumb = [$this->title];
?>

<div class="main-title">
    <h1><?= $this->title ?></h1>
</div>

<p>
    This is an example page you can found me in <code><?= __FILE__ ?> </code>
</p>