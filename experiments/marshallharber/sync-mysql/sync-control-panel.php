<?php 

$allow_current_host= $_SERVER["SERVER_NAME"];
// Include ezSQL core
include_once "include_sync/ez_sql_core.php";
// Include ezSQL database specific component
include_once "include_sync/ez_sql_mysql.php";
require_once("../../private_config/constants.php"); // defined all constants
$fetchfromdb = new ezSQL_mysql(DB_USER,DB_PASSWORD,DB_NAME,DB_HOST);
?>
<!DOCTYPE html>
<html>


<head>
<title>MySQL DB Sync Wizard</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="../js/moment.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="lib/chosen.css">
<style>
  .custom-combobox {
    position: relative;
    display: inline-block;
  }
  .custom-combobox-toggle {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 0;
  }
  .custom-combobox-input {
    margin: 0;
    padding: 5px 10px;
}
  
</style>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="lib/chosen.jquery.js" type="text/javascript"></script>

<link REL="STYLESHEET" HREF="../css/bootstrap.css">
</head>

<body>

<div CLASS="container">
<div CLASS="table-bordered" STYLE="margin-top:20px;">

<h3 STYLE="margin-top:0px; padding:10px; background-color:#025DAA; color:#fff;">Local host (Sync DB to host):</h3>
<h4 STYLE="padding-left:10px">Select MySQL tables to sync data into Local host from Remote host:</h4>

<div class="form-horizontal"  STYLE="padding:5px 20px 10px 10px;">
    <div class="form-group" id="displayMsg">
      <label class="control-label col-sm-3">Local host (Sync DB to host):</label>
      <div class="col-sm-9">
    <input CLASS="form-control" id="this_host" name="this_host" value="<?php echo $_SERVER['SERVER_NAME']; ?>" readonly=true/>
      </div>
    </div>
	
	
	<div class="form-group">
      <label class="control-label col-sm-3">Remote host (Sync from host):</label>
      <div class="col-sm-9">
   <input CLASS="form-control" id="remote_host" name="remote_host" value="http://www2.marshallharber.com" />
      </div>
    </div>
	
	<div class="form-group">
      <label class="control-label col-sm-3">Table:</label>
      <div class="col-sm-9">
      	<?php 
      	//$fetchAllTablesQry = "SHOW TABLES FROM ".DB_NAME;
      	$fetchAllTablesQry = "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".DB_NAME."'";
      	$fetchAllTables=$fetchfromdb->get_results($fetchAllTablesQry);
      	if(count($fetchAllTables)>0){	?>
      	<select data-placeholder="Choose a table..." class="form-control chosen-select" multiple style="width:100%;" tabindex="4" name="table" id="table">
      	<?php
      		foreach($fetchAllTables as $tbNameStr) {	?>
    			<option value="<?php echo $tbNameStr->TABLE_NAME; ?>"><?php echo $tbNameStr->TABLE_NAME; ?></option>
		<?php	}	?>
		</select>
      	<?php	
      	} else{	?>
  		<input CLASS="form-control" id="table" name="table" value="documents" />
  		<?php } ?>
      </div>
    </div>
	
	<!--<div class="form-group">
      <label class="control-label col-sm-3">Key field name:</label>
      <div class="col-sm-9" id="keyFieldDiv">
 		<input CLASS="form-control" id="keyField" name="keyField" value="GUID" />
      </div>
    </div>-->
	
	<div class="form-group">
		<label class="control-label col-sm-3">Sync date start from</label>
      	<div class="col-sm-2">
  			<input CLASS="form-control" id="offset_timestamp" name="offset_timestamp" value=0 type="hidden"/>
			<input CLASS="form-control" id="start_timestamp" name="start_timestamp" value="" type="hidden"/>
 			<input CLASS="form-control datepicker" id="start_date" name="start_date" value="" type="text"/>
      	</div>
    	<div class="col-sm-2">
      		<button onclick="fetchAvailableTimestamp('start_date', 'start')" CLASS="btn btn-danger">Suggest a start date</button>
      	</div>
		<label class="control-label col-sm-1">Sync till date end</label>
      	<div class="col-sm-2">
 			<input CLASS="form-control" id="end_timestamp" name="end_timestamp" value="" type="hidden"/>
 			<input CLASS="form-control datepicker" id="end_date" name="end_date" value="" type="text"/>
      	</div>
      	<div class="col-sm-2">
      		<button onclick="fetchAvailableTimestamp('end_date', 'end')" CLASS="btn btn-danger">Suggest an end date</button>
      	</div>
    </div>
	<div class="form-group">
      <label class="control-label col-sm-3">Sync state:</label>
      <div class="col-sm-9">
