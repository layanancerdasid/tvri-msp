<style>
		
		.loginbody{
			background-color:#e9ebee !important;color:#212529; 
			background-image:url(../../images/bg-login.jpg);
			background-position:center center; background-repeat:no-repeat; background-size:cover;}
			.footer{color:#212529;background-color:transparent;border-top:none;left:0;}
			.form-control {border-color: #CCCCCC;}
			.form-control, .btn {border-radius: 2px;}
			.login-form {max-width: 350px;margin: 0 auto;padding: 22% 0 0 0;left:0;}
			@media only screen and (min-width: 490px) {
				.login-form {padding: 15% 0 0 0;}
			}			
			.login-form form {color: #7a7a7a;border-radius: 15% 0;margin-bottom: 15px;font-size: 13px;background: rgba(255,255,255,0.35);			box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);padding: 30px;position: relative;}
			.login-form h2 {font-size: 18px;margin: 35px -2px 25px;}
			.login-form .avatar {position: absolute;margin: 0 auto;left: 0;right: 0;top: -50px;width: 95px;height: 95px;border-radius: 50%;				z-index: 9;background: #FFFFFF;padding: 15px;box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);background-image:url(../../images/navs/kominfo_basic.png);				background-position:center;background-repeat:no-repeat;background-size:90%;}
			.login-form .avatar img {width: 100%;}	
			.login-form input[type="checkbox"] {margin-top: 2px;}
			.login-form a {color: #212529;text-decoration: underline;font-weight:bold;}
			.login-form a:hover {text-decoration: none;}
			.login-form form a {color: #7a7a7a;text-decoration: none;}
			.login-form form a:hover {text-decoration: underline;}			
			.btn-primary{background-image:url(../../assets/img/menu-active2.png);}
			
    </style>
                <div class="login-form">
                    <?php echo form_open('auth/reset_password/' . $code);?>
						<div class="avatar"></div>
						<h2 class="text-center"> Sistem Informasi Pemantauan Proyek<br>Subdit. IPPL</h2>
						<span id="infoMessage" class="blink_text" style="color:red;"><?php echo $message;?></span>
                        <div class="form-group">
							<label for="new_password"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length);?></label>
							<?php echo form_input($new_password);?>
                        </div>
                        <div class="form-group">
							<label for="new_password_confirm"><?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm');?></label>
							<?php echo form_input($new_password_confirm);?>
                        </div>
                        <?php echo form_input($user_id);?>
						<?php echo form_hidden($csrf); ?>
                        <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Sign in</button>
                    <?php echo form_close();?>
                </div>
            </div>

<!--	
<h1><?php echo lang('reset_password_heading');?></h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open('auth/reset_password/' . $code);?>

	<p>
		<label for="new_password"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length);?></label> <br />
		<?php echo form_input($new_password);?>
	</p>

	<p>
		<?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm');?> <br />
		<?php echo form_input($new_password_confirm);?>
	</p>

	<?php echo form_input($user_id);?>
	<?php echo form_hidden($csrf); ?>

	<p><?php echo form_submit('submit', lang('reset_password_submit_btn'));?></p>

<?php echo form_close();?>-->