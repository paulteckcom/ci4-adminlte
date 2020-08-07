<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h5><?= lang('Auth.accountSettings') ?></h5>
			</div>
			<div class="card-body">
				<?= view('Auth\Views\_notifications') ?>
				<form method="POST" action="<?= site_url('account'); ?>" accept-charset="UTF-8">
					<?= csrf_field() ?>
					<div class="form-group">
						<label><?= lang('Auth.name') ?></label><br />
						<input required type="text" name="name" class="form-control" value="<?= $userData['name']; ?>" />
					</div>
					<div class="form-group">
						<label><?= lang('Auth.email') ?></label><br />
						<input disabled type="text" class="form-control" value="<?= $userData['email']; ?>" />
					</div>
					<?php if ($userData['new_email']): ?>
					<div class="form-group">
						<label><?= lang('Auth.pendingEmail') ?></label><br />
						<input disabled type="text" class="form-control" value="<?= $userData['new_email']; ?>" />
					</div>
					<?php endif; ?>
				    <div class="form-group">
				        <button type="submit" class="btn btn-primary"><?= lang('Auth.update') ?></button>
				    </div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h5><?= lang('Auth.changeEmail') ?></h5>
			</div>
			<div class="card-body">
				<p><?= lang('Auth.changeEmailInfo') ?></p>
				<form method="POST" action="<?= site_url('change-email'); ?>" accept-charset="UTF-8" onsubmit="changeEmail.disabled = true; return true;">
					<?= csrf_field() ?>
					<div class="form-group">
						<label><?= lang('Auth.newEmail') ?></label>
						<input required type="email" class="form-control" name="new_email" value="<?= old('new_email') ?>" />
					</div>
					<div class="form-group">
						<label><?= lang('Auth.currentPassword') ?></label>
						<input required type="password" class="form-control" name="password" value="" />
					</div>
				    <div class="form-group">
				        <button name="changeEmail" class="btn btn-primary" type="submit"><?= lang('Auth.update') ?></button>
				    </div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h5><?= lang('Auth.changePassword') ?></h5>
			</div>
			<div class="card-body">
				<form method="POST" action="<?= site_url('change-password'); ?>" accept-charset="UTF-8" onsubmit="changePassword.disabled = true; return true;">
					<?= csrf_field() ?>
					<div class="form-group">
						<label><?= lang('Auth.currentPassword') ?></label><br />
						<input required type="password" class="form-control" minlength="5" name="password" value="" />
					</div>
					<div class="form-group">
						<label><?= lang('Auth.newPassword') ?></label><br />
						<input required type="password" class="form-control" minlength="5" name="new_password" value="" />
					</div>
					<div class="form-group">
						<label><?= lang('Auth.newPasswordAgain') ?></label><br />
						<input required type="password" class="form-control" minlength="5" name="new_password_confirm" value="" />
					</div>
				    <div class="form-group">
				        <button name="changePassword" class="btn btn-primary" type="submit"><?= lang('Auth.update') ?></button>
				    </div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h5><?= lang('Auth.deleteAccount') ?></h5>
			</div>
			<div class="card-body">
				<form method="POST" action="<?= site_url('delete-account') ?>" accept-charset="UTF-8">
				    <?= csrf_field() ?>
				    <p><?= lang('Auth.deleteAccountInfo') ?></p>
					<div class="form-group">
						<label><?= lang('Auth.currentPassword') ?></label><br />
						<input class="form-control" required type="password" name="password" value="" />
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-danger" onclick="return confirm('<?= lang('Auth.areYouSure') ?>')"><?= lang('Auth.deleteAccount') ?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>