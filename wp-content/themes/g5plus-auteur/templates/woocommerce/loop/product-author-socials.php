<?php
/**
 * Created by PhpStorm.
 * User: MyPC
 * Date: 11/12/2018
 * Time: 10:45 SA
 *
 * @var $social_networks
 */
// show product author social networks

if(isset($social_networks) && !empty($social_networks)):
    $wrapper_classes = array(
        'gf-social-icon gf-inline social-icon-circle-outline social-icon-medium'
    );
    ?>
    <ul class="<?php echo esc_attr(implode(' ', array_filter($wrapper_classes))) ?>">
        <?php foreach ($social_networks as $social): ?>
            <?php if(isset($social['social_link']) && !empty($social['social_link'])): ?>
                <?php
                $social_id = $social['social_id'];
                $social_name = $social['social_name'];
                $social_link = $social['social_link'];
                $social_icon = $social['social_icon'];
                $social_class = 'transition03';
                ?>
                <li class="<?php echo esc_attr($social_id)?>">
                    <?php if ($social_id === 'social-email'): ?>
                        <a class="<?php echo esc_attr($social_class)?>" data-toggle="tooltip" target="_blank" title="<?php echo esc_attr($social_name)?>" href="mailto:<?php echo esc_attr($social_link) ?>"><i class="<?php echo esc_attr($social_icon)?>"></i><?php echo esc_html($social_name) ?></a>
                    <?php else: ?>
                        <a class="<?php echo esc_attr($social_class)?>" data-toggle="tooltip" title="<?php echo esc_attr($social_name)?>" href="<?php echo esc_url($social_link)?>"><i class="<?php echo esc_attr($social_icon)?>"></i><?php echo esc_html($social_name) ?></a>
                    <?php endif; ?>

                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
<?php endif;