    <!-- Blacksmith -->
    <?php if (!empty($_GET['blacksmith']) && empty($err)) : ?>
        <form action="?blacksmith=craft" method="post">
            <?php if (!empty($craft['newItem'])) : ?>
                <div><input type="hidden" name="cp[]" id="" class="form-control" value="<?php if (!empty($cp)) echo $cp['cp'][0]; ?>"></div>
                <div><input type="hidden" name="cp[]" id="" class="form-control" value="<?php if (!empty($cp)) echo $cp['cp'][1]; ?>"></div>
                <div><input type="hidden" name="cp[]" id="" class="form-control" value="<?php if (!empty($cp)) echo $cp['cp'][2]; ?>"></div>
                Title: <br>
                <input type="text" name="title" id="" class="form-control" value="" maxlength="20"><br>
            <?php else : ?>
                <div class="form-group">
                    <label for="exampleFormControlSelect2">Choose item</label>
                    <?php for($x=1;$x<=3;$x++): ?>
                    <select name="cp[]" class="form-control mb-2">
                        <option value="0">Null</option>
                        <?php $d = 0;
                        if (!empty($listItem)) foreach ($listItem as $key => $it) : $d++;  ?>
                            <option value="<?php echo $it['id']; ?>" <?php if (!empty($cp) && $cp['cp'][0] == $it['id']) echo 'selected'; ?>><?php echo $d; ?>. <?php echo $it['title']; ?>
                                <?php if ($it['star'] == 2) echo '[Uncommon]'; ?>
                                <?php if ($it['star'] == 3) echo '[Rare]'; ?>
                                <?php if ($it['star'] == 4) echo '[Epic]'; ?>
                                <?php if ($it['star'] == 5) echo '[Mythic]'; ?>
                                <?php if ($it['star'] == 6) echo '[Heroic]'; ?>
                                <?php if ($it['star'] == 7) echo '[Divine]'; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
            <button type="submit">CRAFT</button>
        </form>
    <?php endif; ?>
    <?php if (!empty($err)) : ?>
        <div class="text-light"><?php echo $err; ?></div>
    <?php endif; ?>