<?php
namespace ASMH;

class Middle
{

  function __construct()
  {
    $this->id = $GLOBALS['asmh']->settings['middle_menu_id'];
    $this->menu = $GLOBALS['asmh']->settings['middle_menu'];
    $this->has_description = $GLOBALS['asmh']->settings['show_description'];
    $this->navs = wp_get_nav_menus();
  }


  public function content_main()
  {
    return apply_filters('asmh_middle_header', $this->_main_output());
  }


  private function _main_output()
  {
    global $asmh;
    $brand = $this->brand_wrap();
    $menu = $this->menu();
    $html = apply_filters('asmh_middle', $brand . $menu);

    $color = $asmh->settings['middle_background_color'];
    $color_sm = $asmh->settings['middle_submenu_background_color'];

    return <<<HTML
      <div class="middle" data-bgcolor="{$color}" data-bgcolorsm="{$color_sm}">
        <div class="container">{$html}</div>
      </div>
HTML;
  }


  public function menu() {
    global $asmh;
    if (empty($asmh->navs)) {
      return;
    }

    $menu = apply_filters('asmh_middle_menu_before', '')
      . wp_nav_menu(array(
        'menu' => $this->id,
        'container' => false,
        'echo' => false,
        'walker' => new \Asmh_Nav_Walker
      ))
      . apply_filters('asmh_middle_menu_after', '');

    return apply_filters('asmh_middle_menu',
      "<nav class=\"primary\" role=\"navigation\">{$menu}</nav>");
  }


  public function brand_wrap()
  {
    global $asmh;
    $before_brand = apply_filters('asmh_before_brand', '');
    $after_brand = apply_filters('asmh_after_brand', '');
    $brand = $this->get_brand_html();

    $tagline = $this->get_tagline_html();

    $ham_button = apply_filters('asmh_nav_collapse', $this->menu_button());

    return <<<HTML
    <div class="nav-wrap">
      {$before_brand}
      <div class="brand-wrap">{$brand}{$tagline}</div>
      {$after_brand}
      {$ham_button}
    </div>
HTML;
  }


  public function menu_button()
  {
    if (is_admin()) {
      return;
    }

    return <<<HTML
      <div class="toggle-wrap">
        <div class="toggle">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </div>
      </div>
HTML;
  }


  public function get_brand_html()
  {
    return apply_filters('asmh_brand', '<a class="brand logo" href="'
      . home_url() . '">' . $this->brand_html() . '</a>');
  }


  public function get_tagline_html()
  {
    if ($GLOBALS['asmh']->is_preview) {
      if (!$this->has_description) {
        $return = '<p style="display:none;" class="description">'
          . get_bloginfo('description') . '</p>';

      } else {
        $return = '<p class="description">' . get_bloginfo('description') . '</p>';
      }

      return apply_filters('asmh_tagline', $return);
    }

    if (!$this->has_description) return;
    return apply_filters('asmh_tagline', '<p class="description">' . get_bloginfo('description') . '</p>');
  }


  public function brand_html() {
    switch ($GLOBALS['asmh']->settings['logo_type']) {
      case 'image':
        return '<img src="' . $this->get_logo_src() . '">';

      case 'text':
        return $GLOBALS['asmh']->settings['logo_text'];

      case 'site':
        return get_bloginfo('name');
    }
  }


  public function get_logo_src() {
    global $asmh;

    if (!isset($asmh->settings['logo_id']) ||
      empty($asmh->settings['logo_id'])) {

        return '';

      } else {
        $img = isset($asmh->settings['logo_id']) ?
          wp_get_attachment_image_src(
            $asmh->settings['logo_id'], 'full'
          ) : '';

        if (!empty($img)) return $img[0];
        else return '';
      }
  }
}
