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
 * Large Calendar Shortcode
 * @internal Complete description
 * @package events-calendar
 * @since 7.0
 * @author Luke Howell <luke.howell@gmail.com>
 */
if( !class_exists( 'WPEC_Large_Calendar_Shortcode' ) ) :
class WPEC_Large_Calendar_Shortcode
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
		
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_styles' ) );
		
		add_shortcode( 'large-events-calendar', array( &$this, 'write_large_calendar' ) );
		
	}
	
	/**
	 * Enqueue styles
	 * @internal Complete description
	 * @since 7.0
	 * @author Luke Howell <luke.howell@gmail.com>
	 */
	function enqueue_styles()
	{
		
		wp_enqueue_style( 'large-calendar-style', WPEC_CSS_URL . 'style.php' );
		
	}
	
	/**
	 * Writes out the large calendar
	 * @internal Description needed
	 * @since 7.0
	 * @author Luke Howell <luke.howell@gmail.com>
	 */
	function write_large_calendar()
	{
		
		include_once( WPEC_ROOT_PATH . 'calendar-classes/calendar.php' );
		
		$month = isset( $_GET[ 'm' ] ) ? $_GET[ 'm' ] : NULL;
		$year  = isset( $_GET[ 'y' ] ) ? $_GET[ 'y' ] : NULL;
		 
		$calendar = Calendar::factory( $month, $year );
		 
		$event1 = $calendar->event()
		    ->condition( 'timestamp', strtotime( date( 'F' ) . ' 21, ' . date( 'Y' ) ) )
		    ->title( 'Hello All' )
		    ->output( '<a href="http://google.com">Going to Google</a>' );
		     
		$event2 = $calendar->event()
		    ->condition( 'timestamp', strtotime( date( 'F' ) . ' 21, ' . date( 'Y' ) ) )
		    ->title( 'Something Awesome' )
		    ->output( '<a href="http://coreyworrell.com">My Portfolio</a><br />It\'s pretty cool in there.' );
		 
		$calendar->standard( 'today' )
		    ->standard( 'prev-next' )
		    ->standard( 'holidays' )
		    ->attach( $event1 )
		    ->attach( $event2 );
		
		$shortcode_output  = '<table class="large-calendar">';
	  $shortcode_output .= '<thead>';
	  $shortcode_output .= '<tr class="navigation">';
	  $shortcode_output .= '<th class="prev-month"><a href="' . htmlspecialchars( $calendar->prev_month_url() ) . '">' . $calendar->prev_month() . '</a></th>';
	  $shortcode_output .= '<th colspan="5" class="current-month">' . $calendar->month() . $calendar->year . '</th>';
	  $shortcode_output .= '<th class="next-month"><a href="' . htmlspecialchars( $calendar->next_month_url() ) . '">' . $calendar->next_month() . '</a></th>';
		$shortcode_output .= '</tr>';
		$shortcode_output .= '<tr class="weekdays">';
		
		foreach( $calendar->days() as $day ) :
			$shortcode_output .= '<th>' . $day . '</th>';
		endforeach;
		$shortcode_output .= '</tr>';
		$shortcode_output .= '</thead>';
		$shortcode_output .= '<tbody>';
		
		foreach( $calendar->weeks() as $week ) :
			$shortcode_output .= '<tr>';
			
			foreach( $week as $day ) :
				list( $number, $current, $data ) = $day;
				 
				$classes = array();
				$output  = '';
				 
				if( is_array( $data ) )
				{
					$classes = $data[ 'classes' ];
					$title   = $data[ 'title' ];
					$output  = empty( $data[ 'output' ])  ? '' : '<ul class="output"><li>' . implode( '</li><li>', $data[ 'output' ] ) . '</li></ul>';
				}

				$shortcode_output .= '<td class="day ' . implode( ' ', $classes ) . '">';
				$shortcode_output .= '<span class="date" title="' . implode( ' / ', $title ) . '">' .$number . '</span>';
				$shortcode_output .= '<div class="day-content">';
				$shortcode_output .= $output;
				$shortcode_output .= '</div>';
				$shortcode_output .= '</td>';
			endforeach;
			$shortcode_output .= '</tr>';
		endforeach;
		$shortcode_output .= '</tbody>';
		$shortcode_output .= '</table>';
		
		return $shortcode_output;
		
	}
	
}
endif;
