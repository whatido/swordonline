<div class="lang text-center">
<a class="<?php if((!empty($_SESSION['lang']) && $_SESSION['lang'] == 'vi') || empty($_SESSION['lang'])) echo 'flag-hover'; ?>" href="<?php echo base_url('dungeon/lang?lang=vi'); ?>"><img src="<?php echo base_url('public/dungeon/images/icon/vi.png'); ?>" alt=""></a>
<b>|</b>
<a class="<?php if((!empty($_SESSION['lang']) && $_SESSION['lang'] == 'en')) echo 'flag-hover'; ?>" href="<?php echo base_url('dungeon/lang?lang=en'); ?>"><img src="<?php echo base_url('public/dungeon/images/icon/en.png'); ?>" alt=""></a>
</div>