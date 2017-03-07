<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- WebApp - Fire icon -->
  <link rel="icon" href="<?php echo base_url(); ?>backend/dist/img/webapp-fire.ico">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>backend/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/skins/skin-black.min.css">
  <!-- Web App :fire: style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/style.css">
  <!-- Normalize CSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/normalize.css">
</head>
<body class="hold-transition skin-black sidebar-mini">

  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="<?php echo site_url(); ?>admin/pages" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>A</b>LT</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Admin</b>LTE</span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?php echo base_url(); ?>backend/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                <span class="hidden-xs"><?php echo $current_user->first_name.''.$current_user->last_name; ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="<?php echo base_url(); ?>backend/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                  <p>
                    <?php echo $current_user->first_name.''.$current_user->last_name; ?> - Web Developer
                    <small>Member since Nov. 2012</small>
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="<?php echo site_url(); ?>admin/user" class="btn btn-default btn-flat">Profile</a>
                  </div>
                  <div class="pull-right">
                    <a href="<?php echo site_url(); ?>logout" class="btn btn-default btn-flat">Sign out</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="<?php echo base_url(); ?>backend/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p><?php echo $current_user->first_name.''.$current_user->last_name; ?></p>
            <a href="<?php echo site_url(); ?>admin/user"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li class="header">MAIN NAVIGATION</li>
          <li class="header">SETTING</li>
          <li class="treeview">
            <a href="#"><i class="fa fa-users" aria-hidden="true"></i> <span>User Management</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo site_url(); ?>admin/users"><i class="fa fa-circle-o" aria-hidden="true"></i> <span>List Users</span></a></li>
              <li><a href="<?php echo site_url(); ?>admin/groups"><i class="fa fa-circle-o" aria-hidden="true"></i> <span>List Group</span></a></li>
            </ul>
          </li>
          <li class="header">SAMPLE</li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-dashboard" aria-hidden="true"></i> <span>Dashboard</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right" aria-hidden="true"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo site_url(); ?>admin/pages"><i class="fa fa-circle-o" aria-hidden="true"></i> Dashboard v1</a></li>
            </ul>
          </li>
          <li class="active"><a href="<?php echo site_url(); ?>admin/pages/datatable"><i class="fa fa-database" aria-hidden="true"></i> <span>Datatable</span></a></li>
          <li><a href="<?php echo site_url(); ?>admin/pages/blank"><i class="fa fa-file-o" aria-hidden="true"></i> <span>Blank Page</span></a></li>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Datatable
          <small>Advance table</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo site_url(); ?>admin/pages"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Datatable</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <?php echo $contents; ?>
          </div>
        </div>
      </section>

    </div>

    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 2.3.8
      </div>
      <strong>Copyright &copy; 2014-2016 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights
      reserved.
    </footer>

  </div>
  <!-- ./wrapper -->


    <!-- jQuery 2.2.3 -->
    <script src="<?php echo base_url(); ?>backend/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="<?php echo base_url(); ?>backend/bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="<?php echo base_url(); ?>backend/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>backend/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="<?php echo base_url(); ?>backend/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url(); ?>backend/plugins/fastclick/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>backend/dist/js/app.min.js"></script>
    <!-- page script -->
    <script>
      $(function () {
        $("#example1").DataTable({
          "scrollX": true,
          "responsive": true
        });
      });
    </script>
</body>
</html>
