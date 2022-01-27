var _pPT_locationStr			= "";
var _pPT_referrerStr			= "";
var _pPT_browserNameStr			= "";
var _pPT_browserVerStr			= "";

var _pPT_httpPostObj;
var _pPT_currentDate			= new Date();
var _pPT_currentTime			= _pPT_currentDate.getTime();
var _pPT_trackEnabled			= true;
var _pPT_trackCounter			= 0;
var _pPT_useragentStr			= "";

// Database record IDs
var _pPT_siteCodeStr			= "";
var _pPT_docCodeStr				= "";
var _pPT_siteIDLong				= 0;
var _pPT_docIDLong				= 0;
var _pPT_docUUIDStr                = ""
var	_pPT_debug					= false;
var _pPT_debugStr				= "";

function _PT_SilentVoid() { return; }
function _PT_LogDebug(pText, _pDebug) {
//console.log('Console log:' + _pDebug); if(_pDebug) console.log(pText);
}


function _PT_PageTracker()
{

var	_pPT_debug					= false;
_PT_LogDebug(_PT_PageTracker, _pPT_debug);

if(window.location) {
_pPT_locationStr			= window.location.href;
}

if(document.referrer) {
_pPT_referrerStr			= document.referrer;
pRegexPat = /\&/g;
_pPT_referrerStr = _pPT_referrerStr.replace(pRegexPat, "__kmaskand__");
}

if(navigator.userAgent) {
_pPT_useragentStr		= navigator.userAgent;
}

if(navigator.appName) {
_pPT_browserNameStr		= navigator.appName;
}

if(navigator.appVersion) {
_pPT_browserVerStr		= navigator.appVersion;
}

/* if(_pPT_locationStr.indexOf(_pPT_siteCodeStr) == -1 && _pPT_trackCounter != 0) { // WILL MAKE SURE 1 CALL PER SESSION */
if(_pPT_trackCounter != 0) { // WILL MAKE SURE 1 CALL PER SESSION
_pPT_trackEnabled = false;
}

if(_pPT_trackEnabled) { _PT_SendTrackedData(); }

}

function _PT_SendTrackedData()
{

if(_pPT_debug) _pPT_debugStr	= "on";
var _pPT_postDatastr			=
								"&site_code=" + encodeURI( _pPT_siteCodeStr ) +
								"&referrer=" + encodeURI( _pPT_referrerStr ) +
								"&location=" + encodeURI( _pPT_locationStr ) +
								"&site_id=" + encodeURI( _pPT_siteIDLong ) +
								"&useragent=" + encodeURI( _pPT_useragentStr ) +
								"&debug=" + encodeURI( _pPT_debugStr ) +
								"&doc_code=" + encodeURI( _pPT_docCodeStr ) +
								"&doc_uuid=" + encodeURI( _pPT_docUUIDStr ) +
								"&doc_id=" + encodeURI( _pPT_docIDLong ) +
								"&browser_name=" + encodeURI( _pPT_browserNameStr ) +
								"&browser_ver=" + encodeURI( _pPT_browserVerStr ) +
								"&timestamp=" + _pPT_currentTime;
								"&random=" + Math.random();
                                
var	_pPT_debug					= false;
_PT_LogDebug(_pPT_postDatastr, _pPT_debug);

  var _pPT_TrackerImageObj=new Image(1,1);
  _pPT_TrackerImageObj.src="http://pagetracker.jobshout.co.uk/_pageTracker.php?_p="+_pPT_postDatastr;
  _pPT_TrackerImageObj.onload=function() {_PT_SilentVoid();}

_pPT_trackCounter++;

}
 
