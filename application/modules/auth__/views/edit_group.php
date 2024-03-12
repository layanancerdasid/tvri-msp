
                <div id="infoMessage"><?php echo $message;?></div>
                <div class="login-form">
                <p>Please enter the group information below.</p>
                    <form>
                        <?php echo form_open(current_url());?>
                              <div class="form-group">
                                    <label>Nama Grup</label>
                                    <?php echo form_input($group_name);?>
                              </div>
                              <div class="form-group">
                                    <label>Deskripsi</label>
                                    <?php echo form_input($group_description);?>
                              </div>
                              <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Submit</button>
                        <?php echo form_close();?>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
<!-- <h1><?php echo lang('edit_group_heading');?></h1>
<p><?php echo lang('edit_group_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open(current_url());?>

      <p>
            <?php echo lang('edit_group_name_label', 'group_name');?> <br />
            <?php echo form_input($group_name);?>
      </p>

      <p>
            <?php echo lang('edit_group_desc_label', 'description');?> <br />
            <?php echo form_input($group_description);?>
      </p>

      <p><?php echo form_submit('submit', lang('edit_group_submit_btn'));?></p>

<?php echo form_close();?> -->