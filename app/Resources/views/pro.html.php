<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/x-icon" href="<?php echo $view['assets']->getUrl('favicon.ico') ?>" />

    <title><?php $view['slots']->output('title', 'Starter Template for Bootstrap') ?></title>
        <link rel="stylesheet" href="<?php echo $view['asset_version']->getAssetVersion($view['assets']->getUrl('css/vendors_app_pro.css')) ?>"/>

        <link rel="stylesheet" href="<?php echo $view['asset_version']->getAssetVersion($view['assets']->getUrl('css/main_app_pro.css')) ?>"/>


</head>

    <body ng-app="beauty">
    <!--[if lt IE 7]>
    <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <!-- Add your site or application content here -->
    <div class="">
        <div ui-view></div>
    </div>

    <!-- Javascripts -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo $view['asset_version']->getAssetVersion($view['assets']->getUrl('js/jquery.js')) ?>"><\/script>')</script>
    <script src="<?php echo $view['asset_version']->getAssetVersion($view['assets']->getUrl('js/vendors_app_pro.js')) ?>"></script>

    <script src="<?php echo $view['asset_version']->getAssetVersion($view['assets']->getUrl('js/fullcalendar.js')) ?>"></script>
    <script src="<?php echo $view['asset_version']->getAssetVersion($view['assets']->getUrl('js/angular_app.js')) ?>"></script>
</body>
</html>
