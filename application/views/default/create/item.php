<?php
$data['array_star'] = $array_star = [1, 2, 3, 4, 5, 6];
$data['value_star'] = $value_star = ["Nomal", "Uncommon", "Rare", "Epic", "Mythic", "Heroic", "Divine"];
$data['color_star'] = $color_star = ["000000", "1eff00", "0070ff", "a335ee", "ff9800", "c34949", "21b6a8"];
$data['array_type'] = $array_type = ["weapon", "shield", "helm", "armor", "boot", "amulet", "ring", "potion", "gem", "pieces", "magicscroll", "jewel", "recipe", "rune", "quest", "powders"];
$data['value_type'] = $value_type = ["Weapon", "Shield", "Helm", "Armor", "Boot", "Amulet", "Ring", "Potion", "Gem", "Pieces", "Magic scroll", "Jewel", "Recipe", "Rune", "Quest", "Powders"];
$data['array_craft'] = $array_craft = ["drop", ""];
$data['value_craft'] = $value_craft = ["Drop", "None"];
$data['array_status'] = $array_status = ["open", "close"];
$data['value_status'] = $value_status = ["Open", "Close"];
$data['array_class'] = $array_class = ["", "barbarian", "druid", "paladin", "necromancer", "assassin", "amazon"];
$data['value_class'] = $value_class = ["None", "Barbarian", "Druid", "Paladin", "Necromancer", "Assassin", "Amazon"];

?>
<style>
    .panel-heading {
        padding: 0;
        border: 0;
    }

    .panel-title>a,
    .panel-title>a:active {
        display: block;
        padding: 15px;
        color: #555;
        font-size: 16px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        word-spacing: 3px;
        text-decoration: none;
    }

    .panel-heading a:before {
        font-family: 'Glyphicons Halflings';
        content: "\e114";
        float: right;
        transition: all 0.5s;
    }

    .panel-heading.active a:before {
        -webkit-transform: rotate(180deg);
        -moz-transform: rotate(180deg);
        transform: rotate(180deg);
    }
</style>









