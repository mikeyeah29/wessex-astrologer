<?php
/**
 * The template for displaying header
 */
$header_enable = G5Plus_Auteur()->options()->get_header_enable();
if ($header_enable !== 'on') return;
G5Plus_Auteur()->helper()->getTemplate('header/desktop');
G5Plus_Auteur()->helper()->getTemplate('header/mobile');


