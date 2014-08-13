<?php

/**
 * Plugin Name: Simple Fullscreen Responsive Slider
 * Plugin URI: http://www.twirlingumbrellas.com/wordpress/simple-slider-fullscreen-responsive-wordpress-slider-plugin/
 * Description: A simple, white box, developer friendly plugin to create a fullscreen responsive slider.
 * Version: 1.0.1
 * Author: Twirling Umbrellas
 * Author URI: http://www.twirlingumbrellas.com
 * License: GPL2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: simple-fullscreen-responsive-slider
 * 
 * @package simple-fullscreen-responsive-slider
 */
/*
 * Copyright (C) 2014, Twirling Umbrellas - info@twirlingumbrellas.com
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * 
 * This plugin includes a jQuery plugin collection "EasyFader" developed by
 * Patrick Kunka (Copyright (c) 2013 Patrick Kunka, All Rights Reserved) under
 * the Creative Commons Attribution 3.0 Unported - CC BY 3.0 license. These
 * files are stored in the /javascripts/ folder. Please visit
 * https://github.com/patrickkunka/easyfader for more information.
 */

class SFRS_Slider {

	private $content; // Slide Content
	private $options; // Slider Options

	/*
	 * Start up and check whether we're on an admin screen or the front page
	 */

	public function __construct() {
		if ( is_admin() ) {
			$this->load_admin_page();
		} else {
			add_action( 'wp', array( $this, 'load_front_page' ) );
		}
	}

	/**
	 * Loads functions required for editing slides and slider options
	 */
	public function load_admin_page() {
		// Retrieve the slider options
		$this->options = get_option( 'sfrs_options' );

		add_action( 'init', array( $this, 'setup_post_type' ), 0 );

		// Disable the visual editor for the slider post type
		add_filter( 'user_can_richedit', array( $this, 'disable_visual_editor' ) );

		// Check to see if MultiPostThumbnails plugin is installed and running.
		// If yes, use it. If no, add support for basic post thumbnails.        
		if ( class_exists( 'MultiPostThumbnails' ) ) {
			add_action( 'init', array( $this, 'configure_multipostthumbnails' ), 100 );
		} else {
			add_action( 'init', array( $this, 'configure_regular_post_thumbnails' ), 100 );
		}

		// Add menu icon styling
		add_action( 'admin_head', array( $this, 'add_admin_menu_icons' ) );

		// Options class for slider configuration
		require_once ( trailingslashit( dirname( __FILE__ ) ) . 'simple-slider-options.php' );
	}

	/**
	 * Loads functions required for displaying the slider on the homepage
	 */
	public function load_front_page() {

		if ( is_front_page() ) {
			// Retrieve the slider options
			$this->options = get_option( 'sfrs_options' );

			add_action( 'init', array( $this, 'setup_post_type' ), 0 );

			// Check to see if MultiPostThumbnails plugin is installed and running.
			// If yes, use it. If no, add support for basic post thumbnails.   
			if ( class_exists( 'MultiPostThumbnails' ) ) {
				add_action( 'init', array( $this, 'configure_multipostthumbnails' ), 100 );
				add_action( 'wp_head', array( $this, 'output_multipostthumbnails_styling' ) );
			} else {
				add_action( 'init', array( $this, 'configure_regular_post_thumbnails' ), 100 );
				add_action( 'wp_head', array( $this, 'output_regular_post_thumbnails_styling' ) );
			}

			// Shortcode to output slider content
			add_shortcode( 'simple-slider', array( $this, 'output_slider_content' ) );

			// Output javascript to the footer to start the slider
			add_action( 'wp_footer', array( $this, 'output_footer_content' ) );

			// Enqueue the necessary minimized jquery plugin depending on the transition chosen
			if ( $this->options['sfrs_option_effects'] == 'slide' ) {
				wp_enqueue_script( 'easyfader', plugins_url( '/javascripts/jquery.easyfader.slide.min.js', __FILE__ ), array( 'jquery' ), '2.0.5', true );
			} else {
				wp_enqueue_script( 'easyfader', plugins_url( '/javascripts/jquery.easyfader.min.js', __FILE__ ), array( 'jquery' ), '2.0.5', true );
			}
		}
	}

