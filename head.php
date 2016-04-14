<!--
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
-->

<link href="<?=$CuteExplorer->set_theme()?>" rel="stylesheet" type="text/css" />
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

window.addEventListener('load', function() {
    check_size();
    window.addEventListener('resize', check_size);
});
</script>
