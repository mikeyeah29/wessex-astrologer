<?php

class WA_CPT
{
    function create_interviews() {

        $labels = array(
    		'name'               => _x( 'Interviews', 'post type general name' ),
    		'singular_name'      => _x( 'Interview', 'post type singular name' ),
    		'add_new'            => _x( 'Add New Interview', 'interview' ),
    		'add_new_item'       => __( 'Add Interview' ),
    		'edit_item'          => __( 'Edit Interview' ),
    		'new_item'           => __( 'New Interview' ),
    		'all_items'          => __( 'All Interviews' ),
    		'view_item'          => __( 'View Interview' ),
    		'search_items'       => __( 'Search Interviews' ),
    		'not_found'          => __( 'No Interviews found' ),
    		'not_found_in_trash' => __( 'No Interviews found in Trash' ),
    		'parent_item_colon'  => '',
    		'menu_name'          => 'Interviews'
    	);
    	$args = array(
    		'labels'        => $labels,
    		'description'   => 'Section for adding author interviews',
    		'public'        => true,
    		'menu_icon'   => 'dashicons-format-chat',
    		'menu_position' => 56,
    		'supports'      => array( 'title'),
    		'has_archive'   => true,
    		'hierarchical'	=> false,
    		// 'exclude_from_search' => true,
    		'exclude_from_search' => false,
    		'rewrite' => true,
    		'query_var'		=> true
    	);
    	register_post_type( 'interviews', $args );
    	flush_rewrite_rules();
        
    }

    public function __construct()
    {
        add_action( 'init', array($this, 'create_interviews') );
    }
}

?>
