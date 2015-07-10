<?php
namespace ASMH;



/**
 * Main class responsible for creating admin interface and
 * printing header.
 *
 * @author Marko Jakic <hi@markojakic.net>
 */
class Main
{
  private static $instance;
  public $settings;


  /**
   * Holds menus gotten from `wp_get_nav_menus`
   *
   * @var array
   * @access public
   */
  public $navs;


  public $customizer;
  public $middle;
  public $defaults;


  function __construct()
  {
    add_action('admin_enqueue_scripts', array($this, 'register_scripts'));
    add_action('admin_init', array($this, 'settings_init'));
    add_action('admin_menu', array($this, 'add_settings_page'));

    $plugin_basename = plugin_basename(ASMH_PATH . 'awesomeheader.php');
    add_filter('plugin_action_links_' . $plugin_basename, array($this, 'add_action_links'));

    // frontend
    add_action('wp_enqueue_scripts', array($this, 'asmh_enqueue_style'));
    add_action('wp_enqueue_scripts', array($this, 'asmh_enqueue_script'));

    add_action('wp_footer', array($this, 'load_header_tpl'), 20);
  }


  public function add_action_links($links)
  {
    return array_merge(
      array(
        'settings'	=> '<a href="'
          . admin_url('themes.php?page=awesome-header') . '">' . __('Settings', ASMH_LANG) . '</a>'
      ),
      $links
    );
  }


  public static function get_instance()
  {
    if (!isset(self::$instance)) {
      self::$instance = new Main();
    }

    return self::$instance;
  }


  public static function init()
  {
    $GLOBALS['asmh'] = self::get_instance();
    $GLOBALS['asmh']->set_vars();
  }


  public function register_scripts($hook)
  {
    if ('appearance_page_awesome-header' != $hook) return;

    wp_enqueue_media();

    wp_enqueue_script(
      'asmh-color',
      ASMH_ASSETS_URL . 'js/jscolor/jscolor.js'
    );

    wp_enqueue_script(
      'asmh-uploader',
      ASMH_ASSETS_URL . 'js/asmh-uploader.js',
      array('jquery')
    );

    wp_register_script(
      'asmh-main',
      ASMH_ASSETS_URL . 'js/main.js',
      array('jquery')
    );

    wp_localize_script('asmh-main', 'asmhObject', array(
      'header_paddings' => $GLOBALS['asmh']->settings['header_paddings'],
      'settings' => $GLOBALS['asmh']->settings
    ));

    wp_enqueue_script('asmh-main');

    wp_enqueue_script('jquery-ui-slider');
    wp_enqueue_style(
        'asmh-jquery-ui',
        ASMH_ASSETS_URL . 'css/jquery-ui/jquery-ui.min.css'
    );
    wp_enqueue_style(
        'asmh-jquery-ui-structure',
        ASMH_ASSETS_URL . 'css/jquery-ui/jquery-ui.structure.min.css'
    );
    wp_enqueue_style(
        'asmh-jquery-ui-theme',
        ASMH_ASSETS_URL . 'css/jquery-ui/jquery-ui.theme.min.css'
    );

    wp_enqueue_style(
      'asmh-preview',
      '/asmh/styles/preview'
    );

    wp_enqueue_style(
      'asmh-admin',
      ASMH_ASSETS_URL . 'css/admin.css'
    );

    wp_enqueue_style(
      'asmh-custom-fonts',
      ASMH_ASSETS_URL . 'fonts/asmh.css'
    );

    if ($this->settings['use_genericons']) {
      wp_enqueue_style(
        'asmh-genericons-fonts',
        ASMH_ASSETS_URL . 'fonts/genericons/genericons.css'
      );
    }
  }


  public function asmh_enqueue_style()
  {
    wp_enqueue_style(
      'asmh-styles',
      '/asmh/styles'
    );

    if ($this->settings['use_genericons']) {
      wp_enqueue_style(
        'asmh-genericons-fonts',
        ASMH_ASSETS_URL . 'fonts/genericons/genericons.css'
      );
    }

    // search icon
    wp_enqueue_style(
      'asmh-custom-fonts',
      ASMH_ASSETS_URL . 'fonts/asmh.css'
    );
  }


  public function asmh_enqueue_script()
  {
    wp_register_script(
      'asmh-main',
      ASMH_ASSETS_URL . 'js/asmh.js',
      array('jquery')
    );

    wp_localize_script('asmh-main', 'asmhObject', array(
      'sticky_scroll_position' => $GLOBALS['asmh']->settings['sticky_start'],
      'header_paddings' => $GLOBALS['asmh']->settings['header_paddings'],
      'menu_padding' => $GLOBALS['asmh']->settings['menu_padding']
    ));

    wp_enqueue_script('asmh-main');
  }


  public function load_header_tpl()
  {
      $header = $this->print_header(false, true);

      echo <<<TEMPLATE
<script type="text/html" id="asmh-tpl">{$header}</script>
TEMPLATE;
  }


