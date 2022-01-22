<form action="" method="post">
    <?php if (!empty($item)) foreach ($item as $id => $value) :  ?>
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
                <label for=""><a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#x<?php echo $item['id']; ?>" aria-expanded="false" aria-controls="collapseTwo"><?php echo $id; ?></a></label>
                <div class="wrapper center-block">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div id="x<?php echo $item['id']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    Health: <input name="data_update[health]" type="number" value="<?php if (!empty($data_update->health)) echo $data_update->health; ?>"> <br>
                                    Mana: <input name="data_update[mana]" type="number" value="<?php if (!empty($data_update->mana)) echo $data_update->mana; ?>"> <br>
                                    Stamina: <input name="data_update[stamina]" type="number" value="<?php if (!empty($data_update->stamina)) echo $data_update->stamina; ?>"> <br>
                                    Strength: <input name="data_update[strength]" type="number" value="<?php if (!empty($data_update->strength)) echo $data_update->strength; ?>"> <br>
                                    Dexterity: <input name="data_update[dexterity]" type="number" value="<?php if (!empty($data_update->dexterity)) echo $data_update->dexterity; ?>"> <br>
                                    Endurance: <input name="data_update[endurance]" type="number" value="<?php if (!empty($data_update->endurance)) echo $data_update->endurance; ?>"> <br>
                                    Wisdom: <input name="data_update[wisdom]" type="number" value="<?php if (!empty($data_update->wisdom)) echo $data_update->wisdom; ?>"> <br>
                                    Damage: <input name="data_update[damage]" type="number" value="<?php if (!empty($data_update->damage)) echo $data_update->damage; ?>"> - <input name="data_update[maxdamage]" type="number" value="<?php echo $data_update->maxdamage; ?>"><br>
                                    Armor: <input name="data_update[armor]" type="number" value="<?php if (!empty($data_update->armor)) echo $data_update->armor; ?>"> <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif ($id == 'equipment_rule') : $equipment_rule = (object) json_decode($value); ?>
            <div class="form-group">
                <label for=""><a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $item['id']; ?>" aria-expanded="false" aria-controls="collapseTwo"><?php echo $id; ?></a></label>
                <div class="wrapper center-block">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div id="<?php echo $item['id']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    Class: <select name="equipment_rule[class]" id="">
                                        <?php if (!empty($array_class)) foreach ($array_class as $key => $value) :  ?>
                                            <option value="<?php echo $value; ?>" <?php if(!empty($equipment_rule->class) && $equipment_rule->class == $value) echo 'selected'; ?>>
                                                <?php echo $value_class[$key]; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select> <br>
                                    Strength: <input name="equipment_rule[strength]" type="number" value="<?php if (!empty($equipment_rule->strength)) echo $equipment_rule->strength; ?>"> <br>
                                    Dexterity: <input name="equipment_rule[dexterity]" type="number" value="<?php if (!empty($equipment_rule->dexterity)) echo $equipment_rule->dexterity; ?>"> <br>
                                    Endurance: <input name="equipment_rule[endurance]" type="number" value="<?php if (!empty($equipment_rule->endurance)) echo $equipment_rule->endurance; ?>"> <br>
                                    Wisdom: <input name="equipment_rule[wisdom]" type="number" value="<?php if (!empty($equipment_rule->wisdom)) echo $equipment_rule->wisdom; ?>"> <br>
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
                    <input type="text" class="form-control" name="<?php echo $id; ?>" id="" aria-describedby="helpId" placeholder="" value="<?php echo $value; ?>" readonly>
                <?php elseif ($id == 'level') : ?>
                    <input type="text" class="form-control" name="<?php echo $id; ?>" id="" aria-describedby="helpId" placeholder="" value="<?php echo $value; ?>">
                <?php else : ?>
                    <input type="text" class="form-control" name="<?php echo $id; ?>" id="" aria-describedby="helpId" placeholder="" value="<?php echo $value; ?>">
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <div class="form-row">
        <div class="col-6">
            <input type="submit" class="form-control btn btn-primary" name="edit" value="Sửa"></input>
        </div>
        <div class="col-6">
            <input type="submit" class="form-control btn btn-danger" name="delete" value="Xóa"></button>
        </div>
    </div>
</form>