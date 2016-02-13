<?php
/**
 * List View Single Event
 * This file contains one event in the list view
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
// Setup an array of venue details for use later in the template
$venue_details = tribe_get_venue_details();
// Venue
$has_venue_address = ( ! empty( $venue_details['address'] ) ) ? ' location' : '';
// Organizer
$organizer = tribe_get_organizer();
?>
<!-- Event Cost -->
<?php if ( tribe_get_cost() ) : ?>
	<div class="tribe-events-event-cost" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
		<meta itemprop="priceCurrency" content="USD" />
		<meta itemprop="url" content="<?php echo tribe_get_event_website_url( $event ); ?>" />
		<meta itemprop="price" content="<?php echo tribe_get_cost( null, false ); ?>" />
<!--
		<meta itemprop="availability" content="" />
		<meta itemprop="category" content="" />
		<meta itemprop="validFrom" content="" />
		<meta itemprop="validThrough" content="" />
-->
		<span><?php echo tribe_get_cost( null, true ); ?></span>
	</div>
<?php endif; ?>
<!-- Event Title -->
<?php do_action( 'tribe_events_before_the_event_title' ) ?>
<h2 class="tribe-events-list-event-title" itemprop="name">
	<a class="tribe-event-url" href="<?php echo esc_url( tribe_get_event_link() ); ?>" title="<?php the_title_attribute() ?>" rel="bookmark">
		<?php the_title() ?>
	</a>
</h2>
<?php do_action( 'tribe_events_after_the_event_title' ) ?>
<!-- Event Meta -->
<?php do_action( 'tribe_events_before_the_meta' ) ?>
<div class="tribe-events-event-meta">
	<div class="author <?php echo esc_attr( $has_venue_address ); ?>">
		<!-- Schedule & Recurrence Details -->
		<div class="tribe-event-schedule-details">
			<span class="tribe-event-date-start">
				<meta itemprop="startDate" content="<?php echo tribe_get_start_date( null, false, 'c' ) ?>" />
				<time datetime="<?php echo tribe_get_start_date( null, false, 'c' ) ?>">
					<?php 
						$time_format = get_option( 'time_format', Tribe__Date_Utils::TIMEFORMAT );
						$start_date = tribe_get_start_date( null, false );
						$start_time = tribe_get_start_date( null, false, $time_format );
						echo $start_date.' @ '.$start_time; 
					?>
				</time>
			</span> - 
			<span class="tribe-event-date-end">
				<meta itemprop="endDate" content="<?php echo tribe_get_end_date( null, false, 'c' ) ?>" />
				<time datetime="<?php echo tribe_get_end_date( null, false, 'c' ) ?>">
					<?php 
						$end_date = tribe_get_display_end_date( null, false );
						$end_time = tribe_get_end_date( null, false, $time_format );
						echo $end_date.' @ '.$end_time; 
					?>
				</time>
			</span>
		</div>
		<?php if ( $venue_details ) : ?>
			<!-- Venue Display Info -->
			<div class="tribe-events-venue-details">
				<div itemprop="location" itemscope itemtype="http://schema.org/Place">
					<div itemprop="name"><?php echo $venue_details['name']; ?></div>
					<?php echo $venue_details['address']; ?>
				</div>
			</div> <!-- .tribe-events-venue-details -->
		<?php endif; ?>
	</div>
</div><!-- .tribe-events-event-meta -->
<?php do_action( 'tribe_events_after_the_meta' ) ?>
<!-- Event Image -->
<?php echo tribe_event_featured_image( null, 'medium' ) ?>
<!-- Event Content -->
<?php do_action( 'tribe_events_before_the_content' ) ?>
<div class="tribe-events-list-event-description tribe-events-content">
	<?php echo tribe_events_get_the_excerpt(); ?>
	<a href="<?php echo esc_url( tribe_get_event_link() ); ?>" class="tribe-events-read-more" rel="bookmark" itemprop="mainEntityOfPage">
		<?php esc_html_e( 'Find out more', 'the-events-calendar' ) ?> &raquo;
	</a>
</div><!-- .tribe-events-list-event-description -->
<?php
do_action( 'tribe_events_after_the_content' );
