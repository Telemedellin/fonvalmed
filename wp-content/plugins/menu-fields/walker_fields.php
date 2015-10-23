<?php

    $locations  = get_nav_menu_locations();
    $terms      = wp_get_post_terms( $item_id, 'nav_menu' ); 
    $fields     = MenuFields::menu_field_get_fields();
    $field_attr = $item_id;
    
    if( is_array( $fields ) ){
        $img_count = 0;
        foreach( $fields as $field ){
            $field_attr = $item_id . '_' . $img_count;
            switch ( $field['type'] ){
                case "image": ?>
                    <p class="field-custom <?php echo MenuFields::menu_fields_item_class( $field, $terms, $locations ); ?>">
                        <label for="<?php echo MenuFields::menu_fields_input_name( $field['name'] ); ?>[<?php echo $item_id; ?>]">
                            <?php if( isset( $field['label'] ) ): ?>
                               <?php echo $field['label']; ?><br />
                            <?php endif; ?>
                            <?php if( $field_value = $item->custom[$field['name']] ): ?>
                                <?php $image = wp_get_attachment_image_src( $field_value, 'thumbnail' ); ?>
                                <a href="#" class="upload_image_button" field_attr="<?php echo $field_attr; ?>"><img id="ad_image_tag_<?php echo $field_attr; ?>" src="<?php echo $image[0]; ?>" width="50" height="50" /></a>
                            <?php else: ?>
                                <a href="#" class="upload_image_button" field_attr="<?php echo $field_attr; ?>"><img id="ad_image_tag_<?php echo $field_attr; ?>" src="<?php echo MenuFields::plugin_url(); ?>/img/image_preview.jpg" width="50" height="50" /></a>
                            <?php endif; ?>
                            <input type="hidden" id="ad_image_<?php echo $field_attr; ?>" name="<?php echo MenuFields::menu_fields_input_name( $field['name'] ); ?>[<?php echo $item_id; ?>]" value="<?php echo $field_value; ?>" />
                            <br />
                            <input class="upload_image_button button" field_attr="<?php echo $field_attr; ?>" type="button" value="<?php _e( 'Choose Image' ); ?>" />
                            <?php if( $field_value ): ?>
                            <a href="#" class="remove_image_button" field_attr="<?php echo $field_attr; ?>" field_attr_img="<?php echo MenuFields::plugin_url(); ?>/img/image_preview.jpg"><?php _e( 'Remove image' ); ?></a>
                            <?php endif; ?>
                        </label>
                    </p>
                    <?php $img_count++; ?>
                <?php break;
            
                case "text": ?>
                    <p class="field-custom <?php echo MenuFields::menu_fields_item_class( $field, $terms, $locations ); ?>">
                        <?php $field_value = $item->custom[$field['name']]; ?>
                        <label for="<?php echo MenuFields::menu_fields_input_name( $field['name'] ); ?>[<?php echo $item_id; ?>]">
                            <?php if( isset( $field['label'] ) ): ?>
                               <?php echo $field['label']; ?><br />
                            <?php endif; ?>
                            <input type="text" size="36" name="<?php echo MenuFields::menu_fields_input_name( $field['name'] ); ?>[<?php echo $item_id; ?>]"  value="<?php echo $field_value; ?>" /> 
                        </label>
                    </p>
                <?php break;
                
                case "color": ?>
                    <p class="field-custom <?php echo MenuFields::menu_fields_item_class( $field, $terms, $locations ); ?>">
                        <?php $field_value =  $item->custom[$field['name']]; ?>
                        <label for="<?php echo MenuFields::menu_fields_input_name( $field['name'] ); ?>[<?php echo $item_id; ?>]">
                            <?php if(isset($field['label'])): ?>
                               <?php echo $field['label']; ?><br />
                            <?php endif; ?>                       
                            <input id="<?php echo MenuFields::menu_fields_input_name( $field['name'] ).'-'.$item_id; ?>" type="text" size="12" name="<?php echo MenuFields::menu_fields_input_name( $field['name'] ); ?>[<?php echo $item_id; ?>]"  value="<?php echo $field_value ? $field_value : '#000000'; ?>" />
                            <input type="color" size="36" onchange="jQuery('#<?php echo MenuFields::menu_fields_input_name( $field['name'] ).'-'.$item_id; ?>').val(jQuery(this).val())" value="<?php echo $field_value; ?>"/> 
                        </label>
                    </p>
                <?php break;
                
                case "textarea": ?>
                    <p class="field-custom <?php echo MenuFields::menu_fields_item_class( $field, $terms, $locations ); ?>">
                        <?php $field_value = $item->custom[$field['name']]; ?>
                        <label for="<?php echo MenuFields::menu_fields_input_name( $field['name'] ); ?>[<?php echo $item_id; ?>]">
                            <?php if( isset( $field['label'] ) ): ?>
                               <?php echo $field['label']; ?><br />
                            <?php endif; ?>
                            <textarea  class="widefat edit-menu-item-description" cols="20" rows="3" name="<?php echo MenuFields::menu_fields_input_name( $field['name'] ); ?>[<?php echo $item_id; ?>]"><?php echo $field_value; ?></textarea>  
                        </label>
                    </p>
                <?php break;
                
                case "radio": ?>
                    <p class="field-custom <?php echo MenuFields::menu_fields_item_class( $field, $terms, $locations ); ?>">
                        <?php $field_value = $item->custom[$field['name']]; ?>
                        <label for="<?php echo MenuFields::menu_fields_input_name( $field['name'] ); ?>[<?php echo $item_id; ?>]">
                            <?php if( isset( $field['label'] ) ): ?>
                               <?php echo $field['label']; ?><br />
                            <?php endif; ?>
                            <?php if( is_array( $field['options'] ) ): ?>
                                <?php foreach( $field['options'] as $value => $option ): ?>
                                    <?php if( $field_value == $value ){ 
                                        $checked = 'checked="checked"';
                                    }else{
                                        $checked = '';
                                    }?>
                                    <p><input <?php echo $checked; ?> type="radio" name="<?php echo MenuFields::menu_fields_input_name( $field['name'] ); ?>[<?php echo $item_id; ?>]" value="<?php echo $value; ?>"><?php echo $option; ?></p>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </label>
                    </p>
                <?php break;
                
                case "select": ?>
                    <p class="field-custom <?php echo MenuFields::menu_fields_item_class( $field, $terms, $locations ); ?>">
                        <?php $field_value = $item->custom[$field['name']]; ?>
                        <label for="<?php echo MenuFields::menu_fields_input_name( $field['name'] ); ?>[<?php echo $item_id; ?>]">
                            <?php if( isset( $field['label'] ) ): ?>
                               <?php echo $field['label']; ?><br />
                            <?php endif; ?>                       
                            <?php if( is_array( $field['options'] ) ): ?>
                                <select name="<?php echo MenuFields::menu_fields_input_name( $field['name'] ); ?>[<?php echo $item_id; ?>]">
                                <?php foreach( $field['options'] as $value => $option ): ?>
                                    <?php if( $field_value == $value ){ 
                                        $selected = 'selected="selected"';
                                    }else{
                                        $selected = '';
                                    }?>
                                    <option <?php echo $selected; ?>  value="<?php echo $value; ?>"><?php echo $option; ?></option>
                                <?php endforeach; ?>
                                </select>
                            <?php endif; ?>
                        </label>
                    </p>
                <?php break;
                
                case "checkbox":
                ?>
                    <p class="field-custom <?php echo MenuFields::menu_fields_item_class( $field, $terms, $locations ); ?>">
                        <?php $field_value = $item->custom[$field['name']]; ?>
                        <label for="<?php echo MenuFields::menu_fields_input_name( $field['name'] ); ?>[<?php echo $item_id; ?>]">
                            <?php if( isset($field['label'] ) ): ?>
                               <?php echo $field['label']; ?><br />
                            <?php endif; ?>
                            <?php if( $field_value == 1 ){ 
                                $checked = 'checked="checked"';
                            }else{
                                $checked = '';
                            }?>
                            <input type="hidden" name="<?php echo MenuFields::menu_fields_input_name( $field['name'] ); ?>[<?php echo $item_id; ?>]" value="off" >
                            <input <?php echo $checked; ?> type="checkbox" name="<?php echo MenuFields::menu_fields_input_name( $field['name'] ); ?>[<?php echo $item_id; ?>]" >
                        </label>
                    </p>
                <?php break;
            }
        }
    }
?>