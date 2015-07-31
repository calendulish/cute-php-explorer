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

include_once("config.php");
include_once("engine.php");

$CuteExplorer = new CuteExplorer();
$CuteExplorer->read_dir();

date_default_timezone_set($CuteExplorer->get_config("timezone"));
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
<?php if($CuteExplorer->get_value('dir')) {
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
