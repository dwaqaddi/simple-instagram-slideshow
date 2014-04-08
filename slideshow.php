<?php
/*
Plugin Name: Simple Instagram Slideshow
Description: Displays latest Instagram images in a slideshow.
Author: Marcel Bischoff
Version: 1.0.2
Author URI: http://herrbischoff.com
*/

function custom_scripts() {
  wp_register_script( 'bjqs', plugins_url( 'javascripts/bjqs-1.3.min.js' , __FILE__ ), array( 'jquery' ) );
  wp_enqueue_style( 'opensans', 'http://fonts.googleapis.com/css?family=Open+Sans' );
  wp_enqueue_style( 'plugin-style', plugins_url( 'stylesheets/plugin.css' , __FILE__ ) );
  wp_enqueue_script( 'bjqs' );
}
add_action( 'wp_enqueue_scripts', 'custom_scripts' );

class simple_instagram_slideshow extends WP_Widget {

  function simple_instagram_slideshow() {
    $widget_ops = array(
      'classname' => 'simple_instagram_slideshow',
      'description' => 'Displays latest Instagram images in a slideshow.'
    );
    $this->WP_Widget('simple-instagram-sidebar', 'Simple Instagram Slideshow', $widget_ops);
  }

  function form( $instance ) {
    $instance = wp_parse_args( (array) $instance, array(
      'title' => '',
      'user_id' => '',
      'client_id' => '',
      'width' => '',
      'height' => '',
      'likes' => '',
      'amount' => ''
    ) );
    $title = $instance['title'];
    $user_id = $instance['user_id'];
    $client_id = $instance['client_id'];
    $width = $instance['width'];
    $height = $instance['height'];
    $likes = $instance['likes'];
    $amount = $instance['amount'];
?>
  <p><label for="<?php echo $this->get_field_id( 'title' ); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo attribute_escape( $title ); ?>" /></label></p>
  <p><label for="<?php echo $this->get_field_id( 'user_id' ); ?>">Instagram User ID: <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'user_id' ); ?>" type="text" value="<?php echo attribute_escape( $user_id ); ?>" /></label></p>
  <p><label for="<?php echo $this->get_field_id( 'client_id' ); ?>">Instagram Client ID: <input class="widefat" id="<?php echo $this->get_field_id( 'client_id' ); ?>" name="<?php echo $this->get_field_name( 'client_id' ); ?>" type="text" value="<?php echo attribute_escape( $client_id ); ?>" /></label></p>
  <p><label for="<?php echo $this->get_field_id( 'width' ); ?>">Image Width: <input class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo attribute_escape( $width ); ?>" /></label></p>
  <p><label for="<?php echo $this->get_field_id( 'height' ); ?>">Image Height: <input class="widefat" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" type="text" value="<?php echo attribute_escape( $height ); ?>" /></label></p>
  <p><label for="<?php echo $this->get_field_id( 'amount' ); ?>">How Many:<br><input id="<?php echo $this->get_field_id( 'amount' ); ?>" name="<?php echo $this->get_field_name( 'amount' ); ?>" type="text" value="<?php echo attribute_escape( $amount ); ?>" style="width: 53px;" /></label></p>
  <p><label for="<?php echo $this->get_field_id( 'likes' ); ?>">Display Likes&nbsp;&nbsp;&nbsp;<input id="<?php echo $this->get_field_id( 'likes' ); ?>" name="<?php echo $this->get_field_name( 'likes' ); ?>" type="checkbox" <?php checked( $likes  == 'on', true); ?> /></label></p>
<?php
  }

  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['user_id'] = $new_instance['user_id'];
    $instance['client_id'] = $new_instance['client_id'];
    $instance['width'] = $new_instance['width'];
    $instance['height'] = $new_instance['height'];
    $instance['likes'] = $new_instance['likes'];
    $instance['amount'] = $new_instance['amount'];
    return $instance;
  }

  function widget($args, $instance) {
    extract($args, EXTR_SKIP);

    echo $before_widget;
    $title = empty( $instance['title'] ) ? ' ' : apply_filters( 'widget_title', $instance['title'] );
    $user_id = $instance['user_id'];
    $client_id = $instance['client_id'];
    $width = $instance['width'];
    $height = $instance['height'];
    $likes = $instance['likes'];
    $amount = $instance['amount'];

    if ( !empty( $title ) )
     echo $before_title . $title . $after_title;

    $api_url = 'https://api.instagram.com/v1/users/' . $user_id . '/media/recent/?client_id=' . $client_id;
    $json = file_get_contents( $api_url );
    $igdata = json_decode( $json );

    echo '<div id="wp-sis-slideshow"><ul class="wp-sis-slider">';

    $i = 1;
    foreach ( $igdata->data as $item ) :
      if ( $i <= $amount ) :
        $image_url = $item->images->standard_resolution->url;
        $image_link = $item->link;
        echo '<li>';
        if ( $likes === 'on' )
          echo '<div class="wp-sis-likes"><i class="fa fa-heart"></i> ' . $item->likes->count . '</div>';
        echo '<a href="' . $image_link . '" target="_blank">';
        echo '<img src="' . plugins_url( 'timthumb.php' , __FILE__ ) . "?src=" . $image_url . "&w=" . $width . "&h=" . $height . '" width="'. $width . '" height="' . $height . '" />';
        echo '</a></li>';
        $i++;
      endif;
    endforeach;

    echo '</ul></div>';

    echo "
      <script>
        jQuery(document).ready(function($) {
          $('#wp-sis-slideshow').bjqs({
            'width' : $width,
            'height' : $height,
            'showcontrols' : false,
            'showmarkers' : false
          });
        });
      </script>
    ";

    echo $after_widget;
  }

}
add_action( 'widgets_init', create_function('', 'return register_widget("simple_instagram_slideshow");') );?>