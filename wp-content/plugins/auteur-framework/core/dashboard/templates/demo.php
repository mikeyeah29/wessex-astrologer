<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$current_theme = wp_get_theme();
$demo_list = G5P_Dashboard_Demo::getInstance()->demo_list();
?>
<div class="gsf-message-box">
	<h4 class="gsf-heading"><?php echo esc_html__('Install Demo Data', 'auteur-framework')?></h4>
	<p><?php esc_html_e('Install demo data (post, page, image, menu, widget, slider, theme setting, ...) is the easiest way to setup your theme. It will allow you to quickly edit everything instead of creating content from scratch.', 'auteur-framework') ?></p>
	<hr>
	<p><?php esc_html_e( 'When you import the data, the following things might happen:', 'auteur-framework' ); ?></p>
	<small>
		<ul>
			<li><strong><?php esc_html_e( 'All data in database and Upload Dir will be deleted when install demo.', 'auteur-framework' ); ?></strong></li>
			<li><?php esc_html_e( 'The included plugins need to be installed and activated before you install a demo.','auteur-framework') ?></li>
			<li><?php esc_html_e( 'Please check the "System Status" tab to ensure your server meets all requirements for a successful import. Settings that need attention will be listed in red.','auteur-framework') ?></li>
			<li><?php esc_html_e( 'Posts, pages, images, widgets, menus and other theme settings will get imported.', 'auteur-framework' ); ?></li>
			<li><?php esc_html_e( 'Please click on the Import button only once and wait, it can take a couple of minutes.', 'auteur-framework' ); ?></li>
		</ul>
	</small>
</div>
<div class="gsf-demo-wrapper" data-nonce="<?php echo wp_create_nonce('gsf_install_demo_data_action') ?>">
	<div class="gsf-row">
		<?php foreach ($demo_list as $k => $v): ?>
			<div class="gsf-col-4">
				<div class="gsf-demo-item" data-demo="<?php echo esc_attr($k)?>">
					<figure>
						<img src="<?php echo esc_url($v['thumbnail']) ?>" alt="<?php echo esc_attr($v['name']) ?>">
						<a href="<?php echo esc_url($v['preview']) ?>" target="_blank"><?php esc_html_e('Preview','auteur-framework') ?></a>
					</figure>
					<div class="gsf-demo-item-body">
						<div class="gsf-demo-item-name" data-name="<?php echo esc_attr($v['name']) ?>"><?php echo esc_html($v['name']) ?></div>
						<button type="button" class="button button-secondary gsf-demo-item-import"
						        data-confirm="<?php echo esc_attr__("Type \"install\" to accept install setting.\nNOTE: Your theme option, post, page, attachment... may change when the installation completed!",'auteur-framework') ?>"
						        data-ajax="<?php echo admin_url('admin-ajax.php?action=gsf_install_demo_setting') ?>"
						        data-import-done="<?php esc_attr_e('Import Done','auteur-framework') ?>"
						        data-importing="<?php esc_attr_e('Importing','auteur-framework') ?>">
							<?php esc_html_e('Import Setting','auteur-framework') ?>
						</button>
						<button type="button" class="button button-primary gsf-demo-item-import"
						        data-confirm="<?php echo esc_attr__("Type \"install\" to accept install demo data.\nNOTE: Will delete all post, page, term ... before install!",'auteur-framework') ?>"
						        data-ajax="<?php echo admin_url('admin-ajax.php?action=gsf_install_demo_data') ?>"
						        data-import-done="<?php esc_attr_e('Import Done','auteur-framework') ?>"
						        data-importing="<?php esc_attr_e('Importing','auteur-framework') ?>">
							<?php esc_html_e('Import','auteur-framework') ?>
						</button>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>

</div>
