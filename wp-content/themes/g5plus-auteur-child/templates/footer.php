<?php
/**
 * The template for displaying footer
 */
$footer_enable = G5Plus_Auteur()->options()->get_footer_enable();
if ($footer_enable !== 'on') return;
$footer_fixed_enable = G5Plus_Auteur()->options()->get_footer_fixed_enable();
$wrapper_classes = array(
	'main-footer-wrapper'
);

if ($footer_fixed_enable === 'on') {
	$wrapper_classes[] = 'footer-fixed';
}
$content_block = G5Plus_Auteur()->options()->get_footer_content_block();
if (empty($content_block)) return;
$wrapper_class = implode(' ', array_filter($wrapper_classes));
?>

<?php

$contact = WA_Content::getContact();
$about = WA_Content::getFooterAbout();
$home_url = home_url();

?>

<footer class="<?php echo esc_attr($wrapper_class); ?>">

	<?php // echo G5Plus_Auteur()->helper()->content_block( $content_block ); ?>

	<div class="wa-footer vc_row wpb_row vc_row-fluid vc_custom_1545877085097 vc_row-has-fill vc_row-o-equal-height vc_row-flex gf-skin skin-dark">
        <div class="gf-row-inner gf-container container">
			<div class="md-mg-bottom-50 col-mb-12 wpb_column vc_column_container vc_col-sm-6 vc_col-md-3 vc_col-xs-6">
				<div class="vc_column-inner">
					<div class="wpb_wrapper">
						<h4 class="widget-title"><span>About</span></h4>
						<?php echo $about; ?>
					</div>
				</div>
			</div>
			<div class="md-mg-bottom-50 col-mb-12 wpb_column vc_column_container vc_col-sm-6 vc_col-md-3 vc_col-xs-6">
				<div class="vc_column-inner">
					<div class="wpb_wrapper">
						<h4 class="widget-title"><span>Opening Times</span></h4>
						<p><i class="fas fa-clock"></i> Monday-Friday</p>
					</div>
				</div>
			</div>
			<div class="md-mg-bottom-50 col-mb-12 wpb_column vc_column_container vc_col-sm-6 vc_col-md-3 vc_col-xs-6">
				<div class="vc_column-inner">
					<div class="wpb_wrapper">
						<h4 class="widget-title"><span>Information</span></h4>
						<div class="nav-italic widget widget_nav_menu">
							<?php

								wp_nav_menu(array(
									'theme_location' => 'wessex-astrologer-footer',
									'container_class' => 'wessex-astrologer-info'
								));

							?>
						</div>
					</div>
				</div>
			</div>
			<div class="md-mg-bottom-50 col-mb-12 wpb_column vc_column_container vc_col-sm-6 vc_col-md-3 vc_col-xs-6">
				<div class="vc_column-inner">
					<div class="wpb_wrapper">
						<h4 class="widget-title"><span>Contact Us</span></h4>
						<div class="fs-15 disable-color">
							<p style="margin-bottom: 11px;"><?php echo $contact['ADDRESS']; ?></p>
							<div class="phone_number">UK <a href="tel:<?php echo $contact['PHONE_UK']; ?>"><?php echo $contact['PHONE_UK']; ?></a></div>
							<div>International <a href="tel:<?php echo $contact['PHONE_INTERNATIONAL']; ?>"><?php echo $contact['PHONE_INTERNATIONAL']; ?></a></div>
							<p><a href="mailto:<?php echo $contact['EMAIL']; ?>"><?php echo $contact['EMAIL']; ?></a></p>
						</div>
					</div>
				</div>
			</div>
		</div>


		<div class="wa-footer-bottom">
			<ul class="widget-payment-wrap">
				<li class="widget-payment-item">
					<a href="#">
						<img src="<?php echo $home_url; ?>/wp-content/uploads/2018/11/payment_01.jpg" alt="">
					</a>
				</li>
				<li class="widget-payment-item">
					<a href="#">
						<img src="<?php echo $home_url; ?>/wp-content/uploads/2018/11/payment_02.jpg" alt="">
					</a>
				</li>
				<li class="widget-payment-item">
					<a href="#">
						<img src="<?php echo $home_url; ?>/wp-content/uploads/2018/11/payment_03.jpg" alt="">
					</a>
				</li>
				<li class="widget-payment-item">
					<a href="#">
						<img src="<?php echo $home_url; ?>/wp-content/uploads/2018/11/payment_04.jpg" alt="">
					</a>
				</li>
	        </ul>
			<p>&copy; <?php echo Date('Y'); ?> The Wessex Astrologer LtdCompany No. 3200489</p>
		</div>

	</div>


	<!-- <h4 class="widget-title"><span>Information</span></h4>

	<div class="vc_row wpb_row vc_row-fluid vc_custom_1545877085097 vc_row-has-fill vc_row-o-equal-height vc_row-flex gf-skin skin-dark">
        <div class="gf-row-inner gf-container container">
            <div class="wpb_column vc_column_container vc_col-sm-12">
				<div class="vc_column-inner">
					<div class="wpb_wrapper">
						<div class="g5plus-space space-631f4d2babe53" data-id="631f4d2babe53" data-tablet="100" data-tablet-portrait="80" data-mobile="60" data-mobile-landscape="70" style="clear: both; display: block; height: 124px"></div>
					</div>
				</div>
			</div>
			<div class="md-mg-bottom-50 col-mb-12 wpb_column vc_column_container vc_col-sm-6 vc_col-md-3 vc_col-xs-6">
				<div class="vc_column-inner">
					<div class="wpb_wrapper">

					<div class="gf-social-networks vc_custom_1544169783179 gsf-social-631f4d2bacab4">
						<ul class="gf-social-icon gf-inline">
							<li class="social-facebook">
			                    <a class="transition03" target="_blank" title="Facebook" href="#">
									<i class="fab fa-facebook-f"></i>Facebook
								</a>
							</li>
							<li class="social-twitter">
			                    <a class="transition03" target="_blank" title="Twitter" href="#">
									<i class="fab fa-twitter"></i>Twitter
								</a>
							</li>
							<li class="social-instagram">
			                    <a class="transition03" target="_blank" title="Instagram" href="#">
									<i class="fab fa-instagram"></i>Instagram
								</a>
							</li>
							<li class="social-skype">
			                    <a class="transition03" target="_blank" title="Skype" href="#">
									<i class="fab fa-skype"></i>Skype
								</a>
							</li>
						</ul>

					</div>
				</div>
			</div>
		</div>
		<div class="md-mg-bottom-50 col-mb-12 wpb_column vc_column_container vc_col-sm-6 vc_col-md-2 vc_col-xs-6">
			<div class="vc_column-inner">
				<div class="wpb_wrapper">
					<div class="wpb_widgetised_column wpb_content_element">
						<div class="wpb_wrapper">
							<aside id="nav_menu-2" class="nav-italic widget widget_nav_menu">
								<h4 class="widget-title"><span>Information</span></h4>
								<div class="menu-extra-links-container">
									<ul id="menu-extra-links" class="menu">
										<li id="menu-item-1370" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1370">
											<a class="x-menu-link" href="#"><span class="x-menu-link-text">Affiliate Program</span></a>
										</li>
										<li id="menu-item-1371" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1371"><a class="x-menu-link" href="#"><span class="x-menu-link-text">Business Services</span></a></li>
										<li id="menu-item-1372" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1372"><a class="x-menu-link" href="#"><span class="x-menu-link-text">Education Services</span></a></li>
										<li id="menu-item-1373" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1373"><a class="x-menu-link" href="#"><span class="x-menu-link-text">Gift Cards</span></a></li>
									</ul>
								</div>
							</aside>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="md-mg-bottom-50 col-mb-12 wpb_column vc_column_container vc_col-sm-6 vc_col-md-3 vc_col-xs-6"><div class="vc_column-inner"><div class="wpb_wrapper"><div class="wpb_widgetised_column wpb_content_element">
		<div class="wpb_wrapper">

			<aside id="nav_menu-3" class="nav-italic widget widget_nav_menu"><h4 class="widget-title"><span>Your Account</span></h4><div class="menu-your-account-container"><ul id="menu-your-account" class="menu"><li id="menu-item-1374" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1374"><a class="x-menu-link" href="#"><span class="x-menu-link-text">Shop</span></a></li>