  public function add_settings_page()
  {
    $page = add_submenu_page(
      'themes.php',
      'Awesome Header', 'Awesome Header',
      'manage_options',
      'awesome-header',
      array($this, 'settings_page')
    );
  }


  public function settings_init()
  {
    register_setting(
      'asmh_header_group',
      'asmh_settings',
      array($this, 'sanitize')
    );

    add_settings_section(
      'asmh_middle_section',
      __('Main Navigation', ASMH_LANG),
      null,
      'asmh_middle_section'
    );

    add_settings_section(
      'asmh_general_section',
      __('General', ASMH_LANG),
      null,
      'asmh_general_section'
    );

    add_settings_field(
      'middle_menu',
      __('Choose menu', ASMH_LANG),
      array($this, 'middle_menu_func'),
      'asmh_middle_section',
      'asmh_middle_section'
    );

    add_settings_field(
      'menu_depth',
      __('Menu depth', ASMH_LANG),
      array($this, 'menu_depth_func'),
      'asmh_middle_section',
      'asmh_middle_section'
    );

    add_settings_field(
      'logo',
      __('Logo image upload', ASMH_LANG),
      array($this, 'logo_func'),
      'asmh_middle_section',
      'asmh_middle_section'
    );

    add_settings_field(
      'logo_type',
      __('Choose your logo type', ASMH_LANG),
      array($this, 'logo_type_func'),
      'asmh_middle_section',
      'asmh_middle_section'
    );

    add_settings_field(
        'menu_padding',
        __('Menu padding (top/bottom)', ASMH_LANG),
        array($this, 'menu_padding_func'),
        'asmh_middle_section',
        'asmh_middle_section'
    );

    add_settings_field(
        'brand_padding',
        __('Logo padding (top/bottom)', ASMH_LANG),
        array($this, 'brand_padding_func'),
        'asmh_middle_section',
        'asmh_middle_section'
    );


    add_settings_field(
      'middle_position',
      __('Menu position', ASMH_LANG),
      array($this, 'middle_position_func'),
      'asmh_middle_section',
      'asmh_middle_section'
    );

    add_settings_field(
      'middle_items_padding',
      __('Menu items padding (left/right)', ASMH_LANG),
      array($this, 'middle_items_padding_func'),
      'asmh_middle_section',
      'asmh_middle_section'
    );

    add_settings_field(
      'sticky_start',
      __('Sticky scroll position', ASMH_LANG),
      array($this, 'sticky_start_func'),
      'asmh_general_section',
      'asmh_general_section'
    );

    add_settings_field(
      'middle_background_image',
      __('Background image URL', ASMH_LANG),
      array($this, 'background_image_func'),
      'asmh_middle_section',
      'asmh_middle_section'
    );

    add_settings_field(
      'middle_background_color',
      __('Background color', ASMH_LANG),
      array($this, 'background_color_func'),
      'asmh_middle_section',
      'asmh_middle_section'
    );

    add_settings_field(
        'site_title_color',
        __('Site title color', ASMH_LANG),
        array($this, 'site_title_color_func'),
        'asmh_middle_section',
        'asmh_middle_section'
    );

    add_settings_field(
      'site_desc_color',
      __('Site description color', ASMH_LANG),
      array($this, 'site_desc_color_func'),
      'asmh_middle_section',
      'asmh_middle_section'
    );

    add_settings_field(
        'middle_link_color',
        __('Menu color', ASMH_LANG),
        array($this, 'link_color_func'),
        'asmh_middle_section',
        'asmh_middle_section'
    );

    add_settings_field(
        'site_title_font_size',
        __('Site title font size', ASMH_LANG),
        array($this, 'site_title_font_size_func'),
        'asmh_middle_section',
        'asmh_middle_section'
    );

    add_settings_field(
        'site_desc_font_size',
        __('Site description font size', ASMH_LANG),
        array($this, 'site_desc_font_size_func'),
        'asmh_middle_section',
        'asmh_middle_section'
    );

    add_settings_field(
        'middle_text_size',
        __('Menu font size', ASMH_LANG),
        array($this, 'text_size_func'),
        'asmh_middle_section',
        'asmh_middle_section'
    );

    add_settings_field(
      'middle_menu_item_background_color',
      __('Menu item hover background color', ASMH_LANG),
      array($this, 'middle_menu_item_background_color_func'),
      'asmh_middle_section',
      'asmh_middle_section'
    );


    //
    // Border begin
    //

    add_settings_field(
      'border_top',
      __('Top border', ASMH_LANG),
      array($this, 'border_func'),
      'asmh_middle_section',
      'asmh_middle_section',
      array('line' => 'top')
    );

    add_settings_field(
      'border_bottom',
      __('Bottom border', ASMH_LANG),
      array($this, 'border_func'),
      'asmh_middle_section',
      'asmh_middle_section',
      array('line' => 'bottom')
    );

    add_settings_field(
      'hamburger_color',
      __('Hamburger icon color', ASMH_LANG),
      array($this, 'hamburger_color_func'),
      'asmh_middle_section',
      'asmh_middle_section'
    );

    //
    // Border end
    //


    add_settings_field(
      'middle_hide_menu_width',
      __('Hide menu if narrower than', ASMH_LANG) . ':',
      array($this, 'middle_hide_menu_width_func'),
      'asmh_middle_section',
      'asmh_middle_section'
    );


    add_settings_field(
      'has_search',
      __('Include search box', ASMH_LANG),
      array($this, 'has_search_func'),
      'asmh_middle_section',
      'asmh_middle_section'
    );


    add_settings_field(
        'has_secondary',
        __('Include secondary menu', ASMH_LANG),
        array($this, 'has_secondary_func'),
        'asmh_middle_section',
        'asmh_middle_section'
    );

    add_settings_field(
        'secondary_menu',
        __('Choose secondary menu', ASMH_LANG),
        array($this, 'secondary_menu_func'),
        'asmh_middle_section',
        'asmh_middle_section'
    );

    add_settings_field(
      'middle_submenu_background_color',
      __('Sub-menu background color', ASMH_LANG),
      array($this, 'background_submenu_color_func'),
      'asmh_middle_section',
      'asmh_middle_section'
    );

    add_settings_field(
      'middle_submenu_hover_color',
      __('Sub-menu item hover background color', ASMH_LANG),
      array($this, 'background_submenu_hover_color_func'),
      'asmh_middle_section',
      'asmh_middle_section'
    );

    add_settings_field(
      'sub_menu_orientation',
      __('Sub-menu orientation', ASMH_LANG),
      array($this, 'sub_menu_orientation_func'),
      'asmh_middle_section',
      'asmh_middle_section'
    );

    add_settings_field(
      'width',
      __('Header width', ASMH_LANG),
      array($this, 'header_width_func'),
      'asmh_general_section',
      'asmh_general_section'
    );

    add_settings_field(
      'stretch',
      __('Full width stretch', ASMH_LANG),
      array($this, 'stretch_func'),
      'asmh_general_section',
      'asmh_general_section'
    );

    add_settings_field(
      'position',
      __('Header position', ASMH_LANG),
      array($this, 'position_func'),
      'asmh_general_section',
      'asmh_general_section'
    );

    add_settings_field(
      'show_description',
      __('Show description', ASMH_LANG),
      array($this, 'show_description_func'),
      'asmh_general_section',
      'asmh_general_section'
    );

    add_settings_field(
      'sticky_animate',
      __('Sticky animation', ASMH_LANG),
      array($this, 'sticky_animate_func'),
      'asmh_general_section',
      'asmh_general_section'
    );

    add_settings_field(
      'hover_transition',
      __('Hover transition', ASMH_LANG),
      array($this, 'hover_transition_func'),
      'asmh_general_section',
      'asmh_general_section'
    );

    add_settings_section(
      'asmh_css_section',
      __('CSS', ASMH_LANG),
      null,
      'asmh_css_section'
    );

    add_settings_field(
      'custom_css',
      __('Your own styles', ASMH_LANG),
      array($this, 'custom_css_func'),
      'asmh_css_section',
      'asmh_css_section'
    );

    add_settings_section(
        'asmh_extras_section',
        __('More features', ASMH_LANG),
        null,
        'asmh_extras_section'
    );


    add_settings_field(
        'middle_transparency_level',
        __('Transparency level', ASMH_LANG)
        . ' (<span id="asmh-slider-middle-amount">' . $this->settings['middle_transparency_level'] . '</span>)',
        array($this, 'transparency_level_func'),
        'asmh_extras_section',
        'asmh_extras_section',
        array('type' => 'middle')
    );

    add_settings_field(
        'submenu_transparency_level',
        __('Sub-menu transparency level', ASMH_LANG)
        . ' (<span id="asmh-slider-submenu-amount">' . $this->settings['submenu_transparency_level'] . '</span>)',
        array($this, 'transparency_level_func'),
        'asmh_extras_section',
        'asmh_extras_section',
        array('type' => 'submenu')
    );

    add_settings_section(
        'asmh_gopro_section',
        __('Awesome Header', ASMH_LANG),
        array($this, 'gopro_top_func'),
        'asmh_gopro_section'
    );

    add_settings_field(
        '',
        __('More features', ASMH_LANG),
        array($this, 'gopro_func'),
        'asmh_gopro_section',
        'asmh_gopro_section'
    );
  }


