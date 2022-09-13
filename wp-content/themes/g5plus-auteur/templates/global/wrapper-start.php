<?php
/**
 * The template for displaying wrapper-start
 *
 */

$content_full_width = G5Plus_Auteur()->options()->get_content_full_width();
$sidebar_layout = G5Plus_Auteur()->options()->get_sidebar_layout();
$sidebar = G5Plus_Auteur()->cache()->get_sidebar();
$sidebar_width = G5Plus_Auteur()->options()->get_sidebar_width();
$wrapper_classes = array();
$inner_classes = array();
$sidebar_col = 0;
$sidebar_condition = apply_filters('gsf_sidebar_condition', ($sidebar_layout !== 'none' && is_active_sidebar($sidebar)));
if ($sidebar_condition) {
	$sidebar_col = ($sidebar_width === 'large') ? 4 : 3;
    $wrapper_classes[] = "gsf-sidebar-{$sidebar_layout}";
}

$inner_classes[] = 'col-lg-'. (12 - $sidebar_col);
if ($sidebar_layout === 'left') {
	$inner_classes[] = 'order-lg-2';
}

if ($content_full_width === 'on') {
    $wrapper_classes[] = 'gsf-primary-content-full-width';
}


$inner_class = implode(' ', array_filter($inner_classes));
$wrapper_class = implode(' ', array_filter($wrapper_classes));
/**
 * @hooked - G5Plus_Auteur()->templates()->page_title() - 5
 **/
do_action('g5plus_before_main_content');
?>
<!-- Primary Content Wrapper -->
<div id="primary-content" class="<?php echo esc_attr($wrapper_class)?>">
	<!-- Primary Content Container -->
	<div class="container clearfix">
		<?php do_action('g5plus_main_content_top') ?>
		<!-- Primary Content Row -->
		<div class="row clearfix">
			<!-- Primary Content Inner -->
			<div class="<?php echo esc_attr($inner_class); ?>">


