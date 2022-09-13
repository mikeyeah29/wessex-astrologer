<?php
/**
 * The template for displaying single
 *
 */
$single_post_layout = G5Plus_Auteur()->options()->get_single_post_layout();
G5Plus_Auteur()->helper()->getTemplate("single/{$single_post_layout}/layout");


