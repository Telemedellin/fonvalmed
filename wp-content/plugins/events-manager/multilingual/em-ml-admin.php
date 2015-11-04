<?php
class EM_ML_Admin{
    
	public static function init(){
		add_filter('em_event_save_meta_pre','EM_ML_Admin::event_save_meta_pre',10,1);
		add_filter('em_location_save_pre','EM_ML_Admin::location_save_pre',10,2);
		add_action('add_meta_boxes', 'EM_ML_Admin::meta_boxes',100);
	}
	
	public static function meta_boxes(){
	    global $EM_Event;
	    //decide if it's a master event, if not then hide the meta boxes
	    if( !empty($EM_Event) && !EM_ML::is_original_event($EM_Event) ){
		    remove_meta_box('em-event-when', EM_POST_TYPE_EVENT, 'side');
	    	remove_meta_box('em-event-where', EM_POST_TYPE_EVENT, 'normal');
		    remove_meta_box('em-event-bookings', EM_POST_TYPE_EVENT, 'normal');
		    remove_meta_box('em-event-bookings-stats', EM_POST_TYPE_EVENT, 'side');
		    remove_meta_box('em-event-group', EM_POST_TYPE_EVENT, 'side');
		    add_meta_box('em-event-translation', __('Translated Event Information','dbem'), array('EM_ML_Admin','meta_box_translated_event'),EM_POST_TYPE_EVENT, 'side','high');
		    if( $EM_Event->event_rsvp ){
		        add_meta_box('em-event-bookings-translation', __('Bookings/Registration','dbem'), array('EM_ML_Admin','meta_box_bookings_translation'),EM_POST_TYPE_EVENT, 'normal','high');
		    }
	    }
	}
	
	public static function meta_box_translated_event(){
	    global $EM_Event;
	    //output the _emnonce because it won't be output due to missing meta boxes
	    ?>
	    <input type="hidden" name="_emnonce" value="<?php echo wp_create_nonce('edit_event'); ?>" />
	    <p>
	    	<?php
	    	$original_event_link = EM_ML::get_original_event($EM_Event)->get_edit_url();
		    $original_event_link = apply_filters('em_ml_admin_original_event_link',$original_event_link);
			echo sprintf(__('This is a translated event, therefore your time, location and booking information is handled by your <a href="%s">originally created event</a>.', 'em-wpml'), $original_event_link);
	    	?>
	    </p>
	    <?php
	}
	
	public static function meta_box_bookings_translation(){
	    global $EM_Event;
	    $event = EM_ML::get_original_event($EM_Event);
	    $lang = EM_ML::$current_language;
	    ?>
	    <p><em><?php esc_html_e('Below are translations for your tickets. If left blank, the language of the original event will be used.','dbem'); ?></em></p>
	    <table class="event-bookings-ticket-translation form-table">
    	    <?php
    	    foreach( $event->get_tickets()->tickets as $EM_Ticket ){ /* @var $EM_Ticket EM_Ticket */
    	        $name = !empty($EM_Ticket->ticket_meta['langs'][$lang]['ticket_name']) ? $EM_Ticket->ticket_meta['langs'][$lang]['ticket_name'] : '';
    	        $description =  !empty($EM_Ticket->ticket_meta['langs'][$lang]['ticket_description']) ? $EM_Ticket->ticket_meta['langs'][$lang]['ticket_description']: '';
    	        $desc_ph = !empty($EM_Ticket->ticket_description) ? $EM_Ticket->ticket_description:__('Description','dbem');  
    	        ?>
    	        <tbody>
    	        <tr>
    	            <td><strong><?php echo esc_html($EM_Ticket->ticket_name); ?></strong></td>
    	            <td>
    	                <input placeholder="<?php echo esc_attr($EM_Ticket->ticket_name); ?>" type="text" name="ticket_translations[<?php echo $EM_Ticket->ticket_id ?>][ticket_name]" value="<?php echo esc_attr($name); ?>" />
    	                <br/>
    	                <textarea placeholder="<?php echo esc_attr($desc_ph); ?>" type="text" name="ticket_translations[<?php echo $EM_Ticket->ticket_id ?>][ticket_description]"><?php echo esc_html($description); ?></textarea>
    	            </td>
    	        </tr>
    	        </tbody>
    	        <?php
    	    }
    	    ?>
	    </table>
	    <?php
	}

	/**
	 * Saves a new location index record if this is a new languge addition
	 * @param boolean $result
	 * @param EM_Location $EM_Location
	 */
	public static function location_save_pre($EM_Location){
		global $wpdb;
	}

	/**
	 * Saves a new event index record if this is a new languge addition, for ML plugins that store translations as new posts
	 * @param boolean $result
	 * @param EM_Event $EM_Event
	 */
	public static function event_save_meta_pre($EM_Event){
		global $wpdb, $post;
		if( !empty($post) && $EM_Event->post_id != $post->ID ){
			//different language, make sure we don't have the same event_id as the original language
			$event = em_get_event($EM_Event->event_id); //gets the true event
			if( $EM_Event->post_id == $event->post_id ){
				//we have a dupe, so we need to reset the event id and the post id here
				$EM_Event->post_id = $post->ID;
				$EM_Event->event_id = null;
				update_post_meta($post->ID, '_post_id', $post->ID);
				update_post_meta($post->ID, '_event_id', '');
				$EM_Event->load_postdata($post,'post_id');
			}
		}
	}
}
EM_ML_Admin::init();