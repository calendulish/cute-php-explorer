<?php
// Think of it like a sample file

// You can clone the git repository and use as an component/module
// with yours projects. Example:
// I have a website project into site/ folder.
// I want to integrate cute-php-explorer into my project:
// $ cd site/
// $ git clone https://github.com/ShyPixie/cute-php-explorer.git
// Then edit your index.php in accordance with example files.

// If you want to use only the cute-php-explorer, without any
// website to handle, then only copy the examples to a main folder:
// $ cp cute-php-explorer/examples/* .

// Remember to edit the configuration options (config.php).
// This file don't needs to be updated with git or cute-php-explorer.

// don't write anything before these includes
require_once('config.php');
require_once('cute-php-explorer/init.php');
// Here you can put your php functions
?>

<!DOCTYPE html>
<html lang="en_US">

<head>
    <title><?=$CuteExplorer->get_config('title')?></title>
    <meta name="viewport" content="width=device-width" />
    <meta charset="utf-8">
    <!-- Here you can put more head tags -->
    <?php include_once('cute-php-explorer/head.php'); ?>
    <!-- Here you can put more styles, scripts -->
</head>

<body>
    <!-- Here you can put your body defs/tags -->
    <?php include_once('cute-php-explorer/explorer.php'); ?>
    <!-- Here you can put more body defs/tags -->
</body>

</html>
