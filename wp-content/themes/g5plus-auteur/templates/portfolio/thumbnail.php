<?php
/**
 * @var $post_id
 * @var $image_size
 * @var $placeholder_enable
 * @var $image_mode
 * @var $image_ratio
 * @var $portfolio_layout
 * @var $display_permalink
 */
remove_action('g5plus_before_post_image',array(G5Plus_Auteur()->templates(),'zoom_image_thumbnail'));
if (has_post_thumbnail($post_id)) {
    if ((in_array($portfolio_layout,array('justified')))) $image_size = 'full';
    $image_id = get_post_thumbnail_id($post_id);
    G5Plus_Auteur()->blog()->render_post_image_markup(array(
        'post_id'           => $post_id,
        'image_id'          => $image_id,
        'image_size'        => $image_size,
        'image_mode'        => $image_mode,
        'display_permalink' => $display_permalink,
        'image_ratio' =>    $image_ratio
    ));
} else if ($placeholder_enable === true) { ?>
    <div class="entry-thumbnail">
        <div class="entry-thumbnail-overlay thumbnail-size-<?php echo esc_attr($image_size); ?> placeholder-image">
        </div>
    </div>
    <?php
}
add_action('g5plus_before_post_image',array(G5Plus_Auteur()->templates(),'zoom_image_thumbnail'));
