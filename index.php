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
?>

<!DOCTYPE html>
<html lang="en_US">

<head>
    <meta name="viewport" content="width=device-width" />
    <meta charset="utf-8" />
    <link href="cute-php-explorer.css" rel="stylesheet" type="text/css" />
    <title>Cute PHP Explorer</title>
</head>

<body>
    <table>
        <tr class="header">
            <td class="name"><a>name</a></td>
            <td class="size"><a>size</a></td>
            <td class="mtime"><a>modified time</a></td>
        </tr>
        <?php
            // make a item for previous directory
            if($CuteExplorer->get_value('dir')) {
                print("<tr>\n");
                print("<td class=\"name\" colspan=3><a href=\"".$CuteExplorer->make_query($CuteExplorer->get_previous_dir($_GET['dir']))."\">..</a></td>\n");
                print("</tr>\n");
            }
            // make a item for each folder
            foreach($CuteExplorer->directories as $current_directory) {
                print("<tr>\n");
                print("<td class=\"name\"><a href=\"".$CuteExplorer->make_query($current_directory)."\">".basename($current_directory)."</a></td>\n");
                print("<td class=\"size center\" colspan=2>Folder</td>\n");
                print("</tr>\n");
            }
            // make a item for each file
            foreach($CuteExplorer->files as $current_file) {
                print("<tr>\n");
                print("<td class=\"name\"><a href=\"".$CuteExplorer->make_link($current_file)."\">$current_file</a></td>\n");
                print("<td class=\"size\">".$CuteExplorer->get_file_size($current_file)."</td>\n");
                print("<td class=\"mtime\">".$CuteExplorer->get_file_mtime($current_file)."</td>\n");
                print("</tr>\n");
            }
        ?>


    </table>
<body>

</html>
