<!-- List wisdom view -->
<?php if (!empty($_GET['learn']) && $_GET['learn'] == 'thing') : ?>
    <?php foreach ($listItem as $key => $it) :  ?>
        <a href="<?php echo base_url('dungeon/action/charater/' . $npc['slug'] . '?learn=' . $it['id']); ?>"><?php echo $it['title']; ?></a>
        <br>
    <?php endforeach; ?>
<?php endif; ?>
<!-- Detail wisdom -->
<?php if (!empty($_GET['learn']) && $_GET['learn'] != 'thing') : $item = (object) $item; ?>
    <div class="text-center text-white text-both"><?php echo $item->title; ?></div>
    <div class="text-center text-white">
        <?php if (!empty($item->data_update)) : $db = (json_decode($item->data_update)); ?>
            <?php foreach ($db as $key => $vl) : if ($key == 'maxdamage') continue; ?>
                <?php if ($key == 'damage') : ?>
                    <?php echo $key; ?>: <?php echo $vl; ?> - <?php echo $db->maxdamage; ?> <br>
                <?php else : ?>
                    <?php echo $key; ?>: +<?php echo $vl; ?> <br>
                <?php endif; ?>
        <?php endforeach;
        endif; ?>
    </div>

    <div class="text-center text-danger">Requirements:</div>
    <div class="text-center text-white">
        <?php if (!empty($item->need_class) && strlen($item->need_class) > 0) : ?>
            <div class="text-center text-white title">
                Class:
                <?php if ($item->need_class === $heroes['class']) echo '<font color="green">' . $item->need_class . '</font>'; ?>
                <?php if ($item->need_class != $heroes['class']) echo '<font color="red">' . $item->need_class . '</font>'; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($item->need_lev) && strlen($item->need_lev) > 0) : ?>
            <div class="text-center text-white title">
                Level:
                <?php if ($item->need_lev <= $heroes['level']) echo '<font color="green">' . $item->need_lev . '</font>'; ?>
                <?php if ($item->need_lev > $heroes['level']) echo '<font color="red">' . $item->need_lev . '</font>'; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($item->need_str) && strlen($item->need_str) > 0) : ?>
            <div class="text-center text-white title">
                Strength:
                <?php if ($item->need_str <= $heroes['strength']) echo '<font color="green">' . $item->need_str . '</font>'; ?>
                <?php if ($item->need_str > $heroes['strength']) echo '<font color="red">' . $item->need_str . '</font>'; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($item->need_dex) && strlen($item->need_dex) > 0) : ?>
            <div class="text-center text-white title">
                Dexterity:
                <?php if ($item->need_dex <= $heroes['dexterity']) echo '<font color="green">' . $item->need_dex . '</font>'; ?>
                <?php if ($item->need_dex > $heroes['dexterity']) echo '<font color="red">' . $item->need_dex . '</font>'; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($item->need_arm) && strlen($item->need_arm) > 0) : ?>
            <div class="text-center text-white title">
                Armor:
                <?php if ($item->need_arm <= $heroes['armor']) echo '<font color="green">' . $item->need_arm . '</font>'; ?>
                <?php if ($item->need_arm > $heroes['armor']) echo '<font color="red">' . $item->need_arm . '</font>'; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($item->need_end) && strlen($item->need_end) > 0) : ?>
            <div class="text-center text-white title">
                Endurance:
                <?php if ($item->need_end <= $heroes['endurance']) echo '<font color="green">' . $item->need_end . '</font>'; ?>
                <?php if ($item->need_end > $heroes['endurance']) echo '<font color="red">' . $item->need_end . '</font>'; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($item->need_wis) && strlen($item->need_wis) > 0) : ?>
            <div class="text-center text-white title">
                Wisdom:
                <?php if ($item->need_wis <= $heroes['wisdom']) echo '<font color="green">' . $item->need_wis . '</font>'; ?>
                <?php if ($item->need_wis > $heroes['wisdom']) echo '<font color="red">' . $item->need_wis . '</font>'; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php if ($id_true == 0) : ?>
        <a href="<?php echo base_url('dungeon/action/charater/' . $npc['slug'] . '?learn=' . $item->id . '&now=1'); ?>">
            <button class="btn btn-primary">LEARN</button>
        </a>
    <?php else : ?>
        <div class="text-center text-danger">You don't pass the requirements.</div>
    <?php endif; ?>
<?php endif; ?>