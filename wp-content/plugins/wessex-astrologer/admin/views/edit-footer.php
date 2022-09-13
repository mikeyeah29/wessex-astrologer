<div class="rwd-admin">

    <?php include('inc/_notice.php'); ?>
    <?php include('inc/_header.php'); ?>

    <div class="rwd-body">

        <h2>About</h2>

        <form action="" method="POST" id="form-save" class="rwd-form">
            <input type="hidden" name="wa_footer_about" value="yes" />

            <div class="rwd-form-group">
                <?php
                    wp_editor($footer_about, 'wa_footer_about_text', array(
                        'media_buttons' => false,
                        'textarea_rows' => 10
                    ));
                ?>
            </div>

            <button class="rwd-btn">Save</button>
        </form>

    </div>

</div>