  public function settings_page()
  {
?>
    <div class="wrap asmh-wrap">
    <form method="post" action="options.php"
      enctype="multipart/form-data">

      <?php settings_fields('asmh_header_group'); ?>

      <h2 class="header-navs nav-tab-wrapper">
        <a class="nav-tab nav-tab-active" href="javascript:;">
          <?php _e('General', ASMH_LANG); ?>
        </a>

        <a class="nav-tab" href="javascript:;">
          <?php _e('Header', ASMH_LANG); ?>
        </a>

        <a class="nav-tab" href="javascript:;">
          <?php _e('Custom CSS', ASMH_LANG); ?>
        </a>

        <a class="nav-tab" href="javascript:;">
          <?php _e('Extras', ASMH_LANG); ?>
        </a>

        <a class="nav-tab" href="javascript:;">
          <?php _e('Go PRO', ASMH_LANG); ?>
        </a>
      </h2>

      <?php settings_errors(); ?>

      <?php $this->print_header(true); ?>

      <div class="nav-tab-content">
        <?php do_settings_sections('asmh_general_section'); ?>
      </div>

      <div class="nav-tab-content" style="display:none;">
        <?php do_settings_sections('asmh_middle_section'); ?>
      </div>

      <div class="nav-tab-content" style="display:none;">
        <?php do_settings_sections('asmh_css_section'); ?>
      </div>

      <div class="nav-tab-content" style="display:none;">
        <?php do_settings_sections('asmh_extras_section'); ?>
      </div>

      <div class="nav-tab-content" style="display:none;">
        <?php do_settings_sections('asmh_gopro_section'); ?>
      </div>

      <input name="submit" type="submit"
        class="button button-primary"
        value="<?php esc_attr_e('Save Changes', ASMH_LANG); ?>" />

      <button name="reset" type="submit" value="reset"
        class="button button-primary reset"><?php
        esc_attr_e('Reset', ASMH_LANG); ?></button>
    </form>
    </div>
<?php
  }


