<div class="container">
    <div class="rwd-top-bar">
        <div class="row">
            <div class="col-sm-6">
                <div class="rwd-top-bar-contact">
                    <div class="d-flex">
                        <div class="rwd-top-bar-contact__item">
                            <i class="fa fa-envelope"></i>
                            <a href="mailto:info@wessexastrologer.com">info@wessexastrologer.com</a>
                        </div>
                        <div class="rwd-top-bar-contact__item">
                            <i class="fa fa-phone"></i>
                            <a href="tel:01202424695">UK 01202 424695</a>
                        </div>
                        <div class="rwd-top-bar-contact__item">
                            <a href="tel:+44 1202424695">International +44 1202424695</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <?php

                    $social_networks = G5Plus_Auteur()->options()->get_social_networks();

                ?>

                <ul class="gf-social-icon gf-inline rwd-socials">
                    <?php foreach ($social_networks as $social) { ?>
                        <?php if($social['social_link']) { ?>
                            <li>
                                <a href="<?php echo $social['social_link']; ?>">
                                    <i class="<?php echo $social['social_icon']; ?>"></i>
                                </a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
