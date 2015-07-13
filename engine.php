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

 class CuteExplorer {
    var $directories;
    var $files;

    function get_value($param){
        if(isset($_GET[$param])&&!empty($_GET[$param])) {
            return $_GET[$param];
        }
    }

    function get_file_size($file) {
        global $_CONFIG;
        $rawsize = filesize($_SERVER["DOCUMENT_ROOT"].$file);

        if($rawsize < pow(2,10)) {
            return $rawsize." bytes";
        } elseif($rawsize < pow(2,20)) {
            return round($rawsize / pow(2,10), 2)." Kb";
        } elseif($rawsize < pow(2,30)) {
            return round($rawsize / pow(2,20), 2)." Mb";
        } else {
            return round($rawsize / pow(2,30), 2)." Gb";
        }
    }

    function get_file_mtime($file) {
        global $_CONFIG;
        return date($_CONFIG['file_mtime_format'], filemtime($_SERVER['DOCUMENT_ROOT'].$file));
    }

    function read_dir() {
        global $_CONFIG;
        $this->directories = array();
        $this->files = array();
        $full_path = $_CONFIG['files_dir'].'/'.$this->get_value('dir');
        $pDir = opendir($full_path);

        while(false !== ($current_file = readdir($pDir))) {
            // ignore directories starting with '.' (previous or hidden)
            if(substr($current_file, 0, 1) == '.') continue;
            // don't show directories from $hidden_dirs
            if(is_dir($full_path.'/'.$current_file)) {
                if(!in_array($current_file, $_CONFIG['hidden_dirs'])) {
                    $this->directories[] = $this->get_value('dir').'/'.$current_file;
                }
            } else { //don't show files from $hidden_files and files matched with hidden_extensions
                if(!in_array($current_file, $_CONFIG['hidden_files'])) {
                    if(!in_array(strtolower(pathinfo($full_path.'/'.$current_file, PATHINFO_EXTENSION)),
                        $_CONFIG['hidden_extensions'])) {
                        $this->files[] = $current_file;
                    }
                }
            }
        }
        closedir($pDir);
    }

    function make_query($current_directory) {
        $query = parse_url($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], PHP_URL_QUERY);

        // If any query exists, check if "[?&]dir=" is already present and updates it.
        if($query) {
            parse_str($query, $params);
            $params["dir"] = $current_directory;
            $link = "?".urldecode(http_build_query($params));
        } else {
            $link = "?dir=".$current_directory;
        }

        return $link;
    }

    function make_link($current_file) {
        // Get current $path from URI
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        // build the full path
        $full_path = $path. '/'.$this->get_value('dir')."/".$current_file;
        // normalize slashes and return
        return preg_replace('#/+#', '/', $full_path);
    }

    function get_previous_dir($current_directory) {
        // Remove last string if it's a "/"
        if(substr($current_directory, -1) == "/"){
            $current_directory = substr($current_directory, 0, $current_directory-1);
        }

        // return the $current_directory removing
        // all caracteries after the last "/"
        $pos = strrpos($current_directory, '/');
        return substr($current_directory, 0, $pos);
    }
}
