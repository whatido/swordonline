<?php
$url_login = 'dungeon/account/login';
$url_register = 'dungeon/account/register';
?>
<div class="form-group text-center">
<?php if(!empty($error)) echo "<div class='text-danger'>$error</div>"; ?>
    <form action="<?php echo base_url($url_login); ?>" method="post">
        <label for=""><?php if(!empty($lang)) echo $lang[0]; ?>:</label>
        <input type="text" name="email" id="" class="form-control" placeholder="" aria-describedby="helpId" value="">
        <br>
        <label for=""><?php if(!empty($lang)) echo $lang[1]; ?>:</label>
        <input type="text" name="password" id="" class="form-control" placeholder="" aria-describedby="helpId" value="">
        <br>
        <button type="submit"><?php if(!empty($lang)) echo $lang[2]; ?></button>
    </form>
    <br>
    <a href="<?php echo base_url($url_register); ?>" class="btn btn-success"><?php if(!empty($lang)) echo $lang[3]; ?></a>
</div>

