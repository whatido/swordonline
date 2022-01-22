<?php
$url_info = 'dungeon/account/info/';
?>

<?php if (!empty($_SESSION['users'])) : ?>
    <?php if (isset($home) && ($udungeon['health'] > 0)) : ?>
        <header class="text-center">
            <div class="text-light">Dungeon</div>
            <div class="text-light"><?php echo $udungeon['name']; ?> -
                <a href="<?php echo base_url($url_info . $udungeon['id']); ?>"><img src="<?php echo base_url(); ?>public/dungeon/<?php echo $udungeon['images']; ?>" width="24px" height="24px" alt=""><?php echo $users['username']; ?></a> (LV:<?php echo $udungeon['level']; ?>)
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
        </header>
        <div class="block text-center">
            <div class="title">
            <?php if ($udungeon['point'] > 0) : ?>
                    <p>
                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            Have New level
                        </button>
                    </p>
                    <div class="collapse text-dark" id="collapseExample">
                        <div class="card card-body">
                            <div class="profile-groups">
                                <div class="strength">
                                    Strength: <?php echo $udungeon['strength']; ?> <a href="<?php echo base_url('dungeon/action/point/strength'); ?>">+</a>
                                </div>
                                <div class="dexterity">
                                    Dexterity: <?php echo $udungeon['dexterity']; ?> <a href="<?php echo base_url('dungeon/action/point/dexterity'); ?>">+</a>
                                </div>
                                <div class="armor">
                                    Armor: <?php echo $udungeon['armor']; ?> <a href="<?php echo base_url('dungeon/action/point/armor'); ?>">+</a>
                                </div>
                                <div class="endurance">
                                    Endurance: <?php echo $udungeon['endurance']; ?> <a href="<?php echo base_url('dungeon/action/point/endurance'); ?>">+</a>
                                </div>
                                <div class="wisdom">
                                    Wisdom: <?php echo $udungeon['wisdom']; ?> <a href="<?php echo base_url('dungeon/action/point/wisdom'); ?>">+</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (!empty($map['title'])) : ?>
                <div class="title">
                    <div class="">
                        <?php echo $map['title']; ?>
                        <br>
                        <img src="public/dungeon/<?php echo $map['images']; ?>" width="80%" height="120px" alt="">
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php elseif (!empty($udungeon['health'])) : ?>
        <div class="block form-check-label text-center" style="color: #fff;font-size: 0.8em;font-weight: bold;">
            <?php echo $_SESSION['heroes']['health'] . "/" . $_SESSION['heroes']['maxhealth']; ?>
            |<?php echo $_SESSION['heroes']['mana'] . "/" . $_SESSION['heroes']['maxmana']; ?>|
            Stamina: <?php echo $_SESSION['heroes']['stamina'] . "/" . $_SESSION['heroes']['maxstamina']; ?>
        </div>
    <?php else : ?>
    <?php endif; ?>
<?php else : ?>
    <header class="text-center">
        Text-Based Fantasy MMORPG.
    </header>
<?php endif; ?>