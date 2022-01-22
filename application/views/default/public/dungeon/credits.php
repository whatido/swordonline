<div class="inbox">
    <?php switch ($status) {
        case 'add': ?>
            <form action="" method="post">
                <label for="">Gold: (Gx1000)</label>
                <input type="text" name="number" id="" class="form-control" placeholder="" aria-describedby="helpId" value="1">
                <small id="helpId" class="d-none text-muted">Help text</small>
                <br>
                <button type="submit">Action</button>
            </form>
        <?php break;
        case 'remove': ?>
            <form action="" method="post">
                <label for="">Diamond mode</label> <br>
                <label for="">Credit: 100/day</label>
                <input type="text" name="numdateDiamond" id="" class="form-control" placeholder="" aria-describedby="helpId" value="1">
                <br>
                <button type="submit">BUY</button>
            </form>
            <br>
            <form action="" method="post">
                <label for="">Experian mode</label> <br>
                <label for="">Credit: 10/day</label>
                <input type="text" name="numdateExperian" id="" class="form-control" placeholder="" aria-describedby="helpId" value="1">
                <br>
                <button type="submit">BUY</button>
            </form>
        <?php break;
        case 'view': ?>
            <div class="title">Credits<br>
            * Gold: <?php echo $users->gold; ?> <br>
            * Credits: <?php echo $users->credit; ?>
            <div class="neon-bar text-white text-left">* Action ? </div>
            <a href="<?php echo base_url('dungeon/credits/add'); ?>">Gold to Credits</a> <br>
            <a href="<?php echo base_url('dungeon/credits/remove'); ?>">Credits Shop</a>                
            </div>
        <?php break;
        case 'detail': ?>
            <?php echo $item['go']; ?>: <?php echo $item['content']; ?><br>
            <?php echo date("H:i:s d.m.Y", $item['time']); ?><br/>
            <form action="" method="post">
                <label for="">Message:</label>
                <textarea type="text" name="number" id="" class="form-control" placeholder="Date" aria-describedby="helpId"></textarea> 
                <br>
                <button type="submit">Answer</button>
            </form>
            <?php foreach (array_reverse($list) as $key => $it) :  ?>
                <?php echo $it['go']; ?>: <?php echo $it['content']; ?> <?php echo date("H:i:s d.m.Y", $it['time']); ?><br>
            <?php endforeach; ?>
    <?php break;
    }; ?>
</div>