<li id="menu-item-1375" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1375"><a class="x-menu-link" href="#"><span class="x-menu-link-text">My Orders</span></a></li>
<li id="menu-item-1376" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1376"><a class="x-menu-link" href="#"><span class="x-menu-link-text">Gift Collections</span></a></li>
<li id="menu-item-1377" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1377"><a class="x-menu-link" href="#"><span class="x-menu-link-text">Purchase Cards</span></a></li>
<li id="menu-item-1378" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1378"><a class="x-menu-link" href="#"><span class="x-menu-link-text">FAQs</span></a></li>
</ul></div></aside>
		</div>
	</div>
</div></div></div><div class="md-mg-bottom-50 col-mb-12 wpb_column vc_column_container vc_col-sm-6 vc_col-md-4 vc_col-xs-6"><div class="vc_column-inner"><div class="wpb_wrapper"><div class="wpb_widgetised_column wpb_content_element">
		<div class="wpb_wrapper">

			<aside id="woocommerce_products-2" class="custom-product-widgets widget woocommerce widget_products"><h4 class="widget-title"><span>Best Sellers</span></h4><ul class="product_list_widget"><li>

	<a href="http://wessexastrologer.rwdstaging.co.uk/product/tma-back-issue-cancer-sol-2022/">
		<img width="330" height="462" src="http://wessexastrologer.rwdstaging.co.uk/wp-content/uploads/2022/08/TMA-Cancer-Sol-2022-scaled-1-330x462.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" loading="lazy">		<span class="product-title">TMA Back Issue Cancer Sol 2022</span>
	</a>


	<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">£</span>3.00</bdi></span>
	</li>
