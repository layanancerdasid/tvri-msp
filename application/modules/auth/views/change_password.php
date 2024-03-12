		<div class="animated fadeIn">
			<div class="row">
				<div class="breadcrumbs" style="margin-top: -16px;">
					<div class="col-sm-12">
						<div class="card" style="margin-top: 20px;padding-left: 2px;border-color:bold;">
							<div class="card-header">
                                <strong class="card-title"><?php echo lang('change_password_heading');?><br/></strong>							
                            </div>
                            <div class="card-body">
                                <div class="col-sm-7" style="padding-right: 50px;">
									<div id="infoMessage"><?php echo $message;?></div>
									<?php echo form_open("auth/change_password");?>
										<div class="form-group row">
											<?php echo lang('change_password_old_password_label', 'old_password');?>
											<?php echo form_input($old_password);?>
										</div>
										<div class="form-group row">
											<label for="new_password"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length);?></label>
											<?php echo form_input($new_password);?>
										</div>
										<div class="form-group row">
											<?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm');?> <br />
											<?php echo form_input($new_password_confirm);?>
										</div>
										<div class="text-center">
											<button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Submit</button>
											<?php echo form_input($user_id);?>
										</div>
									<?php echo form_close();?>
								</div>
                                
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>

<!-- <h1><?php echo lang('change_password_heading');?></h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/change_password");?>

      <p>
            <?php echo lang('change_password_old_password_label', 'old_password');?> <br />
            <?php echo form_input($old_password);?>
      </p>

      <p>
            <label for="new_password"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length);?></label> <br />
            <?php echo form_input($new_password);?>
      </p>

      <p>
            <?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm');?> <br />
            <?php echo form_input($new_password_confirm);?>
      </p>

      <?php echo form_input($user_id);?>
      <p><?php echo form_submit('submit', lang('change_password_submit_btn'));?></p>

<?php echo form_close();?> -->
