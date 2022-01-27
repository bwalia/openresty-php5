<?php

if( $cacheObj->mem_cache_enabled )
{

$cacheObj->cache_content_txt = ob_get_contents();

if ( $cacheObj->cache_content_txt != '' )
{
$cacheObj->show_just_cached = true;
}

$cacheObj->cache_content_txt .= '<!-- Cached at: ' . date('d M Y h:m:s',$cacheObj->cache_timestamp) . ', host: ' . $_SERVER['SERVER_ADDR'] . ' -->';

$cacheObj->__set_Cached_Content();
$cacheObj->__cache_End();

ob_end_clean();

if( $cacheObj->debug_all ) {
echo 'cache_end: <textarea>' . $cacheObj->cache_content_txt . '</textarea>';
}

if( $cacheObj->show_just_cached ) {
echo $cacheObj->cache_content_txt;
exit;
}

}

?>