</ul></aside>
		</div>
	</div>
</div></div></div><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner"><div class="wpb_wrapper"><div class="g5plus-space space-631f4d2baf927" data-id="631f4d2baf927" data-tablet="80" data-tablet-portrait="20" data-mobile="0" data-mobile-landscape="10" style="clear: both; display: block; height: 100px"></div></div></div></div><div class="wpb_column vc_column_container vc_col-sm-6"><div class="vc_column-inner"><div class="wpb_wrapper"><div class="wpb_widgetised_column wpb_content_element">
		<div class="wpb_wrapper">

			<aside id="gsf-payment-2" class="widget widget-payment">            <ul class="widget-payment-wrap">
                                                            <li class="widget-payment-item">
                                                        <a href="#">
                                                                <img src="http://dev.testwp.com/wp-content/uploads/2018/11/payment_01.jpg" alt="">
                                                            </a>
                                                </li>
                                                                                <li class="widget-payment-item">
                                                        <a href="#">
                                                                <img src="http://dev.testwp.com/wp-content/uploads/2018/11/payment_02.jpg" alt="">
                                                            </a>
                                                </li>
                                                                                <li class="widget-payment-item">
                                                        <a href="#">
                                                                <img src="http://dev.testwp.com/wp-content/uploads/2018/11/payment_03.jpg" alt="">
                                                            </a>
                                                </li>
                                                                                <li class="widget-payment-item">
                                                        <a href="#">
                                                                <img src="http://dev.testwp.com/wp-content/uploads/2018/11/payment_04.jpg" alt="">
                                                            </a>
                                                </li>
                                                </ul>
            </aside>
		</div>
	</div>
</div></div></div><div class="wpb_column vc_column_container vc_col-sm-6"><div class="vc_column-inner"><div class="wpb_wrapper"><div class="wpb_widgetised_column wpb_content_element text-right sm-text-left">
		<div class="wpb_wrapper">

			<aside id="text-3" class="widget widget_text">			<div class="textwidget"><p class="mg-top-5 mg-bottom-0 text-italic primary-font fs-14 disable-color">© 2022 The Wessex Astrologer. All Right Reserved.</p>
</div>
		</aside>
		</div>
	</div>
</div></div></div><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner"><div class="wpb_wrapper"><div class="g5plus-space space-631f4d2bb0903" data-id="631f4d2bb0903" data-tablet="45" data-tablet-portrait="40" data-mobile="40" data-mobile-landscape="40" style="clear: both; display: block; height: 50px"></div></div></div></div>							</div>

		</div> -->

</footer>
