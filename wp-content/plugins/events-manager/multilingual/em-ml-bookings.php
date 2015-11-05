<?php
class EM_ML_Bookings {
    
    public static function init(){
        add_action('em_booking_save_pre','EM_ML_Bookings::em_booking_save_pre',10);
		add_filter('em_event_get_bookings', 'EM_ML_Bookings::override_bookings',100,2);
		add_action('em_booking_form_footer','EM_ML_Bookings::em_booking_form_footer',10,1);
    }
    
    /**
     * @param EM_Booking $EM_Booking
     */
    public static function em_booking_save_pre( $EM_Booking ){
        if( empty($EM_Booking->booking_id) && EM_ML::$current_language != EM_ML::$wplang ){
            $EM_Booking->booking_meta['lang'] = EM_ML::$current_language;
        }
    }
	
	public static function override_bookings($EM_Bookings, $EM_Event){
		$original_event_id = EM_ML::get_original_event_id($EM_Event);
		if( $original_event_id != $EM_Event->event_id ){
		    if( !empty($EM_Bookings->translated) ){
		        //we've already done this before, so we just need to make sure the event id isn't being reset to the translated event id
		        $EM_Bookings->event_id = $original_event_id;
		    }else{
		        //bookings hasn't been 'translated' yet, so we get the original event, get the EM_Bookings object and replace the current event with it. 
    			$EM_Bookings = new EM_Bookings($original_event_id);
    			$EM_Bookings->event_id = $original_event_id;
    			$EM_Bookings->translated = true;
    			//go through tickets and translate to appropriate language
    			$event_lang = EM_ML::get_the_language($EM_Event);
    			foreach($EM_Bookings->get_tickets()->tickets as $EM_Ticket){ /* @var $EM_Ticket EM_Ticket */
    			    if( !empty($EM_Ticket->ticket_meta['langs'][$event_lang]['ticket_name']) ){
    			        $EM_Ticket->ticket_name = $EM_Ticket->ticket_meta['langs'][$event_lang]['ticket_name'];
    			    }
    			    if( !empty($EM_Ticket->ticket_meta['langs'][$event_lang]['ticket_description']) ){
    			        $EM_Ticket->ticket_description = $EM_Ticket->ticket_meta['langs'][$event_lang]['ticket_description'];
    			    }
    			}
		    }
		}
		return $EM_Bookings;
	}
	
	public static function em_booking_form_footer($EM_Event){
	    if( EM_ML::$current_language != EM_ML::$wplang || EM_ML::$current_language != EM_ML::get_the_language($EM_Event) ){
	        echo '<input type="hidden" name="em_lang" value="'.EM_ML::$current_language.'" />';
	    }
	}
}
EM_ML_Bookings::init();