<?php if($message !== '') { ?>
    <div class="rwd-notice <?php if($error) { echo 'is-error'; } ?>">
        <p><?php echo $message; ?></p>
    </div>
<?php } ?>
