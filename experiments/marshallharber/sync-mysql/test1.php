<?php 
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
<title>Local host (Sync to host)</title>
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
  label.error {
    color: red;
    font-style: italic;
}
</style>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="lib/chosen.jquery.js" type="text/javascript"></script>
<link REL="STYLESHEET" HREF="../css/bootstrap.css">
</head>

<body>

<div CLASS="container">
<div CLASS="table-bordered" STYLE="margin-top:20px;">

<h3 STYLE="margin-top:0px; padding:10px; background-color:#025DAA; color:#fff;">Local host (Sync to host):</h3>
<h5 STYLE="padding-left:10px">Click the MySQL table from Remote http host to http Local host (see hosts below) .</h5>

<form class="form-horizontal" id="myform" method="post" STYLE="padding:5px 20px 10px 10px;">
    <div class="form-group" id="displayMsg">
      <label class="control-label col-sm-3">Local host (Sync to host):</label>
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
      	$fetchAllTablesQry = "SELECT TABLE_NAME  FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".DB_NAME."'";
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
	
	<div class="form-group">
      <label class="control-label col-sm-3">Key field of selected table(s):</label>
      <div class="col-sm-9" id="keyFieldDiv">
      	<select data-placeholder="Choose a key..." class="form-control chosen-select" multiple style="width:100%;" tabindex="4" name="keyField" id="keyField">
      		<option value="GUID">GUID</option>
      		<option value="ID">ID</option>
      		<option value="uuid">uuid</option>
      	</select>
 		<!--<input CLASS="form-control" id="keyField" name="keyField" value="GUID" />-->
      </div>
    </div>
	
	<div class="form-group drawColumns">
		<label class="control-label col-sm-3">Start Date</label>
      	<div class="col-sm-3">
  			<input CLASS="form-control" id="offset_timestamp" name="offset_timestamp" value=0 type="hidden"/>
			<input CLASS="form-control" id="start_timestamp" name="start_timestamp" value="" type="hidden"/>
 			<input CLASS="form-control datepicker" id="start_date" name="start_date" value="" type="text"/>
      	</div>
    
		<label class="control-label col-sm-2">End Date</label>
      	<div class="col-sm-3">
 			<input CLASS="form-control" id="end_timestamp" name="end_timestamp" value="" type="hidden"/>
 			<input CLASS="form-control datepicker" id="end_date" name="end_date" value="" type="text"/>
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
	  
	 <!--<button onclick="sync_set_state_start(); sync_restart()" CLASS="btn btn-primary ">Start Sync</button>-->
	 <input type="submit" class="btn btn-primary" value="Start Sync">
	 <button onclick="sync_set_state_stop(); return false;" CLASS="btn btn-danger">Stop Sync</button>
     
      </div>
    </div>
</form>

<p id="json"></p>
</div>
<div CLASS="table-bordered" STYLE="margin-top:20px;display:none;"  id="logDiv">
	<h3 STYLE="margin-top:0px; padding:10px; background-color:#025DAA; color:#fff;">Log</h3>
	<div class="table-responsive" style="margin:20px;">
	<table class="table table-bordered">
		<tbody  id="demo">
		
		</tbody>
	</table>
	</div>
</div>
</div>
<script src="../js/jquery.validate.js"></script>
<script>
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
    
