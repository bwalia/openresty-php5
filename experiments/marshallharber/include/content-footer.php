<?php $curr_file=basename($_SERVER['PHP_SELF']); ?>
<?php if($curr_file=="index.php"){	?>
<div id="defaultFooter">
    <div align="center">
        <p>
            <br />
            <a href="<?php echo SITE_WS_PATH; ?>/chef.asp" ><img src="images/text/defaultcatagories.gif" alt="Domestic recruitment - household staff" width="610" height="100" border="0" usemap="#Map" />
<map name="Map" id="Map"><area shape="rect" coords="6,4,137,28" href="<?php echo SITE_WS_PATH; ?>/housekeeper.asp" alt="housekeeper" /><area shape="rect" coords="141,6,228,27" href="<?php echo SITE_WS_PATH; ?>/butler.asp" alt="butler" /><area shape="rect" coords="233,4,304,26" href="<?php echo SITE_WS_PATH; ?>/valet.asp" alt="valet" /><area shape="rect" coords="311,5,427,27" href="<?php echo SITE_WS_PATH; ?>/chauffeur.asp" alt="chauffeur" /><area shape="rect" coords="435,4,607,28" href="<?php echo SITE_WS_PATH; ?>/couple.asp" alt="domestic couple" /><area shape="rect" coords="42,31,148,49" href="<?php echo SITE_WS_PATH; ?>/gardener.asp" alt="gardener" /><area shape="rect" coords="156,31,321,48" href="<?php echo SITE_WS_PATH; ?>/estatemanager.asp" alt="estate manager" /><area shape="rect" coords="331,31,431,48" href="<?php echo SITE_WS_PATH; ?>/houseman.asp" alt="houseman" /><area shape="rect" coords="439,31,565,48" href="<?php echo SITE_WS_PATH; ?>/ladysmaid.asp" alt="ladies maid" /><area shape="rect" coords="36,52,194,71" href="<?php echo SITE_WS_PATH; ?>/housemanager.asp" alt="house manager" /><area shape="rect" coords="202,51,401,73" href="<?php echo SITE_WS_PATH; ?>/personalassistants.asp" alt="personal assistant" /><area shape="rect" coords="409,53,557,72" href="<?php echo SITE_WS_PATH; ?>/cleaner.asp" alt="cleaner" /><area shape="rect" coords="235,76,372,94" href="<?php echo SITE_WS_PATH; ?>/chef.asp" alt="chef" /></map></a><br />
            <br />


		<?php	$tokenxmasTxt = __token_getValue($db, 'home-page-main-content');
		if($tokenxmasTxt!="" ){
			echo $tokenxmasTxt;
		}else{ ?>
            At Marshall Harber we have an impressive database of household staff. We insist
            that all candidates applying to register with us have a minimum of 2 years previous
            experience in private service with excellent checkable references. All candidates
            are interviewed and reference checked by one of our trained consultants.<br />
            <br />
            Our consultants have a true understanding of how difficult it can be to find the
            right member of staff for a household. Having worked in private service themselves,
            they have a unique advantage in being able to assist both candidates and clients
            find the perfect match.
		<?php } ?>
            <br />
            <br />
            <!--<a href="http://www.staff4you.net" target="_blank">
    <img src="images/icons/staff4you.jpg" alt="Domestic recruitment - household staff online - no agency fees"
                    width="249" height="96" /></a>-->
            <br />
        </p>
<p align="center"><g:plusone size="standard"></g:plusone>
An alternative to recruiting household staff, brought to you<br />by Marshall Harber</p>
<p>&nbsp;</p>


    </div>
<?php }else{ ?>
<div id="footer">
<?php } ?>
	<hr />
		<p>
		<?php if($footer_cat_group_id=$db->get_var("select ID from categorygroups where SiteID=".SITE_ID." and Code='sitenav'")){
			if($category=$db->get_row("select * from categories where SiteID=".SITE_ID." and TopLevelID=0 and CategoryGroupID='".$footer_cat_group_id."' and code='footer-navigation' order by Order_By_Num asc")){
				$sub_query=$db->get_results("SELECT distinct(l.ID), l.Link, l.Label, l.Source, lc.CategoryID from links_categories lc join links l on lc.LinkID=l.ID where lc.CategoryID = '".$category->ID."' and lc.SiteID='".SITE_ID."' and l.SiteID='".SITE_ID."' order by l.OrderNum asc");
				if(count($sub_query)>0) {
					$total_count=count($sub_query);
					$i=0;
					foreach($sub_query as $row){
						$i++;
						echo "<a href='".$row->Link."'";
						if($row->Source==0){ echo "target='_blank'"; }
						echo "title='".$row->Label."'>".$row->Label."</a>";
						if($total_count!=$i){ echo " | ";}

					}
				}
			}
		}else{	?>
			<a href="<?php echo SITE_WS_PATH; ?>/links.asp" title="Exclusive Links">Exclusive Links</a>
			| <a href="<?php echo SITE_WS_PATH; ?>/terms.asp" title="Terms &amp; Conditions">Terms &amp; Conditions</a>
			| <a href="<?php echo SITE_WS_PATH; ?>/company.asp" title="Staff Agency Company Profile">Staff Agency Company Profile</a>
			| <a href="<?php echo SITE_WS_PATH; ?>/glossary2.asp" title="Domestics Glossary">Domestics Glossary</a> |
			<a href="<?php echo SITE_WS_PATH; ?>/sitemap.htm" title="Site Map">Site Map</a> | <a title="Nanny Agency" href="<?php echo SITE_WS_PATH; ?>/nannies/default.asp">
            Nanny Agency</a>
		<?php } ?>
	</p>
	<p class="copyright">
	 <?php
		$tokenxmasTxt = __token_getValue($db, 'footer-address');
		if($tokenxmasTxt!="" ){
			echo $tokenxmasTxt;
		}else{ ?>
		marshallharber.com, The UK&#39;s Exclusive Domestic Staffing Agency.<br />
		Copyright &copy; 2003-2015. All Rights Reserved
	<?php } ?>
	</p>
	<?php if($curr_file!="index.php"){	?>
	<table id="obsceneFooter">

		<tr>
			<td><a href="<?php echo SITE_WS_PATH; ?>/butler.asp" title="Butler Agency">Butler Agency</a></td>
			<td><a href="<?php echo SITE_WS_PATH; ?>/chauffeur.asp" title="Chauffeur Jobs">Chauffeur Jobs</a></td>
			<td><a href="<?php echo SITE_WS_PATH; ?>/chef.asp" title="Chef">Chef</a></td>
			<td><a href="<?php echo SITE_WS_PATH; ?>/couple.asp" title="Domestic Couples">Domestic Couples</a></td>
			<td><a href="<?php echo SITE_WS_PATH; ?>/cleaner.asp" title="Domestic Cleaner">Domestic Cleaner</a></td>
			<td><a href="<?php echo SITE_WS_PATH; ?>/estatemanager.asp" title="Estate Manager">Estate Manager</a></td>
			<td><a href="<?php echo SITE_WS_PATH; ?>/gamekeeper.asp" title="Gamekeeper">Gamekeeper</a></td>
			<td><a href="<?php echo SITE_WS_PATH; ?>/gardener.asp" title="Gardener Jobs">Gardener Jobs</a></td>
		</tr>
		<tr>
			<td><a href="<?php echo SITE_WS_PATH; ?>/housekeeper.asp" title="Domestic Housekeeper">Domestic Housekeeper</a></td>
			<td><a href="<?php echo SITE_WS_PATH; ?>/housemanager.asp" title="House Manager">House Manager</a></td>
			<td><a href="<?php echo SITE_WS_PATH; ?>/nannies.asp" title="Nanny Jobs">Nanny Jobs</a></td>
			<td><a href="<?php echo SITE_WS_PATH; ?>/personalassistants.asp" title="Personal Assistant">Personal Assistant</a></td>
			<td><a href="<?php echo SITE_WS_PATH; ?>/footman.asp" title="Domestic Footman">Domestic Footman</a></td>
			<td><a href="<?php echo SITE_WS_PATH; ?>/houseman.asp" title="Houseman Agency">Houseman Agency</a></td>
			<td><a href="<?php echo SITE_WS_PATH; ?>/ladysmaid.asp" title="Lady&#39;s Maid">Lady&#39;s Maid</a></td>
			<td><a href="<?php echo SITE_WS_PATH; ?>/valet.asp" title="Household Valet">Household Valet</a></td>
		</tr>
	</table>
	<?php } ?>
</div>