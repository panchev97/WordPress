<?php
/**
 * Plugin Name: RU Testimonials Plugin
 * Description: Plugin for adding widgets for testimonials to your pages
 * Version: 1.0
 * License: GPL2
*/

define( 'PATH_INCLUDES', dirname( __FILE__ ) . '/inc' );
define( 'PATH', dirname( __FILE__ ) );

class RU_Testimonials_Plugin {
  function __construct() {
    //Register testimonials custom post type
    add_action( 'init', array( $this, 'ru_testimonials_post_type' ), 5 );

    //Register testimonials widget
    add_action( 'widgets_init', array( $this, 'ru_testimonials_widget' ) );

    //Register the shortcode
    add_action( 'init', array( $this, 'ru_fetching_testimonials_shortcode' ) );

    //Register testimonials help page
    add_action( 'admin_menu', array( $this, 'ru_testimonials_help_page' ) );
  }

  // Include widget class
  public function ru_testimonials_widget() {
    include_once PATH_INCLUDES . '/ru-testimonials-widget-class.php';
  }

  // Include testimonials help page template
  public function ru_testimonials() {
    include_once( PATH_INCLUDES . '/testimonials-page-template.php' );
  }

  /**
  * Register testimonials custom post type
  */
  public function ru_testimonials_post_type() {
    register_post_type( 'testimonials', array(
      'labels' => array(
        'name'               => __("Testimonials ", 'rubase'),
        'singular_name'      => __("Testimonial", 'rubase'),
        'add_new'            => _x("Add New", 'testimonials', 'rubase' ),
        'add_new_item'       => __("Add New Testimonial", 'rubase' ),
        'edit_item'          => __("Edit Testimonial", 'rubase' ),
        'new_item'           => __("New Testimonial", 'rubase' ),
        'view_item'          => __("View Testimonial", 'rubase' ),
        'search_items'       => __("Search Testimonials", 'rubase' ),
        'not_found'          =>  __("No Testimonials found", 'rubase' ),
        'not_found_in_trash' => __("No Testimonials found in Trash", 'rubase' ),
      ),
      'description'         => __("Testimonials for the demo", 'rubase'),
      'public'              => true,
      'publicly_queryable'  => true,
      'query_var'           => true,
      'rewrite'             => true,
      'exclude_from_search' => true,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'menu_position'       => 40,
      'supports' => array(
        'title',
        'editor',
        'thumbnail',
        'page-attributes',
      ),
    ));
  }

  /**
  * Register a sample shortcode for fetching the testimonials
  */
  public function ru_fetching_testimonials_shortcode() {
    add_shortcode( 'testimonials-shortcode', array( $this, 'ru_shortcode_body' ) );
  }

  /**
  * Returns the content of the sample shortcode
  */
  public function ru_shortcode_body( $attr, $content = null ) {
    $testimonials_args = array(
      'post_status'    => 'publish',
      'post_type'      => 'testimonials',
      'posts_per_page' => '100',
      'orderby'        => 'title',
      'order'          => 'asc',
    );
    $query = new WP_Query( $testimonials_args );
    ?>
    <div class="wrapper">
        <ul>
          <?php if ( $query->have_posts() ) : ?>
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
          <?php endif; ?>
        </ul>
    </div>
    <?php
  }

  /**
  * Callback for registering pages
  */
  public function ru_testimonials_help_page() {
    add_menu_page(__( "Testimonials Help Page", 'rubase' ), __( "Testimonials Help Page", 'rubase' ), 'edit_themes', 'ru-testimonials', array( $this, 'ru_testimonials' ) );
  }
}

$ru_testimonials_plugin = new RU_Testimonials_Plugin();
