<?php
/**
 * The template for displaying comments.php
 * @var $comment
 * @var $args
 * @var $depth
 */
$GLOBALS['comment'] = $comment;
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
    <div id="comment-<?php comment_ID(); ?>" class="comment-body clearfix">
        <?php echo get_avatar($comment, $args['avatar_size']); ?>
        <div class="comment-text entry-content">
            <ul class="comment-meta-top d-flex list-inline flex-wrap align-items-center">
                <li class="comment-meta-author">
                    <h4 class="author-name"><?php echo get_comment_author_link() ?></h4>
                </li>
                <li class="comment-meta-date">
                    <?php printf( _x( '%s ago', '%s = human-readable time difference', 'g5plus-auteur' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?>
                </li>
            </ul>
            <div class="gf-entry-content">
                <?php comment_text() ?>
                <?php if ($comment->comment_approved == '0') : ?>
                    <em><?php esc_html_e('Your comment is awaiting moderation.', 'g5plus-auteur'); ?></em>
                <?php endif; ?>
            </div>
            <div class="comment-meta-footer d-flex list-inline flex-wrap align-items-center">
                <?php comment_reply_link(array_merge($args, array(
                    'depth' => $depth,
                    'max_depth' => $args['max_depth'],
                    'reply_text' => '<i class="fa fa-comment"></i> ' . esc_html__('Reply', 'g5plus-auteur'),
                    'reply_to_text' => '<i class="fa fa-comment"></i> ' . esc_html__('Reply to %s', 'g5plus-auteur'),
                    'login_text' => '<i class="fa fa-comment"></i> ' . esc_html__('Log in to Reply', 'g5plus-auteur'),
                ))) ?>
                <?php edit_comment_link('<i class="fa fa-edit"></i> ' . esc_html__('Edit','g5plus-auteur')); ?>
            </div>
        </div>
    </div>
