<?php
/* @var $EM_Event EM_Event */
$people = array();
$EM_Bookings = $EM_Event->get_bookings();
if( count($EM_Bookings->bookings) > 0 ){
	?>
	<ul class="event-attendees">
	<?php
	foreach( $EM_Bookings as $EM_Booking){ /* @var $EM_Booking EM_Booking */
		if($EM_Booking->booking_status == 1 && !in_array($EM_Booking->get_person()->ID, $people) ){
			$people[] = $EM_Booking->get_person()->ID;
			$ticket_bookings = $EM_Booking->get_tickets_bookings();
			$ticket_type = $EM_Booking->booking_comment;
			if (empty($ticket_type) && count($ticket_bookings) > 0) {
				foreach ($EM_Booking->get_tickets_bookings()->tickets_bookings as $EM_Ticket_Booking) {
					if ($EM_Ticket_Booking->get_spaces() > 0) {
						$ticket_type = EM_Ticket::get_ticket_name($EM_Ticket_Booking->ticket_id);
						break;
					}
				}
			}
			echo '<li>'. $EM_Booking->get_person()->get_name() . ' - ' . $ticket_type .'</li>';
		}elseif($EM_Booking->booking_status == 1 && $EM_Booking->is_no_user() ){
			echo '<li>'. $EM_Booking->get_person()->get_name() .'</li>';
		}
	}
	?>
	</ul>
	<?php
}