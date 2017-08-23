<?php
/**
 * Widget initialization
 * @author Rumen Panchev
 */
 class RU_Testimonials_Widget extends WP_Widget {
   public function __construct() {
        parent::__construct(
            'ru_testimonials_widget',
            __("RU Testimonials Widget", 'rubase'),
            array( 'classname' => 'ru_testimonials_widget_sample_single', 'description' => __( "Widget for displaying testimonials to your posts/pages", 'rubase' ) )
        );
    }

    /**
     * Output of widget
     */
    public function widget( $args, $instance ) {
      extract( $args );

      $testimonials_args = array(
        'post_status'    => 'publish',
        'post_type'      => 'testimonials',
        'posts_per_page' => $instance['testimonials_number'],
        'orderby'        => 'title',
        'order'          => $instance['order_testimonials_dropdown'],
      );
      $query = new WP_Query( $testimonials_args );
      ?>
      <div class="wrapper">
        <h1><?php echo $instance['title'] ?></h1>
            <?php if ( $query->have_posts() ) : ?>
              <ul>
              <?php while ( $query->have_posts() ) : $query->the_post() ?>
                <li>
                  <div class="post">
                    <a href="<?php the_permalink() ?>"
                      <h3 class="title">
                        <a href="<?php the_permalink() ?>" title=""><b><?php echo the_title() ?></b></a>
                      </h3>
                    <p><?php the_excerpt() ?></p>
                  </div>
                </li>
              <?php endwhile; ?>
              </ul>
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

      $instance['title']                       = strip_tags( $new_instance['title'] );
      $instance['testimonials_number']         = strip_tags( $new_instance['testimonials_number'] );
      $instance['order_testimonials_dropdown'] = strip_tags( $new_instance['order_testimonials_dropdown'] );

      return $instance;
    }

    /**
    * Widget Form
    */
    public function form ( $instance ) {
       $instance_defaults = array(
           'title'                       => 'Title',
           'testimonials'                => '1',
           'order_testimonials_dropdown' => 'asc',
           'testimonials_number'         => '1',
       );

       $instance = wp_parse_args( $instance, $instance_defaults );

       $title                       = esc_attr( $instance['title'] );
       $testimonials_number         = esc_attr( $instance['testimonials_number'] );
       $order_testimonials_dropdown = esc_attr( $instance['order_testimonials_dropdown'] );
           ?>

       <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( "Title:", 'rubase'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
       <p><label for="<?php echo $this->get_field_id('testimonials_number'); ?>"><?php _e( "Number of Testimonials:", 'rubase'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('testimonials_number'); ?>" name="<?php echo $this->get_field_name('testimonials_number'); ?>" type="number" min="0" value="<?php echo $testimonials_number; ?>" /></p>
       <p><label for="<?php echo $this->get_field_id('order_testimonials_dropdown'); ?>"><?php _e( "Order Testimonials by:", 'rubase' ); ?></label></p>
       <p>
         <select name="<?php echo $this->get_field_name('order_testimonials_dropdown'); ?>" id="<?php echo $this->get_field_id('order_testimonials_dropdown'); ?>" class="widefat">
           <option value="asc"<?php selected( $instance['order_testimonials_dropdown'], 'asc' ); ?>><?php _e( "Ascending", 'rubase' ); ?></option>
           <option value="desc"<?php selected( $instance['order_testimonials_dropdown'], 'desc' ); ?>><?php _e( "Descending", 'rubase' ); ?></option>
         </select>
       </p>
     <?php
   }
 }

register_widget( 'RU_Testimonials_Widget' );
