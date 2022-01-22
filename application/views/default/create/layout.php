<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo base_url('public/default/img/favicon.png'); ?>">
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('public/default/img/favicon.png'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('public/vendor/css/bootstrap.min.css'); ?>" type="text/css" media="all">
  <link rel="stylesheet" href="<?php echo base_url('public/dungeon/scss/main.css'); ?>" type="text/css" media="all">
</head>

<body>
  <?php if (!empty($main)) echo $main; ?>
  <script src="<?php echo base_url("public/vendor/js/jquery-3.2.1.min.js"); ?>"></script>
  <script src="<?php echo base_url("public/vendor/js/popper.min.js"); ?>"></script>
  <script src="<?php echo base_url("public/vendor/js/bootstrap.min.js"); ?>"></script>
  <script src="<?php echo base_url("public/vendor/js/jquery.sticky-kit.min.js"); ?>"></script>
  <script src="<?php echo base_url("public/vendor/js/jquery.countdown.js"); ?>"></script>
  <script src="<?php echo base_url("public/dungeon/js/main.js"); ?>"></script>
  <script>
    // Select all elements with data-toggle="popover" in the document
    $('[data-toggle="popover"]').popover();
  </script>
</body>

</html>