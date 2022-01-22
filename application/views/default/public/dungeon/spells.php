<?php if (!empty($list)) : ?>
    <footer class="text-center pl-2">
        <div class="text-light">Spell</div>

        <?php foreach ($list as $key => $it) :  ?>
            <div class="text-left text-light">
                
            <div class="text-left text-light">
            <div class="d-flex bd-highlight">
  <div class="p-2 flex-grow-1 bd-highlight"><a href="#<?php echo base_url('dungeon/action/items/' . $it['id']); ?>"><?php echo $it['title']; ?></a></div>
  <div class="p-2 bd-highlight"></div>
  <div class="p-2 bd-highlight"><?php if($it['active'] == 0): ?>
                [<a href="<?php echo base_url('dungeon/spells/?id=' . $it['id'].'&active=1'); ?>">Active</a>]
                <?php endif; ?></div>
</div>
            </div>

        <?php endforeach; ?>

    </footer>
<?php endif; ?>