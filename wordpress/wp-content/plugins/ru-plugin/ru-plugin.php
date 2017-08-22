<?php
/**
 * Plugin Name: RU Plugin
 * Description: A plugin for adding widgets to your pages
 * Version: 1.0
 * License: GPL2
*/

define( 'RU_PATH_INCLUDES', dirname( __FILE__ ) . '/inc' );
define( 'RU_PATH', dirname( __FILE__ ) );

/**
 * Plugin main class
 */
class RU_Plugin {
  public function __construct() {
  		// Add the post widget
  		add_action( 'widgets_init', array( $this, 'ru_posts_widget' ) );

      //Register the custom post type
      add_action( 'init', array( $this, 'ru_custom_post_type_callback' ), 5 );

      //Register the shortcode
      add_action( 'init', array( $this, 'ru_fetching_posts_shortcode' ) );
    }

     /**
  	 * Hook for including a posts widget with options
  	 */
  	public function ru_posts_widget() {
  		include_once RU_PATH_INCLUDES . '/ru-widget-class.php';
  	}

    /**
    * Register a help section
    */
    public function ru_register_help() {
      require_once( RU_PATH . '/ru-plugin-help-class.php' );
      new RU_Plugin_Help();
    }

     /**
  	 * Register a sample shortcode for fetching the posts
  	 */
     public function ru_fetching_posts_shortcode() {
       add_shortcode( 'rusampcode', array( $this, 'ru_shortcode_body' ) );
     }

     /**
     * Returns the content of the sample shortcode
     */
     public function ru_shortcode_body( $attr, $content = null ) {
       $posts_args = array(
         'post_status'    => 'publish',
         'post_type'      => 'post',
         'posts_per_page' => '5',
         'orderby'        => 'title',
         'order'          => 'asc',
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
     }

    /**
    * Register Custom Post Type
    */
    public function ru_custom_post_type_callback() {
		register_post_type( 'custom_posts', array(
			'labels' => array(
				'name'               => __("Custom Posts ", 'rubase'),
				'singular_name'      => __("Custom Post", 'rubase'),
				'add_new'            => _x("Add New", 'custom_posts', 'rubase' ),
				'add_new_item'       => __("Add New Custom Post", 'rubase' ),
				'edit_item'          => __("Edit Custom Post", 'rubase' ),
				'new_item'           => __("New Custom Post", 'rubase' ),
				'view_item'          => __("View Custom Post", 'rubase' ),
				'search_items'       => __("Search Custom Posts", 'rubase' ),
				'not_found'          =>  __("No base posts found", 'rubase' ),
				'not_found_in_trash' => __("No custom posts found in Trash", 'rubase' ),
			),
			'description'         => __("Custom Posts for the demo", 'rubase'),
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
				'custom-fields',
				'page-attributes',
			),
		));
	}
}

// Initialize everything
$ru_plugin = new RU_Plugin();
