<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Subheader-->
	<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
		<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
			<!--begin::Info-->
			<div class="d-flex align-items-center flex-wrap mr-1">
				<!--begin::Page Heading-->
				<?=$breadcrumbs;?>
				<!--end::Page Heading-->
			</div>
			<!--end::Info-->
			
		</div>
	</div>
	<!--end::Subheader-->
	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class="container">
			<div class="animated fadeIn">
				<div class="row">
					<div class="col-sm-12">
						<div class="card" style="margin-top: 20px;padding-left: 2px;border-color:bold;">
							<div class="card-header">
								<strong class="card-title"><?php echo lang('edit_user_heading');?><br/></strong>
							</div>
							<div class="card-body">
								<div class="col-sm-7" style="padding-right: 50px;">
									<div id="infoMessage"><?php echo $message;?></div>
									<?php echo form_open(uri_string());?>
										<div class="form-group row">
											<label class="col-sm-12 control-label" style="padding-top: 6px;">
												<?php echo lang('edit_user_fname_label', 'first_name');?>
											</label>
											<?php echo form_input($first_name);?> 
										</div>
										<div class="form-group row">
											<label class="col-sm-12 control-label" style="padding-top: 6px;">
												<?php echo lang('edit_user_lname_label', 'last_name');?>
											</label>
											<?php echo form_input($last_name);?>
										</div>
										<!--<div class="form-group row">
											<label class="col-sm-3 control-label" style="text-align: right;padding-top: 6px;">
												<i class="fa fa-user"> </i>
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
										</div>-->
										<div class="form-group row">
											<label class="col-sm-12 control-label" style="padding-top: 6px;">
												<?php echo lang('edit_user_company_label', 'company');?>
											</label>
											<?php echo form_input($company);?>
										</div>
										<!--<div class="form-group row">
											<label class="col-sm-3 control-label" style="text-align: right;padding-top: 6px;">
												No. Telp
											</label>
											<?php echo form_input($phone);?>
										</div>-->
										<div class="form-group row">
											<label class="col-sm-12 control-label"  style="padding-top: 6px;">
												<?php echo lang('edit_user_password_label', 'password');?>
											</label>
											<?php echo form_input($password);?>
										</div>
										<div class="form-group row">
											<label class="col-sm-12 control-label" style="padding-top: 6px;">
												<?php echo lang('edit_user_password_confirm_label', 'password_confirm');?>
											</label>
											<?php echo form_input($password_confirm);?>
										</div>
										<div class="form-group row">
										<?php if ($this->ion_auth->is_admin()): ?>

											<label class="col-sm-12 control-label" style="padding-bottom: 10px;">
												<?php echo lang('edit_user_groups_heading');?>
											</label>
											<div class="col-sm-10" style="">
												<?php foreach ($groups as $group):?>
													  <label class="checkbox">
													  <?php
														  $gID=$group['id'];
														  $checked = null;
														  $item = null;
														  foreach($currentGroups as $grp) {
															  if ($gID == $grp->id) {
																  $checked= ' checked="checked"';
															  break;
															  }
														  }
													  ?>
													  <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
													  <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
													  </label>
												<?php endforeach?>

											</div>
										  
										  <?php endif ?>

										  <?php 
											// echo form_hidden('id', $user->id);
											// echo form_hidden($csrf); 
											?>
										</div>
										<!--<div class="form-group row">
											<button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30 col-sm-12">Submit</button>
										</div>-->
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
		<!--end::Container-->
	</div>
	<!--end::Entry-->
</div>
<!--end::Content-->



