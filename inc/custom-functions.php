<?php

add_action( 'wp_enqueue_scripts', 'memoo_dequeue_jquery_migrate', 0);
function memoo_dequeue_jquery_migrate(){
	if(!is_admin()){
		wp_deregister_script( 'jquery' );
    	wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, NULL, true );
    	wp_enqueue_script( 'jquery' );
	}
}

//Add SVG support for media upload
function memoo_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'memoo_mime_types');

//Fix SVG thumbnail display in Media Grid
function memoo_fix_svg_thumb_display() {
    echo '<style type="text/css">td.media-icon img[src$=".svg"] { width: 100% !important; height: auto !important; }</style>';
}
add_action('admin_head', 'memoo_fix_svg_thumb_display');

//remove ver from scripts and styles
add_filter( 'script_loader_src', 'memoo_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'memoo_remove_script_version', 15, 1 );
function memoo_remove_script_version( $src ) {
	$exceptions = array();
	foreach ( $exceptions as $item ) {
		if ( stripos( $src, $item ) !== FALSE ) {
			return $src;
		}
	}
	return remove_query_arg( 'ver', $src );
}

function memoo_featured_post() {
	global $post;
	?>
	<input type="checkbox" id="memoo_featured_post" value="1" name="memoo_featured_post" <?php checked($post->ID, get_option('memoo_featured_post'), true); ?>>
	<label for="memoo_featured_post"><?php esc_html_e('Marker som fremhævet indlæg', 'memoo'); ?></label>
	<?php
}

function memoo_featured_post_meta_box() {
	add_meta_box('featured-setting-wrapper', esc_html('Fremhævet indlæg', 'memoo'), 'memoo_featured_post', 'post', 'side', 'high');
}

add_action('add_meta_boxes', 'memoo_featured_post_meta_box');


function memoo_save_featured_post($post_id, $post) {
    if ('post' != $post->post_type ) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (defined('DOING_AJAX') && DOING_AJAX) {
        return;
    }

	if (!empty($_POST['memoo_featured_post']) && '1' == $_POST['memoo_featured_post']) {
		update_option('memoo_featured_post', $post_id);
	}
}

add_action('save_post', 'memoo_save_featured_post', 10, 2);


//Remove WP tags + emojis
remove_action('wp_head', 'wp_resource_hints', 2 );
remove_action('wp_head', 'print_emoji_detection_script', 7 );
remove_action('wp_print_styles', 'print_emoji_styles' );
add_filter('emoji_svg_url', '__return_false' );

remove_action('wp_head', 'rsd_link'); //removes EditURI/RSD (Really Simple Discovery) link.
remove_action('wp_head', 'wlwmanifest_link'); //removes wlwmanifest (Windows Live Writer) link.
remove_action('wp_head', 'wp_generator'); //removes meta name generator.
remove_action('wp_head', 'wp_shortlink_wp_head'); //removes shortlink.
remove_action('wp_head', 'feed_links', 2 ); //removes feed links.
remove_action('wp_head', 'feed_links_extra', 3 );  //removes comments feed.
if (! empty($GLOBALS['sitepress']) ) {
	remove_action( 'wp_head', array($GLOBALS['sitepress'], 'meta_generator_tag') );
}



?>
