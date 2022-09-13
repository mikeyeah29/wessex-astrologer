<?php
/**
 * The template for displaying top-bar
 *
 */
$top_bar_enable = G5Plus_Auteur()->options()->get_top_bar_enable();
if ($top_bar_enable !== 'on') return;
$content_block = G5Plus_Auteur()->options()->get_top_bar_content_block();
if (empty($content_block)) return;
?>
<div class="top-bar">
    <?php echo G5Plus_Auteur()->helper()->content_block($content_block);?>
</div>

