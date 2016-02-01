<?php
/**
 * class-plugin-settings.php
 * @internal Description needed.
 * @package Events Calendar
 * @since 7.0
 * @author Luke Howell <luke.howell@gmail.com>
 * @copyright Copyright (c) 2007-2012 Luke Howell
 * @license GPLv2 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 */
 
/**
 * Plugin settings
 * @internal Complete description
 * @package events-calendar
 * @since 7.0
 * @author Luke Howell <luke.howell@gmail.com>
 */
if( !class_exists( 'WPEC_Plugin_Settings' ) ) :
class WPEC_Plugin_Settings
{
	
	/**
	 * Constructor
	 * Adds hooks and filters to get things started
	 * @internal Complete description
	 * @since 7.0
	 * @author Luke Howell <luke.howell@gmail.com>
	 */
	function __construct()
	{
		
		add_action( 'admin_menu', array( &$this, 'create_menu' ) );
		
		add_action( 'admin_init', array( &$this, 'register_settings' ) );
		
		add_action( 'update_option_wpec_options', array( &$this, 'options_updated' ), 10, 2 );
		
	}
	
	/**
	 * Create the menu
	 * @internal Complete description
	 * @since 7.0
	 * @author Luke Howell <luke.howell@gmail.com>
	 */
	function create_menu()
	{
		
		add_options_page( 'WP Events Calendar', 'Events Calendar', 'manage_options' ,'wpec', array( &$this, 'settings_page' ) );
		
		
		
	}
	
	/**
	 * Output the settings page
	 * @internal Complete description
	 * @since 7.0
	 * @author Luke Howell <luke.howell@gmail.com>
	 */
	function settings_page()
	{
		
		?>
		<div class="wrap">
			<h2>WP Events Calendar</h2>
			<form method="post" action="options.php">
				<?php settings_fields( 'wpec_options' ); ?>
				<?php do_settings_sections( 'wpec' ); ?>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
		
	}
	
	/**
   * Registers the settings
   * @internal Complete description
   * @since 1.0
   */
  function register_settings()
  {
  	
		// Register the setting
		register_setting( 'wpec_options',
			'wpec_options',
			array( &$this, 'validate_options' ) );
          
	  // Front end settings section
	  add_settings_section( 'wpec-main',
	    __( 'Main Settings', WPEC_L10N ),
	    array( &$this, 'main_section' ),
	    'wpec' );
			
		// Event post type slug
		add_settings_field( 'post_type_slug',
			__( 'Custom Post Slug for Events', WPEC_L10N ),
			array( &$this, 'setting_post_type_slug' ),
			'wpec',
			'wpec-main' );

  }
	
	/**#@+
   * Settings sections
   * @internal Complete description
   */

  /**
   * Main Settings Section
   * @internal Complete description
   * @since 1.0
   */
  function main_section()
  {
          
    ?>
    <p>
    	<?php _e( 'This section is used to edit the main functionality of the plugin.', WPEC_L10N ); ?>
    </p>
    <?php

  }
	
  /**#@-*/
	
	/**
	 * Create setting to change the post type
	 * @internal Complete description
	 * @since 7.0
	 * @author Luke Howell <luke.howell@gmail.com>
	 */
	function setting_post_type_slug()
	{
		
		$options = get_option( 'wpec_options' );
		
		echo "<input id='post_type_slug' name='wpec_options[post_type_slug]' size='40' type='text' value='{$options[ 'post_type_slug' ]}'>";
		
	}
	
	/**
	 * Validate the options
	 * @internal Complete description
	 * @since 7.0
	 * @author Luke Howell <luke.howell@gmail.com>
	 */
	function validate_options( $input )
	{
		
		// Strip slashes and make sure it is not empty
		$input[ 'post_type_slug' ] = str_replace( array( '/', '\\' ), '', $input[ 'post_type_slug' ] );
		$input[ 'post_type_slug' ] = empty( $input[ 'post_type_slug' ] ) ? 'event' : $input[ 'post_type_slug' ];
		
		return $input; 
	}
	
	/**
	 * Run when options are updated
	 * @internal Complete description
	 * @since 7.0
	 * @author Luke Howell <luke.howell@gmail.com>
	 */
	function options_updated( $old_options, $new_options )
	{
		
		if( $old_options[ 'post_type_slug' ] != $new_options[ 'post_type_slug' ] )
		{
			
			$posts = get_posts( array( 'post_type' => $old_options[ 'post_type_slug' ] ) );
			
			foreach( $posts as $post )
			{
					
				set_post_type( $post->ID, $new_options[ 'post_type_slug' ] );
				
			}
			
		}
		
		flush_rewrite_rules();
		
	}
	
}
endif;
