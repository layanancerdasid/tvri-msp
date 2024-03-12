
                <div class="login-form">
										
										<!--
										<br>
										<h6 class="text-center">Please sign in</h6>
										-->
                    <!--<div class="alert alert-info" role="alert" id="infoMessage">
                      
                    </div>-->
                    <?php echo form_open("auth/login");?>
											<div class="avatar"></div>
											<h2 class="text-center">Sistem Informasi Pemantauan Proyek <br>Direktorat Pengembangan Pitalebar</h2>
											<span id="infoMessage" class="blink_text" style="color:red;"><?php echo $message;?></span>
                        <div class="form-group">
													<label class="sr-only" for="inputEmail">Email/Username</label>
													<?php echo form_input($identity);?>
                        </div>
                        <div class="form-group">
													<label class="sr-only" for="inputPassword">Password</label>
													<?php echo form_input($password);?>
                        </div>
                        <div class="checkbox">
                            <label class="pull-right">
                              <a href="forgot_password">
                                <?php echo lang('login_forgot_password');?>
                              </a>
                            </label>

                        </div>
                        <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Sign in</button>
                        <!--<div class="register-link m-t-15 text-center">
                            <p>Don't have account ? <a href="<?php echo base_url();?>index.php/auth/create_user"> Sign Up Here</a></p>
                        </div>-->
                    <?php echo form_close();?>
                </div>
            </div>
<script>
	setTimeout(function () {
			if ($("#infoMessage").text() !== '')  {
					$("#infoMessage").html('');
			}
	}, 5000);
</script>