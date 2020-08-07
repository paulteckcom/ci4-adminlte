  <?= $this->extend($config->viewLayout) ?>
  <?= $this->section('main') ?>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body rounded">
      <p class="login-box-msg"><?= lang('Auth.forgottenPassword') ?></p>
      <?= view('Auth\Views\_notifications') ?>
      <form method="POST" action="<?= site_url('forgot-password'); ?>" accept-charset="UTF-8" onsubmit="submitButton.disabled = true; return true;">
			<?= csrf_field() ?>
		    <div class="form-group">
		        <input required type="email" class="form-control" name="email" value="<?= old('email') ?>" placeholder="<?= lang('Auth.typeEmail') ?>" />
		    </div>
		    <div class="form-group">
		        <button name="submitButton" class="btn btn-primary" type="submit"><?= lang('Auth.setNewPassword') ?></button>
		    </div>
		</form>

      <!-- <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div> -->
      <!-- /.social-auth-links -->
      <p class="mb-0">
        <a href="<?= site_url('register'); ?>" class="text-center"><?= lang('Auth.registerNewAccount') ?></a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
  <?= $this->endSection() ?>