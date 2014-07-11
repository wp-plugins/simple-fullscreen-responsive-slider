<?php

/**
 * Options Class
 *
 * @package simple-fullscreen-responsive-slider
 */
class SFRS_Options {

	/**
	 * Holds values to be used in the fields callbacks.
	 */
	private $options;

	/**
	 * Start up
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );
	}

	/**
	 * Adds Setttings > Slider Options page
	 */
	public function add_options_page() {
		add_options_page(
				__( 'SFRS Options', 'simple-fullscreen-responsive-slider' ),
				__( 'Simple Slider', 'simple-fullscreen-responsive-slider' ),
				'manage_options',
				'sfrs-options',
				array( $this, 'create_options_page' )
		);
	}

	/**
	 * Options page callback
	 */
	public function create_options_page() {
		// Load existing options
		$this->options = get_option( 'sfrs_options' );

		echo '<div class="wrap">';
		echo '<h2>' . __('Simple Fullscreen Responsive Slider (SFRS) Options', 'simple-fullscreen-responsive-slider') . '</h2>';
		echo '<form method="post" action="options.php">';
		settings_fields( 'sfrs_options_group' );					// Print all hidden settings fields
		do_settings_sections( 'sfrs-options' );						// Replace form field markup
		submit_button();											// Add the save settings button
		echo '</form></div>';
	}

	/**
	 * Register and add settings
	 */
	public function page_init() {

		/*
		 * Register slider settings in the options table
		 */
		register_setting( 'sfrs_options_group', 'sfrs_options', array( $this, 'sanitize' ) );

		/*
		 * Slider configuration settings such as effect, duration, etc.
		 */
		add_settings_section(
				'sfrs_section_configuration',
				__('Configuration:', 'simple-fullscreen-responsive-slider'),
				'',
				'sfrs-options'
				);

		/*
		 * Slider transition effect
		 */
		add_settings_field(
				'sfrs_option_effects',
				__('Slide Effect', 'simple-fullscreen-responsive-slider'),
				array( $this, 'cb_create_select' ),
				'sfrs-options',
				'sfrs_section_configuration',
				array(
					'sfrs_option_effects', 
					__('Choose the slider\'s transition effect.', 'simple-fullscreen-responsive-slider'),
					__('Fade', 'simple-fullscreen-responsive-slider'),
					array(
						__('Fade', 'simple-fullscreen-responsive-slider') => 'fade',
						__('Slide', 'simple-fullscreen-responsive-slider') => 'slide'
					)
				)
		);

		// Allows user to define the slide duration
		add_settings_field(
				'sfrs_option_slideDur',
				__('Slide Duration', 'simple-fullscreen-responsive-slider'),
				array( $this, 'cb_create_text_input' ),
				'sfrs-options',
				'sfrs_section_configuration',
				array( 'sfrs_option_slideDur',
					__('Set the duration of each slide (in milliseconds). Default: 7000', 'simple-fullscreen-responsive-slider'),
					'7000'
				)
		);

		// Allows user to define the slide's effect duration
		add_settings_field(
				'sfrs_option_effectDur',
				__('Effect Duration', 'simple-fullscreen-responsive-slider'),
				array( $this, 'cb_create_text_input' ),
				'sfrs-options',
				'sfrs_section_configuration',
				array(
					'sfrs_option_effectDur',
					__('Set the duration of each transition effect (in milliseconds). Default: 800', 'simple-fullscreen-responsive-slider'),
					'800'
				)
		);

		/*
		 * Slider grid overlay
		 */
		add_settings_field(
				'sfrs_option_overlay',
				__('Overlay', 'simple-fullscreen-responsive-slider'),
				array( $this, 'cb_create_select' ),
				'sfrs-options',
				'sfrs_section_configuration',
				array(
					'sfrs_option_overlay',
					__('Choose an overlay. Default: None', 'simple-fullscreen-responsive-slider'),
					__('None', 'simple-fullscreen-responsive-slider'),
					array(
						__('None', 'simple-fullscreen-responsive-slider') => '',
						__('Black Dots', 'simple-fullscreen-responsive-slider') => 'overlay-dots-black',
						__('White Dots', 'simple-fullscreen-responsive-slider') => 'overlay-dots-white',
						__('Grid Black', 'simple-fullscreen-responsive-slider') => 'overlay-grid-black',
						__('Grid White', 'simple-fullscreen-responsive-slider') => 'overlay-grid-white',
						__('Black Scanlines', 'simple-fullscreen-responsive-slider') => 'overlay-scanlines-black',
						__('White Scanlines', 'simple-fullscreen-responsive-slider') => 'overlay-scanlines-white'
					)
				)
		);

		/*
		 * Slider title field
		 */
		add_settings_field(
				'sfrs_option_show_title',
				__('Show Title', 'simple-fullscreen-responsive-slider'),
				array( $this, 'cb_create_select' ),
				'sfrs-options',
				'sfrs_section_configuration',
				array(
					'sfrs_option_show_title',
					__('If you don\'t show the title you can include a heading tag in the body of the slide post instead. Default: Yes', 'simple-fullscreen-responsive-slider'),
					__('Yes', 'simple-fullscreen-responsive-slider'),
					array(
						__('Yes', 'simple-fullscreen-responsive-slider') => 'yes',
						__('No', 'simple-fullscreen-responsive-slider') => 'no'
					)
				)
		);

		/*
		 * Slider title field
		 */
		add_settings_field(
				'sfrs_option_text_formatting',
				__('Text Formatting', 'simple-fullscreen-responsive-slider'),
				array( $this, 'cb_create_select' ),
				'sfrs-options',
				'sfrs_section_configuration',
				array(
					'sfrs_option_text_formatting',
					__('You can turn off "wpautop" and "wptexturize" if you wish. Default: On', 'simple-fullscreen-responsive-slider'),
					__('On', 'simple-fullscreen-responsive-slider'),
					array(
						__('On', 'simple-fullscreen-responsive-slider') => 'on',
						__('Off', 'simple-fullscreen-responsive-slider') => 'off'
					)
				)
		);

		if ( !isset( $this->options['sfrs_option_css'] ) ) {
			$preload = file_get_contents( trailingslashit( dirname( __FILE__ ) ) . 'stylesheets/preload.css' );
		}

		add_settings_field(
				'sfrs_option_css',
				__('Your CSS', 'simple-fullscreen-responsive-slider'),
				array( $this, 'cb_create_textarea' ),
				'sfrs-options',
				'sfrs_section_configuration',
				array(
					'sfrs_option_css',
					__('Enter your custom CSS here (or use inline CSS as you create each slide).', 'simple-fullscreen-responsive-slider'),
					$preload
				)
		);
	}

	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 */
	public function sanitize( $input ) {

		$new_input = array();

		if ( isset( $input['sfrs_option_effects'] ) ) {
			$new_input['sfrs_option_effects'] = sanitize_text_field( $input['sfrs_option_effects'] );
		}

		if ( isset( $input['sfrs_option_slideDur'] ) ) {
			$new_input['sfrs_option_slideDur'] = absint( $input['sfrs_option_slideDur'] );
		}

		if ( isset( $input['sfrs_option_effectDur'] ) ) {
			$new_input['sfrs_option_effectDur'] = absint( $input['sfrs_option_effectDur'] );
		}

		if ( isset( $input['sfrs_option_overlay'] ) ) {
			$new_input['sfrs_option_overlay'] = sanitize_text_field( $input['sfrs_option_overlay'] );
		}

		if ( isset( $input['sfrs_option_show_title'] ) ) {
			if ( ($input['sfrs_option_show_title'] === 'yes') || ($input['sfrs_option_show_title'] === 'no') ) {
				$new_input['sfrs_option_show_title'] = $input['sfrs_option_show_title'];
			}
		}

		if ( isset( $input['sfrs_option_text_formatting'] ) ) {
			if ( ($input['sfrs_option_text_formatting'] === 'on') || ($input['sfrs_option_text_formatting'] === 'off') ) {
				$new_input['sfrs_option_text_formatting'] = $input['sfrs_option_text_formatting'];
			}
		}

		if ( isset( $input['sfrs_option_css'] ) ) {
			$input['sfrs_option_css'] = str_replace( "\n", "-SFRSLB-", $input['sfrs_option_css'] );
			$input['sfrs_option_css'] = sanitize_text_field( $input['sfrs_option_css'] );
			$new_input['sfrs_option_css'] = str_replace( "-SFRSLB-", "\n", $input['sfrs_option_css'] );
		}

		return $new_input;
	}

