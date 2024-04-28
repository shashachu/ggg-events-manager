<?php
/* GGG Modification: Input to show RSVP/Decline date */
global $EM_Event, $post;
$required = apply_filters('em_required_html','<i>*</i>');
?>
<div class="event-form-when" id="em-form-when">
	<p>
		<span class="em-ec-rsvp-date-normal">
			<span class="em-date-single">
				<input id="em-ec-rsvp-date-loc" class="em-date-input-loc" type="text" />
				<input id="em-ec-rsvp-date" class="em-date-input" type="hidden" name="event_ec_rsvp_date" value="<?php echo $EM_Event->event_ec_rsvp_date; ?>" />
			</span>
		</span>
	</p>
	<span id='event-date-explanation'>
	<?php esc_html_e( 'This is the date the ER has requested an RSVP. Separate from the Booking Cut-off Date, and defaults to the event start date if not specified.', 'events-manager'); ?>
	</span>
</div>