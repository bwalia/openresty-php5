<?php

	/**********************************************************************
	*  Author: Balinder WALIA (bwalia@tenthmatrix.co.uk)
	*  Web...: http://twitter.com/balinderwalia
	*  Name..: myCache
	*  Desc..: myCache Core module - cache to make site pages faster and avoid DB connections until cached.
	*  Dependancies..: myCache may require memcache server if using memcache.
	*/

	/**********************************************************************
	*  myCache Constants
	*/

	define('CACHE_VERSION','1.01');
	define('CACHE_TYPE','MEM_CACHE',true);
	

	/**********************************************************************
	*  Core class containg common functions to make web pages faster from web servers using memcache.caching.php
	*/

require_once('memcache.caching.php');

if ( ! class_exists ('CacheMemcache') ) die('<b>Fatal Error:</b> myCacheCore requires CacheMemcache (memcache.caching.php) to be included/loaded before it can be used');

class myCacheCore extends CacheMemcache
{

		var $mem_cache_enabled            	= false;  // cache pages
		var $exit_on_cache           		= true;  // cache pages
		var $cache_url_txt        			= '';  // 
		var $cache_url_md5        			= '';  // 
		var $debug_all        				= false;  // same as $trace
		var $cache_content_txt        		= '';  // 
		var $cache_timestamp        		= 0;  // 
		var $show_just_cached        		= false;  // 

function __get_Cached_Content()
{

$this->__cache_GetFromMemCache();

if( $this->debug_all ) {
echo '<!-- __get_Cached_Content: ' . $this->cache_content_txt . ' -->';
}

if ( $this->cache_content_txt == '' && false ) { $this->cache_content_txt = '<!-- cache is empty -->'; } //testing only

return $this->cache_content_txt;
}


function __set_Cached_Content()
{

$this->__cache_SetToMemCache();

if( $this->debug_all ) {
echo '<!-- __set_Cached_Content: ' . $this->cache_content_txt . ' -->';
}

}

function __cache_Start()
{

if( $this->mem_cache_enabled )
{

$this->cache_url_txt    = 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING']; // requested dynamic page (full url)

if( $this->debug_all ) {
echo '<!--  __cache_Start cache_url_txt: '. $this->cache_url_txt .'-->';
}

$this->cache_url_md5    = md5($this->cache_url_txt);

if( $this->debug_all ) {
echo '<!--  __cache_Start cache_url_md5: '. $this->cache_url_md5 .'-->';
}

if ( $this->cache_timestamp == 0) { 
$this->cache_timestamp = time();

if( $this->debug_all ) {
echo '<!--  __cache_Start -->';
}

}

if( $this->debug_all ) {
echo '<!-- __cache_Start -->';
}

$this->__get_Cached_Content();

if( $this->cache_content_txt !='' )
{

echo $this->cache_content_txt;

if ( $this->exit_on_cache===true )
{
exit;
}

}


}

}



function __cache_End()
{

if( $this->mem_cache_enabled )
{

if( $this->debug_all ) {
echo '<!-- __cache_End -->';
}

}

}


function __cache_SetToMemCache()
{

if( $this->mem_cache_enabled && $this->cache_content_txt != '' && $this->cache_url_md5 != '')
{
//open connection to memcache

$this->setData( $this->cache_url_md5, $this->cache_content_txt ); // saving data to cache server

if( $this->debug_all ) {
echo '<!-- __cache_SetToMemCache timestamp' . $this->cache_timestamp . ' -->';
}

}

}


function __cache_GetFromMemCache()
{

if( $this->mem_cache_enabled )
{

$this->cache_content_txt = $this->getData($this->cache_url_md5); // lets try to get data agai

if( $this->debug_all ) {
echo '<!-- __cache_GetFromMemCache -->';
}

}

}

}

?>