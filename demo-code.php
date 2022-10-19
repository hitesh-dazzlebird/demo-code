<?php
/**
 * Single Event Meta (Details) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/details.php
 *
 * @link http://evnt.is/1aiy
 *
 * @package TribeEventsCalendar
 *
 * @version 4.6.19
 */


$event_id             = Tribe__Main::post_id_helper();
$time_format          = get_option( 'time_format', Tribe__Date_Utils::TIMEFORMAT );
$time_range_separator = tribe_get_option( 'timeRangeSeparator', ' - ' );
$show_time_zone       = tribe_get_option( 'tribe_events_timezones_show_zone', false );
$local_start_time     = tribe_get_start_date( $event_id, true, Tribe__Date_Utils::DBDATETIMEFORMAT );
$time_zone_label      = Tribe__Events__Timezones::is_mode( 'site' ) ? Tribe__Events__Timezones::wp_timezone_abbr( $local_start_time ) : Tribe__Events__Timezones::get_event_timezone_abbr( $event_id );

$start_datetime = tribe_get_start_date();
$start_date = tribe_get_start_date( null, false );
$start_time = tribe_get_start_date( null, false, $time_format );
$start_ts = tribe_get_start_date( null, false, Tribe__Date_Utils::DBDATEFORMAT );

$end_datetime = tribe_get_end_date();
$end_date = tribe_get_display_end_date( null, false );
$end_time = tribe_get_end_date( null, false, $time_format );
$end_ts = tribe_get_end_date( null, false, Tribe__Date_Utils::DBDATEFORMAT );

$time_formatted = null;
if ( $start_time == $end_time ) {
	$time_formatted = esc_html( $start_time );
} else {
	$time_formatted = esc_html( $start_time . $time_range_separator . $end_time );
}

/**
 * Returns a formatted time for a single event
 *
 * @var string Formatted time string
 * @var int Event post id
 */
$time_formatted = apply_filters( 'tribe_events_single_event_time_formatted', $time_formatted, $event_id );

/**
 * Returns the title of the "Time" section of event details
 *
 * @var string Time title
 * @var int Event post id
 */
$time_title = apply_filters( 'tribe_events_single_event_time_title', __( 'Start Time:', 'the-events-calendar' ), $event_id );

$cost    = tribe_get_formatted_cost();
$website = tribe_get_event_website_link( $event_id );
$website_title = tribe_events_get_event_website_title();
$weburl = tribe_get_event_website_url($event_id);
?>

