<div class="card" style="margin: 0 auto;max-width: 500px;">
	<div class="card-header bg-primary">	
		API Data
	</div>
	<div class="card-body">
		<?php echo form_open(); ?>
		<div class="form-group">
			<label>Exchange</label>
			<?php echo form_dropdown('exchange', $exchange, '', 'class="form-control"'); ?>
		</div>
		<div class="form-group">
			<label>Public Key</label>
			<input type="text" name="apikey" class="form-control" placeholder="Please enter public key">
		</div>
		<div class="form-group">
			<label>Secret</label>
			<input type="text" name="secret" class="form-control" placeholder="Please enter secret">
		</div>
		<div class="form-group">
			<input type="submit" name="submitBtn" value="Process" value="Start Trade" class="btn btn-primary" style="width: 100%;">
		</div>
		<?php echo form_close(); ?>
	</div>
</div>