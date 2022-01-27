<?php
$disable_mem_cache=true;
if ( !isset($disable_mem_cache) )
{
$disable_mem_cache=false;
}

if ( !class_exists('Memcache') )
{
$disable_mem_cache=true;
}

if ( !empty($_POST) )
{
$disable_mem_cache=true;
}

if ( !isset($cache_time))
{
$cache_time     = 3600;
} //Cache file expires after these seconds (1 hour = 3600 sec)

if ( $cache_time < 60 )
{
$cache_time=60;
}//what is the point of caching for less than 60 seconds

require_once 'cache_core.php';

$cacheObj = new myCacheCore();

$cacheObj->mem_cache_enabled	= !$disable_mem_cache;
$cacheObj->debug_all			= false;

$cacheObj->iTtl=$cache_time;

$cacheObj->__cache_Start();

if ( $cacheObj->mem_cache_enabled ) {	//start caching otherwise
ob_start();
}

?>