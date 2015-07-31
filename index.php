<?php
/*
 * The Cute PHP explorer is free software: you can redistribute it
 * and/or modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * The Cute PHP explorer is distributed in the hope that it will be
 * useful, but WITHOUT ANY WARRANTY; without even the implied warranty
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Lara Maia <dev@lara.click> © 2015
 *
 */

// Use the file cute-php-explorer/config.php for setting configure
// options for cute-php-explorer.

// You can put anything in this file, and it don't needs to be updated.
// Only update files from cute-php-explorer folder. Remember to backing
// up your config.php before update.

// don't write anything before that include
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