<div class="tribe-events-meta-group tribe-events-meta-group-details">
	<!-- <h2 class="tribe-events-single-section-title"> <?php //esc_html_e( 'Details', 'the-events-calendar' ); ?> </h2> -->
	<h2><?php echo esc_html( get_the_title() ); ?></h2>
	<dl>

		<?php
		do_action( 'tribe_events_single_meta_details_section_start' );

		// All day (multiday) events
		if ( tribe_event_is_all_day() && tribe_event_is_multiday() ) :
			?>
		<div class="single_event_card_details">
			<dt class="tribe-events-start-date-label"> <?php esc_html_e( 'Start:', 'the-events-calendar' ); ?> </dt>
			<dd>
				<abbr class="tribe-events-abbr tribe-events-start-date published dtstart" title="<?php echo esc_attr( $start_ts ); ?>"> <?php echo esc_html( $start_date ); ?> </abbr>
			</dd>
		</div>
		<div class="single_event_start_card_details"> 
			<dt class="tribe-events-end-date-label"> <?php esc_html_e( 'End:', 'the-events-calendar' ); ?> </dt>
			<dd>
				<abbr class="tribe-events-abbr tribe-events-end-date dtend" title="<?php echo esc_attr( $end_ts ); ?>"> <?php echo esc_html( $start_time ); ?> </abbr>
			</dd>
		</div>

		<?php
		// All day (single day) events
	elseif ( tribe_event_is_all_day() ):
			// echo "multiple day";
		
		
		
		?>

		<dt class="tribe-events-start-date-label"> <?php esc_html_e( 'Date:', 'the-events-calendar' ); ?> </dt>
		<dd>
			<abbr class="tribe-events-abbr tribe-events-start-date published dtstart" title="<?php echo esc_attr( $start_ts ); ?>"> <?php echo esc_html( $start_date ); ?> </abbr>
		</dd>

		<?php
		// Multiday events
	elseif ( tribe_event_is_multiday() ) :
		
		
		?>
		<div class="single_event_card_details">
			<dt class="tribe-events-start-datetime-label"> <?php esc_html_e( 'Start:', 'the-events-calendar' ); ?> </dt>
			<dd>
				<!-- <abbr class="tribe-events-abbr tribe-events-start-datetime updated published dtstart" title="<?php // echo esc_attr( $start_ts ); ?>"> <?php // echo esc_html( $start_datetime ); ?> </abbr> -->
				<abbr class="tribe-events-abbr tribe-events-start-datetime updated published dtstart" title="<?php echo esc_attr( $start_ts ); ?>"> <?php echo esc_html( $start_date ); ?> </abbr>
				<?php //if ( $show_time_zone ) : ?>
				<!-- <span class="tribe-events-abbr tribe-events-time-zone published "><?php //echo esc_html( $time_zone_label ); ?></span> -->
				<?php //endif; ?>
			</dd>
		</div>

		<div class="single_event_start_card_details">
			<dt class="tribe-events-end-datetime-label"> <?php esc_html_e( 'Time:', 'the-events-calendar' ); ?> </dt>
			<dd>
				<!-- <abbr class="tribe-events-abbr tribe-events-end-datetime dtend" title="<?php //echo esc_attr( $end_ts ); ?>"> <?php //echo esc_html( $end_datetime ); ?> </abbr> -->
				<abbr class="tribe-events-abbr tribe-events-end-datetime dtend" title="<?php echo esc_attr( $end_ts ); ?>"> <?php echo esc_html( $start_time ); ?> </abbr>
				<?php if ( $show_time_zone ) : ?>
					<span class="tribe-events-abbr tribe-events-time-zone published "><?php echo esc_html( $time_zone_label ); ?></span>
				<?php endif; ?>
			</dd>
		</div>

		<?php
		// Single day events
	else :
		?>
		<div class="single_event_card_details">
			<dt class="tribe-events-start-date-label"> <?php esc_html_e( 'Datum:', 'the-events-calendar' ); ?> </dt>
			<dd>
				<abbr class="tribe-events-abbr tribe-events-start-date published dtstart" title="<?php echo esc_attr( $start_ts ); ?>"> <?php echo esc_html( $start_date ); ?> </abbr>
			</dd>
		</div>

		<div class="single_event_start_card_details">
			<dt class="tribe-events-start-time-label"> <?php echo esc_html( $time_title ); //echo esc_html( $time_title ); ?> </dt>
			<dd>
				<div class="tribe-events-abbr tribe-events-start-time published dtstart" title="<?php echo esc_attr( $end_ts ); ?>">
					<?php echo $start_time; ?>	
					<?php // echo $time_formatted; ?>
					<?php //if ( $show_time_zone ) : ?>
					<!-- <span class="tribe-events-abbr tribe-events-time-zone published "><?php //echo esc_html( $time_zone_label ); ?></span> -->
					<?php //endif; ?>
				</div>
			</dd>
		</div>

	<?php endif ?>

	<?php
			tribe_get_template_part( 'modules/meta/venue' ); //Display location
			?>

			<?php
		// Event Cost
			if ( ! empty( $cost ) ) : ?>
				<div class="single_event_cost_card_details">
					<dt class="tribe-events-event-cost-label"> <?php esc_html_e( 'Cost:', 'the-events-calendar' ); ?> </dt>
					<dd class="tribe-events-event-cost"> <?php echo esc_html( $cost ); ?> </dd>
				</div>
			<?php endif ?>

			<?php 

			$event_id = Tribe__Main::post_id_helper();
			$website = tribe_get_event_website_link( $event_id );
			$weburl = tribe_get_event_website_url($event_id);

			if ( ! empty( $website ) ) {
				
				$classes = [
					'tribe-common',
					'event-tickets',
					'tribe-tickets__tickets-wrapper',
					'custom_ticket_details'
				];
				$button_classes = apply_filters(
					'tribe_tickets_ticket_block_submit_classes',
					[
						'tribe-common-c-btn',
						'tribe-common-c-btn--small',
						'get_ticket_button',
						'url_ticket'
					]
				);
				?>
				<div <?php tribe_classes( $classes ); ?>>
					<?php 
					if(!empty(get_field('write_button_text')) && !empty(get_field('ticket_url'))): 
						?>
					<a href="<?php echo esc_url(the_field('ticket_url')); ?>" <?php tribe_classes( $button_classes ); ?>><?php esc_html_e(the_field('write_button_text')); ?></a>
					<?php  
				endif;
				?>
			</div>
			<?php
		}
		?>
		<?php do_action( 'tribe_events_single_meta_details_section_end' ); ?>
	</dl>
</div>
