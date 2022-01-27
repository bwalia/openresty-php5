<?php 
//require_once("include/cache_start.php");
require_once("include/lib.inc.php"); 

//title
$tokenWindowStr = __token_getValue($db, 'blog-page-windowtitle'); 
if(isset($tokenWindowStr) && $tokenWindowStr!="" ){ 
	$pWindowTitleTxt= $tokenWindowStr; 
}

//meta description
$tokenMetaDescStr = __token_getValue($db, 'blog-page-metadescription'); 
if(isset($tokenMetaDescStr) && $tokenMetaDescStr!="" ){ 
	$pMetaDescriptionTxt= $tokenMetaDescStr; 
}

//meta keywords
$tokenMetaKeywordsStr = __token_getValue($db, 'blog-page-metakeywords'); 
if(isset($tokenMetaKeywordsStr) && $tokenMetaKeywordsStr!="" ){ 
	$pMetaKeywordsTxt= $tokenMetaKeywordsStr; 
}

include_once ("include/main-header.php"); 
$catcode='';
if(isset($_GET['category']) && $_GET['category']!=''){
	$catcode= $_GET['category'];
}
?>
<link rel="canonical" href="<?php echo SITE_PATH;?>/blog.php" />
</head>
<body>
<!--start header-->
	<?php include_once ("include/top-header.php"); ?>
<!--end header-->
<div class="container page-content">
	<div class="row"> 
	
    	<div class="col-sm-8 col-md-9" > 
		<div id="ImageLoadingDiv" style=" text-align:center; display: block; margin-top: 85px; margin-bottom: 20px;">
	Loading...<br />
    <img id="imgAjaxLoading" src="images/loading-3.gif"  style="border-width: 0px;" alt="">
 </div>
		<div id="content_area">
		
		</div>
     		
    	</div>
    	
    <div class="col-sm-4 col-md-3">
      	<!-- start recent posts-->
        <?php include_once("include/recent-posts.php"); ?>
        <!-- end recent posts-->
        
        <!-- start blog archives-->
        <?php include_once("include/blog-archive.php"); ?>
     	<!-- end blog archives-->
     
      	<!-- start blog categories-->
		<?php include_once("include/blog-categories.php"); ?>
		<!-- start blog categories-->
    </div>
  </div>
</div>
<?php include_once("include/footer.php"); ?>

<script type="text/javascript">
var month= "<?php if(isset($_GET['Month']) && $_GET['Month']!='') { echo $_GET['Month']; }else{ echo ''; }?>";
var year="<?php if(isset($_GET['Year']) && $_GET['Year']!=""){ echo $_GET['Year']; }else{ echo ''; }?>";
var category="<?php if(isset($_GET['category']) && $_GET['category']!=""){ echo $_GET['category']; }else{ echo ''; }?>";

	$(document).ready(function(){
		$.movePage(1);
	});

	$.movePage = function movePage(pageNum){
	
		$('#content_area').html("");
		$('#ImageLoadingDiv').show();
		$.ajax({
		  type : "GET",
		  url: "json-blogs.php?pageNum="+pageNum+"&cat="+category+"&month="+month+"&year="+year,
		  cache: false,
		  success: function(html){
			//alert(html);return false;
			if(html!='no'){
				$('#ImageLoadingDiv').hide();
				$('#content_area').html(html);
				
			}
		  }
		});
	}

</script>
	</body>
</html>
<?php
//require_once("include/cache_end.php");
?>