<?php require_once("submit-contact.php"); ?>
<?php include_once("include/main-header.php"); ?>
   
  </head>
  <body>
  <?php include_once("include/top-header.php"); ?>
    <div class="container page-content">
   	    <div class="row">
        	
           
           
           <div class="col-sm-12 ">
		   
           <h2 style="margin-top:15px;" >
		   <?php if(isset($success)){ ?>
		   Thank You
		   <?php } else{ ?>
		   Error
		   <?php } ?>
		   </h2> 
           <div class="row">
           <div class="col-md-12">
        	 <?php if(isset($success)){ ?>
		   <div class="alert alert-success" role="alert"><i class="glyphicon glyphicon-ok" aria-hidden="true" ></i> <?php echo $success; ?></div>
		   <?php } if(isset($error)){ ?>
		   <div class="alert alert-danger" role="alert"><i class="glyphicon glyphicon-remove" aria-hidden="true" ></i> <?php echo $error; ?></div>
		   <?php } ?>

          </div>
      </div>      
           
            </div>
            
            </div>
       </div>
     <?php include_once("include/footer.php"); ?>

  </body>
</html>