	/**
	 * Disables visual editor for specific custom post types
	 */
	function disable_visual_editor() {
		if ( 'sfrs_slider' == get_post_type() ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Create a custom post type called sfrs_slider
	 */
	public function setup_post_type() {

		$labels = array(
			'name' => _x( 'Slider', 'Slider General Name', 'simple-fullscreen-responsive-slider' ),
			'singular_name' => _x( 'Slider', 'Slider Singular Name', 'simple-fullscreen-responsive-slider' ),
			'menu_name' => __( 'Slider', 'simple-fullscreen-responsive-slider' ),
			'parent_item_colon' => __( 'Parent Slide:', 'simple-fullscreen-responsive-slider' ),
			'all_items' => __( 'All Slides', 'simple-fullscreen-responsive-slider' ),
			'view_item' => __( 'View Slide', 'simple-fullscreen-responsive-slider' ),
			'add_new_item' => __( 'Add New Slide', 'simple-fullscreen-responsive-slider' ),
			'add_new' => __( 'Add New', 'simple-fullscreen-responsive-slider' ),
			'edit_item' => __( 'Edit Slide', 'simple-fullscreen-responsive-slider' ),
			'update_item' => __( 'Update Slide', 'simple-fullscreen-responsive-slider' ),
			'search_items' => __( 'Search Slides', 'simple-fullscreen-responsive-slider' ),
			'not_found' => __( 'Not Found', 'simple-fullscreen-responsive-slider' ),
			'not_found_in_trash' => __( 'Not Found in Trash', 'simple-fullscreen-responsive-slider' ),
		);

		$args = array(
			'label' => __( 'Slider', 'simple-fullscreen-responsive-slider' ),
			'description' => __( 'Slides for homepage slider.', 'simple-fullscreen-responsive-slider' ),
			'labels' => $labels,
			'supports' => array( 'title', 'editor' ),
			'taxonomies' => array(),
			'hierarchical' => false,
			'public' => false,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => false,
			'show_in_admin_bar' => true,
			'menu_position' => 27,
			'menu_icon' => '',
			'can_export' => true,
			'has_archive' => false,
			'exclude_from_search' => true,
			'publicly_queryable' => false,
			'rewrite' => false,
			'capability_type' => 'page',
		);

		register_post_type( 'sfrs_slider', $args );
	}

	/**
	 * Adds menu icon to admin dashboard for custom post types using dashicons
	 */
	public function add_admin_menu_icons() {
		echo '<style>#adminmenu .menu-icon-sfrs_slider div.wp-menu-image:before { content: "\f169"; }</style>';
	}

	/**
	 * Setup Multiple Post Thumbnails For Media Queries
	 */
	public function configure_multipostthumbnails() {

		$ids_and_labels = array(
			'slide-bg-888x888' => __( '888x888 (Smartphones)', 'simple-fullscreen-responsive-slider' ),
			'slide-bg-1366x768' => __( '1366x768 (Tablets)', 'simple-fullscreen-responsive-slider' ),
			'slide-bg-1600x900' => __( '1600x900 (Laptops)', 'simple-fullscreen-responsive-slider' ),
			'slide-bg-1920x1080' => __( '1920x1080 (Desktops)', 'simple-fullscreen-responsive-slider' ),
			'slide-bg-2560x1600' => __( '2560x1600 (Retina Displays)', 'simple-fullscreen-responsive-slider' ),
			'slide-bg-3840x2160' => __( '3840x2160 (4K Displays)', 'simple-fullscreen-responsive-slider' ),
		);

		foreach ( $ids_and_labels as $id => $label ) {
			new MultiPostThumbnails( array(
				'label' => $label,
				'id' => $id,
				'post_type' => 'sfrs_slider'
					) );
		}
	}

	/**
	 * Add a basic post thumbnail support to post type
	 */
	public function configure_regular_post_thumbnails() {
		if ( !current_theme_supports( 'post-thumbnails' ) ) {
			add_theme_support( 'post-thumbnails' );
		}
		add_post_type_support( 'sfrs_slider', 'thumbnail' );
	}

	/**
	 * This function echos css into the head area of the homepage while simultaneously
	 * loading a variable with the slider data for inclusion later.
	 * 
	 * @global type $content
	 */
	public function output_multipostthumbnails_styling() {

		// Setup our loop
		$slide_query = new WP_Query( array( 'post_type' => 'sfrs_slider', 'orderby' => 'date', 'order' => 'DESC' ) );

		// Setup our thumbnail keys and media queries array
		$queries = array(
			'slide-bg-3840x2160' => '@media screen and ( min-width: 3840px )',
			'slide-bg-2560x1440' => '@media screen and ( min-width: 2560px ) and ( max-width: 3839px )',
			'slide-bg-1920x1080' => '@media screen and ( min-width: 1920px ) and ( max-width: 2559px )',
			'slide-bg-1600x900' => '@media screen and ( min-width: 1600px ) and ( max-width: 1919px )',
			'slide-bg-1366x768' => '@media screen and ( min-width: 1137px ) and ( max-width: 1599px )',
			'slide-bg-888x888' => '@media screen and ( max-width: 1136px )'
		);

		$keys = array_keys( $queries ); // Keys used for indexing thumbnails
		$c = count( $keys );   // Total number of keys (and queries)
		$i = 0; // Total number of slides (posts)

		/*
		 * The fun begins and we construct our slider array. We start by looping
		 * through each post in the slider post type to collect information.
		 */
		while ( $slide_query->have_posts() ) {
			$slide_query->the_post();

			/*
			 * Next we run through two loops. The outer loop provides the index
			 * for each key in the above media queries array and the index for
			 * the final content array we're creating. The inner loop allows us
			 * to check for a smaller thumbnail if the current size is missing.
			 * The inner loop will break upon finding a matching thumbnail,
			 * which is usually the first iteration of the loop.
			 */
			for ( $a = 0; $a < $c; $a++ ) {
				for ( $b = $a; $b < $c; $b++ ) {
					if ( MultiPostThumbnails::has_post_thumbnail( 'sfrs_slider', $keys[$b] ) ) {
						$thumb_id = MultiPostThumbnails::get_post_thumbnail_id( 'sfrs_slider', $keys[$b], get_the_ID() );
						$this->content[$i][$keys[$a]] = wp_get_attachment_image_src( $thumb_id, $keys[$b] );
						break;
					}
				}
			}

			/*
			 * Grab the title and content for each slide on the way out the door.
			 */
			$this->content[$i]['title'] = get_the_title();
			$this->content[$i]['content'] = get_the_content();
			$i++;
		}

		wp_reset_postdata(); // Cleanup
		// Open our style header
		echo "<style type='text/css'>\n";

		// Echo in our optional CSS created by the user
		echo sanitize_text_field( $this->options['sfrs_option_css'] );

		if ( isset( $this->options['sfrs_option_overlay'] ) && (!empty( $this->options['sfrs_option_overlay'] ) ) ) {
			echo ".simple-slide-content-wrapper { background: url(" . plugins_url( '', __FILE__ ) . "/images/" . $this->options['sfrs_option_overlay'] . ".png); }";
		}

		// if (is_array($content_array)) { echo "It's an Array!"; }
		// we loop through the available media queries as required
		foreach ( $queries as $query => $value ) {
			echo $value . " {";
			$j = $i;
			foreach ( $this->content as $slide ) {
				echo ".simple-slide-" . $j . " { background: url(" . $slide[$query][0] . "); }";
				$j--;
			}
			echo "}";
		}

		echo '</style>';
	}

	/**
	 * This function echos css into the head area of the homepage while simultaneously
	 * loading a variable with the slider data for inclusion later.
	 * 
	 * @global type $content
	 */
	public function output_regular_post_thumbnails_styling() {

		// Setup our loop
		$slide_query = new WP_Query( array( 'post_type' => 'sfrs_slider', 'orderby' => 'date', 'order' => 'DESC' ) );

		$i = 0; // Total number of slides (posts)

		/*
		 * Loop through each post in the slider to collect information.
		 */
		while ( $slide_query->have_posts() ) {
			$slide_query->the_post();

			/*
			 * Check for a post thumbnail and load the content array
			 */
			if ( has_post_thumbnail() ) {
				$thumb_id = get_post_thumbnail_id( get_the_ID() );
				$this->content[$i]['background'] = wp_get_attachment_url( $thumb_id );
			}

			/*
			 * Grab the title and content for each slide on the way out the door.
			 */
			$this->content[$i]['title'] = get_the_title();
			$this->content[$i]['content'] = get_the_content();
			$i++;
		}

		wp_reset_postdata(); // Cleanup
		// Open our style header
		echo "<style type='text/css'>\n";

		// sfrs_option_css includes custom styles chosen by the user
		echo sanitize_text_field( $this->options['sfrs_option_css'] );

		// Add an overlay class if chosen
		if ( isset( $this->options['sfrs_option_overlay'] ) && (!empty( $this->options['sfrs_option_overlay'] ) ) ) {
			echo ".simple-slide-content-wrapper { background: url(" . plugins_url( '', __FILE__ ) . "/images/" . $this->options['sfrs_option_overlay'] . ".png); }";
		}

		// Loop through slide backgrounds
		foreach ( $this->content as $slide ) {
			echo ".simple-slide-" . $i . " { background: url(" . $slide['background'] . "); }\n";
			$i--;
		}

		// Close our styles
		echo '</style>';
	}

	/**
	 * Outputs the required markup to create the slider
	 * 
	 * @global type $content
	 */
	public function output_slider_content() {
		echo '<div id="simple-slider">';
		$this->content = array_reverse( $this->content );

		$i = 1; // Slide counter

		foreach ( $this->content as $slide ) {
			echo '<div class="simple-slide simple-slide-' . $i . '">';
			echo '<div class="simple-slide-content-wrapper">';
			echo '<div class="simple-slide-content">';

			if ( $this->options['sfrs_option_show_title'] == 'yes' ) {
				echo '<h2>' . $slide["title"] . '</h2>';
			}

			if ( $this->options['sfrs_option_text_formatting'] == 'off' ) {
				echo $slide['content'];
			} else {
				echo wpautop( wptexturize( $slide['content'] ) );
			}
			echo '</div>';
			echo '</div>';
			echo '</div>';
			$i++;
		}

		echo '<div class="fader_controls">';
		echo '<div class="pager prev" data-target="prev">&lsaquo;</div>';
		echo '<div class="pager next" data-target="next">&rsaquo;</div>';
		echo '<ul class="pager-list"></ul>';
		echo '</div>';
		echo '</div>';
	}

	/**
	 * Output the jquery in footer to start the jQuery plugin
	 */
	public function output_footer_content() {
		echo '<script type="text/javascript">';
		echo 'jQuery(document).ready(function($) { $("#simple-slider").easyFader({autoCycle: true, slideSelector: \'.simple-slide\', ';

		if ( $this->options['sfrs_option_effects'] ) {
			echo "effect: '" . $this->options['sfrs_option_effects'] . "',";
		}

		if ( $this->options['sfrs_option_slideDur'] ) {
			echo "slideDur: '" . $this->options['sfrs_option_slideDur'] . "',";
		}

		if ( $this->options['sfrs_option_effectDur'] ) {
			echo "effectDur: '" . $this->options['sfrs_option_effectDur'] . "'";
		}

		echo '});});</script>';
	}

}

$sfrs_slider_class = new SFRS_Slider();
