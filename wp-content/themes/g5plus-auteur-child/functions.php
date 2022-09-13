<?php
add_action( 'wp_enqueue_scripts', 'g5plus_auteur_child_theme_enqueue_styles', 1000 );
function g5plus_auteur_child_theme_enqueue_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'gsf_main' ) );
}

add_action( 'after_setup_theme', 'g5plus_auteur_child_theme_setup');
function g5plus_auteur_child_theme_setup(){
    $language_path = get_stylesheet_directory() .'/languages';
    if(is_dir($language_path)){
        load_child_theme_textdomain('g5plus-auteur', $language_path );
    }
}
// if you want to add some custom function

// Create Authors CPT
// function custom_post_authors() {
// 	$labels = array(
// 		'name'               => _x( 'Authors', 'post type general name' ),
// 		'singular_name'      => _x( 'Author', 'post type singular name' ),
// 		'add_new'            => _x( 'Add New Author', 'author' ),
// 		'add_new_item'       => __( 'Add Author' ),
// 		'edit_item'          => __( 'Edit Author' ),
// 		'new_item'           => __( 'New Author' ),
// 		'all_items'          => __( 'All Authors' ),
// 		'view_item'          => __( 'View Author' ),
// 		'search_items'       => __( 'Search Authors' ),
// 		'not_found'          => __( 'No Authors found' ),
// 		'not_found_in_trash' => __( 'No Authors found in Trash' ),
// 		'parent_item_colon'  => '',
// 		'menu_name'          => 'Authors'
// 	);
// 	$args = array(
// 		'labels'        => $labels,
// 		'description'   => 'Section for adding latest authors',
// 		'public'        => true,
// 		'menu_position' => 56,
// 		'supports'      => array( 'title', 'editor', 'thumbnail'),
// 		'has_archive'   => true,
// 		'hierarchical'	=> false,
// 		// 'exclude_from_search' => true,
// 		// 'publicly_queryable' => true,
// 		'exclude_from_search' => false,
// 		'rewrite' => true,
// 		'query_var'		=> true
// 	);
// 	register_post_type( 'authors', $args );
// 	flush_rewrite_rules();
// }
// add_action( 'init', 'custom_post_authors' );

// create interview post type
// function custom_post_interviews() {
// 	$labels = array(
// 		'name'               => _x( 'Interviews', 'post type general name' ),
// 		'singular_name'      => _x( 'Interview', 'post type singular name' ),
// 		'add_new'            => _x( 'Add New Interview', 'interview' ),
// 		'add_new_item'       => __( 'Add Interview' ),
// 		'edit_item'          => __( 'Edit Interview' ),
// 		'new_item'           => __( 'New Interview' ),
// 		'all_items'          => __( 'All Interviews' ),
// 		'view_item'          => __( 'View Interview' ),
// 		'search_items'       => __( 'Search Interviews' ),
// 		'not_found'          => __( 'No Interviews found' ),
// 		'not_found_in_trash' => __( 'No Interviews found in Trash' ),
// 		'parent_item_colon'  => '',
// 		'menu_name'          => 'Interviews'
// 	);
// 	$args = array(
// 		'labels'        => $labels,
// 		'description'   => 'Section for adding author interviews',
// 		'public'        => true,
// 		'menu_icon'   => 'dashicons-format-chat',
// 		'menu_position' => 56,
// 		'supports'      => array( 'title'),
// 		'has_archive'   => true,
// 		'hierarchical'	=> false,
// 		// 'exclude_from_search' => true,
// 		'exclude_from_search' => false,
// 		'rewrite' => true,
// 		'query_var'		=> true
// 	);
// 	register_post_type( 'interviews', $args );
// 	flush_rewrite_rules();
// }
// add_action( 'init', 'custom_post_interviews' );