function getTimestamp(dateString){
var dateParts = dateString.split('/'),
date;
date = new Date(dateParts[2], parseInt(dateParts[0])-1, dateParts[1]);
date= date.getTime();
date= parseInt(date)/1000;
return date;
}
$( document ).ready(function() {
	//apply validation
	$("#myform").validate({
		ignore: [],
  		rules: {
   			this_host: "required",
   			remote_host: "required",
   			table: "required",
   			start_date: "required",
   			end_date: "required"
  		},
  		submitHandler: function(form) {
  			sync_set_state_start(); sync_restart();
			return false;
  		}
	});

	
	//on tables selection
	$("#table").change(function(){
		var selectedTablesArr = []; 
		$('#table :selected').each(function(i, selected){ 
  			selectedTablesArr[i] = $(selected).val(); 
		});
				
		var selectedTablesStr= selectedTablesArr.toString(); 
		var vURLStr = '/sync-mysql/fetch-tables-fields.php?tables='+selectedTablesStr;
		$.getJSON( vURLStr , function( data ) {
			if(data.error){
			
			}else{
				$.each(data, function(key, value){	
					if($("#"+key).length){
						//not to draw dropdown again
					}	else{
						var tableColumns='', selectedItem='';
						tableColumns+='<div class="form-group tableColumns" id="'+key+'">';
						tableColumns+='<label class="control-label col-sm-3">'+key+'</label>';
						tableColumns+='<div class="col-sm-9"><select CLASS="form-control chosen-select columnSelectClass" id="column_'+key+'" name="column_'+key+'">';
						//tableColumns+='<option value="">--Select--</option>';
						$.each(value, function(i, field){
							if(field.toLowerCase()=="guid" || field.toLowerCase()=="uuid"){
								selectedItem=field;
							}
							tableColumns+='<option value="'+field+'">'+field+'</option>';
						});
						tableColumns+='</select></div>';
						tableColumns+='</div>';
						$(".drawColumns").before(tableColumns);
						
						//add validation
						$("#myform").validate(); //sets up the validator
						$("#column_"+key).rules("add", "required");
						
						//select default item
						if(selectedItem==""){
							selectedItem="ID";
						}
						$("#column_"+key).val(selectedItem);
					}
				});
			}
			
			//to draw searchable dropdowns
			for (var selector in configDropDown) {
      			$(selector).chosen(configDropDown[selector]);
   			}
   			
   			//to remove column's div of unselected tables
   			$('.tableColumns').each(function(i, existingDropdowns){ 
  				var perDiv = $(existingDropdowns).attr('id'); 
  				if ($.inArray(perDiv, selectedTablesArr) == -1)	{	//not found such table
					$(existingDropdowns).remove();
				}
			});
		});
	});

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
	alert();
	$('#sync_state').val(0);
	$('#offset_timestamp').val(0);
}

function sync_set_state_start() {
	$('#sync_state').val(1);
}

function sync_restart() {

if($('#sync_state').val() == 1)
{	
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
	if($("#start_timestamp").val()==""){
		var errorStr="<div class='alert alert-danger'>Please select start date</div>";
		$("#displayMsg").before(errorStr);
		$("#start_date").focus();
		return false;
	}
	if($("#end_timestamp").val()==""){
		var errorStr="<div class='alert alert-danger'>Please select end date</div>";
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
  				var selectedKeyFieldStr = $("#column_"+selectedTablenameStr).val(); 
		
    			var vURLStr = document.getElementById("remote_host").value + '/sync-mysql/sync_fetch_changed_rows.php?table='+selectedTablenameStr+'&key='+selectedKeyFieldStr;
    			vURLStr += '&start_timestamp='+nStart+'&end_timestamp='+nEnd+'&'+Math.random();
    
				console.log(nStart);
				var printContent='<tr><td>'+ vURLStr + ', (<b>start:</b> ' +moment.unix(nStart).format("DD/MM/YYYY")+ ', <b>end:</b> ' +moment.unix(nEnd).format("DD/MM/YYYY")+ ')';
				$("#demo").prepend();
				//y = document.getElementById("demo").innerHTML;
				//document.getElementById("demo").innerHTML =  vURLStr + ', (<b>' +myTime+ '</b>)<br />' + y;
				
			if(false){
				$.getJSON( vURLStr , function( data ) {

					//document.getElementById("json").innerHTML = data;
					$.each(data, function(i, field){
            			printContent+="<br /><strong>Result: </strong>"+field + " </td></tr>";
            			$("#demo").prepend(printContent);
						//console.log(field);
						sync_fetch_Row(field);
         			});
					$('#offset_timestamp').val(nEnd);
					sync_restart();
				});
			}else{
				$("#demo").prepend(printContent);
				$('#offset_timestamp').val(nEnd);
					sync_restart();
			}
		});	
	} else {
		console.log('sync state is 0');
	}
}

function sync_fetch_Row(pUUID)
{

if(pUUID==='no records found')
{

}else{
vURLStr = '/sync-mysql/sync-control-panel-sync-row.php?remote_host='+document.getElementById("remote_host").value+'&table='+document.getElementById("table").value+'&key='+document.getElementById("keyField").value+'&uuid='+pUUID+'&'+Math.random();
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