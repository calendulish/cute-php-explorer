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

$_CONFIG['title'] = "Cute PHP Explorer";

// if your files is on another directory, set here.
 $_CONFIG['files_dir'] = ".";

// You can define an icon size (in pixels)
$_CONFIG['icon_size'] = 28;

// You can define a theme. Currently you can use:
// purple, blue or "386".
$_CONFIG['theme'] = "purple";

// You can merge some extensions using this array.
// Example 1:
// If you want only one icon for all image types, you can write:
// "<image>" => array("jpg", "png", "gif", "svg", ...);
// and put a file called "<image>.svg" on the folder of current icon theme.
//
// Example 2:
// If you want some extensions with same icon file, you can write:
// "txt" => array("doc", "conf");
// in this example, all files *.doc and *.conf will use the txt icon.
$_CONFIG['merged_extensions'] = array(
    "txt"      => array("conf", "config", "doc", "docx"),
    "xls"      => array("xlsx"),
    "tar.gz"   => array("tgz"),
    "odp"      => array("ppt", "pptx", "pps", "ppsx"),
    "jpg"      => array("jpeg"),
    "html"     => array("htm"),
    "py"       => array("pyo", "pyc", "pyd", "pyw"),
    "pl"       => array("plx","perl"),
    "sh"       => array("zsh", "csh", "tcsh", "ksh", "run", "fish", "bash"),
);

 // You can hide some files, directories, extensions if you need.
 // The path is relative to the current location of your index.php. In
 // other words, the variable $files_dir is not considered here.
 // Absolute paths (starting with '/') will not work for security reasons.
 $_CONFIG['hidden_dirs']       = array("cute-php-explorer");
 $_CONFIG['hidden_files']      = array("directory/example.file");
 $_CONFIG['hidden_extensions'] = array("php", "css");

// Adjust the file mtime (modified time) format here.
// You can see the available formats at:
// http://php.net/manual/en/function.date.php
$_CONFIG['file_mtime_format'] = "M d, Y - h:m";

// Adjust the timezone here.
// You can see the available timzeones at:
// http://php.net/manual/en/timezones.php
$_CONFIG['timezone'] = "Etc/UTC";

// Enable or Disable current directory (boolean)
$_CONFIG['current_directory'] = true;

// Enable or Disable theme selection form (boolean)
$_CONFIG['theme_form'] = true;

// Enable or Disable the login form (boolean)
$_CONFIG['login'] = true;

// You can define users and special permissions here.
// Use the securepass.php for generate a secure hash for your password.
// Below is an example with the user "testuser" and the password "testpsw".
$_CONFIG['users'] = array(
    'testuser' => '$2y$10$yfdJHtUyz41587CvX6rK6uxJwK5BTt5PoQBvsn6FS5AtwoTvwI2Ze',
);
