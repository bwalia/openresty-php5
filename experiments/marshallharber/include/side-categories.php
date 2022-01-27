<h2>Jobs by Discipline</h2>
				 <?php
				 $query_cat= $db->get_results("select distinct(c.ID), c.Name, c.Code from categories c left join documentcategories dc on c.ID=dc.CategoryID left join documents d on dc.DocumentID=d.ID where c.SiteID='".SITE_ID."' and dc.SiteID='".SITE_ID."' and d.SiteID='".SITE_ID."' and d.type='job' and d.Status=1 order by c.Name asc");
				 if(count($query_cat)>0){
				 ?>
                 <ul class="jobs-cat">
				 <?php
				 foreach($query_cat as $cat){
				 	$query_docs= $db->get_var("select count(distinct(d.ID)) as num_jobs from documents d join documentcategories dc on d.ID=dc.DocumentID where dc.CategoryID='".$cat->ID."' and dc.SiteID='".SITE_ID."' and d.SiteID='".SITE_ID."' and d.type='job' and d.Status=1");
					
				 ?>
                     <li <?php if(isset($catcode) && $catcode==$cat->Code){  ?> class="current" <?php } elseif(isset($arr_cats) && in_array($cat->Code,$arr_cats)) { ?> class="current" <?php } ?> ><a href="job-board.php?category=<?php echo $cat->Code; ?>" ><?php echo $cat->Name; ?> (<?php echo $query_docs; ?>)</a></li>
                     
                   <?php } ?> 
				   <li <?php if((!isset($catcode) || $catcode=='') && !isset($arr_cats)){ ?> class="current" <?php } ?>><a href="job-board.php">View all Jobs</a></li>
                 </ul>
				 <?php } ?>
				 
                  <!--<div style="margin-top:15px; margin-bottom:15px;">
                 <form method="get" action="search-results.php" id="frm-srch-sm">
        			 <h2>Search Jobs</h2>
					<input type="text" name="srch" id="srch" value=""  class="form-control" style="margin-bottom:10px;">
                       				 <p><input type="submit" value="Submit" class="btn white-btn"></p>
				 </form>
                 </div>-->