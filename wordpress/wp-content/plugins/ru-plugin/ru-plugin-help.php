<?php
class RU_Plugin_Help {

  private $ru_help;

  public function __construct() {
    $this->ru_help = get_option( 'ru_help', '' );
  }
}
