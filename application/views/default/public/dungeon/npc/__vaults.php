<!-- START VAULTS -->
<?php if (!empty($_GET['status']) && $_GET['status'] == 'open') : ?>
    <?php if (!empty($listItem)) : foreach ($listItem as $key => $it) :  ?>
            <div class="d-flex bd-highlight">
                <div class="p-2 flex-grow-1 bd-highlight">
                    <a href="<?php echo base_url('dungeon/action/charater/Vaults?status=open&id=' . $it['id']); ?>"><?php echo colorStar($it); ?></a>
                </div>
            </div>
        <?php endforeach;
    else : ?>
        Null
    <?php endif; ?>
    <div><a href="<?php echo base_url('dungeon/action/charater/Vaults'); ?>">Back</a></a>
    <?php endif; ?>

    <?php if (!empty($_GET['status']) && $_GET['status'] == 'save') : ?>
        <?php if (!empty($listItem)) : foreach ($listItem as $key => $it) :  ?>
                <div class="d-flex bd-highlight">
                    <div class="p-2 flex-grow-1 bd-highlight">
                        <a href="<?php echo base_url('dungeon/action/charater/Vaults?status=save&id=' . $it['id']); ?>"><?php echo colorStar($it); ?></a>
                    </div>
                </div>
            <?php endforeach;
        else : ?>
            Null
        <?php endif; ?>
        <div><a href="<?php echo base_url('dungeon/action/charater/Vaults'); ?>">Back</a></a>
        <?php endif; ?>

        </div>
        <!-- END VAULTS -->