	/**
	 * Callback to create a text field
	 * 
	 * @param type $args
	 */
	public function cb_create_text_input( $args ) {
		printf(
				'<input type="text" name="sfrs_options[' . $args[0] . ']" value="%s" />', isset( $this->options[$args[0]] ) ? esc_attr( $this->options[$args[0]] ) : $args[2]
		);
		if ( !empty( $args[1] ) ) {
			echo '<p class="description">' . $args[1] . '</p>';
		}
	}

	/**
	 * Callback to create a textarea
	 * 
	 * @param type $args
	 */
	public function cb_create_textarea( $args ) {
		printf(
				'<textarea cols="90" rows="15" name="sfrs_options[' . $args[0] . ']">%s</textarea>', isset( $this->options[$args[0]] ) ? esc_attr( $this->options[$args[0]] ) : $args[2]
		);
		if ( !empty( $args[1] ) ) {
			echo '<p class="description">' . $args[1] . '</p>';
		}
	}

	/**
	 * Callback to create a select field
	 * 
	 * @param type $args
	 */
	public function cb_create_select( $args ) {
		echo '<select name="sfrs_options[' . $args[0] . ']">';
		if ( isset( $this->options[$args[0]] ) ) {
			$check = $this->options[$args[0]];
		} else {
			$check = $args[2];
		}

		foreach ( $args[3] as $description => $option ) {
			printf(
					'<option value="' . $option . '" %s>' . $description . '</option>', ($check == $option) ? 'selected' : ''
			);
		}
		echo '</select>';
		if ( !empty( $args[1] ) ) {
			echo '<p class="description">' . $args[1] . '</p>';
		}
	}

	/**
	 * Callback to create a select field
	 * 
	 * @param type $args
	 */
	public function cb_create_radio_input( $args ) {
		if ( isset( $this->options[$args[0]] ) ) {
			$check = $this->options[$args[0]];
		} else {
			$check = $args[2];
		}

		foreach ( $args[3] as $description => $option ) {
			printf(
					'<p><label><input type="radio" name="sfrs_options[' . $args[0] . ']" value="' . $option . '" %s>' . $description . '</label></p>', ($check == $option) ? 'checked' : ''
			);
		}
	}
	
	public function reset_slider_options() {

		
		delete_option( 'sfrs_options' );
	}

}

if ( is_admin() ) {
	$sfrs_options_class = new SFRS_Options();
}