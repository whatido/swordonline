<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= isset($title) ? $title . ' - ' : 'Title -' ?> <?= $this->general_settings['application_name']; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>public/admin/plugins/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>public/admin/dist/css/adminlte.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= base_url() ?>public/admin/plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="<?= base_url() ?>public/admin/plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?= base_url() ?>public/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?= base_url() ?>public/admin/plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?= base_url() ?>public/admin/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?= base_url() ?>public/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <!-- DropZone -->
    <link rel="stylesheet" href="<?= base_url() ?>public/admin/plugins/dropzone/dropzone.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- jQuery -->
    <script src="<?= base_url() ?>public/admin/plugins/jquery/jquery.min.js"></script>

</head>

<body class="hold-transition sidebar-mini <?= (isset($bg_cover)) ? 'bg-cover' : '' ?>">
    <?php $this->load->view('admin/includes/_header'); ?>
    <?php if (!empty($main)) echo $main; ?>
    <?php $this->load->view('admin/includes/_footer'); ?>


    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>public/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Slimscroll -->
    <script src="<?= base_url() ?>public/admin/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?= base_url() ?>public/admin/plugins/fastclick/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>public/admin/dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?= base_url() ?>public/admin/dist/js/demo.js"></script>
    <!-- Notify JS -->
    <script src="<?= base_url() ?>public/admin/plugins/notify/notify.min.js"></script>
    <!-- DROPZONE -->
    <script src="<?= base_url() ?>public/admin/plugins/dropzone/dropzone.js" type="text/javascript"></script>

    <script>
        var csfr_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';

        var csfr_token_value = '<?php echo $this->security->get_csrf_hash(); ?>';

        $(function() {
            //-------------------------------------------------------------------
            // Country State & City Change

            $(document).on('change', '.country', function() {

                if (this.value == '') {
                    $('.state').html('<option value="">Select Option</option>');

                    $('.city').html('<option value="">Select Option</option>');

                    return false;
                }


                var data = {

                    country: this.value,

                }

                data[csfr_token_name] = csfr_token_value;

                $.ajax({

                    type: "POST",

                    url: "<?= base_url('admin/auth/get_country_states') ?>",

                    data: data,

                    dataType: "json",

                    success: function(obj) {
                        $('.state').html(obj.msg);
                    },

                });
            });

            $(document).on('change', '.state', function() {

                var data = {

                    state: this.value,

                }

                data[csfr_token_name] = csfr_token_value;

                $.ajax({

                    type: "POST",

                    url: "<?= base_url('admin/auth/get_state_cities') ?>",

                    data: data,

                    dataType: "json",

                    success: function(obj) {

                        $('.city').html(obj.msg);

                    },

                });
            });
        });
    </script>

</body>

</html>