  public function middle_menu_func()
  {
    $nav = $this->find_menu_by_id_setting('middle');
?>
    <select name="asmh_settings[middle_menu_id]" style="width: 200px;">
      <?php foreach ($this->navs as $nav) { ?>
      <option value="<?php echo $nav->term_id; ?>"
      <?php if ($nav->term_id == $this->middle->id)
        echo 'selected'; ?>><?php echo $nav->name; ?></option>
      <?php } ?>
    </select>
<?php
  }


  public function secondary_menu_func()
  {
  ?>
      <select name="asmh_settings[secondary_menu_id]" style="width: 200px;">
        <option value="">Select...</option>
        <?php foreach ($this->navs as $nav) { ?>
          <?php if ($nav->term_id == $this->settings['middle_menu_id']) continue; ?>
          <option value="<?php echo $nav->term_id; ?>"
          <?php if (!empty($this->settings['secondary_menu_id']) &&
            $nav->term_id == $this->settings['secondary_menu_id'])
              echo 'selected'; ?>><?php echo $nav->name; ?></option>
        <?php } ?>
      </select>
  <?php
  }


  public function menu_depth_func()
  {
?>
    <input type="number" style="width: 70px;"
      name="asmh_settings[menu_depth]"
      value="<?php echo $this->settings['menu_depth']; ?>">
<?php
  }


  public function logo_func() {
    $logo_src = $this->middle->get_logo_src();
    $logo_id = $this->settings['logo_id'];
    ?>
    <div class="asmh-logo-wrap">
      <figure>
        <?php if (!empty($logo_src)) { ?>
          <img class="asmh-upload-preview" src="<?php
            echo $logo_src; ?>">
        <?php } ?>
      </figure>

      <p><button type="button"
        class="button asmh-upload"><?php
          _e('Select an image...', ASMH_LANG);
        ?></button> <span
          class="asmh-upload-text"><?php echo $logo_src; ?></span></p>

      <p><button type="submit" name="logo_remove"
      class="button"><?php _e('Remove', ASMH_LANG); ?></button></p>

      <input id="asmh-upload-id"
        type="hidden" name="asmh_settings[logo_id]"
        value="<?php echo $logo_id; ?>">
    </div>
<?php }


  public function logo_type_func()
  {
    $type = $this->settings['logo_type'];
    ?>
    <fieldset>
      <label>
        <input type="radio"
          name="asmh_settings[logo_type]"
          onchange="asmh.headerLogo(this)"
          value="image"<?php
            if ($type == 'image') { ?> checked="checked"<?php } ?>>
        <span><?php _e('Image', ASMH_LANG); ?></span>
        <br>
            <p style="padding-left: 25px;">
                <small><?php _e('Max. width:', ASMH_LANG); ?></small>
                <input type="number" value="<?php echo $this->settings['logo_max_width']; ?>"
                    name="asmh_settings[logo_max_width]"
                    onchange="asmh.logoMaxWidth(this)"
                    placeholder="200" style="width:60px;"> px
            </p>

      </label>
        <br>
      <label>
        <input type="radio"
          name="asmh_settings[logo_type]"
          onchange="asmh.headerLogo(this)"
          value="text"<?php
          if ($type == 'text') { ?> checked="checked"<?php } ?>>
        <span><?php _e('Text', ASMH_LANG); ?></span>
        <input type="text" class="regular-text"
          name="asmh_settings[logo_text]"
          onchange="asmh.logoText(this)"
          value="<?php echo $this->settings['logo_text']; ?>">
      </label>
        <br>
      <label>
        <input type="radio"
          name="asmh_settings[logo_type]"
          onchange="asmh.headerLogo(this)"
          value="site"<?php
          if ($type == 'site') { ?> checked="checked"<?php } ?>>
        <span><?php _e('Site title', ASMH_LANG); ?></span>
      </label>
    </fieldset>
<?php }



