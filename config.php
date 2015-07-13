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

// if your files is on another directory, set here.
 $_CONFIG['files_dir']          = ".";

 // You can hidden some files,folder,extensions if you need.
 $_CONFIG['hidden_dirs']       = array("images", "tmp");
 $_CONFIG['hidden_files']      = array("");
 $_CONFIG['hidden_extensions'] = array("php", "css");

// Adjust the file mtime (modified time) format here.
// You can see the available formats at:
// http://php.net/manual/en/function.date.php
$_CONFIG['file_mtime_format'] = "d.m.y h:m";

?>
