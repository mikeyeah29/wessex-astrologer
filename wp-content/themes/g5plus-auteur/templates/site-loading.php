<?php
/**
 * The template for displaying site-loading.php
 */
$loading_animation = G5Plus_Auteur()->options()->get_loading_animation();
if (empty($loading_animation)) return;
$logo_loading = G5Plus_Auteur()->options()->get_loading_logo();
?>
<div class="site-loading">
	<div class="block-center">
		<div class="block-center-inner">
			<?php if (isset($logo_loading['url']) && !empty($logo_loading['url'])): ?>
				<img class="logo-loading" alt="<?php esc_attr_e('Logo Loading','g5plus-auteur') ?>" src="<?php echo esc_url($logo_loading['url']) ?>" />
			<?php endif; ?>
			<?php G5Plus_Auteur()->helper()->getTemplate("loading/{$loading_animation}") ?>
		</div>
	</div>
</div>
