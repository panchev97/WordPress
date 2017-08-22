<?php
/**
 * Plugin Name: RU Plugin
 * Description: A plugin for adding widgets to your pages
 * Version: 1.0
 * License: GPL2
*/

// Constant for defining the inc folder path
define( 'RU_PATH_INCLUDES', dirname( __FILE__ ) . '/inc' );

/**
 * Plugin main class
 */
class RU_Plugin {
  public function __construct() {

  		// Add the post widget
  		add_action( 'widgets_init', array( $this, 'ru_posts_widget' ) );
  	}

  /**
	 * Hook for including a posts widget with options
	 */
	public function ru_posts_widget() {
		include_once RU_PATH_INCLUDES . '/ru-widget-class.php';
	}
}

// Initialize everything
$ru_plugin = new RU_Plugin();