  public function menu_padding_func() {
      ?>
        <input type="number" style="width: 70px;" min="10"
          onchange="asmh.menuPadding(this)"
          name="asmh_settings[menu_padding]"
          value="<?php echo $this->settings['menu_padding']; ?>"> px
  <?php
  }


  public function brand_padding_func() {
      ?>
        <input type="number" style="width: 70px;"
          onchange="asmh.brandPadding(this)"
          name="asmh_settings[brand_padding]"
          value="<?php echo $this->settings['brand_padding']; ?>"> px
    <?php
  }


  public function middle_position_func($params) {
?>
    <select name="asmh_settings[middle_position]"
      onchange="asmh.middlePosition(this)">
    <?php asmh_option_tags('middle_position', array(
        'right'  => __('Right', ASMH_LANG),
        'center' => __('Center', ASMH_LANG)
      )); ?>
    </select>
<?php
  }


  public function middle_items_padding_func() {
      $val = $this->settings['middle_items_padding'];

      $html = <<<HTML
          <input type="number" min="0" name="asmh_settings[middle_items_padding]"
              style="width:50px;"
              onchange="asmh.middleItemsPadding(this)"
              value="{$val}"> px
HTML;

      echo $html;
  }


  public function background_image_func($params) {
?>
    <input type="text"
      style="width:400px;"
      placeholder="http://"
      onchange="asmh.backgroundImage(this)"
      name="asmh_settings[middle_background_image]"
      value="<?php echo $this->settings['middle_background_image']; ?>">

    <select name="asmh_settings[middle_background_repeat]"
      onchange="asmh.backgroundRepeat(this)"
      style="width:100px;"
      value="<?php echo $this->settings['middle_background_repeat']; ?>">

    <?php asmh_option_tags('middle_background_repeat', array(
        'no-repeat' => 'no-repeat',
        'repeat-x' => 'repeat-x',
        'repeat-y' => 'repeat-y',
        'repeat' => 'repeat'
      )); ?>
    </select>
<?php
  }


  public function background_color_func() {
?>
    <input type="text"
      class="color {adjust:false}"
      onchange="asmh.backgroundColor('middle', this)"
      name="asmh_settings[middle_background_color]"
      value="<?php echo $this->settings['middle_background_color']; ?>">
<?php
  }


  public function background_submenu_color_func() {
?>
    <input type="text"
      class="color {adjust:false}"
      onchange="asmh.backgroundColor('submenu', this)"
      name="asmh_settings[middle_submenu_background_color]"
      value="<?php echo $this->settings['middle_submenu_background_color']; ?>">
<?php
  }


  public function background_submenu_hover_color_func() {
?>
    <input type="text"
      class="color {adjust:false}"
      name="asmh_settings[middle_submenu_hover_color]"
      value="<?php echo $this->settings['middle_submenu_hover_color']; ?>">
<?php
  }


  public function border_func($params) {
    $type = 'middle';
    $line = $params['line'];
?>
    <input type="text"
      class="color {adjust:false}"
      onchange="asmh.borderColor('<?php echo $type; ?>', '<?php echo $line; ?>', this)"
      name="asmh_settings[<?php echo $type; ?>_<?php echo $line; ?>_border_color]"
      value="<?php echo $this->settings[$type.'_'.$line.'_border_color']; ?>">

    <input type="number" placeholder="<?php _e('Width', ASMH_LANG); ?>"
      style="width: 70px;"
      onchange="asmh.borderWidth('<?php echo $type; ?>', '<?php echo $line; ?>', this)"
      name="asmh_settings[<?php echo $type; ?>_<?php echo $line; ?>_border_width]"
      value="<?php echo $this->settings[$type.'_'.$line.'_border_width']; ?>"> px
<?php
  }


  public function site_title_color_func() {
      $color = $this->settings['site_title_color'];

      echo <<<HTML
          <input type="text" class="color {adjust:false}"
              onchange="asmh.siteTitleColor(this)"
              name="asmh_settings[site_title_color]"
              value="{$color}">
HTML;
  }


  public function site_desc_color_func() {
      $color = $this->settings['site_desc_color'];

      echo <<<HTML
          <input type="text" class="color {adjust:false}"
              onchange="asmh.siteDescColor(this)"
              name="asmh_settings[site_desc_color]"
              value="{$color}">
HTML;
  }


  public function site_title_font_size_func() {
      $val = $this->settings['site_title_font_size'];

      echo <<< HTML
          <input type="number"
            style="width: 70px;"
            onchange="asmh.siteTitleSize(this)"
            name="asmh_settings[site_title_font_size]"
            value="{$val}"> px
HTML;
  }


  public function site_desc_font_size_func() {
      $val = $this->settings['site_desc_font_size'];

      echo <<< HTML
          <input type="number"
            style="width: 70px;"
            onchange="asmh.siteDescSize(this)"
            name="asmh_settings[site_desc_font_size]"
            value="{$val}"> px
HTML;
    }


