<?php
/**
 * List View Loop
 * This file sets up the structure for the list loop
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/loop.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
} ?>

<?php
global $post;
global $more;
$more = false;
$columns = array(
    'xl' => G5Plus_Auteur()->options()->get_event_columns(),
    'lg' => G5Plus_Auteur()->options()->get_event_columns_md(),
    'md' => G5Plus_Auteur()->options()->get_event_columns_sm(),
    'sm' => G5Plus_Auteur()->options()->get_event_columns_xs(),
    '' => G5Plus_Auteur()->options()->get_event_columns_mb()
);
$columns_class = G5Plus_Auteur()->helper()->get_bootstrap_columns($columns);
$wrapper_class = array('row gf-blog-inner clearfix layout-grid gf-event-style-01', 'g5plus-tribe-events-loop');
$columns_gutter = G5Plus_Auteur()->options()->get_event_columns_gutter();
$wrapper_class[] = 'gf-gutter-' . $columns_gutter;
$event_animation = G5Plus_Auteur()->options()->get_event_animation();
$inner_class = array(
    'event-item-inner',
    'clearfix',
    G5Plus_Auteur()->helper()->getCSSAnimation($event_animation),
);
?>

<div class="<?php echo esc_attr(join(' ', $wrapper_class) ) ?>">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php do_action( 'tribe_events_inside_before_loop' ); ?>
		<!-- Event  -->
        <article id="post-<?php the_ID() ?>" class="<?php echo esc_attr($columns_class) ?> <?php tribe_events_event_classes() ?>" data-parent-post-id="<?php echo esc_attr($post->post_parent ? absint( $post->post_parent ) : '')?>">
            <div class="<?php echo esc_attr(join(' ', $inner_class)); ?>">
			    <?php tribe_get_template_part( 'list/single', 'event' ) ?>
            </div>
		</article>
		<?php do_action( 'tribe_events_inside_after_loop' ); ?>
	<?php endwhile; ?>
</div>