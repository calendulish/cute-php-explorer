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

if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("engine.php");

$CuteExplorer = new CuteExplorer();
//FIXME: We needs the path of current file, but in some cases a file can
// call this from another directory, and it will cause a fail to get the
// current path from getcwd. The dirname(__FILE__) can be an alternative.
$CuteExplorer->base_dir = basename(dirname(__FILE__));
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
                $CuteExplorer->make_error('403');
                exit;
            }
            break;
        }
    }
}

if(isset($_POST['theme'])) {
    $_SESSION['theme'] = $_POST['theme'];
} else {
    if(!isset($_SESSION['theme'])) {
        $_SESSION['theme'] = $CuteExplorer->get_config('theme');
    }
}
