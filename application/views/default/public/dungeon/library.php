<header class="text-center">
    Library
</header>
<div class="text-center">Charater</div>
<?php if (!empty($charater)) foreach ($charater as $key => $item) : ?>
    <div class="card">
        <?php echo $item['name']; ?>
        <img src="<?php echo base_url('public/dungeon/' . $item['images']); ?>" alt="<?php echo $item['name']; ?>" width="32px"> <br>
    </div>
<?php endforeach; ?>
<div class="">Bosses</div>
<div class="">Monster</div>
<div class="">Item</div>
<div class="">Gem</div>
<div class="">Stone</div>
<div class="">Other item</div>