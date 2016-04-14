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

// This will create a secured string with the received string.
if(isset($_POST["passwd"])) {
    $salt = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);
    $salt = base64_encode($salt);
    $salt = str_replace('+', '.', $salt);
    $hash = crypt($_POST['passwd'], '$2y$10$'.$salt.'$');
}
?>

<!DOCTYPE html>
<html lang="en_US">

<head>
    <meta name="viewport" content="width=device-width" />
    <meta charset="utf-8" />
    <link href="themes/securepass.css" rel="stylesheet" type="text/css" />
    <title>Generate a secure password</title>
</head>

<body>
    <p>You can use this page to generate a secured string of your password until the support for control panel is complete.</p>
    <form method="post">
        User: <input type="text" pattern=".{3,}" required title="You need at least 3 characters" name="user" size="20">
        Password: <input type="password" pattern=".{5,}" required title="You need at least 5 characters" name="passwd" size="20">
        <input type="submit" name="login" value="Generate">
    </form>
<?php
if(isset($_POST["passwd"])) {
?>
    <h3>Put this at your config.php on users array ($_CONFIG['users']):</h1>
    <p>    '<?=$_POST['user']?>' => '<?=$hash?>',</p>
<?php
}
?>
</body>

</html>
