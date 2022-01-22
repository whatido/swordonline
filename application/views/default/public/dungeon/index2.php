<?php if (($heroes['health'] > 0)) : ?>
    <div style="text-align: center;overflow: auto;">
        <div class="block" style="width: 352px;">
            <table>
                <?php if (!empty($map) && !empty($heroes)) :
                    $no_go      = json_decode($map['z']);
                    $listBackground    = matchMap($heroes['x'], $map);
                    $listinBackground    = $map['inbackground'];
                    $key = 0;
                ?>
                    <div class="text-center text-light mb-2">
                        <?php if (in_array($_SESSION['heroes']['x'], $plink) === true && is_numeric($link[array_search($_SESSION['heroes']['x'], $plink)])) : ?>
                            Go to <a class="text-danger" href="<?php echo base_url('dungeon/action/go/' . $_SESSION['heroes']['x']); ?>"><?php echo $nextmap[0]['title']; ?></a> ?
                        <?php elseif (in_array($_SESSION['heroes']['x'], $plink) === true && !is_numeric($link[array_search($_SESSION['heroes']['x'], $plink)])) : ?>
                            Go to <a class="text-danger" href="<?php echo base_url('dungeon/action/charater/' . $link[array_search($_SESSION['heroes']['x'], $plink)]); ?>"><?php echo $link[array_search($_SESSION['heroes']['x'], $plink)]; ?></a> ?
                            <?php else : echo $map['title']; ?>

                        <?php endif; ?>
                    </div>
                    <?php if (!empty($listBackground)) foreach ($listBackground as $xloca => $item) : $key = $key + 1; ?>
                        <?php if ($heroes['x'] == $xloca) : ?>
                            <span style="display: -webkit-inline-box;background-image: url(public/dungeon/images/map/background/<?php echo $item; ?>.png);background-repeat: no-repeat;background-size: cover;width:32px;height:32px;">
                                <a href="<?php echo base_url('dungeon/action/go/' . $xloca); ?>">
                                    <img src="public/dungeon/<?php echo $heroes['images']; ?>" width="32px" height="32px" alt="">
                                </a>
                            </span>
                        <?php elseif (!empty($hmap) && count($hmap) > 0 && array_key_exists($xloca, $hmap) == 1) :
                            $b_health = ceil(0.32 * (($hmap[$xloca][0]['health'] / $hmap[$xloca][0]['maxhealth']) * 100));
                        ?>
                            <span style="display: -webkit-inline-box;background-image: url(public/dungeon/images/map/background/<?php echo $item; ?>.png);background-repeat: no-repeat;background-size: cover;width:32px;height:32px;position: relative;">
                                <a href="<?php echo base_url('dungeon/attack/' . $xloca); ?>">
                                    <img src="public/dungeon/images/cards/thumbs/<?php echo $hmap[$xloca][0]['images']; ?>.png" width="32px" height="32px" alt="">
                                    <div style="background-color: red;width: <?php echo $b_health; ?>px;height: 2px;position: absolute;left:0;top: 32px;"></div>
                                    <div style="font-size: 12px;width: 5px;height: 0px;position: absolute;left: 4px;top: 0px;font-weight: bold;color: red;"><?php echo $hmap[$xloca][0]['level']; ?></div>
                                </a>
                            </span>

                        <?php else : ?>
                            <span style="display: -webkit-inline-box;background-image: url(public/dungeon/images/map/background/<?php echo $item; ?>.png);background-repeat: no-repeat;background-size: cover;width:32px;height:32px;">
                                <a href="<?php echo base_url('dungeon/action/go/' . $xloca); ?>">
                                    <img src="public/dungeon/images/map/inbackground/<?php echo $listinBackground[($key - 1)]; ?>.png" width="32px" height="32px" alt=""></a>
                            </span>
                        <?php endif; ?>
                        <?php if ($key > 1 && $key % ($map['x']) == 0) echo "</br>";
                        if ($key >= ($map['x'] * $map['y'])) break; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
        </div>
    </div>
<?php endif; ?>
<?php if (($heroes['health'] <= 0) && ($heroes['time_die'] - time() > 0)) : ?>
    <footer>
        <div class="text-light">You have died!</div>
        <div class="text-light">You have died recently and the elders are using their energy to resurrect you.</div>
        <div class="text-light">Time left: <?php echo ($heroes['time_die'] - time()); ?> sec.</div>
    </footer>
<?php endif; ?>
<?php if (!empty($restore)) : ?>
    <footer>
        <div class="text-light"><?php echo $restore; ?></div>
    </footer>
<?php endif; ?>