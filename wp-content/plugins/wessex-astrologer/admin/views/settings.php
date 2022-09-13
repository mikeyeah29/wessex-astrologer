<div class="rwd-admin">

    <?php include('inc/_notice.php'); ?>
    <?php include('inc/_header.php'); ?>

    <div class="rwd-body">

        <h2>Contact Details</h2>

        <form action="" method="POST" id="form-save" class="rwd-form">
            <input type="hidden" name="wa_options" value="yes" />

            <div class="rwd-form-group">
                <label>Address</label>
                <textarea name="wa-address"><?php echo $options['ADDRESS']; ?></textarea>
            </div>

            <div class="rwd-form-group">
                <label>UK phone number</label>
                <input type="text" value="<?php echo $options['PHONE_UK']; ?>" name="wa-phone-uk" />
            </div>

            <div class="rwd-form-group">
                <label>International phone number</label>
                <input type="text" value="<?php echo $options['PHONE_INTERNATIONAL']; ?>" name="wa-phone-international" />
            </div>

            <div class="rwd-form-group">
                <label>Main email</label>
                <input type="text" value="<?php echo $options['EMAIL']; ?>" name="wa-email" />
            </div>

            <button class="rwd-btn">Save</button>
        </form>

    </div>

</div>
