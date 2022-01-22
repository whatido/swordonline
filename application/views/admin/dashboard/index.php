  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?= trans('dashboard') ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><?= trans('home') ?></a></li>
              <li class="breadcrumb-item active"><?= trans('dashboard') ?> v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= $all_users; ?></h3>

                <p><?= trans('user_registrations') ?></p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer"><?= trans('more_info') ?> <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= $active_users; ?></h3>

                <p><?= trans('active_users') ?></p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer"><?= trans('more_info') ?> <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $deactive_users; ?></h3>

                <p><?= trans('inactive_users') ?></p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer"><?= trans('more_info') ?> <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>

                <p><?= trans('unique_visitors') ?></p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer"><?= trans('more_info') ?> <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="<?= base_url() ?>public/admin/plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?= base_url() ?>public/admin/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?= base_url() ?>public/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?= base_url() ?>public/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?= base_url() ?>public/admin/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="<?= base_url() ?>public/admin/plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?= base_url() ?>public/admin/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url() ?>public/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>


<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?= base_url() ?>public/admin/dist/js/pages/dashboard.js"></script>
