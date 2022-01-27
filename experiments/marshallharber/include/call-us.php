<div class="call-us-panel">
	<div class="panel-heading">Call us </div>
     	<p style="text-align:left;">Call us to discuss your requirements:<br/>
     		<?php $tokenPhone = __token_getValue($db, 'telephone'); 
				if($tokenPhone!="" ){ ?>
					<a href="tel://<?php echo str_replace(' ','',$tokenPhone); ?>"><?php echo $tokenPhone; ?></a>
				<?php }else{	?>
					<a href="tel://+44(0)207-938-2200">+44 (0) 20 7938 2200</a>
			<?php } ?>
        </p>
    </div>             
</div>