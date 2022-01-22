<div class="inbox">
    <?php switch ($status) {
        case 'add': ?>
            <form action="" method="post">
                <label for="">Username:</label>
                <input type="text" name="username" id="" class="form-control" placeholder="" aria-describedby="helpId" value="<?php if (!empty($to)) echo $to; ?>">
                <small id="helpId" class="d-none text-muted">Help text</small>
                <br>
                <button type="submit">ADD</button>
            </form>
        <?php break;
        case 'remove': ?>
            <form action="" method="post">
                <label for="">Username:</label>
                <input type="text" name="username" id="" class="form-control" placeholder="" aria-describedby="helpId" value="<?php if (!empty($to)) echo $to; ?>">
                <small id="helpId" class="d-none text-muted">Help text</small>
                <br>
                <button type="submit">REMOVE</button>
            </form>
        <?php break;
        case 'view': ?>
            <div class="title">Friends<br>
            <a href="<?php echo base_url('dungeon/friends/add'); ?>">Add friends</a> <br>
            <a href="<?php echo base_url('dungeon/friends/remove'); ?>">Remove friends</a>                
            </div>
            <div class="text-light">
                <?php foreach (array_reverse($list) as $key => $it) :  ?>
                    <a href="#"><?php echo $it['username']; ?></a><br>
                <?php endforeach; ?>
            </div>
        <?php break;
        case 'detail': ?>
            <?php echo $item['go']; ?>: <?php echo $item['content']; ?><br>
            <?php echo date("H:i:s d.m.Y", $item['time']); ?><br/>
            <form action="" method="post">
                <label for="">Message:</label>
                <textarea type="text" name="content" id="" class="form-control" placeholder="" aria-describedby="helpId"></textarea>
                <small id="helpId" class="d-none text-muted">Help text</small>
                <br>
                <button type="submit">Answer</button>
            </form>
            <?php foreach (array_reverse($list) as $key => $it) :  ?>
                <?php echo $it['go']; ?>: <?php echo $it['content']; ?> <?php echo date("H:i:s d.m.Y", $it['time']); ?><br>
            <?php endforeach; ?>
    <?php break;
    }; ?>
</div>