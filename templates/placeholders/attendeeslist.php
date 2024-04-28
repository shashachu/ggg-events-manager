<?php
/* @var $EM_Event EM_Event */
/* GGG Modifications: Separating by ticket type */
$people = array();
$EM_Bookings = $EM_Event->get_bookings();
if( count($EM_Bookings->bookings) > 0 ){
	?>
	<ul class="event-attendees">
	<?php
	$bookings_by_ticket = array();
	foreach( $EM_Bookings as $EM_Booking){ /* @var $EM_Booking EM_Booking */
		if($EM_Booking->booking_status == 1){
			$people[] = $EM_Booking->get_person()->ID;
			$ticket_bookings = $EM_Booking->get_tickets_bookings();
			$ticket_type = $EM_Booking->booking_comment;
			foreach ($EM_Booking->get_tickets_bookings()->tickets_bookings as $EM_Ticket_Booking) {
				if ($EM_Ticket_Booking->get_spaces() > 0) {
					$ticket_name = EM_Ticket::get_ticket_name($EM_Ticket_Booking->ticket_id);
					if (empty($ticket_type) && count((array)$ticket_bookings) > 0) {
						$ticket_type = $ticket_name;
					}
					$bookings_by_ticket[$ticket_name][] = array('name' => $EM_Booking->get_person()->get_name(),
							'ticket_type' => $ticket_type,
							'email' => $EM_Booking->person->user_email);
				}
			}
		}
	}

	foreach ($bookings_by_ticket as $ticket_name => $bookings) {
		$is_costumed = EM_Ticket::is_costumed_ticket($ticket_name);
		echo '<b>' . $ticket_name . '</b>';
		usort($bookings, function($a, $b) {
			$cmp = strcmp($a['ticket_type'], $b['ticket_type']);
			if ($cmp == 0) {
				return strcmp($a['name'], $b['name']);
			} else {
				return $cmp;
			}
		});
		foreach ($bookings as $booking) {
			echo '<li>'. $booking['name'];
			if ($is_costumed) {
				echo ' - ' . $booking['ticket_type'];
			}
			echo '</li>';
		}
	}
	?>
	</ul>

	<div id='emails' style='display:none'>
		<?php
			$firstElem = true;
			foreach ($bookings_by_ticket as $ticket_name => $bookings) {
				foreach ($bookings as $booking) {
					if (!$firstElem) {
						echo '; ';
					} else {
						$firstElem = false;
					}
					echo $booking['email'];
				}
			}
		?>
	</div>

	<script type="text/javascript">
		function selectText(containerid) {
			if (document.selection) { // IE
				var range = document.body.createTextRange();
				range.moveToElementText(document.getElementById(containerid));
				range.select();
			} else if (window.getSelection) {
				var range = document.createRange();
				range.selectNode(document.getElementById(containerid));
				window.getSelection().removeAllRanges();
				window.getSelection().addRange(range);
			}
		}

		function copyEmails() {
			var emailsDiv = document.getElementById("emails");
			emailsDiv.style.display = "block";
			selectText("emails");
			document.execCommand("copy");
			emailsDiv.style.display = "none";
		}
	</script>

	<button onclick="copyEmails()">Copy emails to clipboard</button>

	<?php
}
