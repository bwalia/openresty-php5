<script type="text/javascript">

/*_gSiteCodeStr		= "jobshout";
_gSiteIDLong			= 7610;
_gDocCodeStr		= "page-url-code";*/

var _gSiteIDLong							= 3320;  
var _gSiteCodeStr							= "marshallharber";  
var _gDocIDLong								= 0;  
var _gDocUUIDStr							= "";  
var _gUnixTimestampCreated					= 0;  
var _gUnixTimestampModified					= 0;  
var _gDocCodeStr							= document.location;
var wiDebug									= false;
</script>

<!--Jobshout pagetracker for traffic analysis/stats-->
<script src="js/_pageTracker.js" type="text/javascript"></script>

<script type="text/javascript">

// _gSiteCodeStr		= "your site code here";
// _gSiteIDLong			= 7610;
// _gDocCodeStr		= "page-url-code";


	// set your account name
if(window._gSiteCodeStr) {

if(_gSiteCodeStr == ''){
_gSiteCodeStr 			= "jobshout"; //workstation
}

} else	{ var _gSiteCodeStr 			= "jobshout"; }
if(window._gSiteIDLong)	{		_pPT_siteIDLong			= _gSiteIDLong; }
if(window._gDocIDLong)		{	_pPT_docIDLong			= _gDocIDLong; }
if(window._gDocCodeStr)	{		_pPT_docCodeStr			= _gDocCodeStr;	}

_pPT_siteCodeStr								= _gSiteCodeStr; // MUST BE PASSED

	// trackes the data
/* Example calls , all cases or conditional calls*/
//_PT_PageTracker();
var thisLocationStr		= "";
if(window.location) {
thisLocationStr			= window.location.href;
}
if(thisLocationStr.indexOf('.marshallharber.com') != -1 || thisLocationStr.indexOf('marshallharber.jobshout.co.uk') != -1) {
_pPT_debug = wiDebug;
_PT_PageTracker();
}
</script>
<!--Jobshout pagetracker for traffic analysis/stats-->