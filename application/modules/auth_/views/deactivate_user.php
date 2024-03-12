		<div class="animated fadeIn">
			<div class="row">
				<div class="breadcrumbs" style="margin-top: -16px;">
					<div class="col-sm-12">
						<div class="card" style="margin-top: 20px;padding-left: 2px;border-color:bold;">
							<div class="card-header">
                                <strong class="card-title"><?php echo lang('deactivate_heading')." ".$user->username."?";?> <br/></strong>							
                            </div>
                            <div class="card-body">
                                <div class="col-sm-7" style="padding-right: 50px;">
									<?php echo form_open("auth/deactivate/".$user->id);?>
										<div class="form-group row">
											<?php echo lang('deactivate_confirm_y_label', 'confirm');?>
											<input type="radio" name="confirm" value="yes" checked="checked" />
											<?php echo lang('deactivate_confirm_n_label', 'confirm');?>
											<input type="radio" name="confirm" value="no" />
										</div>
										<div class="text-center">
										<?php echo form_hidden($csrf); ?>
										<?php echo form_hidden(array('id'=>$user->id)); ?>
											<button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Submit</button>
										</div>
									<?php echo form_close();?>
								</div>
                                
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
  
<!-- <h1><?php echo lang('deactivate_heading');?></h1>
<p><?php echo sprintf(lang('deactivate_subheading'), $user->username);?></p>

<?php echo form_open("auth/deactivate/".$user->id);?>

  <p>
  	<?php echo lang('deactivate_confirm_y_label', 'confirm');?>
    <input type="radio" name="confirm" value="yes" checked="checked" />
    <?php echo lang('deactivate_confirm_n_label', 'confirm');?>
    <input type="radio" name="confirm" value="no" />
  </p>

  <?php echo form_hidden($csrf); ?>
  <?php echo form_hidden(array('id'=>$user->id)); ?>

  <p><?php echo form_submit('submit', lang('deactivate_submit_btn'));?></p>

<?php echo form_close();?> -->