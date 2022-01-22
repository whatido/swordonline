<style>
    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="url"],
    textarea,
    button[type="submit"] {
        font: 400 12px/16px "Open Sans", Helvetica, Arial, sans-serif;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="url"],
    textarea {
        width: 100%;
        border: 1px solid #CCC;
        background: #FFF;
        margin: 0 0 5px;
        padding: 10px;
    }

    input[type="text"]:hover,
    input[type="email"]:hover,
    input[type="tel"]:hover,
    input[type="url"]:hover,
    textarea:hover {
        -webkit-transition: border-color 0.3s ease-in-out;
        -moz-transition: border-color 0.3s ease-in-out;
        transition: border-color 0.3s ease-in-out;
        border: 1px solid #AAA;
    }

    textarea {
        resize: none;
    }

    button[type="submit"] {
        cursor: pointer;
        width: 100%;
        border: none;
        background: #0CF;
        color: #FFF;
        margin: 0 0 5px;
        padding: 10px;
        font-size: 15px;
    }

    button[type="submit"]:hover {
        background: #09C;
        -webkit-transition: background 0.3s ease-in-out;
        -moz-transition: background 0.3s ease-in-out;
        transition: background-color 0.3s ease-in-out;
    }

    button[type="submit"]:active {
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.5);
    }

    input:focus,
    textarea:focus {
        outline: 0;
        border: 1px solid #999;
    }

    ::-webkit-input-placeholder {
        color: #888;
    }

    :-moz-placeholder {
        color: #888;
    }

    ::-moz-placeholder {
        color: #888;
    }

    :-ms-input-placeholder {
        color: #888;
    }

    .head {
        border: 1px dotted #fff;
    }

    .input-hidden {
        position: absolute;
        left: -9999px;
    }

    input[type=checkbox]:checked+label>img,
    input[type=radio]:checked+label>img {
        border: 1px solid #fff;
        box-shadow: 0 0 3px 3px #090;
    }

    input[type=checkbox]+label>img,
    input[type=radio]+label>img {
        width: 32px;
        height: 32px;
        transition: 500ms all;
    }
</style>
<div class="container pt-4">
    <div class="row">
        <div class="col-4">
            <form method="post" action="">
                <input type="text" name="folder" value="public/image/MARGINLESS/"><br>
                <input type="text" name="key" value="_"><br>
                <input type="submit" name="butt" value="SAVE">
                <div class="foot">
                    <?php if (!empty($icon_map)) foreach ($icon_map as $key => $it) :  ?>
                        <input type="radio" name="img" id="change_<?php echo $key; ?>" class="input-hidden" value="<?php echo $it; ?>" />
                        <label for="change_<?php echo $key; ?>" style="padding: 0;margin: 0" data-toggle="popover" title="" data-content="<?php echo $it; ?>">
                            <img src="/public/image/<?php echo $it; ?>" />
                        </label>
                    <?php endforeach; ?>
                </div>
            </form>
        </div>
        <div class="col-4">
        </div>
        <div class="col-4">
        </div>
    </div>
</div>