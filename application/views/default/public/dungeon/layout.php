<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="description" content="<?php if (!empty($config->description)) echo $config->description; ?>">
  <meta name="keywords" content="<?php if (!empty($config->keywords)) echo $config->keywords; ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php if (!empty($config->head_meta)) echo $config->head_meta; ?>
  <title><?php if (!empty($config->title)) echo $config->title; ?></title>
  <link rel="canonical" href="<?php echo base_url(); ?>">
  <link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo base_url('public/default/img/favicon.png'); ?>">
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('public/default/img/favicon.png'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('public/vendor/css/bootstrap.min.css'); ?>" type="text/css" media="all">
  <link rel="stylesheet" href="<?php echo base_url("public/vendor/css/font-awesome/css/font-awesome.min.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url('public/vendor/css/icon.css'); ?>" type="text/css" media="all">
  <link rel="stylesheet" href="<?php echo base_url('public/dungeon/scss/main.css'); ?>" type="text/css" media="all">
  <?php if (!empty($config->head_link)) echo $config->head_link; ?>
  <?php if (!empty($config->head_script)) echo $config->head_script; ?>
</head>

<body>
  <div class="container">
    <div class="row">
      <!-- lg-4 col-md-6 col-12 offset-lg-4 offset-md-3 -->
      <main class="col-lg-4 col-md-6 col-12 offset-lg-4 offset-md-3"> 
      <?php $this->load->view('default/public/dungeon/_header'); ?>
        <?php if (!empty($main)) echo $main; ?>
        <?php $this->load->view('default/public/dungeon/_footer'); ?>
      </main>
    </div>
  </div>
  <?php if (!empty($config->footer_script)) echo $config->footer_script; ?>
  <script src="<?php echo base_url("public/vendor/js/jquery-3.2.1.min.js"); ?>"></script>
  <script src="<?php echo base_url("public/vendor/js/popper.min.js"); ?>"></script>
  <script src="<?php echo base_url("public/vendor/js/bootstrap.min.js"); ?>"></script>
  <script src="<?php echo base_url("public/vendor/js/jquery.sticky-kit.min.js"); ?>"></script>
  <script src="<?php echo base_url("public/vendor/js/jquery.countdown.js"); ?>"></script>
  <script src="<?php echo base_url("public/dungeon/js/main.js"); ?>"></script>
  <?php if (!empty($config->script)) echo $config->script; ?>
</body>

</html>