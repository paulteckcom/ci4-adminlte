  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
    </ul>

    

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item pr-1">
        <a href="<?php echo base_url('home');?>" class="btn btn-primary">
          Home
        </a>
      </li>
      <?php 
      if(!isset($apiData['secret'])):
      ?>
      <li class="nav-item pr-1">
        <a href="<?php echo base_url('trade/api');?>" class="btn btn-primary">
          Trade
        </a>
      </li>
      <?php 
      else:
      ?>
      <li class="nav-item pr-1">
        <a href="<?php echo base_url('trade/balance');?>" class="btn btn-primary">
          Balance
        </a>
      </li>
      <?php endif; ?>
      <li class="nav-item pr-1">
        <a href="<?php echo base_url('account');?>" class="btn btn-warning">
          Account
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo base_url('logout');?>" class="btn btn-danger">
          Logout
        </a>
      </li>
      <!-- Notifications Dropdown Menu -->
      <!-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li> -->
    </ul>
  </nav>
  <!-- /.navbar -->