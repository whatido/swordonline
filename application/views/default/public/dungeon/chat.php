<div class="inbox">
    <div class="title">Chat [World]</div>
    <?php switch ($status) {
        case 'view': ?>
            <form action="" method="post">
                <label for="">Message:</label>
                <textarea type="text" name="content" id="" class="form-control" placeholder="" aria-describedby="helpId"></textarea>
                <small id="helpId" class="d-none text-muted">Help text</small>
                <br>
                <button type="submit">Answer</button>
            </form>
            <?php foreach (array_reverse($list) as $key => $it) :  ?>
                <?php echo $it['users']; ?>: <?php echo $it['content']; ?> <?php echo timeAgo(date("H:i:s d.m.Y", $it['time'])); ?><br>
            <?php endforeach; ?>
        <?php break;
        case 'smmill': ?>

        <?php break;
        case 'detail': ?>
            <?php echo $item['go']; ?>: <?php echo $item['content']; ?><br>
            <?php echo date("H:i:s d.m.Y", $item['time']); ?><br />
            <form action="" method="post">
                <label for="">Message:</label>
                <textarea type="text" name="content" id="" class="form-control" placeholder="" aria-describedby="helpId"></textarea>
                <small id="helpId" class="d-none text-muted">Help text</small>
                <br>
                <button type="submit">Answer</button>
            </form>
            <?php foreach (array_reverse($list) as $key => $it) :  ?>
                <?php echo $it['users']; ?>: <?php echo $it['content']; ?> <?php echo date("H:i:s d.m.Y", $it['time']); ?><br>
            <?php endforeach; ?>
    <?php break;
    }; ?>
</div>