<!--  -->
<?php if (empty($_SESSION['heroes'])) : ?>
    <footer>
        <a href="<?php echo base_url(''); ?>">Home</a>
        <br>
        <a href="<?php echo base_url('dungeon/account/logout'); ?>">Logout</a>
    </footer>
<?php else : ?>
    <footer>
        <a href="<?php echo base_url('dungeon/inbox'); ?>">Inbox</a> <b>|</b>
        <a href="<?php echo base_url('dungeon/friends'); ?>">Friends</a> <b>|</b>
        <a href="<?php echo base_url('dungeon/credits'); ?>">Credits (<?php echo $_SESSION['heroes']['credit']; ?>)</a>
        <br>
        <a href="<?php echo base_url('dungeon'); ?>">Map</a> <b>|</b>
        <a href="<?php echo base_url('dungeon/account/info/' . $_SESSION['heroes']['id']); ?>">Profile</a> <b>|</b>
        <a href="<?php echo base_url('dungeon/item'); ?>">Items</a> <b style="color:chocolate">(<?php echo countBag(); ?>)</b> <b>|</b>
        <a href="<?php echo base_url('dungeon/spells'); ?>">Spells</a>
        <br>
        <a href="<?php echo base_url('dungeon/chat'); ?>">Chat</a> <b>|</b>
        <a href="<?php echo base_url('dungeon/setting'); ?>">Setting</a> <b>|</b>
        <a href="<?php echo base_url('/dungeon/online'); ?>">Online <?php if (!empty($online)) echo count($online); ?></a>
        <br>
        <?php if (isset($_SESSION['users']['email'])) : ?>
            <a href="<?php echo base_url('dungeon/account/logout'); ?>">Logout</a>
        <?php endif; ?>
    </footer>
<?php endif; ?>
<div class="lang text-center">
    <a class="<?php if ((!empty($_SESSION['lang']) && $_SESSION['lang'] == 'vi')) echo 'flag-hover'; ?>" href="<?php echo base_url('dungeon/lang?lang=vi'); ?>"><img src="<?php echo base_url('public/dungeon/images/icon/vi.png'); ?>" alt=""></a>
    <b>|</b>
    <a class="<?php if ((!empty($_SESSION['lang']) && $_SESSION['lang'] == 'en') || empty($_SESSION['lang'])) echo 'flag-hover'; ?>" href="<?php echo base_url('dungeon/lang?lang=en'); ?>"><img src="<?php echo base_url('public/dungeon/images/icon/en.png'); ?>" alt=""></a>
</div>

<?php if (empty($_SESSION['heroes'])) : ?>
    <div class="text-center">
        <a href="<?php echo base_url('/dungeon/online'); ?>">Online <?php echo (count($online)+count($guest)); ?></a>
    </div>
<?php endif; ?>