<?php
namespace ASMH;

class Customizer
{
  function __construct()
  {
    add_action('send_headers', array($this, 'headers'));
  }


  public function headers()
  {
    $path = $_SERVER['REQUEST_URI'];

    if (strpos($path, '/asmh/styles/preview') !== false) {
      $this->generate_preview_css();
      exit;
    } else
    if (strpos($path, '/asmh/styles') !== false) {
      $this->generate_live_css();
      exit;
    }
  }


  public function generate_preview_css()
  {
    header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
    header('Content-type: text/css');
    ob_clean();
    require_once('css-util.php');
  }


  public function generate_live_css()
  {
    header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
    header('Content-type: text/css');
    ob_clean();
    require_once('css-live.php');
  }


  public static function num_to_px($number)
  {
    return $number . 'px';
  }


  public static function to_color($hex)
  {
    if (!empty($hex)) {
      return '#' . $hex;
    }
  }


  public static function block_from_bool($bool)
  {
    return $bool? 'block' : 'none';
  }


  public static function to_url($str)
  {
    return "url({$str})";
  }


  // http://css-tricks.com/snippets/php/convert-hex-to-rgb/
  public static function hex2rgb($color, $transparency = -1) {
    if ($color[0] == '#') {
      $color = substr($color, 1);
    }

    if (strlen($color) == 6) {
      list($r, $g, $b) =
        array(
          $color[0] . $color[1],
          $color[2] . $color[3],
          $color[4] . $color[5]
        );

    } elseif (strlen($color) == 3) {
      list($r, $g, $b) =
        array(
          $color[0] . $color[0],
          $color[1] . $color[1],
          $color[2] . $color[2]
        );

    } else {
      return false;
    }

    $r = hexdec($r);
    $g = hexdec($g);
    $b = hexdec($b);

    if ($transparency > 0) {
        return implode(',', array($r, $g, $b, $transparency / 100));
    }

    return implode(',', array($r, $g, $b));
  }


  public static function get_css_a_genericons($header_type) {
      return <<<CSS
.asmh-{$header_type} li a[href*="twitter.com"],
.asmh-{$header_type} li a[href*="facebook.com"],
.asmh-{$header_type} li a[href*="google.com"],
.asmh-{$header_type} li a[href*="linkedin.com"],
.asmh-{$header_type} li a[href*="pinterest.com"],
.asmh-{$header_type} li a[href*="wordpress.org"],
.asmh-{$header_type} li a[href*="wordpress.com"],
.asmh-{$header_type} li a[href*="vimeo.com"],
.asmh-{$header_type} li a[href*="youtube.com"],
.asmh-{$header_type} li a[href*="tumblr.com"],
.asmh-{$header_type} li a[href*="instagram.com"],
.asmh-{$header_type} li a[href*="path.com"],
.asmh-{$header_type} li a[href*="reddit.com"],
.asmh-{$header_type} li a[href*="stumbleupon.com"],
.asmh-{$header_type} li a[href*="dribbble.com"],
.asmh-{$header_type} li a[href*="github.com"]
CSS;
  }


  public static function get_css_a_genericons_before($header_type) {
      return <<<CSS
.asmh-{$header_type} li a[href*="twitter.com"]:before,
.asmh-{$header_type} li a[href*="facebook.com"]:before,
.asmh-{$header_type} li a[href*="plus.google.com"]:before,
.asmh-{$header_type} li a[href*="linkedin.com"]:before,
.asmh-{$header_type} li a[href*="pinterest.com"]:before,
.asmh-{$header_type} li a[href*="wordpress.org"]:before,
.asmh-{$header_type} li a[href*="wordpress.com"]:before,
.asmh-{$header_type} li a[href*="vimeo.com"]:before,
.asmh-{$header_type} li a[href*="youtube.com"]:before,
.asmh-{$header_type} li a[href*="tumblr.com"]:before,
.asmh-{$header_type} li a[href*="instagram.com"]:before,
.asmh-{$header_type} li a[href*="path.com"]:before,
.asmh-{$header_type} li a[href*="reddit.com"]:before,
.asmh-{$header_type} li a[href*="stumbleupon.com"]:before,
.asmh-{$header_type} li a[href*="dribbble.com"]:before,
.asmh-{$header_type} li a[href*="github.com"]:before
CSS;
  }
}