<input CLASS="form-control" id="sync_state" name="sync_state" value=0 />
      </div>
    </div>
	
	
	<div class="form-group text-right">        
      <div class="col-sm-offset-3 col-sm-9">
	  
	 <button onclick="sync_set_state_start(); sync_restart()" CLASS="btn btn-primary ">Start Sync</button>
	 <button onclick="sync_set_state_stop()" CLASS="btn btn-danger">Stop Sync</button>
     <button onclick="$('#showdates').html('');$('#demo').html('');return false;" CLASS="btn btn-danger">Clear Log</button>
      </div>
    </div>
</div>

<p id="json"></p>
</div>
<div CLASS="table-bordered" STYLE="margin-top:20px;display:none;"  id="logDiv">
	<h3 STYLE="margin-top:0px; padding:10px; background-color:#025DAA; color:#fff;">Log</h3>
	<div class="table-responsive" style="margin:20px;">
		<h4 STYLE="margin-top:0px; padding:1px; background-color:#025DAA; color:#fff;text-align:center;" id="showdates"></h4>
		<table class="table table-bordered">
			<tbody  id="demo">
		
			</tbody>
		</table>
	</div>
</div>
</div>
<script>
<?php foreach($fetchAllTables as $tbNameStr) {	?>
	var <?php echo $tbNameStr->TABLE_NAME; ?>Arr = [];

<?php	 $queryColNameStr="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_NAME = '".$tbNameStr->TABLE_NAME."' AND TABLE_SCHEMA = '".DB_NAME."'";
		 $fetchAllColumns=$fetchfromdb->get_results($queryColNameStr);
		 if(count($fetchAllColumns)>0){
			foreach($fetchAllColumns as $row) {	?>
				<?php echo $tbNameStr->TABLE_NAME; ?>Arr.push('<?php echo $row->COLUMN_NAME;	?>');
		<?php	}	
		}
}	?>

var configDropDown = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
}
for (var selector in configDropDown) {
   $(selector).chosen(configDropDown[selector]);
}

function fetchAvailableTimestamp(e, fetchStr){
	var selectedTablenameArr = [];
	$('#table :selected').each(function(i, selected){ 
		selectedTablenameArr[i]= $(selected).val(); 
	});
				
	var selectedTablesStr= selectedTablenameArr.toString(); 
		
		var vURLStr =  '/sync-mysql/fetchUnixTimestamp.php?remote_host=' + document.getElementById("remote_host").value + '&tables='+selectedTablesStr+'&fetch='+fetchStr;
		$.getJSON( vURLStr , function( result ) {
			if(result.error){
				alert(result.error);
			}else{
			console.log(fetchStr + ' date: ' + result.date);
	
			if(result.date){
				$("#"+e).val(result.date);
			}
			
			console.log(fetchStr + ' timestamp: ' + result.timestamp);
			
			if(result.timestamp){
				if(fetchStr=="end"){
					$("#end_timestamp").val(result.timestamp);
				}else{
					$("#start_timestamp").val(result.timestamp);
				}
			}
			}
		});

}

function getTimestamp(dateString){
	var dateParts = dateString.split('/'), date;
	date = new Date(dateParts[2], parseInt(dateParts[0])-1, dateParts[1]);
	date= date.getTime();
	date= parseInt(date)/1000;
	return date;
}

$( document ).ready(function() {
	
		// datepicker plugin
		$("#start_date").datepicker({
  			onSelect: function() {
  				var startdate= $('#start_date').val();
   		 		var startTimestamp= getTimestamp(startdate);
				$('#start_timestamp').val(startTimestamp);
 		 	}
		});
		$("#end_date").datepicker({
  			onSelect: function() {
  				var dateStr= $('#end_date').val();
   		 		var date_timestamp= getTimestamp(dateStr);
				$('#end_timestamp').val(date_timestamp);
 		 	}
		});	
});

function sync_set_state_stop() {
	$('#sync_state').val(0);
	$('#offset_timestamp').val(0);
}

function sync_set_state_start() {
	$('#sync_state').val(1);
}

function sync_restart() {

if($('#sync_state').val() == 1)	{	
	$(".alert").remove();
	if($("#this_host").val()==""){
		var errorStr="<div class='alert alert-danger'>Please enter Local host</div>";
		$("#displayMsg").before(errorStr);
		return false;
	}
	if($("#remote_host").val()==""){
		var errorStr="<div class='alert alert-danger'>Please enter Remote host</div>";
		$("#displayMsg").before(errorStr);
		return false;
	}
	if($("#table").val()==""){
		var errorStr="<div class='alert alert-danger'>Please select table</div>";
		$("#displayMsg").before(errorStr);
		return false;
	}
	if($("#keyField").val()==""){
		var errorStr="<div class='alert alert-danger'>Please enter Key field</div>";
		$("#displayMsg").before(errorStr);
		return false;
	}
	if($("#timestamp").val()==""){
		var errorStr="<div class='alert alert-danger'>Please enter timestamp</div>";
		$("#displayMsg").before(errorStr);
		return false;
	}
	if($("#start_timestamp").val()==""){
		var errorStr="<div class='alert alert-danger'>Please select sync from start date</div>";
		$("#displayMsg").before(errorStr);
		$("#start_date").focus();
		return false;
	}
	if($("#end_timestamp").val()==""){
		var errorStr="<div class='alert alert-danger'>Please select sync to end date</div>";
		$("#displayMsg").before(errorStr);
		$("#end_date").focus();
		return false;
	}
	console.log('sync_restart called');
	$("#logDiv").show();
	setTimeout(sync_fetch_TableChangedRows, 1000);
	
	} else {
		console.log('sync state is 0');
	}
}

