<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/11/2016
 * Time: 10:25 AM
 * @var $name
 * @var $job
 * @var $bio
 * @var $image_src
 * @var $url
 * @var $image
 * @var $user_rating
 */
?>
<div class="testimonial-item">
    <?php if (!empty($image_src)): ?>
        <?php if (!empty($image_src)): ?>
            <div class="author-avatar">
                <img src="<?php echo esc_url($image_src); ?>" title="<?php echo esc_attr($name); ?>"
                     alt="<?php echo esc_attr($name); ?>">
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <div class="testimonials-content">
        <?php if (!empty($bio)): ?>
            <p><?php echo wp_kses_post($bio); ?></p>
        <?php endif; ?>
    </div>
    <?php if(!empty($user_rating)): ?>
        <div class="testimonial-rating">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <?php $icon_class = ($i <= $user_rating) ? 'fas fa-star' : 'fal fa-star';?>
                <span class="<?php echo esc_attr($icon_class) ?>"></span>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($name) || !empty($job)): ?>
        <div class="author-attr">
            <?php if (!empty($name)): ?>
                <h6 class="author-name">
                    <?php if (!empty($url)): ?>
                    <a href="<?php echo esc_url($url) ?>">
                        <?php endif;
                        echo esc_attr($name);
                        if (!empty($url)): ?>
                    </a>
                <?php endif; ?>
                </h6>
            <?php endif; ?>
            <?php if (!empty($job)): ?>
                <span class="author-job">/ <?php echo esc_html($job); ?></span>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>