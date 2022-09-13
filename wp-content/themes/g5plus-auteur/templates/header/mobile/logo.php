<?php
/**
 * The template for displaying logo.php
 *
 */

$logo_retina = G5Plus_Auteur()->options()->get_logo_retina();
$logo_retina = isset($logo_retina['url']) ? $logo_retina['url'] : '';

$mobile_logo = G5Plus_Auteur()->options()->get_mobile_logo();
$mobile_logo = isset($mobile_logo['url']) ? $mobile_logo['url'] : $mobile_logo;

$mobile_logo_retina = G5Plus_Auteur()->options()->get_mobile_logo_retina();
$mobile_logo_retina = isset($mobile_logo_retina['url']) ? $mobile_logo_retina['url'] : $logo_retina;

$mobile_sticky_logo = G5Plus_Auteur()->options()->get_mobile_sticky_logo();
$mobile_sticky_logo = isset($mobile_sticky_logo['url']) ? $mobile_sticky_logo['url'] : '';

$mobile_sticky_logo_retina = G5Plus_Auteur()->options()->get_mobile_sticky_logo_retina();
$mobile_sticky_logo_retina = isset($mobile_sticky_logo_retina['url']) ? $mobile_sticky_logo_retina['url'] : '';

$logo_title = esc_attr(get_bloginfo('name', 'display')) . '-' . get_bloginfo('description', 'display');
$logo_text = get_bloginfo('name', 'display');
$mobile_logo_classes = array(
    'mobile-logo-header',
    'align-items-center d-flex'
);
if ($mobile_sticky_logo) {
    $mobile_logo_classes[] = 'has-logo-sticky';
}

$logo_attributes = array();
if ($mobile_logo_retina && ($mobile_logo_retina != $mobile_logo)) {
	$logo_attributes[] = 'data-retina="' . esc_url($mobile_logo_retina) . '"';
}
$mobile_logo_sticky_attributes = array();
if ($mobile_sticky_logo_retina && ($mobile_sticky_logo_retina != $mobile_sticky_logo)) {
    $mobile_logo_sticky_attributes[] = 'data-retina="' . esc_url($mobile_sticky_logo_retina) . '"';
}

$mobile_logo_class = implode(' ', array_filter($mobile_logo_classes));
?>
<div class="<?php echo esc_attr($mobile_logo_class) ?>">
	<a class="gsf-link main-logo" href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr($logo_title) ?>">
		<?php if (!empty($mobile_logo)): ?>
			<img <?php echo implode(' ', $logo_attributes); ?> src="<?php echo esc_url($mobile_logo) ?>" alt="<?php echo esc_attr($logo_title) ?>">
		<?php else: ?>
			<h2 class="logo-text"><?php echo esc_html($logo_text); ?></h2>
		<?php endif; ?>
	</a>
    <?php if ($mobile_sticky_logo): ?>
        <a class="sticky-logo" href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr($logo_title) ?>">
            <img <?php echo implode(' ', $mobile_logo_sticky_attributes); ?> src="<?php echo esc_url($mobile_sticky_logo) ?>" alt="<?php echo esc_attr($logo_title) ?>">
        </a>
    <?php endif; ?>
</div>


