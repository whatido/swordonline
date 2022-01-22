<?php
$url_login = 'dungeon/account/login';
$url_register = 'dungeon/account/register';
$url_confirm = 'dungeon/account/register?confirm=';
?>

<?php if (!isset($_SESSION['users']['email'])) : ?>
    <div class="form-group text-center">
    <?php if(!empty($error['mes'])) echo "<div class='text-danger'>$error[mes]</div>"; ?>
        <form action="<?php echo base_url($url_register); ?>" method="post">
            <label for=""><?php if(!empty($lang)) echo $lang[0]; ?>:</label>
            <input type="text" name="username" id="" class="form-control" placeholder="" aria-describedby="helpId" value="<?php if(!empty($error['username'])) echo $error['username']; ?>">
            <br>
            <label for=""><?php if(!empty($lang)) echo $lang[1]; ?>:</label>
            <input type="text" name="email" id="" class="form-control" placeholder="thucamt@outlook.com" aria-describedby="helpId" value="<?php if(!empty($error['email'])) echo $error['email']; ?>">
            <br>
            <label for=""><?php if(!empty($lang)) echo $lang[2]; ?>:</label>
            <input type="text" name="password" id="" class="form-control" placeholder="Password" aria-describedby="helpId" value="<?php if(!empty($error['password'])) echo $error['password']; ?>">
            <br>
            <button type="submit"><?php if(!empty($lang)) echo $lang[4]; ?></button>
        </form>
        <br>
        <a href="<?php echo base_url($url_login); ?>" class="btn btn-success"><?php if(!empty($lang)) echo $lang[3]; ?></a>
    </div>
<?php endif; ?>
<?php if (isset($_SESSION['users']['email'])) : ?>
    <div class="card-body">
        <h4 class="card-title"><?php if(!empty($lang)) echo $lang[5]; ?></h4>
        <h6 class="card-subtitle text-muted"><?php if(!empty($lang)) echo $lang[6]; ?>:</h6>
    </div>
    <?php if (!empty($heroes)) foreach ($heroes as $key => $item) : ?>
        <div class="card">
            <div class="card-header btn" data-toggle="collapse" data-target="#noidungcard_<?php echo $item['id']; ?>" aria-expanded="true" data-parent="#myaccordion">
                <?php echo $item['name']; ?>
            </div>
            <div class="card-body collapse" data-toggle="collapse" aria-expanded="false" id="noidungcard_<?php echo $item['id']; ?>">
                <div class="item-japanese comphrase-item">
                    <img src="<?php echo base_url('public/dungeon/' . $item['images']); ?>" alt="<?php echo $item['name']; ?>"> <br>
                    Strength: <?php echo $item['strength']; ?> <br>
                    Dexterity: <?php echo $item['dexterity']; ?> <br>
                    Endurance: <?php echo $item['endurance']; ?> <br>
                    Wisdom: <?php echo $item['wisdom']; ?> <br>
                    <a class="btn btn-danger" href="<?php echo base_url($url_confirm. '' . $item['id'] . ''); ?>"><?php if(!empty($lang)) echo $lang[7]; ?> >></a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>