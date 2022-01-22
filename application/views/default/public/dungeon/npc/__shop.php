<!-- List sell item -->
<?php if (!empty($_GET['buy']) && $_GET['buy'] == 'thing') : ?>
    <?php foreach ($listItem as $key => $it) : $it = (array) $it; ?>
        <a href="<?php echo base_url('dungeon/action/charater/' . $npc['slug'] . '?buy=' . ($key + 1)); ?>"><?php echo $it['title']; ?></a>
        <?php if ($it['star'] == 2) echo '<span class="small" style="color: #1eff00">[Uncommon]</span>'; ?>
        <?php if ($it['star'] == 3) echo '<span class="small" style="color: #0070ff">[Rare]</span>'; ?>
        <?php if ($it['star'] == 4) echo '<span class="small" style="color: #a335ee">[Epic]</span>'; ?>
        <?php if ($it['star'] == 5) echo '<span class="small" style="color: #ff9800">[Mythic]</span>'; ?>
        <?php if ($it['star'] == 6) echo '<span class="small" style="color: #c34949">[Heroic]</span>'; ?>
        <br>
    <?php endforeach; ?>
<?php endif; ?>
<!-- detail shop view -->
<?php if (!empty($_GET['buy']) && $_GET['buy'] != 'thing') : $item = (object) $item; ?>
    <div class="text-center text-white"><?php echo $item->title; ?></div>
    <?php if (!empty($item->data_update)) : $db = viewDataItem($item->data_update); ?>
        <?php foreach ($db as $key => $vl) : if ($key == 'maxdamage') continue; ?>
            <?php if ($key == 'damage') : ?>
                <div class="text-center text-white">
                    <?php echo ucfirst($key); ?>: <?php echo $vl; ?> - <?php echo $db['maxdamage']; ?>
                </div>
            <?php elseif ($key == 'life_leech') : ?>
                <div class="text-center text-white">
                    Life Leech: +<?php echo $vl; ?>%
                </div>
            <?php else : ?>
                <div class="text-center text-white">
                    <?php echo ucfirst($key); ?>: +<?php echo $vl; ?> <?php if ($item->type == 'potion' && $item->level == 2) echo '%'; ?>
                </div>
            <?php endif; ?>
    <?php endforeach;
    endif; ?>
    <div class="text-center text-danger">Requirements:</div>
    <?php if (!empty($item->equipment_rule)) foreach (json_decode($item->equipment_rule) as $k => $v) : if ($v == '') continue; ?>
        <div class="text-center text-white title">
            <?php echo $k; ?>:
            <?php if ($v <= $heroes[$k]) echo '<font color="green">' . $v . '</font>'; ?>
            <?php if ($v > $heroes[$k]) echo '<font color="red">' . $v . '</font>'; ?>
        </div>
    <?php endforeach; ?>
    <form action="<?php echo base_url('dungeon/action/charater/' . $npc['slug'] . ''); ?>" method="get">
        <input type="hidden" name="buy" id="" class="form-control" value="<?php echo $_GET['buy']; ?>">
        <input type="hidden" name="now" id="" class="form-control" value="1">
        <input type="<?php if ($item->type == 'potion') echo 'text';
                        else echo 'hidden'; ?>" name="num" id="" class="form-control" value="1">
        <br>
        <button type="submit">BUY</button>
    </form>
    <br>
    <?php if ($heroes['gold'] > 0) : ?>
        <div class="text-center text-white title">
            Gold:
            <?php if ($item->gold <= $heroes['gold']) echo '<font color="green">' . $item->gold . '</font>'; ?>
            <?php if ($item->gold > $heroes['gold']) echo '<font color="red">' . $item->gold . '</font>'; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>