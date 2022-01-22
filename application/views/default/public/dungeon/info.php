<!-- Info Users S -->
<?php if (!empty($users) && empty($item)) : ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <article>
                    <div class="profile">
                        <?php if ($users->username !== $_SESSION['users']['username']) : ?>
                            <div class="profile-groups">
                                <div class="text-center text-white username">
                                    <a href="<?php echo base_url('dungeon/inbox/mes/' . $users->username); ?>">Message</a>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="profile-groups">
                            <div class="text-center text-white username">
                                <?php echo $users->username; ?>
                            </div>
                            <div class="text-center text-white level-type">
                                Level <?php echo $users->level; ?> - <?php echo $users->name; ?>
                            </div>
                            <div class="text-center text-white avatar">
                                <img src="<?php echo base_url('public/dungeon/' . $users->images); ?>" alt="<?php echo $users->name; ?>">
                            </div>
                            <div class="text-center text-white exp">
                                EXP: <?php echo $users->exp; ?> / <?php echo $users->expmax; ?>
                            </div>
                        </div>
                        <div class="profile-groups">
                            <div class="text-white health">
                                HP: <?php echo $users->health; ?> / <?php echo $users->maxhealth; ?>
                            </div>
                        </div>
                        <div class="profile-groups">
                            <div class="text-white damage">
                                Damage: <?php echo ($users->damage + $users->strength) . ' - ' . ($users->maxdamage + $users->strength); ?>
                            </div>
                            <div class="text-white strength">
                                Strength: <?php echo $users->strength; ?> (<?php echo $usersbonus['strength']; ?>) <?php if($bonus['strength'] > 0) echo '- '.$bonus['strength'].'%'; ?>
                            </div>
                            <div class="text-white dexterity">
                                Dexterity: <?php echo $users->dexterity; ?> (<?php echo $usersbonus['dexterity']; ?>) <?php if($bonus['dexterity'] > 0) echo '- '.$bonus['dexterity'].'%'; ?>
                            </div>
                            <div class="text-white armor">
                                Armor: <?php echo $users->armor; ?> (<?php echo $usersbonus['armor']; ?>) <?php if($bonus['armor'] > 0) echo '- '.$bonus['armor'].'%'; ?>
                            </div>
                            <div class="text-white armor">
                                Magic Resistance: <?php echo $users->magic_resistance; ?> (<?php echo $usersbonus['magic_resistance']; ?>) <?php if($bonus['magic_resistance'] > 0) echo '- '.$bonus['magic_resistance'].'%'; ?>
                            </div>
                            <div class="text-white endurance">
                                Endurance: <?php echo $users->endurance; ?> (<?php echo $usersbonus['endurance']; ?>) <?php if($bonus['endurance'] > 0) echo '- '.$bonus['endurance'].'%'; ?>
                            </div>
                            <div class="text-white wisdom">
                                Wisdom: <?php echo $users->wisdom; ?> (<?php echo $usersbonus['wisdom']; ?>) <?php if($bonus['wisdom'] > 0) echo '- '.$bonus['wisdom'].'%'; ?>
                            </div>
                            <div class="text-white wisdom">
                                Prot. from Water: <?php echo $users->water; ?>%
                            </div>
                            <div class="text-white wisdom">
                                Prot. from Fire: <?php echo $users->fire; ?>%
                            </div>
                            <div class="text-white wisdom">
                                Prot. from Wind: <?php echo $users->wind; ?>%
                            </div>
                            <div class="text-white wisdom">
                                Prot. from Earth: <?php echo $users->earth; ?>%
                            </div>
                            <div class="text-white wisdom">
                                Credit: <?php echo $users->credit; ?>
                            </div>
                            <div class="text-white wisdom">
                                Gold: <?php echo $users->gold; ?>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
