<div class="wrap" id="of_container">
	<div id="of-popup-save" class="of-save-popup">
		<div class="of-save-save">Options Updated</div>
	</div>
	<div id="of-popup-reset" class="of-save-popup">
		<div class="of-save-reset">Options Reset</div>
	</div>
	<div id="of-popup-fail" class="of-save-popup">
		<div class="of-save-fail">Error!</div>
	</div>
	<span style="display: none;" id="hooks"><?php echo json_encode(of_get_header_classes_array()); ?></span>
	<input type="hidden" id="reset" value="<?php if(isset($_REQUEST['reset'])) echo $_REQUEST['reset']; ?>" />
	<input type="hidden" id="security" name="security" value="<?php echo wp_create_nonce('of_ajax_nonce'); ?>" />
	<form id="of_form" method="post" action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ) ?>" enctype="multipart/form-data" >
		<div id="header">
			<div class="logo">
				<h2><?php echo THEMENAME; ?></h2>
				<span><?php echo ('v'. THEMEVERSION); ?></span>
			</div>
			<div id="js-warning">Warning- This options panel will not work properly without javascript!</div>
			<div class="icon-option"></div>
			<div class="clear"></div>
			<!-- delete this -->
				<a style="margin:13px 0 0 50px !important; background-color: #cc3333; border: 1px solid #cc3333 !important; color: #FFF !important; text-shadow: 0 -1px 0 #cc3333;" href="http://themeforest.net/user/An-Themes/portfolio?ref=An-Themes" target="_blank" class="button-primary"><?php _e('Themes', 'anthemes');?></a>
				<a style="margin:13px 0 0 2px !important; background-color: #3b3b3b; border: 1px solid #3b3b3b !important; color: #FFF !important; text-shadow: 0 -1px 0 #3b3b3b;" href="http://themeforest.net/user/An-Themes?ref=An-Themes" target="_blank" class="button-primary"><?php _e('Support', 'anthemes');?></a>
				<a style="margin:13px 0 0 2px !important; background-color: #7dc34d !important; border: 1px solid #7dc34d !important; color: #FFF !important; text-shadow: 0 -1px 0 #7dc34d;" href="http://themeforest.net/user/An-Themes/follow?ref=An-Themes" target="_blank" class="button-primary"><?php _e('Follow', 'anthemes');?></a>
    		<!-- delete this -->
    	</div>
		<div id="info_bar">
			<a>
				<div id="expand_options" class="expand">Expand</div>
			</a>
			<img style="display:none" src="<?php echo ADMIN_DIR; ?>assets/images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..." />
			<button id="of_save" type="button" class="button-primary">
				<?php _e('Save All Changes', 'anthemes');?>
			</button>
		</div><!--.info_bar-->
		<div id="main">
			<div id="of-nav">
				<ul>
				  <?php echo $options_machine->Menu ?>
				</ul>
			</div>
			<div id="content">
		  		<?php echo $options_machine->Inputs /* Settings */ ?>
		  	</div>
			<div class="clear"></div>
		</div>
		<div class="save_bar">
			<img style="display:none" src="<?php echo ADMIN_DIR; ?>assets/images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..." />
			<button id ="of_save" type="button" class="button-primary"><?php _e('Save All Changes', 'anthemes');?></button>
			<button id ="of_reset" type="button" class="button submit-button reset-button" ><?php _e('Options Reset', 'anthemes');?></button>
			<img style="display:none" src="<?php echo ADMIN_DIR; ?>assets/images/loading-bottom.gif" class="ajax-reset-loading-img ajax-loading-img-bottom" alt="Working..." />
		</div><!--.save_bar-->
	</form>
	<div style="clear:both;"></div>
</div><!--wrap-->