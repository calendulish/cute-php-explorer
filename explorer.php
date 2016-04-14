<h1 class="title"><?=$CuteExplorer->get_config('title')?></h1>
<?php
if($CuteExplorer->get_value('error_code') == 404) {
    print('<p class="error">The file or directory you tried to access does not exist.</p>');
}
if($CuteExplorer->get_value('error_code') == 403) {
    print("<p class='error'>You don't have permission to access the requested page or file.</p>\n");
    print("<p class='error'>Please, if you need to access, login in the form bellow.</p>\n");
}

// If the user is not logged in and form is enabled
// then show the login form.
if($CuteExplorer->get_config('login')) {
    if(!isset($_SESSION['users'])) {
?>
    <form method="post">
        <p class="login">
            User: <input type="text" pattern=".{3,}" required title="You need at least 3 characters" name="user" size="20">
            Password: <input type="password" pattern=".{5,}" required title="You need at least 5 characters" name="passwd" size="20">
            <input type="submit" name="login" value="Login">
        </p>
    </form>
<?php
        // If the user or password is incorrect, show a info message.
        if(isset($_POST['login'])) {
            print("<p class='error'>Incorrect login. Try again.</p>");
        }
    // If the user is already logged in, show the user info and logout button.
    } else {
?>
    <form method="post">
        <p>
            You are logged in as <?=$_SESSION['users']?>.
            <input type="submit" name="logout" value="Logout">
        </p>
    </form>
<?php
    }
}

if($CuteExplorer->get_config('current_directory')) {
    if($CuteExplorer->get_value('dir')) {
        print('<p class="current_directory">~'.$CuteExplorer->get_value('dir')."</p>\n");
    } else {
        print("<p class='current_directory'>~/</p>\n");
    }
}
?>
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
                <img alt="previous directory" src="<?=$CuteExplorer->set_icon($_GET['dir'])?>" width="<?=$CuteExplorer->get_config('icon_size')?>" />
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
                <img alt="directory" src="<?=$CuteExplorer->set_icon($current_directory)?>" width="<?=$CuteExplorer->get_config('icon_size')?>" />
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
                <img alt="file" src="<?=$CuteExplorer->set_icon($current_file)?>" width="<?=$CuteExplorer->get_config('icon_size')?>" />
            </td>
            <td class="name"><?=$current_file?></td>
            <td class="size"><?=$CuteExplorer->get_file_size($current_file)?></td>
            <td class="mtime"><?=$CuteExplorer->get_file_mtime($current_file)?></td>
        </tr>
<?php
    }
?>
    </table>
<?php
if($CuteExplorer->get_config('theme_form')) {
?>
    <form method="POST">
        <p class="theme">
            Select a theme here:
            <select name='theme' onchange='this.form.submit()'>
                    <option <?=($_SESSION['theme'] == 'purple')?'selected':''?>>purple</option>
                    <option <?=($_SESSION['theme'] == 'blue')?'selected':''?>>blue</option>
                    <option <?=($_SESSION['theme'] == '386')?'selected':''?>>386</option>
            </select>
        </p>
    </form>
<?php
}
?>
    <p>Cute PHP Explorer © 2015 &lt;dev@lara.click&gt;</p>
    <p>The icons are based on MeliaSVG icon theme pack.<br/>
       Thanks to Andrea Soragna.</p>