<div class="container">
    <div class="row">
        <div class="col-12">
            <form action="" method="get">
                <div class="form-row">
                    <div class="col-4">
                        <select class="form-control" name="type" id="">
                            <?php if (!empty($array_type)) foreach ($array_type as $key => $value) :  ?>
                                <option value="<?php echo $value; ?>" <?php if (!empty($_GET['type']) && $_GET['type'] == $value) echo 'selected'; ?>>
                                    <?php echo $value_type[$key]; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-4">

                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary mb-2">Confirm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <form action="" method="post">
                <?php if (!empty($tbkey)) foreach ($tbkey as $id => $value) :  ?>
                    <?php if ($id == 'star') : ?>
                        <div class="form-group">
                            <label for=""><?php echo $id; ?></label>
                            <select class="form-control" name="type" id="">
                                <?php if (!empty($array_star)) foreach ($array_star as $key => $value) :  ?>
                                    <option value="<?php echo $value; ?>" <?php if (!empty($_GET['star']) && $_GET['star'] == $value) echo 'selected'; ?>>
                                        <?php echo $value_star[$key]; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php elseif ($id == 'type') : ?>
                        <div class="form-group">
                            <label for=""><?php echo $id; ?></label>
                            <select class="form-control" name="type" id="">
                                <?php if (!empty($array_type)) foreach ($array_type as $key => $value) :  ?>
                                    <option value="<?php echo $value; ?>" <?php if (!empty($_GET['type']) && $_GET['type'] == $value) echo 'selected'; ?>>
                                        <?php echo $value_type[$key]; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php elseif ($id == 'craft') : ?>
                        <div class="form-group">
                            <label for=""><?php echo $id; ?></label>
                            <select class="form-control" name="craft" id="">
                                <?php if (!empty($array_craft)) foreach ($array_craft as $key => $value) :  ?>
                                    <option value="<?php echo $value; ?>" <?php if (!empty($_GET['type']) && $_GET['type'] == $value) echo 'selected'; ?>>
                                        <?php echo $value_craft[$key]; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php elseif ($id == 'data_update') : $data_update = (object) json_decode($value); ?>
                        <div class="form-group">
                            <label for=""><a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseTwo"><?php echo $id; ?></a></label>
                            <div class="wrapper center-block">
                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                            <div class="panel-body">
                                                Health: <input name="data_update[health]" type="number" value="0"> <br>
                                                Mana: <input name="data_update[mana]" type="number" value="0"> <br>
                                                Stamina: <input name="data_update[stamina]" type="number" value="0"> <br>
                                                Strength: <input name="data_update[strength]" type="number" value="0"> <br>
                                                Dexterity: <input name="data_update[dexterity]" type="number" value="0"> <br>
                                                Endurance: <input name="data_update[endurance]" type="number" value="0"> <br>
                                                Wisdom: <input name="data_update[wisdom]" type="number" value="0"> <br>
                                                Damage: <input name="data_update[damage]" type="number" value="0"> - <input name="data_update[maxdamage]" type="number" value="0"><br>
                                                Armor: <input name="data_update[armor]" type="number" value="0"> <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php elseif ($id == 'equipment_rule') : $equipment_rule = (object) json_decode($value); ?>
                        <div class="form-group">
                            <label for=""><a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><?php echo $id; ?></a></label>
                            <div class="wrapper center-block">
                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                            <div class="panel-body">
                                                Class: <select name="equipment_rule[class]" id="">
                                                    <?php if (!empty($array_class)) foreach ($array_class as $key => $value) :  ?>
                                                        <option value="<?php echo $value; ?>">
                                                            <?php echo $value_class[$key]; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select> <br>
                                                Strength: <input name="equipment_rule[strength]" type="number" value=""> <br>
                                                Dexterity: <input name="equipment_rule[dexterity]" type="number" value=""> <br>
                                                Endurance: <input name="equipment_rule[endurance]" type="number" value=""> <br>
                                                Wisdom: <input name="equipment_rule[wisdom]" type="number" value=""> <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php elseif ($id == 'status') : ?>
                        <div class="form-group">
                            <label for=""><?php echo $id; ?></label>
                            <select class="form-control" name="status" id="">
                                <?php if (!empty($array_status)) foreach ($array_status as $key => $value) :  ?>
                                    <option value="<?php echo $value; ?>" <?php if (!empty($_GET['type']) && $_GET['type'] == $value) echo 'selected'; ?>>
                                        <?php echo $value_status[$key]; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php else : ?>
                        <div class="form-group">
                            <label for=""><?php echo $id; ?></label>
                            <?php if ($id == 'id') : ?>
                                <input type="text" class="form-control" name="<?php echo $id; ?>" id="" aria-describedby="helpId" placeholder="" value="" readonly>
                            <?php elseif ($id == 'level') : ?>
                                <input type="text" class="form-control" name="<?php echo $id; ?>" id="" aria-describedby="helpId" placeholder="" value="1">
                            <?php else : ?>
                                <input type="text" class="form-control" name="<?php echo $id; ?>" id="" aria-describedby="helpId" placeholder="" value="">
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
                <div class="form-row">
                    <div class="col-4">
                        <input type="submit" class="form-control btn btn-success" name="add" value="Tạo"></input>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-6">
            <?php if (!empty($item_all)) foreach ($item_all as $key => $item) : $data['item'] = $item;  ?>
                <label for=""><a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $item['title']; ?>" aria-expanded="false" aria-controls="<?php echo $item['title']; ?>"><?php echo $item['title']; ?></a></label>
                <div class="wrapper center-block">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div id="<?php echo $item['title']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="<?php echo $item['title']; ?>">
                                <div class="panel-body">
                                    <?php $this->load->view('default/create/__item-form', $data); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>