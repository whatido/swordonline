<?php
$url_info = 'dungeon/account/info/';
?>

<?php if (!empty($users)) : ?>
    <footer>
        <div class="text-light">Dungeon</div>
        <div class="text-light"><?php echo $heroes['name']; ?> -
            <a href="<?php echo base_url($url_info . $heroes['id']); ?>"><img src="<?php echo base_url(); ?>public/dungeon/<?php echo $heroes['images']; ?>" width="24px" height="24px" alt=""><?php echo $users['username']; ?></a>  (LV:<?php echo $heroes['level']; ?>)
            <?php if (!empty($_SESSION['mode_Diamond']) && ($_SESSION['mode_Diamond'] > time())) : ?>
                <img src="<?php echo base_url(); ?>public/dungeon/images/heroes/thumbs/diamond.gif" alt="">
            <?php endif; ?>
        </div>
    </footer>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <article>
                    <div class="profile">
                        <div class="profile-groups">
                            <div class="text-white damage">
                                Weapon: <?php if (!empty($weapon[0])) : ?>
                                    <a href="<?php echo base_url('dungeon/item/info/' . $weapon[0]['id']); ?>"><?php echo colorStar($weapon[0]); ?></a><br>
                                <?php endif; ?>
                            </div>
                            <div class="text-white strength">
                                Shield: <?php if (!empty($shield[0])) : ?>
                                    <a href="<?php echo base_url('dungeon/item/info/' . $shield[0]['id']); ?>"><?php echo colorStar($shield[0]); ?></a><br>
                                <?php endif; ?>
                            </div>
                            <div class="text-white dexterity">
                                Helm: <?php if (!empty($helm[0])) : ?>
                                    <a href="<?php echo base_url('dungeon/item/info/' . $helm[0]['id']); ?>"><?php echo colorStar($helm[0]); ?></a><br>
                                <?php endif; ?>
                            </div>
                            <div class="text-white armor">
                                Body Armor: <?php if (!empty($armor[0])) : ?>
                                    <a href="<?php echo base_url('dungeon/item/info/' . $armor[0]['id']); ?>"><?php echo colorStar($armor[0]); ?></a><br>
                                <?php endif; ?>
                            </div>
                            <div class="text-white endurance">
                                Boots: <?php if (!empty($boot[0])) : ?>
                                    <a href="<?php echo base_url('dungeon/item/info/' . $boot[0]['id']); ?>"><?php echo colorStar($boot[0]); ?></a><br>
                                <?php endif; ?>
                            </div>
                            <div class="text-white wisdom">
                                Amulet: <?php if (!empty($amulet[0])) : ?>
                                    <a href="<?php echo base_url('dungeon/item/info/' . $amulet[0]['id']); ?>"><?php echo colorStar($amulet[0]); ?></a><br>
                                <?php endif; ?>
                            </div>
                            <div class="text-white wisdom">
                                Ring #1: <?php if (!empty($ring[0])) : ?>
                                    <a href="<?php echo base_url('dungeon/item/info/' . $ring[0]['id']); ?>"><?php echo colorStar($ring[0]); ?></a><br>
                                <?php endif; ?>
                            </div>
                            <div class="text-white wisdom">
                                Ring #2: <?php if (!empty($ring[1])) : ?>
                                    <a href="<?php echo base_url('dungeon/item/info/' . $ring[1]['id']); ?>"><?php echo colorStar($ring[1]); ?></a><br>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
    <div class="mt-2">
    <form action="http://game.test/dungeon/action/charater/Jimli" method="post">
        <button type="submit">Blacksmith</button>
    </form>
    </div>
    <footer class="text-left pl-2">
        <div class="text-light">Inventory (<?php echo $countItem; ?>/<?php echo $_SESSION['heroes']['max_inventory']; ?>): <a href="/dungeon/item?status=destroy">SELL</a></div>
        <div class="text-light">
            <?php if (!empty($_GET['status']) && !empty($item)) : ?>
                <a href="/dungeon/item?status=destroy&select=all">Select all</a>
                <form action="<?php echo base_url('dungeon/item/info/' . $listItem[0]['id']); ?>" method="post">
                    <div class="form-check">
                        <?php if (!empty($listItem)) foreach ($listItem as $key => $it) :  ?>
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="choose[]" id="" value="<?php echo $it['id']; ?>" <?php if (!empty($_GET['select']) && $_GET['select'] == 'all') echo 'checked'; ?>>
                                <?php if ($it['star'] == 1) echo '<span style="color: #fff">' . $it['title'] . '</span>'; ?>
                                <?php if ($it['star'] == 2) echo '<span style="color: #1eff00">' . $it['title'] . ' [Uncommon]</span>'; ?>
                                <?php if ($it['star'] == 3) echo '<span style="color: #0070ff">' . $it['title'] . ' [Rare]</span>'; ?>
                                <?php if ($it['star'] == 4) echo '<span style="color: #a335ee">' . $it['title'] . ' [Epic]</span>'; ?>
                                <?php if ($it['star'] == 5) echo '<span style="color: #ff9800">' . $it['title'] . ' [Mythic]</span>'; ?>
                                <?php if ($it['star'] == 6) echo '<span style="color: #c34949">' . $it['title'] . ' [Heroic]</span>'; ?>
                                <?php if ($it['star'] == 7) echo '<span style="color: #21b6a8">' . $it['title'] . ' [Divine]</span>'; ?>
                            </label> <img src="<?php echo base_url('public/dungeon/images/icon/gold.png'); ?>" alt=""><?php echo $it['gold']; ?><br>
                        <?php endforeach; ?>
                    </div>
                    <input type="hidden">
                    <button type="submit" name="status" value="destroy" class="btn btn-primary">Choose</button>
                </form>
            <?php else : ?>
                <?php if(!empty($item)) echo viewListItem($item); ?>
            <?php endif; ?>
        </div>
    </footer>
<?php endif; ?>