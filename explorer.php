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
    // make a item for previous directory
    if($CuteExplorer->get_value('dir')) {
?>
        <div class="item" onclick="window.location='<?=$CuteExplorer->make_query($CuteExplorer->get_previous_dir($_GET['dir']))?>'">
            <div class="icon">
                <img alt="previous directory" src="<?=$CuteExplorer->set_icon($_GET['dir'])?>" width="<?=$CuteExplorer->get_config('icon_size')?>" />
            </div>
            <div class="name" colspan=3>
                <a href="<?=$CuteExplorer->make_query($CuteExplorer->get_previous_dir($_GET['dir']))?>">..</a>
            </div>
        </div>
<?php }
    // make a item for each folder
    foreach($CuteExplorer->directories as $current_directory) {
?>
        <div class="item" onclick="window.location='<?=$CuteExplorer->make_query($current_directory)?>'">
            <div class="icon">
                <img alt="directory" src="<?=$CuteExplorer->set_icon($current_directory)?>" width="<?=$CuteExplorer->get_config('icon_size')?>" />
            </div>
            <div class="name">
                <a href="<?=$CuteExplorer->make_query($current_directory)?>"><?=basename($current_directory)?></a>
            </div>
            <div class="size center" colspan=2>Folder</div>
        </div>
<?php
    }
    // make a item for each file
    foreach($CuteExplorer->files as $current_file) {
?>
        <div class="item" onclick="window.location='<?=$CuteExplorer->make_link($current_file)?>'">
            <div class="icon">
                <img alt="file" src="<?=$CuteExplorer->set_icon($current_file)?>" width="<?=$CuteExplorer->get_config('icon_size')?>" />
            </div>
            <div class="name">
                <a href="<?=$CuteExplorer->make_link($current_file)?>"><?=$current_file?></a>
            </div>
            <div class="size"><?=$CuteExplorer->get_file_size($current_file)?></div>
        </div>
<?php
    }

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