<?php if (isset($home) && !isset($_POST['attack'])) : ?>
    <footer>
        <div class="text-light">Dungeon Attack</div>
    </footer>
    <footer>
        <form action="" method="post">
            <div class="text-light"><?php echo $hmap['name']; ?> [Level: <?php echo $hmap['level']; ?>]</div>
            <div class="text-light"><img src="<?php echo base_url(); ?>public/dungeon/images/cards/thumbs/<?php echo $hmap['images']; ?>.png" width="48px" height="48px" alt=""></div>
            <div class="text-light">Health: <?php echo $hmap['health']; ?>/<?php echo $hmap['maxhealth']; ?></div>
            <div class="text-light">Damage: <?php echo ($hmap['strength'] + $hmap['damage']) . ' - ' . ($hmap['strength'] + $hmap['maxdamage']); ?></div>
            <div class="text-light">Strength: <?php echo $hmap['strength']; ?></div>
            <div class="text-light">Dexterity: <?php echo $hmap['dexterity']; ?></div>
            <div class="text-light">Endurance: <?php echo $hmap['endurance']; ?></div>
            <div class="text-light">Wisdom: <?php echo $hmap['wisdom']; ?></div>
            <div class="text-light">Armor: <?php echo $hmap['armor']; ?></div>
            <div class="text-light mt-1 mb-1">
                <?php if (!empty($spells_list) && count($spells_list) > 0) : ?>
                    <select name="spell" id="" class="btn btn-primary">
                        <option value="0">None</option>
                        <?php if (!empty($spells_list)) foreach ($spells_list as $key => $item) : ?>
                            <option value="<?php echo $item['id']; ?>" <?php if ((!empty($_POST['spell']) && $_POST['spell'] == $item['id'])) echo 'selected';
                                                                        elseif ($item['active'] == 1) echo 'selected'; ?>><?php echo $item['title']; ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
            </div>
            <div class="text-light"><button type="submit" name="attack" class="btn btn-primary">ATTACK</button></div>
        </form>
    </footer>
<?php endif; ?>

<?php if (isset($home) && isset($_POST['attack'])) : ?>
    <footer>
        <div class="text-light">Dungeon Attack</div>
        <?php if (empty($rs)) : ?>
            <div class="text-light"><?php echo $hmap['name']; ?> (<?php echo $hmap['health']; ?>) vs <?php echo $users['username']; ?> (<?php echo $udungeon['health']; ?>)</div>
        <?php endif; ?>
    </footer>
    <footer>
        <form action="" method="post">
            <?php if (empty($rs)) : ?>
                <div class="text-light"><button type="submit" name="attack" class="btn btn-primary">ATTACK</button></div>
                <div class="text-light mt-1 mb-1">
                    <?php if (!empty($spells_list) && count($spells_list) > 0) : ?>
                        <select name="spell" id="" class="btn btn-primary">
                            <option value="0">None</option>
                            <?php if (!empty($spells_list)) foreach ($spells_list as $key => $item) : ?>
                                <option value="<?php echo $item['id']; ?>" <?php if (!empty($_POST['spell']) && $_POST['spell'] == $item['id']) echo 'selected'; ?>><?php echo $item['title']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <div class="text-light"><a href="<?php echo base_url('dungeon'); ?>">NEXT</a></div>
            <?php endif; ?>
        </form>
    </footer>
    <?php if (!empty($result['row_result'])) : ?>
        <footer class="text-light">
            <?php echo $result['row_result']; ?> <?php if (!empty($result['row_experience'])) : ?>Experience: +<?php echo $result['row_experience']; ?> [<?php echo $result['row_pox']; ?>]<?php endif; ?><br>
            <?php echo $result['row_dam_user']; ?> <br>
            <?php echo $result['row_dam_monster']; ?>
        </footer>
    <?php endif; ?>
    <footer class="">
        <div class="text-light"><?php echo $_SESSION['message']; ?></div>
    </footer>
<?php endif; ?>
<?php if (!empty($listItem)) foreach ($listItem as $key => $list) :  ?>
    <div class="d-flex bd-highlight">
        <div class="p-2 flex-grow-1 bd-highlight">
            <a href="<?php echo base_url('dungeon/item/info/' . $list[0]['id'] . '?status=use&back=' . $_SERVER['PHP_SELF']); ?>">
                <?php if (count($list) > 1) echo "x" . count($list); ?> <?php echo $key; ?></a>
        </div>
    </div>
<?php endforeach; ?>