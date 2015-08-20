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

session_start();

include_once("config.php");
include_once("engine.php");

$CuteExplorer = new CuteExplorer();
$CuteExplorer->read_dir();

date_default_timezone_set($CuteExplorer->get_config("timezone"));

// If the user try to login, check if the password is correct.
if(isset($_POST['login'])) {
    $user_input = $_POST['passwd'];
    // If the user exists, check if the password is correct
    if(array_key_exists($_POST['user'], $CuteExplorer->get_config('users'))) {
        $password = $CuteExplorer->get_config("users")[$_POST['user']];
        if(crypt($user_input, $password) == $password) {
            $_SESSION['users'] = $_POST['user'];
            // reload for changes to take effect
            header('Location: '.$CuteExplorer->make_query($CuteExplorer->get_value('dir')));
        }
    }
}
// If the user try to logout, so logout and reload the page.
if(isset($_POST['logout'])&&isset($_SESSION['users'])) {
    unset($_SESSION['users']);
    header('Location: '.$CuteExplorer->make_query($CuteExplorer->get_value('dir')));
    exit(0);
}

// If the user try to access a hidden directory, he needs a special
// permission for that. Check if he is currently logged in.
if($CuteExplorer->get_value('dir')) {
    $directories = explode('/', $CuteExplorer->get_value('dir'));
    // Remove empty element case the first directory are a '/'
    if($directories[0] == "") array_shift($directories);
    // Check if the first directory exists in hidden_dirs, if not
    // check all subdirectories until a match is found.
    $directory = array($directories[0]);
    for($e=0;$e<count($directories);$e++) {
        if($e!=0) array_push($directory, "/", $directories[$e]);
        if(in_array(implode($directory), $CuteExplorer->get_config('hidden_dirs'))) {
            // If a match is found, check if user is logged.
            //If not, back and shows a info mesage.
            if(!isset($_SESSION['users'])) {
                header('Location: ?error_code=403');
                exit;
            }
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en_US">

<head>
    <meta name="viewport" content="width=device-width" />
    <meta charset="utf-8" />
    <link href="<?=$CuteExplorer->set_theme()?>" rel="stylesheet" type="text/css" />
    <title><?=$CuteExplorer->get_config('title')?></title>
    <script type="text/javascript">
    function change(style){
        mtime = document.getElementsByClassName('mtime');
        for(var i = 0; i < mtime.length; i++) {
            mtime[i].style.display = style;
        };
    };

    function check_size() {
        var width = window.innerWidth
        || document.documentElement.clientWidth
        || document.body.clientWidth;

        if(width < 700) change('none'); else change('table-cell');
    }

    window.onload = check_size;
    window.addEventListener('resize', check_size);
    </script>
</head>

<body>
    <h1 class="title"><?=$CuteExplorer->get_config('title')?></h1>
<?php
// If the user is not logged in, show the login form.
if(!isset($_SESSION['users'])) {
// If the user tried access a protected file or folder,
// show the info message.
if($CuteExplorer->get_value('error_code') == 403) {
    printf("%4s%s\n", "", "<p>You don't have permission to access the requested page or file.</p>");
    printf("%4s%s\n", "", "<p>Please, if you need to access, login in the form bellow.</p>");
}
?>
    <form method="post" action="">
        <p class="login">
            User: <input type="text" pattern=".{3,}" required title="You need at least 3 characters" name="user" size="20">
            Password: <input type="password" pattern=".{5,}" required title="You need at least 5 characters" name="passwd" size="20">
            <input type="submit" name="login" value="Login">
        </p>
    </form>
<?php
    // If the user or password is incorrect, show a info message.
    if(isset($_POST['login'])) {
        printf("%8s%s", "", "Incorrect login. Try again.");
    }
// If the user is already logged in, show the user info and logout button.
} else {
?>
    <form method="post" action="">
        <p>
            You are logged in as <?=$_SESSION['users']?>.
            <input type="submit" name="logout" value="Logout">
        </p>
    </form>
<?php
}

if($CuteExplorer->get_value('dir')) {
    printf("%4s%s\n", "", "<p class='current_directory'>~".$CuteExplorer->get_value('dir')."</p>");
} else {
    printf("%4s%s\n", "", "<p class='current_directory'>~/</p>");
}?>
    <table>
        <tr class="header">
            <td class="icon"></td>
            <td class="name"><a>Name</a></td>
            <td class="size"><a>Size</a></td>
            <td class="mtime"><a>Modified Time</a></td>
        </tr>
<?php
    // make a item for previous directory
    if($CuteExplorer->get_value('dir')) {
?>
        <tr onclick="window.location='<?=$CuteExplorer->make_query($CuteExplorer->get_previous_dir($_GET['dir']))?>'">
            <td class="icon">
                <img src="<?=$CuteExplorer->set_icon($_GET['dir'])?>" width="<?=$CuteExplorer->get_config('icon_size')?>" height=auto />
            </td>
            <td class="name" colspan=3>
                <a href="<?=$CuteExplorer->make_query($CuteExplorer->get_previous_dir($_GET['dir']))?>">..</a>
            </td>
        </tr>
<?php }
    // make a item for each folder
    foreach($CuteExplorer->directories as $current_directory) {
?>
        <tr onclick="window.location='<?=$CuteExplorer->make_query($current_directory)?>'">
            <td class="icon">
                <img src="<?=$CuteExplorer->set_icon($current_directory)?>" width="<?=$CuteExplorer->get_config('icon_size')?>" height=auto />
            </td>
            <td class="name"><?=basename($current_directory)?></td>
            <td class="size center" colspan=2>Folder</td>
        </tr>
<?php
    }
    // make a item for each file
    foreach($CuteExplorer->files as $current_file) {
?>
        <tr onclick="window.location='<?=$CuteExplorer->make_link($current_file)?>'">
            <td class="icon">
                <img src="<?=$CuteExplorer->set_icon($current_file)?>" width="<?=$CuteExplorer->get_config('icon_size')?>" height=auto />
            </td>
            <td class="name"><?=$current_file?></td>
            <td class="size"><?=$CuteExplorer->get_file_size($current_file)?></td>
            <td class="mtime"><?=$CuteExplorer->get_file_mtime($current_file)?></td>
        </tr>
<?php
    }
?>
    </table>
    <p>Cute PHP Explorer © 2015 &lt;dev@lara.click&gt;</p>
    <p>The icons are based on MeliaSVG icon theme pack.<br/>
       Thanks to Andrea Soragna.</p>
</body>

</html>
