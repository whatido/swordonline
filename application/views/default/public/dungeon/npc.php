<div class="title title-gray mb-4">
    <?php echo $npc['name']; ?> <br>
    <img src="<?php echo base_url('public/dungeon/' . $npc['images']); ?>" alt="<?php echo $npc['name']; ?>" width="32px">
</div>

<div>
    <?php $this->load->view('default/public/dungeon/npc/__shop'); ?>
    <?php $this->load->view('default/public/dungeon/npc/__wisdom'); ?>
    <?php $this->load->view('default/public/dungeon/npc/__blacksmith'); ?>
    <?php $this->load->view('default/public/dungeon/npc/__vaults'); ?>
    <?php if (!empty($mes)) echo $mes; ?>
    <?php $this->load->view('default/public/dungeon/npc/__option'); ?>