<!-- BUY SELL OPEN CRAFT -->
<div class="text-center pt-4">
    <?php if (empty($_GET)) :  ?>
        <?php if ($npc['type_sell'][0] != 'spells' && $npc['type_sell'][0] != 'vaults' && $npc['type_sell'][0] != 'blacksmith') : ?>
            <a href="<?php echo base_url('dungeon/action/charater/' . $npc['slug'] . '?buy=thing'); ?>">
                <button class="btn btn-primary">BUY</button>
            </a>
            <a href="<?php echo base_url('dungeon/action/charater/' . $npc['slug'] . '?sell=thing'); ?>">
                <button class="btn btn-danger">SELL</button>
            </a>
        <?php endif; ?>
        <?php if ($npc['type_sell'][0] === 'blacksmith') : ?>
            <a href="<?php echo base_url('dungeon/action/charater/' . $npc['slug'] . '?blacksmith=thing'); ?>">
                <button class="btn btn-primary">Go</button>
            </a>
        <?php endif; ?>
        <?php if ($npc['type_sell'][0] === 'vaults') : ?>
            <a href="<?php echo base_url('dungeon/action/charater/' . $npc['slug'] . '?status=open'); ?>">
                <button class="btn btn-primary">OPEN</button>
            </a>
            <a href="<?php echo base_url('dungeon/action/charater/' . $npc['slug'] . '?status=save'); ?>">
                <button class="btn btn-primary">SAVE</button>
            </a>
        <?php endif; ?>
        <?php if ($npc['type_sell'][0] === 'spells') : ?>
            <a href="<?php echo base_url('dungeon/action/charater/' . $npc['slug'] . '?learn=thing'); ?>">
                <button class="btn btn-primary">LEARN</button>
            </a>
        <?php endif; ?>
    <?php endif; ?>
</div>
<!-- ////////////////////// -->