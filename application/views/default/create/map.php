<style>
    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="url"],
    textarea,
    button[type="submit"] {
        font: 400 12px/16px "Open Sans", Helvetica, Arial, sans-serif;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="url"],
    textarea {
        width: 100%;
        border: 1px solid #CCC;
        background: #FFF;
        margin: 0 0 5px;
        padding: 10px;
    }

    input[type="text"]:hover,
    input[type="email"]:hover,
    input[type="tel"]:hover,
    input[type="url"]:hover,
    textarea:hover {
        -webkit-transition: border-color 0.3s ease-in-out;
        -moz-transition: border-color 0.3s ease-in-out;
        transition: border-color 0.3s ease-in-out;
        border: 1px solid #AAA;
    }

    textarea {
        resize: none;
    }

    button[type="submit"] {
        cursor: pointer;
        width: 100%;
        border: none;
        background: #0CF;
        color: #FFF;
        margin: 0 0 5px;
        padding: 10px;
        font-size: 15px;
    }

    button[type="submit"]:hover {
        background: #09C;
        -webkit-transition: background 0.3s ease-in-out;
        -moz-transition: background 0.3s ease-in-out;
        transition: background-color 0.3s ease-in-out;
    }

    button[type="submit"]:active {
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.5);
    }

    input:focus,
    textarea:focus {
        outline: 0;
        border: 1px solid #999;
    }

    ::-webkit-input-placeholder {
        color: #888;
    }

    :-moz-placeholder {
        color: #888;
    }

    ::-moz-placeholder {
        color: #888;
    }

    :-ms-input-placeholder {
        color: #888;
    }

    .head {
        border: 1px dotted #fff;
    }

    .input-hidden {
        position: absolute;
        left: -9999px;
    }

    input[type=checkbox]:checked+label>img,
    input[type=radio]:checked+label>img {
        border: 1px solid #fff;
        box-shadow: 0 0 3px 3px #090;
    }

    input[type=checkbox]+label>img,
    input[type=radio]+label>img {
        width: 32px;
        height: 32px;
        transition: 500ms all;
    }
</style>
<div class="container pt-4">
    <div class="row">
        <div class="col-4">
            <form method="post" action="">
                <div class="main">
                    <div class="d-flex" style="justify-content: center;">
                        <div class="block">
                            <table class="">
                                <?php if (!empty($map)) :
                                    $no_go      = json_decode($map['z']);
                                    $listBackground    = json_decode($map['background']);
                                    $listinBackground    = json_decode($map['inbackground']);
                                ?>
                                    <?php if (!empty($listBackground)) foreach ($listBackground as $key => $item) : $key = $key + 1; ?>
                                        <input type="checkbox" name="selectTile[]" id="selectTile_<?php echo $key; ?>" class="input-hidden" value="<?php echo $key; ?>" />
                                        <label for="selectTile_<?php echo $key; ?>" style="padding: 0;margin: 0">
                                            <img src="/public/dungeon/images/map/background/<?php echo $item; ?>.png" />
                                        </label>
                                        <?php if ($key > 1 && $key % ($map['x']) == 0) echo "</br>";
                                        if ($key >= ($map['x'] * $map['y'])) break; ?>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
                <input type="submit" value="SAVE">
                <div class="foot">
                    <?php if (!empty($icon_map)) foreach ($icon_map as $key => $it) :  ?>
                        <input type="radio" name="change" id="change_<?php echo $key; ?>" class="input-hidden" value="<?php echo $key; ?>" />
                        <label for="change_<?php echo $key; ?>" style="padding: 0;margin: 0"
                        data-toggle="popover" title="" data-content="<?php echo $it; ?>"
                        >
                            <img src="/public/dungeon/images/map/background/<?php echo $it; ?>" />
                        </label>
                    <?php endforeach; ?>
                </div>
            </form>
        </div>
        <div class="col-4">
            <form action="" method="post">
                <?php foreach ($map as $key => $value) : ?>
                    <?php
                    $rs = $value;
                    $col = 1;
                    if ($key == 'description' || $key == 'background' || $key == 'inbackground') continue;
                    ?>
                    <div><?php echo $key; ?><textarea name="<?php echo $key; ?>" id="" cols="30" rows="<?php echo $col; ?>"><?php echo $rs; ?></textarea></div>
                <?php endforeach; ?>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="newmap" id="" value="checkedValue">
                    </label>
                </div>
                <button type="submit" name="submit" value="12">Tạo hoặc sửa</button>
            </form>
        </div>
        <div class="col-4">
            <?php foreach ($map_all as $k => $imap) : ?>
                <li><a href="<?php echo base_url('create/map?Emap=' . $k) ?>"><?php echo $imap['title']; ?></a></li>
            <?php endforeach; ?>
        </div>
    </div>
</div>