<?php
// Think of it like a sample file

// Use the file config.php for setting configure options
// for cute-php-explorer.

// You can put anything in this file, and it don't needs to be updated.
// Only update files from cute-php-explorer folder.

// don't write anything before these includes
include_once('config.php');
include_once('cute-php-explorer/init.php');
// Here you can put your php functions
?>

<!DOCTYPE html>
<html lang="en_US">

<head>
    <!-- don't write anything before that include -->
    <?php include_once('cute-php-explorer/head.php'); ?>
    <!-- Here you can put more head tags -->
</head>

<body>
    <!-- Here you can put your body defs/tags -->
    <?php include_once('cute-php-explorer/explorer.php'); ?>
    <!-- Here you can put more body defs/tags -->
</body>

</html>
