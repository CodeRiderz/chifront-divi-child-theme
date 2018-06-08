<?php 
  /* ----------------------------------------------------------------------------------- */
  // Add Divi Builder to TEC Post Types
  /* ----------------------------------------------------------------------------------- */
  function add_tec_post_types( $post_types ) {
    $post_types[] = 'tribe_events';
    $post_types[] = 'tribe_venue';
    $post_types[] = 'tribe_organizer';

    return $post_types;
  }
  add_filter( 'et_builder_post_types', 'add_tec_post_types' );

  // `event-list` shortcode to show events list
  add_shortcode('event-list', 'eventList');

  function eventList($atts) {
    if (function_exists('tribe_get_events')) {
        // Ensure the global $post variable is in scope
        global $post;

        // default options
        $tribe_options = [
            'posts_per_page' => 9999,
            'evenDisplay' => 'custom'
        ];

        if (!empty($atts['maxEvent'])) {
            $tribe_options['posts_per_page'] = $atts['maxEvent'];
        }

        if (!empty($atts['eventDisplay'])) {
            $tribe_options['evenDisplay'] = $atts['eventDisplay'];
        }

        if (!empty($atts['year'])) {
            $tribe_options['start_date'] = $atts['year'].'-01-01 00:01';
            $tribe_options['end_date'] = $atts['year'].'-12-30 23:59';
        }

        if (!empty($atts['order'])) {
            $tribe_options['order'] = $atts['order'];
        }

        $events = tribe_get_events($tribe_options);
        if (empty($events)) {
            return '<h3 class="event-post-empty"> No Events Found</h3>';
        } else {
            $itemsDOM = '';
            foreach ( $events as $event ) {
                $imageSize = empty($atts['imageSize']) ? array(300, 300) : $atts['imageSize'];
                $image_url = wp_get_attachment_image_src( get_post_thumbnail_id($event->ID), 'medium')[0];
                $image = tribe_event_featured_image($event->ID, $imageSize, false);
                $website_url = tribe_get_event_website_url($event);
                $url = empty($website_url) ? esc_url( tribe_get_event_link($event->ID)) : $website_url;
                $itemsDOM = $itemsDOM.'  
                <a href="'.$url.'" class="event-post-item '. $atts['style'] .'">'
                    .'<div class="event-image et-pb-icon" style="background-image: url(\''.$image_url.'\');"></div>'.
                    '<div class="event-content">'.
                        '<h3>'.$event->post_title.'</h3>'.
                        (empty($event->post_excerpt) ? '<p>'. wp_trim_words($event->post_content, '10') .'</p>' : '<p>'.$event->post_excerpt.'</p>')
                        .'<div class="date">'.date('j F Y', strtotime($event->EventStartDate)) .' - '. date('j F Y', strtotime($event->EventEndDate)) .'</div>
                    </div>
                </a>';
            }
            return $itemsDOM;
        }
    }
  }
?>
