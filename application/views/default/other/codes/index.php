<div class="container">
    <div class="left-side">
        <div class="logo">CODE NOTE</div>
        <div class="side-wrapper">
            <div class="side-title">TAG</div>
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

        </div>
    </div>
    <div class="right-side">
        <div class="side-wrapper stories">
            <div class="side-title">NEW CODE</div>
            <div class="side-content">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="">Password</label><br>
                        <input type="password" name="pass" id="" value="" class="form-control" placeholder="" aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                        <label for="">Comment</label><br>
                        <input type="password" name="comment" id="" value="" class="form-control" placeholder="" aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                        <label for="">Tag</label><br>
                        <input type="text" name="tag" id="" value="#" class="form-control" placeholder="" aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                        <label for="">Code</label><br>
                        <textarea name="code" id="code" cols="30" rows="10"></textarea>
                    </div>
                    <input type="submit" name="note" value="Note">
                </form>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?= base_url() ?>public/vendor/lib/codemirror.css">
<link rel="stylesheet" href="<?= base_url() ?>public/vendor/lib/fullscreen.css">
<link rel="stylesheet" href="<?= base_url() ?>public/vendor/lib/night.css">
<script src="<?= base_url() ?>public/vendor/lib/codemirror.js"></script>
<script src="<?= base_url() ?>public/vendor/lib/fullscreen.js"></script>
<script>
    var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
        lineNumbers: true,
        theme: "night",
        extraKeys: {
            "F11": function(cm) {
                cm.setOption("fullScreen", !cm.getOption("fullScreen"));
            },
            "Esc": function(cm) {
                if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
            }
        }
    });
</script>