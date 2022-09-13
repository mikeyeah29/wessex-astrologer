<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 9/20/2017
 * Time: 10:43 AM
 * @var $layout
 */
if(!isset($layout)) {
    $layout = 'horizontal';
}
$wrapper_class = array(
    'gsf-portfolio-meta',
    'portfolio-meta-' . $layout
);
if('horizontal' === $layout) {
    $wrapper_class = array_merge($wrapper_class, array(
        'd-flex',
        'align-items-start'
    ));
}
$single_portfolio_detail_configs = G5Plus_Auteur()->options()->get_single_portfolio_details();
$prefix = G5Plus_Auteur()->getMetaPrefix();
?>
<ul class="<?php echo esc_attr(join(' ', $wrapper_class)); ?>">
    <?php foreach ($single_portfolio_detail_configs as $config): ?>
        <?php
        $meta_type = isset($config['type']) ? $config['type'] : 'text';
        $meta_title = isset($config['title']) ? $config['title'] : '';
        $meta_id = isset($config['id']) ? $config['id'] : '';
        $meta_value = '';
        $meta_value = G5Plus_Auteur()->metaBoxPortfolio()->getMetaValue("{$prefix}{$meta_id}");
        ?>
        <?php if (!empty($meta_title) && !empty($meta_value)): ?>
            <li>
                <label><?php echo  esc_html($meta_title) ?>:</label>
                <?php echo wp_kses_post( $meta_value, true ); ?>
            </li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>