function getKeyFieldValue(table){
	var primaryKeyStr="";
	var tableNameArr = eval(table+'Arr');
	
	if($.inArray( "GUID", tableNameArr )!==-1){
		primaryKeyStr="GUID";
	}else if($.inArray( "guid", tableNameArr )!==-1){
		primaryKeyStr="guid";
	}else if($.inArray( "uuid", tableNameArr )!==-1){
		primaryKeyStr="uuid";
	}else if($.inArray( "UUID", tableNameArr )!==-1){
		primaryKeyStr="UUID";
	}else if($.inArray( "ID", tableNameArr )!==-1){
		primaryKeyStr="ID";
	}else {
		var vURLStr = '/sync-mysql/fetchTableColumns.php?table='+table+'&columns=pri';
		$.getJSON( vURLStr , function( data ) {
			if(data.error){
				var printContent="<tr><td><strong>Result: </strong>No primary field found for ["+table+"] table</td></tr>";
				$("#demo").prepend(printContent);
			}else{
				$.each(data, function(i, field){
					primaryKeyStr=field;
				});
			}
		});
	}
	return primaryKeyStr;
}

function sync_fetch_TableChangedRows() {
	if( $('#sync_state').val() == 1 )	{
		var startdate= $('#start_date').val();
		var startTimestamp = moment(startdate).unix();

		//alert(startdate + ' -> startTimestamp: ' + startTimestamp+ ' - converted: '+moment.unix(startTimestamp).format("DD/MM/YYYY"));

		$('#start_timestamp').val(startTimestamp);

		var nStart=parseInt($('#offset_timestamp').val());
		if(	nStart==0	){	nStart	=	startTimestamp;	}
		var nEnd = nStart + 86000;

		var endDate= $('#end_date').val();
		var endTimestamp = moment(endDate).unix();

		if(nStart > endTimestamp)	{
			$('#sync_state').val(2);//finished
		}
	
		$('#table :selected').each(function(i, selected){ 
			var selectedTablenameStr = $(selected).val(); 
  			var keyFieldStr=getKeyFieldValue(selectedTablenameStr);
  	
   			var vURLStr = document.getElementById("remote_host").value + '/sync-mysql/sync_fetch_changed_rows.php?table='+selectedTablenameStr+'&key='+keyFieldStr;
    		vURLStr += '&start_timestamp='+nStart+'&end_timestamp='+nEnd+'&source_host=<?php echo $allow_current_host; ?>&'+Math.random();
    		
			//console.log(nStart);
			
			var printContent='<tr><td>'+ vURLStr + ', (<b>start:</b> ' +moment.unix(nStart).format("DD/MM/YYYY")+ ', <b>end:</b> ' +moment.unix(nEnd).format("DD/MM/YYYY")+ ')';
			
			$("#showdates").html('Syncing...data in ' + selectedTablenameStr + ' table from date: ' +moment.unix(nStart).format("DD/MM/YYYY")+ ' till : ' +moment.unix(nEnd).format("DD/MM/YYYY"));
			$("#demo").prepend();
			
			$.getJSON( vURLStr , function( data ) {
				$.each(data, function(i, field){
           			printContent+="<br /><strong>Result: </strong>"+field + " </td></tr>";
            		$("#demo").prepend(printContent);
					//console.log(field);
					sync_fetch_Row(field, keyFieldStr, selectedTablenameStr);
       			});
			});
		});

		$('#offset_timestamp').val(nEnd);
		sync_restart();

	} else {
	console.log('sync state is 0');
	}
}

function sync_fetch_Row(pUUID,keyField, table)
{

if(pUUID==='no records found')
{

}else{

vURLStr = '/sync-mysql/sync-control-panel-sync-row.php?remote_host='+document.getElementById("remote_host").value+'&table='+table+'&key='+keyField+'&uuid='+pUUID+'&source_host=<?php echo $allow_current_host;?>&'+Math.random();
//y = document.getElementById("demo").innerHTML;
//document.getElementById("demo").innerHTML = '<a target=_blank href=' + vURLStr + '>' + vURLStr + '</a><br />' + y;

var printContentStr='<tr><td><a target=_blank href=' + vURLStr + '>' + vURLStr + '</a>';

$.getJSON( vURLStr , function( data ) {
	printContentStr+='<br><b>Response: </b>'+data.response+'</td></tr>'
	$("#demo").prepend(printContentStr);
});
/**/
}

}

</script>

</body>
</html>