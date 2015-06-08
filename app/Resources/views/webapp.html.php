<!DOCTYPE html>
<html lang="en" ng-app="helloWorld">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/x-icon" href="<?php echo $view['assets']->getUrl('favicon.ico') ?>{{ asset('favicon.ico') }}" />

    <title><?php $view['slots']->output('title', 'Starter Template for Bootstrap') ?></title>
        <link rel="stylesheet" href="<?php echo $view['asset_version']->getAssetVersion($view['assets']->getUrl('css/vendors.css')) ?>"/>

        <link rel="stylesheet" href="<?php echo $view['asset_version']->getAssetVersion($view['assets']->getUrl('css/main.css')) ?>"/>

    <script src="<?php echo $view['asset_version']->getAssetVersion($view['assets']->getUrl('js/angular_app.js')) ?>"></script>

</head>

<body ng-controller="HelloController as hello">


    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Project name</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container">

        <div class="starter-template">
            <h1>Bootstrap starter template</h1>
            <p class="lead"><?php echo $view->escape($helloMessage) ?> and {{ hello.message }}</p>
        </div>

    </div><!-- /.container -->

    <!-- Javascripts -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo $view['asset_version']->getAssetVersion($view['assets']->getUrl('js/jquery.js')) ?>"><\/script>')</script>
    <script src="<?php echo $view['asset_version']->getAssetVersion($view['assets']->getUrl('js/vendors.js')) ?>"></script>

    <script src="<?php echo $view['asset_version']->getAssetVersion($view['assets']->getUrl('js/site.js')) ?>"></script>
</body>
</html>
