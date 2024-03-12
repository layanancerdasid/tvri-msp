
		<div class="animated fadeIn">
			<div class="row">
				<div class="breadcrumbs" style="margin-top: -16px;">
					<div class="col-sm-12">
						<div class="card" style="margin-top: 20px;padding-left: 2px;border-color:bold;">
							<div class="card-header">
                                <strong class="card-title"><?php echo lang('create_user_heading');?><br/></strong>
                            </div>
                            <div class="card-body">
                                <div class="col-sm-7" style="padding-right: 50px;">
									<div id="infoMessage"><?php echo $message;?></div>
									<?php echo form_open("auth/create_user");?>
										<div class="form-group row">
											<label class="col-sm-12 control-label" style="padding-top: 6px;">
												<?php echo lang('create_user_fname_label', 'first_name');?>
											</label>
											<?php echo form_input($first_name);?> 
										</div>
										<div class="form-group row">
											<label class="col-sm-12 control-label" style="padding-top: 6px;">
												<?php echo lang('create_user_lname_label', 'last_name');?>
											</label>
											<?php echo form_input($last_name);?>
										</div>
										<div>
											  <?php
													if($identity_column!=='email') {
														  echo '<p>';
														  echo lang('create_user_identity_label', 'identity');
														  echo '<br />';
														  echo form_error('identity');
														  echo form_input($identity);
														  echo '</p>';
													}
											  ?>
										</div>
										<div class="form-group row">
											<label class="col-sm-12 control-label" style="padding-top: 6px;">
												<?php echo lang('create_user_company_label', 'company');?>
											</label>
											<?php echo form_input($company);?>
										</div>
										<div class="form-group row">
											<label class="col-sm-12 control-label" style="padding-top: 6px;">
												<?php echo lang('create_user_email_label', 'email');?>
											</label>
											<?php echo form_input($email);?>
										</div>
										<div class="form-group row">
											<label class="col-sm-12 control-label" style="padding-top: 6px;">
												<?php echo lang('create_user_password_label', 'password');?>
											</label>
											<?php echo form_input($password);?>
										</div>
										<div class="form-group row">
											<label class="col-sm-12 control-label" style="padding-top: 6px;">
												<?php echo lang('create_user_password_confirm_label', 'password_confirm');?>
											</label>
											<?php echo form_input($password_confirm);?>
										</div>
										
										<div class="form-group row">
												<?php foreach ($groups as $group):?>
													  <label class="col-sm-12 control-label">
													  <?php
														  $gID=$group['id'];
														  $item = null;
													  ?>
													  <input type="radio" name="groups[]" value="<?php echo $group['id'];?>">
													  <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
													  </label>
												<?php endforeach?>

										</div>
										
										
										
										<div class="text-center">
											<div class="col-sm-10">
												<button type="submit" id="submit" name="submit" class="btn btn-primary col-sm-3">Submit</button>
											</div>
										</div>
									</form>
								  <?php echo form_close();?>
								</div>
                                
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>


<!--
		<div class="animated fadeIn">
			<div class="row">
				<div class="breadcrumbs" style="margin-top: -16px;">
					<div class="col-sm-12">
						<div class="card" style="margin-top: 20px;padding-left: 2px;border-color:bold;">
							<div class="card-header">
                                <strong class="card-title"><?php echo lang('create_user_heading');?><br/></strong>
                            </div>
                            <div class="card-body">
                                <div class="col-sm-7" style="padding-right: 50px;">
									<div id="infoMessage"><?php echo $message;?></div>
									<?php echo form_open("auth/create_user");?>
										<div class="form-group row">
											<label class="col-sm-3 control-label" style="text-align: right;padding-top: 6px;">
												<?php echo lang('create_user_name_label', 'first_name');?>
											</label>
											<?php echo form_input($first_name);?> 
											<?php echo form_input($last_name);?>
										</div>
										<div>
											  <?php
													if($identity_column!=='email') {
														  echo '<p>';
														  echo lang('create_user_identity_label', 'identity');
														  echo '<br />';
														  echo form_error('identity');
														  echo form_input($identity);
														  echo '</p>';
													}
											  ?>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 control-label" style="text-align: right;padding-top: 6px;">
												<?php echo lang('create_user_company_label', 'company');?>
											</label>
											<?php echo form_input($company);?>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 control-label" style="text-align: right;padding-top: 6px;">
												<?php echo lang('create_user_email_label', 'email');?>
											</label>
											<?php echo form_input($email);?>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 control-label" style="text-align: right;padding-top: 6px;">
												<?php echo lang('create_user_password_label', 'password');?>
											</label>
											<?php echo form_input($password);?>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 control-label" style="text-align: right;padding-top: 6px;">
												<?php echo lang('create_user_password_confirm_label', 'password_confirm');?>
											</label>
											<?php echo form_input($password_confirm);?>
										</div>
										<div class="text-center">
											<button type="submit" id="submit" name="submit" class="btn btn-primary center-block col-sm-3">Submit</button>
										</div>
									</form>
								  <?php echo form_close();?>
								</div>
                                
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
-->