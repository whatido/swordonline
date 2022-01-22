<div class="container">
    <div class="left-side">
        <div class="logo">NEWSPAPER</div>
        <div class="side-wrapper">
            <div class="side-title">MENU</div>
            <div class="side-menu menuLoad">
                <a href="/news/tin-moi-nhat"><i class="fa fa-home" aria-hidden="true"></i>&#12644;Trang chủ</a>
                <a href="/news/tin-noi-bat"><i class="fa fa-fire" aria-hidden="true"></i>&#12644;Tin nổi bật</a>
                <a href="/news/tin-xem-nhieu"><i class="fa fa-star" aria-hidden="true"></i>&#12644;Tin xem nhiều</a>
                <a href="/news/the-gioi"><i class="fa fa-newspaper" aria-hidden="true"></i>&#12644;Thế giới</a>
                <a href="/news/thoi-su"><i class="fa fa-newspaper" aria-hidden="true"></i>&#12644;Thời sự</a>
                <a href="/news/giai-tri"><i class="fa fa-guitar" aria-hidden="true"></i>&#12644;Giải trí</a>
            </div>
        </div>
    </div>
    <div class="main">
        <div class="search-bar"><input type="text" placeholder="Search" /><button class="right-side-button" @click="rightSide=!rightSide"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg></button></div>
        <div class="main-container">
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
                                    <div id="loading"></div>
                                    <a href="<?php echo $item['link']; ?>" target="_blank" rel="noopener noreferrer">
                                        <img class="event-img" src="<?php echo $item['image']; ?>" alt="<?php echo $item['title']; ?>" loading="lazy">
                                    </a>
                                </div>
                                <div class="info-item">
                                    <a href="<?php echo $item['link']; ?>" target="_blank" rel="noopener noreferrer">
                                        <?php echo $item['description']; ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="right-side">
        <div class="side-wrapper stories">
            <div class="side-title">STORIES</div>
            <?php if (!empty($stories)) foreach ($stories as $key => $item) : ?>
                <div class="user">
                    <a href="<?php echo $item['link']; ?>" target="_blank" rel="noopener noreferrer">✿ <?php echo $item['title']; ?></a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="side-wrapper funny">
            <div class="side-title">FUNNY</div>
            <?php if (!empty($funny)) foreach ($funny as $key => $item) : ?>
                <div class="user"><a href="<?php echo $item['link']; ?>" target="_blank" rel="noopener noreferrer">✿ <?php echo $item['title']; ?></a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>