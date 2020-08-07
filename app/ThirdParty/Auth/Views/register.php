<?= $this->extend($config->viewLayout) ?>
  <?= $this->section('main') ?>
  <div class="card">
    <div class="card-body register-card-body rounded">
      <p class="login-box-msg">Register a new membership</p>
      <?= view('Auth\Views\_notifications') ?>
      <form method="POST" action="<?= base_url('register'); ?>" accept-charset="UTF-8" onsubmit="registerButton.disabled = true; return true;">
        <?= csrf_field() ?>
        <div class="input-group mb-3">
          <input required minlength="2" name="name" type="text" class="form-control" placeholder="<?= lang('Auth.name') ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input required type="email" name="email" class="form-control" placeholder="<?= lang('Auth.email') ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input required minlength="5" type="password" name="password" class="form-control" placeholder="<?= lang('Auth.password') ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input required minlength="5" type="password" name="password_confirm" class="form-control" placeholder="<?= lang('Auth.passwordAgain') ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button name="registerButton" type="submit" class="btn btn-primary btn-block"><?= lang('Auth.register') ?></button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <a href="<?= site_url('login'); ?>" class="text-center"><?= lang('Auth.alreadyRegistered') ?></a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
<?= $this->endSection() ?>