  public function link_color_func($params = '') {
    $type = 'middle';
?>
    <input type="text" class="color {adjust:false}"
    onchange="asmh.linkColor('<?php echo $type; ?>', this)"
    name="asmh_settings[<?php echo $type; ?>_link_color]"
      value="<?php echo $this->settings[$type . '_link_color']; ?>">

    <span style="margin-left: 7px;"><?php _e('Hover', ASMH_LANG); ?></span>
    <input type="text" class="color {adjust:false}"
      name="asmh_settings[<?php echo $type; ?>_hover_color]"
      value="<?php echo $this->settings[$type . '_hover_color']; ?>">

    <span style="margin-left: 7px;"><?php _e('Active', ASMH_LANG); ?></span>
    <input type="text" class="color {adjust:false}"
      name="asmh_settings[<?php echo $type; ?>_active_color]"
      value="<?php echo $this->settings[$type . '_active_color']; ?>">
<?php
  }


  public function middle_menu_item_background_color_func() {
      $val = $this->settings['middle_menu_item_background_color'];
      $val_active = $this->settings['middle_menu_item_background_active_color'];
      $active_tr = __('Active', ASMH_LANG);

      $html = <<<HTML
          <input type="text" class="color {adjust:false}"
              name="asmh_settings[middle_menu_item_background_color]"
              value="{$val}">

          {$active_tr}: <input type="text" class="color {adjust:false}"
              name="asmh_settings[middle_menu_item_background_active_color]"
              value="{$val_active}">
HTML;

      echo $html;
  }


  public function text_size_func($params = '') {
    $type = 'middle';
?>
    <input type="number"
      style="width: 70px;"
      onchange="asmh.textSize('<?php echo $type; ?>', this)"
      name="asmh_settings[<?php echo $type; ?>_text_size]"
      value="<?php echo $this->settings[$type . '_text_size']; ?>"> px
<?php
  }


  public function has_search_func() {
    $checked = $this->settings['has_search'];

    echo asmh_checkbox_tag(array(
      'name' => 'asmh_settings[has_search]',
      'onchange' => 'asmh.toggleSearch()',
      'value' => $this->settings['has_search'],
      'checked' => $this->settings['has_search']
    ));
  }


  public function has_secondary_func() {
      $checked = $this->settings['has_search'];

      echo asmh_checkbox_tag(array(
          'name' => 'asmh_settings[has_secondary]',
          'onchange' => 'asmh.toggleSecondary()',
          'value' => $this->settings['has_secondary'],
          'checked' => $this->settings['has_secondary']
      ));
  }


  public function sub_menu_orientation_func() {
    $side = $this->settings['sub_menu_orientation'];

    ?><select name="asmh_settings[sub_menu_orientation]"
      value="<?php echo $this->settings['sub_menu_orientation']; ?>">
    <?php asmh_option_tags('sub_menu_orientation', array(
      'right' => __('Right', ASMH_LANG),
      'left' => __('Left', ASMH_LANG)
    ));
    echo '</select>';
  }


  public function position_func() {
    ?><select name="asmh_settings[position]"
      value="<?php echo $this->settings['position']; ?>">
    <?php asmh_option_tags('position', array(
      'center' => __('Center', ASMH_LANG),
      'left' => __('Left', ASMH_LANG),
      'right' => __('Right', ASMH_LANG)
    ));
    echo '</select>';
  }


  public function center_content_func($params) {
    $type = 'middle';
    $checked = $this->settings["center_content_{$type}"];

    echo asmh_checkbox_tag(array(
      'name' => "asmh_settings[center_content_{$type}]",
      'value' => $this->settings["center_content_{$type}"],
      'onchange' => "asmh.centerContent('{$type}', this)",
      'checked' => $this->settings["center_content_{$type}"]
    ));
  }


  public function header_width_func() {
?>
    <input type="number" name="asmh_settings[width]"
      onchange="asmh.width(this)"
      style="width: 70px;"
      value="<?php echo $this->settings['width']; ?>"> px
    <p class="description">Leave blank for 100% width</p>
<?php
  }


  public function stretch_func() {
    $checked = $this->settings['stretch'];

    echo asmh_checkbox_tag(array(
      'name' => 'asmh_settings[stretch]',
      'value' => $this->settings['stretch'],
      'checked' => $this->settings['stretch']
    ));
  }


  public function load_genericons() {
    $checked = $this->settings['load_genericons'];

    echo asmh_checkbox_tag(array(
      'name' => 'asmh_settings[load_genericons]',
      'value' => $this->settings['load_genericons'],
      'checked' => $this->settings['load_genericons']
    ));
  }


  public function show_description_func() {
    $checked = $this->settings['show_description'];

    echo asmh_checkbox_tag(array(
      'name' => 'asmh_settings[show_description]',
      'onchange' => 'asmh.toggleDescription()',
      'value' => $this->settings['show_description'],
      'checked' => $this->settings['show_description']
    ));
  }


  public function sticky_animate_func() {
    $checked = $this->settings['sticky_animate'];

    echo asmh_checkbox_tag(array(
      'name' => 'asmh_settings[sticky_animate]',
      'value' => $this->settings['sticky_animate'],
      'checked' => $this->settings['sticky_animate']
    ));
  }


