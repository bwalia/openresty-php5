<?php 
require_once("include/lib.inc.php");
require_once('include/main-header.php'); 



if($token = $db->get_row("SELECT * FROM site_options where name='style-guide' and SiteID='".$_SESSION['site_id']."' and status='1'")){

$token_text=$token->value;
}
else{
$token_text='No help found.';
}
		

 ?>

    </head>
    <body>
		<div id="maincontainer" class="clearfix">
			<!-- header -->
            <header>
                <?php require_once('include/top-header.php');?>
            </header>
            
            <!-- main content -->
            <div id="contentwrapper">
                <div class="main_content">
                    
                    <nav>
                        <div id="jCrumbs" class="breadCrumb module">
	<ul>
		<li>
			<a href="home.php"><i class="icon-home"></i></a>
		</li>
		<li>
			<a href="index.php">Dashboard</a>
		</li>
		<li>
			<a href="#">Help for HTML</a>
		</li>
		
		
		<?php include_once("include/curr_selection.php"); ?>
	</ul>
</div>
               
                    </nav>
                    
					
                   <pre> <?php echo htmlentities($token_text); ?></pre>
                        
                </div>
            </div>
            
			<!-- sidebar -->
            <aside>
                <?php require_once('include/sidebar.php');?>
			</aside>
            
            <?php require_once('include/footer.php');?>
			 
		
			
			

			
		</div>
	</body>
</html>