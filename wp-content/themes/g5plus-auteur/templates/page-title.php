<?php
/**
 * The template for displaying page-title
 */
$page_title_enable = G5Plus_Auteur()->options()->get_page_title_enable();
if ($page_title_enable !== 'on') return;
$content_block = G5Plus_Auteur()->options()->get_page_title_content_block();
$skin = G5Plus_Auteur()->options()->get_page_title_skin();

$wrapper_classes = array(
	'gf-page-title'
);

if(empty($content_block)) {
    $wrapper_classes[] = 'gf-page-title-default';
}
$skin_classes = G5Plus_Auteur()->helper()->getSkinClass($skin);
$wrapper_classes = array_merge($wrapper_classes,$skin_classes);
$wrapper_class = implode(' ', array_filter($wrapper_classes));
?>
<div class="<?php echo esc_attr($wrapper_class) ?>">
    <?php if (!empty($content_block)): ?>
        <?php echo G5Plus_Auteur()->helper()->content_block($content_block); ?>
    <?php else: ?>
        <?php $page_title = G5Plus_Auteur()->helper()->get_page_title(); ?>
        <?php $page_subtitle = G5Plus_Auteur()->helper()->get_page_subtitle(); ?>
        <div class="container">
            <div class="page-title-inner row no-gutters align-items-center">
                <div class="page-title-content">
                    <h1 class="page-main-title"><?php echo esc_html($page_title);?></h1>
                    <?php if(!empty($page_subtitle)): ?>
                        <p class="page-sub-title"><?php echo esc_html($page_subtitle); ?></p>
                    <?php endif; ?>
                </div>
                <?php G5Plus_Auteur()->breadcrumbs()->get_breadcrumbs(); ?>
            </div>
        </div>
    <?php endif; ?>
</div>
