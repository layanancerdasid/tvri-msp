		<div class="animated fadeIn">
			<div class="row">
				<div class="breadcrumbs" style="margin-top: -16px;">
					<div class="col-sm-12">
						<div class="card" style="margin-top: 20px;padding-left: 2px;border-color:bold;">
							<div class="card-header">
                                <strong class="card-title"><?php echo lang('create_group_heading');?><br/></strong>							
                            </div>
                            <div class="card-body">
                                <div class="col-sm-7" style="padding-right: 50px;">
									<div id="infoMessage"><?php echo $message;?></div>
									<?php echo form_open("auth/create_group");?>
										<p><?php echo lang('create_group_subheading');?></p>
										<div class="form-group row">
											<?php echo lang('create_group_name_label', 'group_name');?> <br />
											<?php echo form_input($group_name);?>
										</div>
										<div class="form-group row">
											<label for="description"><?php echo lang('create_group_desc_label', 'description');?></label>
											<?php echo form_input($description);?>
										</div>
										
										<div class="text-center">
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

<!-- <h1><?php echo lang('create_group_heading');?></h1>
<p><?php echo lang('create_group_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/create_group");?>

      <p>
            <?php echo lang('create_group_name_label', 'group_name');?> <br />
            <?php echo form_input($group_name);?>
      </p>

      <p>
            <?php echo lang('create_group_desc_label', 'description');?> <br />
            <?php echo form_input($description);?>
      </p>

      <p><?php echo form_submit('submit', lang('create_group_submit_btn'));?></p>

<?php echo form_close();?> -->