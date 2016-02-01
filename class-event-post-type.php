<?php
/**
 * class-event-post-type.php
 * @internal Description needed.
 * @package Events Calendar
 * @since 7.0
 * @author Luke Howell <luke.howell@gmail.com>
 * @copyright Copyright (c) 2007-2012 Luke Howell
 * @license GPLv2 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 */
 
/**
 * Event Post Type
 * @internal Complete description
 * @package events-calendar
 * @since 7.0
 * @author Luke Howell <luke.howell@gmail.com>
 */
if( !class_exists( 'WPEC_Event_Post_Type' ) ) :
class WPEC_Event_Post_Type
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
		
		add_action( 'init', array( &$this, 'register_event_post_type' ) );
		
		add_action( 'admin_init', array( &$this, 'add_custom_meta_boxes' ) );
		
		add_action( 'save_post', array( &$this, 'save_custom_meta_boxes' ) );
		
		add_action( 'admin_print_scripts-post.php', array( &$this, 'enqueue_scripts' ) );
		
		add_action( 'admin_print_scripts-post.php', array( &$this, 'enqueue_styles' ) );
		
		add_action( 'admin_print_scripts-post-new.php', array( &$this, 'enqueue_scripts' ) );
		
		add_action( 'admin_print_scripts-post-new.php', array( &$this, 'enqueue_styles' ) );

		add_filter( 'post_updated_messages', array( &$this, 'customize_update_messages' ) );
		
	}
	
	/**
	 * Registers the event post type
	 * @internal Complete description
	 * @since 7.0
	 * @author Luke Howell <luke.howell@gmail.com>
	 */
	function register_event_post_type()
	{
		
		$options = get_option( 'wpec_options' );
		$post_type_slug = $options[ 'post_type_slug' ];
				
		// Call built in WordPress function to register post type
		register_post_type(
			$post_type_slug,
			array(
				'labels' => array(
					'name' => _x( 'Events', 'post type general name', WPEC_L10N ),
					'singular_name' => _x( 'Event', 'post type singular name', WPEC_L10N ),
					'add_new' => _x( 'Add New', 'wpec_event', WPEC_L10N ),
					'add_new_item' => __( 'Add New Event', WPEC_L10N ),
					'edit_item' => __( 'Edit Event', WPEC_L10N ),
					'new_item' => __( 'New Event', WPEC_L10N ),
					'view_item' => __( 'View Event', WPEC_L10N ),
					'search_items' => __( 'Search Events', WPEC_L10N ),
					'not_found' => __( 'No events found', WPEC_L10N ),
					'not_found_in_trash' => __( 'No events found in Trash', WPEC_L10N )
				),
				'description' => __( 'Events that can be displayed for your visitors to see.', WPEC_L10N ),
				'public' => true,
				'menu_icon' => WPEC_IMG_URL . 'menu_icon.gif',
				'has_archive' => true
			)
		);
		
		flush_rewrite_rules();
		
	}
	
	/**
	 * Add JS for custom post type
	 * @internal Complete description
	 * @since 7.0
	 * @author Luke Howell <luke.howell@gmail.com>
	 * @global $post_type
	 */
	function enqueue_scripts()
	{
		
		global $post_type;
		
		$options = get_option( 'wpec_options' );
		$post_type_slug = $options[ 'post_type_slug' ];
		
		if( $post_type_slug != $post_type )
			return;
			
		wp_enqueue_script( 'ec-jquery-ui-custom', WPEC_JS_URL . 'jquery-ui-1.8.23.custom.min.js', 'jquery' );
		
		wp_enqueue_script( 'ec-event-custom-post-type', WPEC_JS_URL . 'event-custom-post-type.js', 'ec-jquery-ui-custom' );
		
	}

	/**
	 * Add CSS for custom post type
	 * @internal Complete description
	 * @since 7.0
	 * @author Luke Howell <luke.howell@gmail.com>
	 * @global $post_type
	 */
	function enqueue_styles()
	{
		
		global $post_type;
		
		$options = get_option( 'wpec_options' );
		$post_type_slug = $options[ 'post_type_slug' ];
		
		if( $post_type_slug != $post_type )
			return;
			
		wp_enqueue_style( 'ec-jquery-ui-theme', WPEC_CSS_URL . 'jquery-ui/smoothness/jquery-ui-1.8.23.custom.css' );
		
		wp_enqueue_style( 'ec-style', WPEC_CSS_URL . 'admin-style.php' );
		
	}

	/**
	 * Customize update messages for custom post type
	 * @internal Complete description
	 * @since 7.0
	 * @author Luke Howell <luke.howell@gmail.com>
	 * @global $post
	 * @global @post_ID
	 */
	function customize_update_messages( $message )
	{
		
		global $post, $post_ID;
		
		$options = get_option( 'wpec_options' );
		$post_type_slug = $options[ 'post_type_slug' ];
		
		$messages[ $post_type_slug ] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => sprintf( __( 'Event updated. <a href="%s">View event</a>' ), esc_url( get_permalink( $post_ID ) ) ),
			2 => __( 'Custom field updated.' ),
			3 => __( 'Custom field deleted.' ),
			4 => __( 'Event updated.' ),
			/* translators: %s: date and time of the revision */
			5 => isset( $_GET[ 'revision' ] ) ? sprintf( __( 'Event restored to revision from %s' ), wp_post_revision_title( ( int ) $_GET[ 'revision' ], false ) ) : false,
			6 => sprintf( __( 'Event published. <a href="%s">View event</a>' ), esc_url( get_permalink( $post_ID ) ) ),
			7 => __( 'Event saved.' ),
			8 => sprintf( __( 'Event submitted. <a target="_blank" href="%s">Preview event</a>' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
			9 => sprintf( __( 'Event scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview event</a>' ),
				// translators: Publish box date format, see http://php.net/date
				date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
			10 => sprintf( __( 'Event draft updated. <a target="_blank" href="%s">Preview event</a>' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) )
		);
		
		return $messages;
		
	}

	/**
	 * Adds custom meta boxes
	 * @internal Complete description
	 * @since 7.0
	 * @author Luke Howell <luke.howell@gmail.com>
	 */
	function add_custom_meta_boxes()
	{
		
		$options = get_option( 'wpec_options' );
		$post_type_slug = $options[ 'post_type_slug' ];
		
		add_meta_box( 'event-date-time-custom-meta-box', __( 'Event Date and Time', WPEC_L10N ), array( &$this, 'create_date_time_meta_box' ), $post_type_slug, 'side' );
		
	}
	
	/**
	 * Save meta information
	 * @internal Complete description
	 * @internal Complete functionality
	 */
	function save_custom_meta_boxes()
	{
		
	}

	/**
	 * Create custom meta box for date and time
	 * @internal Complete description
	 * @internal Date will have to be pulled when determined
	 * @since 7.0
	 * @author Luke Howell <luke.howell@gmail.com>
	 */
	function create_date_time_meta_box()
	{
		
		$startdate = '';//get_post_meta( $post->ID, 'startdate', true );
		$starttimehour = '';//get_post_meta( $post->ID, 'starttimehour', true );
		$starttimehour = empty( $starttimehour ) ? '12' : $starttimehour;
		$starttimeminute = '';//get_post_meta( $post->ID, 'starttimeminute', true );
		$starttimeminute = empty( $starttimeminute ) ? '0' : $starttimeminute;
		$starttimeampm = '';//get_post_meta( $post->ID, 'starttimeampm', true );
		$starttimeampm = empty( $starttimeampm ) ? 'am' : $starttimeampm;
		$enddate = '';//get_post_meta( $post->ID, 'enddate', true );
		$endtimehour = '';//get_post_meta( $post->ID, 'endtimehour', true );
		$endtimehour = empty( $endtimehour ) ? '12' : $endtimehour;
		$endtimeminute = '';//get_post_meta( $post->ID, 'endtimeminute', true );
		$endtimeminute = empty( $endtimeminute ) ? '0' : $endtimeminute;
		$endtimeampm = '';//get_post_meta( $post->ID, 'endtimeampm', true );
		$endtimeampm = empty( $endtimeampm ) ? 'am' : $endtimeampm;
		
		?>
		<div>
			<p>
				<label for="startdate"><?php _e( 'Start Date', WPEC_L10N ); ?> (YYYY-MM-DD)<br>
					<input id="startdate" name="startdate" value="<?php echo $startdate ? $startdate : ''; ?>">
				</label>
				<label for="allday">
					<input type="checkbox" id="allday" name="allday"> <?php _e( 'All day?', WPEC_L10N ); ?>
				</label>
			</p>
		</div>
		<div class="eventtime">
			<p>
				<label for="starttime"><?php _e( 'Start Time', WPEC_L10N ); ?><br>
					<select id="starttimehour" name="starttimehour">
						<?php 
						for( $i = 1; $i <= 12; $i++ )
						{
							$selected = ( $i == $starttimehour ) ? ' selected="selected"' : '';
							echo "<option value=\"$i\"$selected>$i</option>";
						}
						?>
					</select>
					<select id="starttimeminute" name="starttimeminute">
						<?php 
						for( $i = 0; $i <= 55; $i += 5 )
						{
							$selected = ( $i == $starttimeminute ) ? ' selected="selected"' : '';
							$zero = $i < 10 ? 0 : '';
							echo "<option value=\"$i\"$selected>$zero$i</option>";
						}
						?>
					</select>
					<select id="starttimeampm" name="starttimeampm">
						<option value="am"<?php echo $starttimeampm == 'am' ? ' selected="selected"' : '';?>><?php _e( 'AM', WPEC_L10N ); ?></option>
						<option value="pm"<?php echo $starttimeampm == 'pm' ? ' selected="selected"' : '';?>><?php _e( 'PM', WPEC_L10N ); ?></option>
					</select>
					<div id="starttimeslider"></div>
				</label>
			</p>
		</div>
		<div>
			<p>
				<label for="enddate"><?php _e( 'End Date', WPEC_L10N ); ?>  (YYYY-MM-DD)<br>
					<input id="enddate" name="enddate" value="<?php echo $enddate ? $enddate : ''; ?>">
				</label>
			</p>
		</div>
		<div class="eventtime">
			<p>
				<label for="endtime"><?php _e( 'End Time', WPEC_L10N ); ?><br>
					<select id="endtimehour" name="endtimehour">
						<?php 
						for( $i = 1; $i <= 12; $i++ )
						{
							$selected = ( $i == $endtimehour ) ? ' selected="selected"' : '';
							echo "<option value=\"$i\"$selected>$i</option>";
						}
						?>
					</select>
					<select id="endtimeminute" name="endtimeminute">
						<?php 
						for( $i = 0; $i <= 55; $i += 5 )
						{
							$selected = ( $i == $endtimeminute ) ? ' selected="selected"' : '';
							$zero = $i < 10 ? 0 : '';
							echo "<option value=\"$i\"$selected>$zero$i</option>";
						}
						?>
					</select>
					<select id="endtimeampm" name="endtimeampm">
						<option value="am"<?php echo $endtimeampm == 'am' ? ' selected="selected"' : '';?>><?php _e( 'AM', WPEC_L10N ); ?></option>
						<option value="pm"<?php echo $endtimeampm == 'pm' ? ' selected="selected"' : '';?>><?php _e( 'PM', WPEC_L10N ); ?></option>
					</select>
					<div id="endtimeslider"></div>
				</label>
			</p>
		</div>
		<?php
	}
	
}
endif;
