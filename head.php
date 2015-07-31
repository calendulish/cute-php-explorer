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
