
                <div class="login-form">
						<?php echo form_open("auth/forgot_password");?>
						<div class="avatar"></div>
						<h2 class="text-center"> Sistem Informasi Pemantauan Proyek<br>Subdit. IPPL</h2>
						<span id="infoMessage" class="blink_text" style="color:red;"><?php echo $message;?></span>
                        <div class="form-group">
							<p style="margin-bottom: 0px;"><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>
							<label for="identity" class="sr-only" ><?php echo (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?></label> <br />
							<?php echo form_input($identity);?>
                        </div>
                        <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Sign in</button>
                        <!--<div class="register-link m-t-15 text-center">
                            <p>Don't have account ? <a href="<?php echo base_url();?>index.php/auth/create_user"> Sign Up Here</a></p>
                        </div>-->
                    <?php echo form_close();?>
                </div>
            </div>
<!--		<div class="animated fadeIn">
			<div class="row">
				<div class="breadcrumbs" style="margin-top: -16px;">
					<div class="col-sm-12">
						<div class="card" style="margin-top: 20px;padding-left: 2px;border-color:bold;">
							<div class="card-header">
                                <strong class="card-title"><?php echo lang('forgot_password_heading');?><br/></strong>
								 </h1>
								
                            </div>
                            <div class="card-body">
                                <div class="col-sm-7" style="padding-right: 50px;">
									<div id="infoMessage"><?php echo $message;?></div>
									<?php echo form_open("auth/forgot_password");?>
										<p style="margin-bottom: 2rem;"><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>
										<div class="form-group row">
											<label for="identity" class="col-sm"><?php echo (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?></label>
											<?php echo form_input($identity);?>
										</div>
										<div class="text-center">
											<button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Submit</button>
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


 <?php echo lang('forgot_password_heading');?></h1>
<p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/forgot_password");?>

      <p>
      	<label for="identity"><?php echo (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?></label> <br />
      	<?php echo form_input($identity);?>
      </p>

      <p><?php echo form_submit('submit', lang('forgot_password_submit_btn'));?></p>

<?php echo form_close();?> 
-->