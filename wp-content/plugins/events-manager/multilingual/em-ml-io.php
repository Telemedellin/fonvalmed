<?php
/**
 * Model-related functions. Each ML plugin will do its own thing so must be accounted for accordingly. Below is a description of things that should happen so everything 'works'.
 * 
 * When an event or location is saved, we need to perform certain options depending whether saved on the front-end editor, 
 * or if saved/translated in the backend, since events share information across translations.
 * 
 * Event translations should assign one event to be the 'original' event, meaning bookings and event times will be managed by the 'orignal' event.
 * Since ML Plugins can change default languages and you can potentially create events in non-default languages first, the first language will be the 'orignal' event.
 * If an event is deleted and is the original event, but there are still other translations, the original event is reassigned to the default language translation, or whichever other event is found first
 */
class EM_ML_IO {
    
    public static function init(){
        //Saving/Editing
        add_filter('em_event_get_post','EM_ML_IO::event_get_post',10,2);
        //Loading
        add_filter('em_event_get_location','EM_ML_IO::event_get_location',10,2);
    }
    
    /**
     * Changes necessary event properties when an event is instantiated.
     * Specifically, modifies the location id to the currently translated location if applicable.
     * @param EM_Event $EM_Event
     */
    public static function event_get_location( $EM_Location, $EM_Event ){
        //check if location has a translation, if so load that one
        if( $EM_Location->location_id ){
            $translated_post_id = EM_ML::get_translated_post_id($EM_Location->post_id, EM_POST_TYPE_LOCATION);
            if( $translated_post_id && $EM_Location->post_id != $translated_post_id ){
                $EM_Location = em_get_location($translated_post_id, 'post_id');
            }
        }
        return $EM_Location;
    }
    
    /**
     * Hooks into em_event_get_post and writes the original event translation data into the current event, to avoid validation errors and correct data saving.
     * @param boolean $result
     * @param EM_Event $EM_Event
     * @return boolean
     */
    public static function event_get_post($result, $EM_Event){
        //check if this is a master event, if not then we need to get the relevant master event info and populate this object with it so it passes validation and saves correctly.
        $event = EM_ML::get_original_event($EM_Event);  /* @var $event EM_Event */
        $EM_Event->original_event_id = $event->event_id;
        if( $EM_Event->event_id !=  $EM_Event->original_event_id ){
            $EM_Event->event_start_date  = $event->event_start_date ;
			$EM_Event->event_end_date  = $event->event_end_date ;
			$EM_Event->recurrence  = $event->recurrence ;
			$EM_Event->post_type  = $event->post_type ;
			$EM_Event->location_id  = $event->location_id ;
			$EM_Event->location = false;
			if( $EM_Event->location_id == 0 ) $_POST['no_location'] = 1;
			$EM_Event->event_all_day  = $event->event_all_day ;
			$EM_Event->event_start_time  = $event->event_start_time ;
			$EM_Event->event_end_time  = $event->event_end_time ;
			$EM_Event->start  = $event->start ;
			$EM_Event->end  = $event->end ;
			$EM_Event->event_rsvp_date  = $event->event_rsvp_date ;
				
			$EM_Event->event_rsvp  = $event->event_rsvp ;
			$EM_Event->event_rsvp_time  = $event->event_rsvp_time ;
							
			$EM_Event->blog_id  = $event->blog_id ;
			$EM_Event->group_id  = $event->group_id ;
			$EM_Event->recurrence  = $event->recurrence ;
			$EM_Event->recurrence_freq  = $event->recurrence_freq ;
			$EM_Event->recurrence_byday  = $event->recurrence_byday ;
			$EM_Event->recurrence_interval  = $event->recurrence_interval ;
			$EM_Event->recurrence_byweekno  = $event->recurrence_byweekno ;
			$EM_Event->recurrence_days  = $event->recurrence_days ;
			
			// We need to save ticket translations here as well to the ticket objects
			foreach( $EM_Event->get_tickets()->tickets as $EM_Ticket ){ /* @var $EM_Ticket EM_Ticket */
			    $ticket_translation = array();
			    if( !empty($_REQUEST['ticket_translations'][$EM_Ticket->ticket_id]['ticket_name'] ) ) $ticket_translation['ticket_name'] = $_REQUEST['ticket_translations'][$EM_Ticket->ticket_id]['ticket_name'];
			    if( !empty($_REQUEST['ticket_translations'][$EM_Ticket->ticket_id]['ticket_description'] ) ) $ticket_translation['ticket_description'] = $_REQUEST['ticket_translations'][$EM_Ticket->ticket_id]['ticket_description'];
			    if( !empty($ticket_translation) ) $EM_Ticket->ticket_meta['langs'][EM_ML::$current_language] = $ticket_translation;
			}
        }
        return $result;
    }
}
EM_ML_IO::init();