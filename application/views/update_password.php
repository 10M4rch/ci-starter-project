<strong><p class="text-muted text-left">Update Password</p></strong>
<?php echo form_open(''); ?>
  <div class="box-body">
    <div class="form-group">
      <label for="old">Old Password</label>

    </div>
    <div class="form-group">
      <label for="new">New Password</label>

    </div>
    <div class="form-group">
      <label for="new_confirm">Confirm New Password</label>

    </div>
    <input type="hidden" name="user_id" value="">
  </div>
  <!-- /.box-body -->

  <div class="box-footer">
    <button type="submit" class="btn btn-primary btn-block">Submit</button>
  </div>
<?php echo form_close(); ?>
