<?php
echo get_the_term_list(get_the_ID(),G5Plus_Auteur()->portfolio()->get_taxonomy_category(),'<div class="portfolio-cat">',' / ','</div>');