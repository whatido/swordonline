<footer class="text-center pl-2">
    <div class="text-light"><a href="<?php echo base_url('/dungeon/online'); ?>">Online <?php echo (count($online)+count($guest)); ?></a></div>
    <div class="text-light">
        <?php foreach ($list as $key => $it) :  ?>
            <img src="<?php echo base_url('public/dungeon/media/heroes/' . $it['images'] . '.ico'); ?>" alt="">
            <a href="<?php echo base_url('dungeon/action/info/' . $it['id']); ?>"><?php echo $it['username']; ?></a>
            Lvl: <?php echo $it['level']; ?>
            <br>
        <?php endforeach; ?>
    </div>
</footer>