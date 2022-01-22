<div class="inbox">
    <div class="title">Inbox</div>
    <?php switch ($status) {
        case 'mes': ?>
            <form action="" method="post">
                <label for="">Send to:</label>
                <input type="text" name="to" id="" class="form-control" placeholder="" aria-describedby="helpId" value="<?php if (!empty($to)) echo $to; ?>">
                <small id="helpId" class="d-none text-muted">Help text</small>
                <br>
                <label for="">Message:</label>
                <textarea type="text" name="content" id="" class="form-control" placeholder="" aria-describedby="helpId"></textarea>
                <small id="helpId" class="d-none text-muted">Help text</small>
                <br>
                <button type="submit">SEND</button>
            </form>
        <?php break;
        case 'view': ?>
            <div class="text-light">
                <?php foreach (array_reverse($list) as $key => $it) :  ?>
                    <a href="<?php echo base_url('dungeon/inbox/detail/' . $it['id']); ?>"><?php echo $it['go']; ?>: <?php echo $it['content']; ?></a><br>
                    <?php echo date("H:i:s d.m.Y", $it['time']); ?><br/>
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
                <?php echo $it['go']; ?>: <?php echo $it['content']; ?> <?php echo timeAgo(date("H:i:s d.m.Y", $it['time'])); ?><br>
            <?php endforeach; ?>
    <?php break;
    }; ?>
</div>