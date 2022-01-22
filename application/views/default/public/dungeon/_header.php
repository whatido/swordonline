<?php
$url_info = 'dungeon/account/info/';
?>

<?php if (!empty($_SESSION['users'])) : ?>
    <?php if (!empty($_SESSION['heroes']) && $_SESSION['heroes']['health'] > 0) : ?>
        <?php if(is_array($users)): ?>
        <div class="title title-b17244 text-center">
            <div class="text-light">Dungeon</div>
            <div class="text-light"><?php echo $_SESSION['heroes']['name']; ?> -
                <a href="<?php echo base_url($url_info . $_SESSION['heroes']['id']); ?>"><img src="<?php echo base_url(); ?>public/dungeon/<?php echo $_SESSION['heroes']['images']; ?>" width="24px" height="24px" alt=""><?php echo $users['username']; ?></a> (LV:<?php echo $_SESSION['heroes']['level']; ?>)
                <?php if (!empty($_SESSION['mode_Diamond']) && ($_SESSION['mode_Diamond'] > time())) : ?>
                    <img src="<?php echo base_url(); ?>public/dungeon/images/heroes/thumbs/diamond.gif" alt="">
                <?php endif; ?>
            </div>
            <div class="progress">
                <div class="progress-bar bg-green" role="progressbar" style="width: <?php echo (ceil(($_SESSION['heroes']['health'] / $_SESSION['heroes']['maxhealth']) * 100)); ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo (ceil(($_SESSION['heroes']['mana'] / $_SESSION['heroes']['maxmana']) * 100)); ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo (ceil(($_SESSION['heroes']['stamina'] / $_SESSION['heroes']['maxstamina']) * 100)); ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo (ceil(($_SESSION['heroes']['exp'] / $_SESSION['heroes']['expmax']) * 100)); ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
        <div class="block text-center">
            <div class="title">
                <?php if ($_SESSION['heroes']['point'] > 0) : ?>
                    <p>
                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            Have New level
                        </button>
                    </p>
                    <div class="collapse text-dark title title-dark" id="collapseExample">
                        <div class="card card-body">
                            <div class="profile-groups">
                                <div class="strength">
                                    Strength: <?php echo $_SESSION['heroes']['strength']; ?> <a href="<?php echo base_url('dungeon/action/point/strength'); ?>">+</a>
                                </div>
                                <div class="dexterity">
                                    Dexterity: <?php echo $_SESSION['heroes']['dexterity']; ?> <a href="<?php echo base_url('dungeon/action/point/dexterity'); ?>">+</a>
                                </div>
                                <div class="armor">
                                    Armor: <?php echo $_SESSION['heroes']['armor']; ?> <a href="<?php echo base_url('dungeon/action/point/armor'); ?>">+</a>
                                </div>
                                <div class="endurance">
                                    Endurance: <?php echo $_SESSION['heroes']['endurance']; ?> <a href="<?php echo base_url('dungeon/action/point/endurance'); ?>">+</a>
                                </div>
                                <div class="wisdom">
                                    Wisdom: <?php echo $_SESSION['heroes']['wisdom']; ?> <a href="<?php echo base_url('dungeon/action/point/wisdom'); ?>">+</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    <?php elseif (!empty($_SESSION['heroes']['health'])) : ?>
        <div class="block form-check-label text-center" style="color: #fff;font-size: 0.8em;font-weight: bold;">
            <?php echo $_SESSION['heroes']['health'] . "/" . $_SESSION['heroes']['maxhealth']; ?>
            |<?php echo $_SESSION['heroes']['mana'] . "/" . $_SESSION['heroes']['maxmana']; ?>|
            Stamina: <?php echo $_SESSION['heroes']['stamina'] . "/" . $_SESSION['heroes']['maxstamina']; ?>
        </div>
    <?php else : ?>
    <?php endif; ?>
<?php else : ?>
    <div class="title title-gray text-center">
        Text-Based Fantasy MMORPG.
    </div>
    <img src="<?php echo base_url('public/dungeon/images/bg2.jpg'); ?>" width="100%" alt="">
<?php endif; ?>