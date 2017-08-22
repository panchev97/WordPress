<?php
/**
 * Widget initialization
 *
 *
 * @author Rumen Panchev
 *
 */
 class RU_Posts_Widget extends WP_Widget {
   /**
   * Registering the widget
   */
   public function __construct() {
        parent::__construct(
            'ru_posts_widget',
            __("RU Posts Widget", 'rubase'),
            array( 'classname' => 'ru_widget_sample_single', 'description' => __( "Plugin for displaying posts", 'rubase' ) ),
            array( ) // you can pass width/height as parameters with values here
        );
    }

    /**
     * Output of widget
     *
     * The $args array holds a number of arguments passed to the widget
     */
     public function widget( $args, $instance ) {
       extract( $args );

       $posts_args = array(
         'post_status'    => 'publish',
         'post_type'      => $instance['post_type_dropdown'],
         'posts_per_page' => $instance['posts_number'],
         'orderby'        => 'title',
         'order'          => $instance['order_posts_dropdown'],
       );
       $query = new WP_QUERY( $posts_args );
       ?>
       <div class="wrapper">
         <h1><?php echo $instance['title'] ?></h1>
         <?php if ( $query->have_posts() ) :
           while ( $query->have_posts() ) : $query->the_post() ?>
             <ul>
               <li>
                 <div class="post">
                   <a href="<?php the_permalink() ?>"
                     <h3 class="title">
                       <a href="<?php the_permalink() ?>" title=""><b><?php echo the_title() ?></b></a>
                     </h3>
                     <p><?php the_excerpt() ?></p>
                 </div>
               </li>
             </ul>
           <?php endwhile; ?>
         <?php endif; ?>
       </div>

       <?php
      // Get widget field values
      $title = apply_filters( 'widget_title', $instance[ 'title' ] );


      // End sample widget body creation

      if ( !empty( $out ) ) {
        echo $before_widget;
        if ( $title ) {
          echo $before_title . $title . $after_title;
        }
        ?>
          <div>
            <?php echo $out; ?>
          </div>
        <?php
          echo $after_widget;
      }
     }

     public function update( $new_instance, $old_instance ) {
       $instance = $old_instance;

       $instance['title']                = strip_tags( $new_instance['title'] );
       $instance['posts_number']         = strip_tags( $new_instance['posts_number'] );
       $instance['order_posts_dropdown'] = strip_tags( $new_instance['order_posts_dropdown'] );
       $instance['post_type_dropdown']   = strip_tags( $new_instance['post_type_dropdown'] );

       return $instance;
     }

     /**
     * Widget Form
     */
     public function form ( $instance ) {
        $instance_defaults = array(
            'title'                => 'Title',
            'posts_number'         => '1',
            'order_posts_dropdown' => 'asc',
            'post_type_dropdown'   => 'post',
        );

        $instance = wp_parse_args( $instance, $instance_defaults );

        $title                = esc_attr( $instance['title'] );
        $posts_number         = esc_attr( $instance['posts_number'] );
        $order_posts_dropdown = esc_attr( $instance['order_posts_dropdown'] );
        $post_type_dropdown   = esc_attr( $instance['post_type_dropdown'] );

            ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( "Title:", 'rubase'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
        <p><label for="<?php echo $this->get_field_id('posts_number'); ?>"><?php _e( "Number of Posts:", 'rubase'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('posts_number'); ?>" name="<?php echo $this->get_field_name('posts_number'); ?>" type="number" min="0" value="<?php echo $posts_number; ?>" /></p>
        <p>
          <label for="<?php echo $this->get_field_id('order_posts_dropdown'); ?>"><?php _e( "Order by:", 'rubase' ); ?></label>
          <select name="<?php echo $this->get_field_name('order_posts_dropdown'); ?>" id="<?php echo $this->get_field_id('order_posts_dropdown'); ?>" class="widefat">
            <option value="asc"<?php selected( $instance['order_posts_dropdown'], 'asc' ); ?>><?php _e( "Ascending", 'rubase' ); ?></option>
            <option value="desc"<?php selected( $instance['order_posts_dropdown'], 'desc' ); ?>><?php _e( "Descending", 'rubase' ); ?></option>
          </select>
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('post_type_dropdown'); ?>"><?php _e( "Select a post type", 'rubase' ); ?></label>
          <select name="<?php echo $this->get_field_name('post_type_dropdown'); ?>" id="<?php echo $this->get_field_id('post_type_dropdown'); ?>" class="widefat">
            <option value="post"<?php selected( $instance['post_type_dropdown'], 'post' ); ?>><?php _e( "Default Post Type", 'rubase' ); ?></option>
            <option value="custom_posts"<?php selected( $instance['post_type_dropdown'], 'custom_posts' ); ?>><?php _e( "Custom Post Type", 'rubase' ); ?></option>
          </select>
        </p>
      <?php
    }
 }

 // Register the widget for use
 register_widget( 'RU_Posts_Widget' );
