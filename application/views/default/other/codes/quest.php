<?php if (!empty($feets)) foreach ($feets as $key => $item) : ?>
    <?php if (!empty($item['image'])) : ?>
        <div class="group">
            <div class="intro box">
                <div class="intro-title">
                    <a href="<?php echo $item['link']; ?>" target="_blank" rel="noopener noreferrer">
                        <?php echo $item['title']; ?>
                    </a>
                </div>
                <div class="info">
                    <div class="info-img">
                        <a href="<?php echo $item['link']; ?>" target="_blank" rel="noopener noreferrer">
                            <img class="event-img" src="<?php echo $item['image']; ?>" alt="<?php echo $item['title']; ?>" loading="lazy">
                        </a>
                    </div>
                    <div class="info-item"><a href="<?php echo $item['link']; ?>" target="_blank" rel="noopener noreferrer">
                            <?php echo $item['description']; ?></a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>