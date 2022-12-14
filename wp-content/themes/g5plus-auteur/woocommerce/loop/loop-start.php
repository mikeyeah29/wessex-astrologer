<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */
$post_settings = &G5Plus_Auteur()->blog()->get_layout_settings();
$post_layout = isset($post_settings['post_layout'] ) ? $post_settings['post_layout'] : 'grid';
$layout_matrix = G5Plus_Auteur()->blog()->get_layout_matrix( $post_layout );
$wrapper_attributes = array();

$inner_attributes = array();
$inner_classes = array(
    'gf-blog-inner',
    'clearfix',
    "layout-{$post_layout}"
);
$image_size_base = isset($post_settings['image_size']) ? $post_settings['image_size'] : (isset($layout_matrix['image_size']) ? $layout_matrix['image_size'] :  '');
$image_ratio_base = '';
if (in_array($post_layout, array('grid','metro-01','metro-02','metro-03','metro-04','metro-05')) && ($image_size_base === 'full')) {
    $image_ratio_base = isset($post_settings['image_ratio']) ? $post_settings['image_ratio'] : '';
    if (empty($image_ratio_base)) {
        $image_ratio_base = G5Plus_Auteur()->options()->get_product_image_ratio();
    }

    if ($image_ratio_base === 'custom') {
        $image_ratio_custom = isset($post_settings['image_ratio_custom']) ? $post_settings['image_ratio_custom'] : G5Plus_Auteur()->options()->get_product_image_ratio_custom();
        if (is_array($image_ratio_custom) && isset($image_ratio_custom['width']) && isset($image_ratio_custom['height'])) {
            $image_ratio_custom_width = intval($image_ratio_custom['width']);
            $image_ratio_custom_height = intval($image_ratio_custom['height']);
            if (($image_ratio_custom_width > 0) && ($image_ratio_custom_height > 0)) {
                $image_ratio_base = "{$image_ratio_custom_width}x{$image_ratio_custom_height}";
            }
        } elseif (preg_match('/x/',$image_ratio_custom)) {
            $image_ratio_base = $image_ratio_custom;
        }
    }

    if ($image_ratio_base === 'custom') {
        $image_ratio_base = '1x1';
    }
}

if ( isset( $post_settings['carousel'] ) ) {
    $inner_classes[] = 'owl-carousel owl-theme';
    if (isset($post_settings['carousel_class'])) {
        $inner_classes[] = $post_settings['carousel_class'];
    }
    $inner_attributes[] = "data-owl-options='" . json_encode( $post_settings['carousel'] ) . "'";
} else {
    if ( isset( $layout_matrix['columns_gutter'] ) ) {
        $inner_classes[] = "gf-gutter-{$layout_matrix['columns_gutter']}";
    } else {
        $inner_classes[] = 'row';
    }

    if ( isset( $layout_matrix['isotope'] ) ) {
        if($post_layout !== 'list') {
            $inner_classes[] = 'isotope';
        }
        $inner_attributes[] = "data-isotope-options='" . json_encode( $layout_matrix['isotope'] ) . "'";
        $wrapper_attributes[] = 'data-isotope-wrapper="true"';
        if (isset($layout_matrix['isotope']['metro'])) {
            if ($image_size_base === 'full') {
                $inner_attributes[] = "data-image-size-base='" . $image_ratio_base . "'";
            } else {
                $image_size_base_dimension =  G5Plus_Auteur()->helper()->get_image_dimension($image_size_base);
                if ($image_size_base_dimension) {
                    $inner_attributes[] = "data-image-size-base='" . $image_size_base_dimension['width'] . 'x' . $image_size_base_dimension['height'] . "'";
                }

            }
        }
    }
}

if (isset($post_settings['isMainQuery']))  {
    $wrapper_attributes[] = 'data-archive-wrapper';
}

$settingId = isset($post_settings['settingId']) ? $post_settings['settingId'] : mt_rand();
$post_settings['settingId'] = $settingId;
$wrapper_attributes[] = sprintf('data-items-wrapper="%s"',$settingId) ;

$inner_attributes[] = 'data-items-container="true"';
$sidebar_layout = G5Plus_Auteur()->options()->get_sidebar_layout();
$sidebar = G5Plus_Auteur()->cache()->get_sidebar();
if ($sidebar_layout !== 'none' && is_active_sidebar($sidebar)) {
    $inner_classes[] = 'product-has-sidebar';
}
$inner_class = implode( ' ', array_filter( $inner_classes ) );
?>
<div <?php echo implode( ' ', $wrapper_attributes ); ?> class="products clearfix">
    <?php
    // You can use this for adding codes before the main loop
    do_action( 'g5plus_before_archive_wrapper' );
    ?>
    <div <?php echo implode( ' ', $inner_attributes ); ?> class="<?php echo esc_attr( $inner_class ); ?>">