<?php endif; ?>
<!-- Info Users N -->
<!-- Info Item S -->
<?php if (!empty($item)) : $item = (object) $item; ?>
    <footer>
        <div class="profile-groups bg-danger">
            <div class="text-center">Inventory</div>
            <div class="text-center text-white title">
                <?php echo $item->title; ?>
            </div>
            <?php if (!empty($item_c1)) : ?>
                <?php echo $item_c1['title']; ?>
            <?php endif; ?>
            <br>
            <?php if (!empty($item_c2)) : ?>
                <?php echo $item_c2['title']; ?>
            <?php endif; ?>
        </div>
    </footer>
    <?php if ($item->craft !== 'peace'): ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <article>
                    <?php if (!empty($item->data_update)) : $db = viewDataItem($item->data_update);
                        $db_equip = viewDataItem($equipitem['data_update']); ?>
                        <?php foreach ($db as $key => $vl) : if ($key == 'maxdamage') continue; ?>
                            <?php if ($key == 'damage') : ?>
                                <div class="text-center text-white title">
                                    <?php echo ucfirst($key); ?>: <?php echo $vl; ?> <?php if ($vl != $db['maxdamage']) echo ' - ' . $db['maxdamage']; ?>
                                    <span style="font-size: 0.8em;font-weight: bold;">
                                        <?php if (empty($db_equip['damage'])) $db_equip['damage'] = 0;
                                        if (!empty($db['damage']) && $vl > $db_equip['damage']) echo '<font color="green">+' . ($vl - $db_equip['damage']) . '</font>'; ?>
                                        <?php if (empty($db_equip['damage'])) $db_equip['damage'] = 0;
                                        if (!empty($db['damage']) && $vl < $db_equip['damage']) echo '<font color="red">- ' . ($db_equip['damage'] - $vl) . '</font>'; ?>
                                        <?php if (empty($db_equip['maxdamage'])) $db_equip['maxdamage'] = 0;
                                        if (!empty($db['maxdamage']) && $vl != $db['maxdamage'] && $db['maxdamage'] > $db_equip['maxdamage']) echo '<font color="green">+' . ($db['maxdamage'] - $db_equip['maxdamage']) . '</font>'; ?>
                                        <?php if (empty($db_equip['maxdamage'])) $db_equip['maxdamage'] = 0;
                                        if (!empty($db['maxdamage']) && $vl != $db['maxdamage'] && $db['maxdamage'] < $db_equip['maxdamage'] && (($db_equip['maxdamage'] - $db['maxdamage']) != 0)) echo '<font color="red">-' . ($db_equip['maxdamage'] - $db['maxdamage']) . '</font>'; ?>
                                    </span>
                                </div>
                            <?php elseif ($key == 'life_leech') : ?>
                                <div class="text-center text-white title">
                                    Life Leech: +<?php echo $vl; ?>%
                                </div>
                            <?php elseif (in_array($key, ['water', 'fire', 'wind', 'earth', 'light', 'dark', 'space'])) : ?>
                                <?php if ($vl > 0) : ?>
                                    <div class="text-center text-white title">
                                        Prot. from <?php echo ucfirst($key); ?>: +<?php echo $vl; ?>%
                                        <span style="font-size: 0.8em;font-weight: bold;">
                                            <?php if (empty($db_equip[$key])) $db_equip[$key] = 0;
                                            if ($vl > $db_equip[$key]) echo '<font color="green">+' . ($vl - $db_equip[$key]) . '</font>'; ?>
                                            <?php if ($vl < $db_equip[$key]) echo '<font color="red">-' . ($db_equip[$key] - $vl) . '</font>'; ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                            <?php else : ?>
                                <div class="text-center text-white title">
                                    <?php echo ucfirst($key); ?>: +<?php echo $vl; ?><?php if($item->type == 'potion' && $item->level == 2) echo '%'; ?>
                                    <span style="font-size: 0.8em;font-weight: bold;">
                                        <?php if (empty($db_equip[$key])) $db_equip[$key] = 0;
                                        if ($vl > $db_equip[$key]) echo '<font color="green">+' . ($vl - $db_equip[$key]) . '</font>'; ?>
                                        <?php if ($vl < $db_equip[$key]) echo '<font color="red">-' . ($db_equip[$key] - $vl) . '</font>'; ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                    <?php endforeach;
                    endif; ?>
                </article>
            </div>
        </div>
    </div>
    <!-- Requirements -->
    <footer>
        <div class="profile-groups bg-default">
            <div class="text-center text-danger">Requirements:</div>
            <?php if (!empty($item->equipment_rule)) foreach ($item->equipment_rule as $k => $v) : if($v == '') continue; ?>
                <div class="text-center text-white title">
                    <?php echo $k; ?>:
                    <?php if ($v <= $heroes[$k]) echo '<font color="green">' . $v . '</font>'; ?>
                    <?php if ($v > $heroes[$k]) echo '<font color="red">' . $v . '</font>'; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </footer>
    <?php endif; ?>
    <footer>
        <form action="" method="post">
            <?php if (!empty($rule['equip'])) : ?>
                <button type="submit" name="status" value="equip" class="btn btn-primary">Equip</button>
            <?php endif; ?>
            <?php if (!empty($rule['use'])) : ?>
                <button type="submit" name="status" value="use" class="btn btn-primary">Use</button>
            <?php endif; ?>
            <?php if (!empty($rule['takeoff'])) : ?>
                <button type="submit" name="status" value="takeoff" class="btn btn-primary">Take off</button>
            <?php endif; ?>
            <?php if (!empty($rule['takeoffall'])) : ?>
                <button type="submit" name="status" value="unequipall" class="btn btn-primary">takeof all</button>
            <?php endif; ?>
            <?php if (!empty($rule['destroy'])) : ?>
                <button type="submit" name="status" value="destroy" class="btn btn-primary">Destroy item</button>
                <img src="<?php echo base_url('public/dungeon/images/icon/gold.png'); ?>" alt=""><?php echo $item->gold; ?>
            <?php endif; ?>
        </form>
        <a href="<?php echo base_url('dungeon/item'); ?>">Items</a>
    </footer>
    
<?php endif; ?>
<!-- Info Item N -->