  public function hover_transition_func() {
    $checked = $this->settings['hover_transition'];

    echo asmh_checkbox_tag(array(
      'name' => 'asmh_settings[hover_transition]',
      'value' => $this->settings['hover_transition'],
      'checked' => $this->settings['hover_transition']
    ));
  }


  public function custom_css_func() {
  ?><textarea name="asmh_settings[custom_css]" rows="20" cols="50"
      placeholder=".asmh-header {...}"><?php echo $this->settings['custom_css'];
    ?></textarea>
<?php
  }


  public function transparency_level_func($params) {
      echo '<div id="asmh-slider-' . $params['type'] . '" style="width:600px; margin-bottom:10px;"></div>';

      echo '<input type="hidden" name="asmh_settings['
         . $params['type'] . '_transparency_level]" id="asmh-slider-'
         . $params['type'] . '-val" value="'
           . $this->settings[$params['type'] . '_transparency_level'] . '">';
  }


  public function sticky_start_func() {
?>
    <input type="number" style="width: 70px;"
      name="asmh_settings[sticky_start]"
      placeholder="30"
      value="<?php echo $this->settings['sticky_start']; ?>"> px
<?php
  }


  public function hamburger_color_func() {
?>
    <input type="text" class="color {adjust:false}"
    onchange="asmh.hamburgerColor(this)"
    name="asmh_settings[hamburger_color]"
      value="<?php echo $this->settings['hamburger_color']; ?>">
<?php
  }


  public function middle_hide_menu_width_func() {
?>
    <input type="number" style="width: 80px;"
      name="asmh_settings[middle_hide_menu_width]"
      placeholder="768"
      value="<?php echo $this->settings['middle_hide_menu_width']; ?>"> px
<?php
  }


