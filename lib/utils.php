<?php
function asmh_cond_result($result, $print = true) {
  if ($print) {
    echo $result;
  } else {
    return $result;
  }
}


function asmh_set_vars($defaults, $settings)
{
  if (!is_array($defaults)) {
    return;
  }

  foreach ($defaults as $name => $value) {
    if (!isset($settings[$name])) {
      $settings[$name] = $value;
    }
  }

  return $settings;
}


function asmh_array_find($array, $key_param, $value_param)
{
  foreach ($array as $key => $value) {
    if ($value->$key_param == $value_param)
      return $array[$key];
  }

  return null;
}


function asmh_checkbox_tag($params)
{
  if (!is_array($params)) {
    return;
  }

  $result = '<input type="checkbox"';

  foreach ($params as $index => $val) {
    if (is_bool($val)) {
      if ($index == 'value') {
        $result .= ' value="' . var_export($val, true) . '"';

      } elseif ($index == 'checked') {
        $result .= ($val ? ' checked="checked"' : '');
      }

    } else {
      $result .= ' ' . $index . '="' . $val . '"';
    }
  }

  $result .= '>';

  echo $result;
}


function asmh_option_tags($opt, $options)
{
  $settings = $GLOBALS['asmh']->settings;
  $return = '';

  foreach ($options as $key => $option)
  {
    $return .= '<option';

    if ($key == $settings[$opt] ||
      ($settings[$opt] === null && $option == __('Select', ASMH_LANG) . '...')) {
      $return .= ' selected ';
    }

    $return .= ' value="' . $key . '">' . $option;

    $return .= '</option>';
  }

  echo $return;
}


class Asmh_Nav_Walker extends Walker_Nav_Menu
{
  function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
    $item_html = '';
    parent::start_el($item_html, $item, $depth, $args);

    if ($item->is_dropdown && ($depth === 0)) {
        $item_html = str_replace('</a>', ' <b class="asmh-caret"></b></a>', $item_html);
    }
    elseif (stristr($item_html, 'li class="divider')) {
        $item_html = preg_replace('/<a[^>]*>.*?<\/a>/iU', '', $item_html);
    }
    elseif (stristr($item_html, 'li class="dropdown-title')) {
        $item_html = preg_replace('/<a[^>]*>(.*)<\/a>/iU', '$1', $item_html);
    }

    if (strlen($item->description) > 0) {
        $item_html = str_replace('</a>', "<p class=\"desc\">{$item->description}</p></a>", $item_html);
    }

    $item_html = apply_filters('asmh_nav_menu_item', $item_html);
    $output .= $item_html;
  }

  function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
    $element->is_dropdown = ((!empty($children_elements[$element->ID]) && (($depth + 1) < $max_depth || ($max_depth === 0))));

    if ($element->is_dropdown) {
      $element->classes[] = 'dropdown';
    }

    parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
  }
}


function asmh_blog_page_title()
{
  $page = get_option('page_for_posts');
  return get_the_title($page);
}


function asmh_blog_page_url()
{
  $page = get_option('page_for_posts');
  return get_permalink($page);
}


function asmh_shop_url()
{
  return get_permalink(woocommerce_get_page_id('shop'));
}


function asmh_shop_title()
{
  return get_the_title(woocommerce_get_page_id('shop'));
}


function asmh_is_blog_home()
{
  return get_option('show_on_front') == 'posts';
}


function asmh_is_shop_home()
{
  $o = (integer) get_option('page_on_front');
  $s = woocommerce_get_page_id('shop');

  if ($o === $s) return true;
}
