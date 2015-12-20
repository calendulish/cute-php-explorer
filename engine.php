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
    var $base_dir;

    function normalize_slashes($path) {
        return preg_replace('#/+#', '/', $path);
    }

    function get_value($param) {
        if(isset($_GET[$param])&&!empty($_GET[$param])) {
            return $_GET[$param];
        }
    }

    function get_config($value) {
        global $_CONFIG;
        if(isset($_CONFIG[$value])&&!empty($_CONFIG[$value])) {
            return $_CONFIG[$value];
        }
    }

    function get_public_path($file, $type = "file") {
        // Get current $path from URI
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        // FIXME: Remove the index.php from $path
        $path = str_replace("index.php", "", $path);
        $path .= '/'.$this->get_config('files_dir');
        if($type != 'dir') {
            $path .= '/'.$this->get_value('dir');
        }
        $path .= "/".$file;
        return $this->normalize_slashes($path);
    }

    function get_real_path($file, $type = "file") {
        $path = $_SERVER['DOCUMENT_ROOT'];
        return $this->normalize_slashes($path.'/'.$this->get_public_path($file, $type));
    }

    function get_file_size($file) {
        $rawsize = filesize($this->get_real_path($file));

        if($rawsize < pow(2, 10)) {
            return $rawsize." bytes";
        } elseif($rawsize < pow(2, 20)) {
            return round($rawsize / pow(2, 10), 2)." Kb";
        } elseif($rawsize < pow(2, 30)) {
            return round($rawsize / pow(2, 20), 2)." Mb";
        } else {
            return round($rawsize / pow(2, 30), 2)." Gb";
        }
    }

    function get_file_extension($file) {
        $extension = strtolower(pathinfo($this->get_real_path($file), PATHINFO_EXTENSION));
        // FIXME: Workaround for tar.xx extensions until mimetype support is available here.
        $sub = explode(".", $file);
        if(count($sub) > 2) {
            if($sub[count($sub)-2] == "tar") {
                return "tar.".$extension;
            }
        }

        return $extension;
    }

    function get_file_mtime($file) {
        return date($this->get_config('file_mtime_format'), filemtime($this->get_real_path($file)));
    }

    function set_theme() {
        $full_path = $this->base_dir."/themes/".$_SESSION['theme']."/style.css";
        // If the theme doesn't exist, try the fallback css
        if(!file_exists($full_path)) {
            return $this->base_dir."/themes/style.css";
        }

        return $full_path;
    }

    function set_icon($item) {
        $icons_path = $this->base_dir."/themes/".$_SESSION['theme']."/icons/";
        $icon = $this->get_file_extension($item).".svg";

        if(is_dir($this->get_real_path($item, "dir"))) {
            return $this->normalize_slashes($icons_path."/directory.svg");
        }

        // For each extension in $_CONFIG['merged_extensions'], check your values
        foreach(array_keys($this->get_config("merged_extensions")) as $extension) {
            // If current file extension is found on these values
            // change the icon to reflect the current $extension value.
            if(in_array($this->get_file_extension($item), $this->get_config("merged_extensions")[$extension])) {
                $icon = $extension.".svg";
            }
        }

        if(file_exists($icons_path."/".$icon)) {
            return $this->normalize_slashes($icons_path."/".$icon);
        } elseif(file_exists($this->base_dir."/themes/icons/".$icon)){
            return $this->base_dir."/themes/icons/".$icon;
        } else {
            if(file_exists($icons_path."/unknown.svg")) {
                return $this->normalize_slashes($icons_path."/unknown.svg");
            } else {
                return $this->base_dir."/themes/icons/unknown.svg";
            }
        }
    }

    function read_dir() {
        $this->directories = array();
        $this->files = array();
        $full_path = realpath($this->get_config('files_dir').'/'.$this->get_value('dir'));
        if($full_path != getcwd()) {
            $public_path = substr($full_path, strlen(getcwd())+1).'/';
        } else {
            $public_path = "";
        }

        // When the user is not cool (block access to internal folders)
        if(strpos($this->get_value('dir'), '..') !== false) {
            $this->make_error('403');
        }
        // If the param is not a directory, show an error
        if(!is_dir($full_path)) {
            $this->make_error('404');
        }
        // check if the user can access current directory
        if(!isset($_SESSION['users'])&&in_array(rtrim($public_path, '/'), $this->get_config('hidden_dirs'))) {
            $this->make_error('403');
        }
        $pDir = opendir($full_path);
        while(false !== ($current_file = readdir($pDir))) {
            // ignore directories starting with '.' (previous or hidden)
            if(substr($current_file, 0, 1) == '.') continue;
            // don't show directories from $hidden_dirs
            if(is_dir($full_path.'/'.$current_file)) {
                // If the user is logged in, show anyway.
                // If the user is not logged in, check the $hidden_dirs
                if(isset($_SESSION['users'])||!in_array($public_path.$current_file, $this->get_config('hidden_dirs'))) {
                    $this->directories[] = $this->get_value('dir').'/'.$current_file;
                }
            } else { //don't show files from $hidden_files and files matched with hidden_extensions
                // If the user is logged in, show $hidden_files but hidden $hidden_extensions.
                // If the user is not logged in, check both $hidden_files and $hidden_extensions
                if(isset($_SESSION['users'])||!in_array($public_path.$current_file, $this->get_config('hidden_files'))) {
                    if(!in_array(strtolower(pathinfo($public_path.$current_file, PATHINFO_EXTENSION)),
                        $this->get_config('hidden_extensions'))) {
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
            unset($params["error_code"]);
            $link = "?".urldecode(http_build_query($params));
        } else {
            $link = "?dir=".$current_directory;
        }

        return $link;
    }

    function make_link($current_file) {
        return $this->get_public_path($current_file);
    }

    function make_error($code) {
      $query = parse_url($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], PHP_URL_QUERY);

      if($query) {
          parse_str($query, $params);
          unset($params["dir"]);
          $params["error_code"] = $code;
          $link = "?".urldecode(http_build_query($params));
      } else {
          $link = "?error_code=".$code;
      }

      header('Location: '.$link);
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