  public function gopro_func() {
      $str1 = __('In addition to main (middle) header which comes as sticky in free plugin version
              you can have Top & Bottom headers (above & below middle header respectively)', ASMH_LANG);

      $str2 = __('More places for menus for top & bottom headers', ASMH_LANG);

      $str3 = __('Breadcrumbs which search engines can read and improve your visibility
              in search results and SEO (WooCommerce & bbPress pages included)', ASMH_LANG);

      $str4 = __('Social icons menu & Genericons icons support', ASMH_LANG);

      $str5 = __('Page title, or sub-menu items, or another menu in bottom header', ASMH_LANG);

      $str6 = __('Menu paddings for header & sticky header, so for example your sticky header
              can be set as smaller', ASMH_LANG);

      $str7 = __('All settings that come for main header (colors, backgrounds, paddings,
              transparency, etc.) are also available for Top & Bottom headers', ASMH_LANG);

      $str8 = __('More filters!', ASMH_LANG);


      echo <<<HTML
        <ol>
          <li>{$str1}</li>
          <li>{$str2}</li>
          <li>{$str3}</li>
          <li>{$str4}</li>
          <li>{$str5}</li>
          <li>{$str6}</li>
          <li>{$str7}</li>
          <li>{$str8}</li>
        </ol>
HTML;
  }


  public function gopro_top_func() {
      echo '<p>' . str_replace(
          array('%a', '%b'),
          array('http://awesomeheader.com/', 'Awesome Header'),
          __('If you would like more control or to have the whole header,
             you could consider PRO version: <a href="%a" target="_blank">%b</a>')
      ) . '</p>';

     echo '<p>' . __('It includes not only sticky header, but your own header in whole, by replacing your existing header!', ASMH_LANG)
         . '</p>';

     echo '<a href="http://codecanyon.net/item/awesome-header/11358372" target="_blank">
             <img src="https://s3-us-west-1.amazonaws.com/awesomeheader/banner-image-11.jpg">
           </a>';
  }


  public function find_menu_by_id_setting($type)
  {
    return asmh_array_find($this->navs, 'term_id',
      $this->settings[$type . '_menu_id']);
  }


  private function set_vars() {
    $this->navs = wp_get_nav_menus();
    $this->set_settings();
    $this->customizer = new Customizer();
    $this->middle = new Middle();

    Nav::init();
  }


  private function set_settings() {
      $defaults = array(
                      'width' => '', // blank = 100%
                      'stretch' => true,
                      'contr_width' => '',
                      'menu_padding' => 25,
                      'brand_padding' => 20,
                      'use_genericons' => false,
                      'use_genericons_text' => false,
                      'sticky_animate' => true,
                      'hover_transition' => true,
                      'position' => 'center',
                      'header_paddings' => 15,
                      'middle_menu' => isset($this->navs[0])? $this->navs[0]:null,
                      'middle_menu_id' => isset($this->navs[0]->term_id)?
                        $this->navs[0]->term_id : null,
                      'secondary_menu_id' => null,
                      'menu_depth' => 3,
                      'load_genericons' => false,
                      'show_description' => true,
                      'logo_id' => null,
                      'logo_type' => 'site',
                      'logo_max_width' => 200,
                      'logo_src' => '',
                      'logo_text' => get_bloginfo('name'),
                      'middle_position' => 'right',
                      'middle_items_padding' => 8,
                      'middle_background_image' => '',
                      'middle_background_repeat' => 'repeat-x',
                      'middle_background_color' => 'FFFFFF',
                      'middle_submenu_background_color' => 'FFFFFF',
                      'middle_submenu_hover_color' => '',

                      'middle_top_border_color' => '000000',
                      'middle_top_border_width' => 0,
                      'middle_bottom_border_color' => '000000',
                      'middle_bottom_border_width' => 1,

                      'middle_transparency_level' => 100,
                      'submenu_transparency_level' => 100,

                      'site_title_color' => null,
                      'site_desc_color' => null,
                      'middle_link_color' => null,
                      'site_title_font_size' => 16,
                      'site_desc_font_size' => 12,
                      'middle_text_size' => 18,
                      'middle_menu_item_background_color' => 'DDDDDD',
                      'middle_menu_item_background_active_color' => null,
                      'middle_hover_color' => null,
                      'middle_active_color' => null,
                      'has_search' => true,
                      'has_secondary' => false,
                      'sticky_start' => 100,
                      'sub_menu_orientation' => 'right',
                      'hamburger_color' => '000000',
                      'middle_hide_menu_width' => 768,
                      'custom_css' => ''
      );

      $this->defaults = $defaults;
      $this->settings = get_option('asmh_settings', array());
      $this->settings = asmh_set_vars($defaults, $this->settings);

      $this->set_menus();
  }


  private function set_menus()
  {
      $type = 'middle';

      if (is_int($this->settings[$type . '_menu_id'])) {
          $this->settings[$type . '_menu'] =
            $this->find_menu_by_id_setting($type);
      }

      if (is_object($this->settings[$type . '_menu']) &&
        $this->settings[$type . '_menu']->term_id !=
        $this->settings[$type . '_menu_id'])
      {
          $this->settings[$type . '_menu'] =
            $this->find_menu_by_id_setting($type);
      }
  }


  /**
   * Print the whole header in backend or frontend.
   *
   * @param bool $is_preview is header as admin preview or real one on client side
   * @param bool $return should HTML be returned or echo'ed
   * @return void|string
   */
  public function print_header($is_preview = false, $return = false)
  {
      $this->is_preview = $is_preview;

      if ($return) {
          return $this->_header_content();
      } else {
          echo $this->_header_content();
      }
  }


  private function _header_content()
  {
      $class = $this->is_preview ? 'asmh-preview' : 'asmh-header';
      $before = apply_filters('asmh_middle_before', '');
      $after = apply_filters('asmh_middle_after', '');
      $content = $this->middle->content_main();

      return <<<HTML
      <div class="{$class}">
          <div>
              {$before}
              {$content}
              {$after}
          </div>
      </div>
HTML;
  }


  public function sanitize($input)
  {
    $new_input = array();

    // Delete all options, return to defaults
    if (isset($_POST['reset']) &&
      'reset' === $_POST['reset']) {

      delete_option('asmh_settings');
      return;
    }

    if (isset($_POST['logo_remove'])) {
      unset($input['logo_id']);
    }

    if (isset($input['logo_id']) && !empty($input['logo_id']) &&
      !isset($_POST['logo_remove'])) {

      $new_input['logo_id'] = $input['logo_id'];
    }

    foreach ($input as $key => $value) {
      if ($key == 'logo_id') continue;
      if ($value == 'true') $value = true;

      // if not color and is number
      if (is_numeric($value) && strlen($value) != 6 ||
        $key == 'menu_depth' || $key == 'logo_max_width') {

        $value = (integer) $value;
      }

      $new_input[$key] = $value;
    }

    if (!isset($input['has_search'])) {
      $new_input['has_search'] = false;
    } else $new_input['has_search'] = true;

    if (!isset($input['load_genericons'])) {
      $new_input['load_genericons'] = false;
    } else $new_input['load_genericons'] = true;

    if (!isset($input['show_description'])) {
      $new_input['show_description'] = false;
    } else $new_input['show_description'] = true;

    if (!isset($input['use_genericons'])) {
      $new_input['use_genericons'] = false;
    } else $new_input['use_genericons'] = true;

    if (!isset($input['use_genericons_text'])) {
        $new_input['use_genericons_text'] = false;
    } else $new_input['use_genericons_text'] = true;

    if (!isset($input['sticky_animate'])) {
      $new_input['sticky_animate'] = false;
    } else $new_input['sticky_animate'] = true;

    if (!isset($input['hover_transition'])) {
      $new_input['hover_transition'] = false;
    } else $new_input['hover_transition'] = true;

    if (!isset($input['stretch'])) {
      $new_input['stretch'] = false;
    } else $new_input['stretch'] = true;

    if (empty($input['sticky_start']) && $input['sticky_start'] !== '0') {
      $new_input['sticky_start'] = 100;
    }

    add_settings_error(
      'asmh_saved_changes',
      esc_attr('asmh_settings_updated'),
      __('Changes successfully saved', ASMH_LANG),
      'updated'
    );

    return $new_input;
  }
}
