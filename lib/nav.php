<?php
namespace ASMH;

class Nav
{
  public static function init()
  {
      add_filter('wp_nav_menu_args', array(__CLASS__, 'nav_args'));
      add_filter('wp_nav_menu_items', array(__CLASS__, 'search_nav'), 10, 2);
      add_filter('wp_nav_menu_items', array(__CLASS__, 'ellipsis_nav'), 20, 2);
      add_filter('asmh_nav_search_item', array(__CLASS__, 'search_item'), 10, 2);
  }


  public static function nav_args($args = '')
  {
      global $asmh;
      $menu_args = array();

      if (!$args['depth']) {
          $menu_args['depth'] = $GLOBALS['asmh']->settings['menu_depth'];
      }

      return array_merge($args, $menu_args);
  }


  public static function search_nav($items, $args) {
      if (isset($args->bottom) && $args->bottom === true) {
          return $items;
      }

      if ($args->menu === $GLOBALS['asmh']->middle->id) {
          if (empty($items)) {
              return;
          }

          if (isset($args->sub_menu) && $args->sub_menu === true) {
              return $items;
          }

          return $items . apply_filters(
              'asmh_nav_search_item',
              array(
                  'search'
              ),
              array('icon-search')
          );

      } else {
          return $items;
      }
  }


  public static function ellipsis_nav($items, $args)
  {
      global $asmh;

      if (isset($args->bottom) && $args->bottom === true) {
          return $items;
      }

      $result = '';

      if (!is_admin() && !$asmh->settings['has_secondary']) {
          return $items;
      }

      if (!$asmh->settings['secondary_menu_id']) {
          return $items;
      }

      if ($args->menu === $asmh->middle->id) {
          if (empty($items)) {
              $result = '';
          }

          // if not bottom sub-menu which uses items of main menu
          elseif (isset($args->sub_menu) && $args->sub_menu === true) {
              $result = $items;

          } else {
              $sub_menu = '<div class="sub-menu">'
                  . apply_filters('asmh_secondary_menu_before', '')
                  . apply_filters('asmh_secondary_menu', wp_nav_menu(array(
                      'menu' => $asmh->settings['secondary_menu_id'],
                      'container' => false,
                      'echo' => false,
                      'depth' => -1
                  )))
                  . apply_filters('asmh_secondary_menu_after', '')
                  . '</div>';

              if (is_admin()) {
                  $display = !$asmh->settings['has_secondary']? 'style="display:none;" ' : '';
                  $result = "{$items}<li {$display}class=\"secondary dropdown\"><a class=\"icon-ellipsis-vert\"></a>{$sub_menu}</li>";

              } else {
                  $result = "{$items}<li class=\"secondary dropdown\"><a class=\"icon-ellipsis-vert\"></a>{$sub_menu}</li>";
              }
          }

      } else {
          $result = $items;
      }

      return $result;
  }


  public static function search_item($li_classes, $classes) {
    if (!is_admin() && !$GLOBALS['asmh']->settings['has_search']) {
      return;
    }

    if (!is_array($li_classes) && !empty($li_classes)) {
      return;
    }

    if (!is_array($classes) && !empty($classes)) {
      return;
    }

    if (is_admin()) {
      return '<li '. (!$GLOBALS['asmh']->settings['has_search']? 'style="display:none;"' : '')
          .'class="' . implode(' ', $li_classes)
            . ($GLOBALS['asmh']->settings['middle_position'] == 'center' ? ' ce' : '') . '">'
        . '<a class="' . implode(' ', $classes) . '"></a>'
        . '<input type="text" name="s" value="" tabindex="0" placeholder="'
                . apply_filters('asmh_search_placeholder', '') . '">'
        . '</li>';

    } else {
      return '<li class="' . implode(' ', $li_classes) . '">'
        . '<a class="' . implode(' ', $classes) . '"></a>'
        . '<form action="' . esc_url(home_url('/')) . '" role="search" method="get">'
        . '<input type="text" name="s" value="' . get_search_query() . '" tabindex="0">'
        . '</form>'
        . '</li>';
    }
  }
}
