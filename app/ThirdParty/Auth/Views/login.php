  <?= $this->extend($config->viewLayout) ?>
  <?= $this->section('main') ?>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start working</p>
      <?= view('Auth\Views\_notifications') ?>
      <form action="<?= site_url('login'); ?>" method="post">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="<?= lang('Auth.email') ?>">
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
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
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

      <p class="mb-1">
        <a href="<?= site_url('forgot-password'); ?>"><?= lang('Auth.forgotYourPassword') ?></a>
      </p>
      <p class="mb-0">
        <a href="<?= site_url('register'); ?>" class="text-center"><?= lang('Auth.registerNewAccount') ?></a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
  <?= $this->endSection() ?>