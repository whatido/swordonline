<!-- <span style="background-image: url(public/dungeon/images/map/background/<?php echo $item; ?>.png);background-repeat: no-repeat;background-size: cover;padding: 11px 0px 16px;">
    <a href="<?php echo base_url('dungeon/action/go/' . $xloca); ?>">
        <img src="public/dungeon/<?php echo $udungeon['images']; ?>" width="48px" height="48px" alt="">
    </a>
</span>
<?php if (!empty($hmap) && count($hmap) > 0 && array_key_exists($key, $hmap) == 1) {
    $b_health = ceil(0.32 * (($hmap[$key][0]['health'] / $hmap[$key][0]['maxhealth']) * 100));
}; ?>
<a href="<?php echo base_url('dungeon/attack/' . $xloca); ?>" style="position: relative;">
    <img src="public/dungeon/images/cards/thumbs/<?php echo $hmap[$key][0]['images']; ?>.jpg" width="48px" height="48px" alt="">
    <div style="background-color: red;width: <?php echo $b_health; ?>px;background-repeat: no-repeat;background-size: cover;height: 2px;position: absolute;left:0;top: 35px;"></div>
    <div style="font-size: 12px;width: 5px;height: 0px;position: absolute;left:0;top: -14px;"><?php echo $hmap[$key][0]['level']; ?></div>
</a>
<span style="background-image: url(public/dungeon/images/map/background/<?php echo $item; ?>.png);background-repeat: no-repeat;background-size: cover;padding: 11px 0px 16px;">
    <a href="<?php echo base_url('dungeon/action/go/' . $xloca); ?>">
        <img src="public/dungeon/images/map/inbackground/<?php echo $listinBackground[$key]; ?>.png" width="48px" height="48px" alt=""></a>
</span> -->

<?php if ($location === $this_loca) : ?>
    <span style="background-image: url(public/dungeon/images/map/background/<?php echo $item; ?>.png);background-repeat: no-repeat;background-size: cover;padding: 11px 0px 16px;">
        <a href="<?php echo base_url('dungeon/action/go/' . $xloca); ?>">
            <img src="public/dungeon/<?php echo $udungeon['images']; ?>" width="48px" height="48px" alt="">
        </a>
    <?php else : ?>
        <span style="background-image: url(public/dungeon/images/map/background/<?php echo $item; ?>.png);background-repeat: no-repeat;background-size: cover;padding: 11px 0px 16px;">
            <a href="<?php echo base_url('dungeon/action/go/' . $xloca); ?>">
                <img src="public/dungeon/images/map/inbackground/<?php echo $listinBackground[$key]; ?>.png" width="48px" height="48px" alt=""></a>
        </span>
    <?php endif; ?>