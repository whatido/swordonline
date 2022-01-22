<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title; ?></title>
  <link rel="stylesheet" href="<?= base_url() ?>public/vendor/font-awesome/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>public/default/css/news.css">
</head>

<body>
  <div id="overlay">
    <div class="cv-spinner">
      <span class="spinner"></span>
    </div>
  </div>
  <?php if (!empty($main)) echo $main; ?>
  <script src="<?= base_url() ?>public/vendor/js/jquery-3.2.1.min.js"></script>
  <script src="<?= base_url() ?>public/default/js/sys.js"></script>
  <script src="<?= base_url() ?>public/default/js/news.js"></script>
</body>

</html>