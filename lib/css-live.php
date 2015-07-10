<?php
global $asmh;
$s = $settings = $asmh->settings;
$c = $asmh->customizer;

// php version < 5.5 produces error on empty function
// "Can't use function return value in write context"
function _asmh_empty_s($val) {
    if (!isset($val)) return true;
    return empty($val);
}
?>

.asmh-header
{
}

.asmh-header > div
{
  position: fixed;
  width: 100%;
  top: -300px;
  left: 0;
  z-index: 99;
<?php if ($asmh->settings['sticky_animate']) { ?>
  -webkit-transition: top .5s ease-in-out;
  -moz-transition: top .5s ease-in-out;
  -o-transition: top .5s ease-in-out;
  transition: top .5s ease-in-out;
<?php } ?>
}

<?php if ($s['logo_type'] == 'image') { ?>
.asmh-header .middle .brand
{
  font-size: 0;
}
<?php } ?>

.asmh-header ul > li > a,
.asmh-header ul > li > a > span
{
  display: inline-block;
}

.asmh-header .container:after
{
  clear: both;
}

.asmh-header .primary:after,
.asmh-header .primary:after ul
{
  clear: both;
}

.asmh-header .primary li
{
  position: relative;
}

.asmh-header, .asmh-header .container
{
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}

.asmh-header ul:before, .asmh-header ul:after,
.asmh-header nav:before, .asmh-header nav:after,
.asmh-header div:before, .asmh-header div:after
{
  content: " ";
  display: table;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}

.asmh-header .container
{
  width: 100%;
<?php if ($s['stretch'] && $s['position'] == 'left') { ?>
  margin-left: 0;
  margin-right: 0;
<?php } else { ?>
  margin-left: auto;
  margin-right: auto;
<?php } ?>
  padding-left: 15px;
  padding-right: 15px;
  position: relative;
}

.asmh-header .stick .container
{
  max-width: <?php if (empty($s['width'])) echo '100%';
    else echo $c::num_to_px($settings['width']); ?>;
}



/***************************        *****************************/
/*************************** MIDDLE *****************************/
/***************************        *****************************/

.asmh-header .middle
{
  font-size: <?php echo $c::num_to_px($s['middle_text_size']); ?>;
}

<?php if ($s['stretch'] && !empty($s['width']) && $s['position'] == 'right') { ?>
.asmh-header > .stick
<?php } else { ?>
.asmh-header .middle
<?php } ?>
{
  border-top-style: solid;
  border-bottom-style: solid;
<?php if (!_asmh_empty_s($c::to_color($s['middle_top_border_color']))) { ?>
  border-top-color: <?php echo $c::to_color($s['middle_top_border_color']); ?>;
<?php } ?>
<?php if (!_asmh_empty_s($c::to_color($s['middle_bottom_border_color']))) { ?>
  border-bottom-color: <?php echo $c::to_color($s['middle_bottom_border_color']); ?>;
<?php } ?>
<?php if ($c::to_color($s['middle_top_border_width'])) { ?>
  border-top-width: <?php echo $c::num_to_px($s['middle_top_border_width']); ?>;
<?php } else { ?>
  border-top-width: 0px;
<?php } ?>
<?php if ($c::to_color($s['middle_bottom_border_width'])) { ?>
  border-bottom-width: <?php echo $c::num_to_px($s['middle_bottom_border_width']); ?>;
<?php } else { ?>
  border-bottom-width: 0px;
<?php } ?>
}

<?php if ($s['stretch'] && !empty($s['width']) && $s['position'] == 'right') { ?>
.asmh-header > .stick
<?php } else { ?>
.asmh-header .middle
<?php } ?>
{
  background-color: <?php echo $c::to_color($s['middle_background_color']); ?>;
  background-color: rgba(<?php
      echo $c::hex2rgb(
              $s['middle_background_color'],
              $s['middle_transparency_level']
      ); ?>);
  <?php if (!empty($s['middle_background_image'])) {
    echo 'background-image: '
      . $c::to_url($s['middle_background_image']) . ';';
  } ?>
  background-repeat: <?php echo $s['middle_background_repeat']; ?>;
}

<?php if (!$s['stretch'] && (!empty($s['width']) || $s['position'] != 'right')) { ?>
.asmh-header .middle
{
  max-width: <?php echo $c::num_to_px($s['width']); ?>;
}
<?php } ?>

<?php if ($s['position'] == 'center') { ?>
.asmh-header .middle
{
  margin: auto;
}
<?php } elseif ($s['position'] == 'right') { ?>
.asmh-header .middle
{
  float: right;
}
<?php } ?>

.asmh-header .nav-wrap
{
  overflow: hidden;
<?php if ($s['middle_position'] == 'left') { ?>
  float: right;
  text-align: right;
<?php } elseif ($s['middle_position'] == 'center') { ?>
  float: none;
  margin: 0 auto;
  text-align: center;
<?php } else { ?>
  float: left;
<?php } ?>
  padding: <?php echo $s['brand_padding']; ?>px 0;
}

.asmh-header .brand
{
  display: block;
  font-size: <?php echo $c::num_to_px($s['site_title_font_size']); ?>;
  line-height: 1;
<?php if (!empty($s['site_title_color'])) { ?>;
  color: <?php echo $c::to_color($s['site_title_color']); ?>;
<?php } ?>
}

.asmh-header .brand img
{
  max-width: <?php echo $s['logo_max_width']; ?>px;
}

<?php if ($s['middle_position'] == 'center' && !$s['show_description']) { ?>
.asmh-header .brand img
{
  vertical-align: middle;
}
<?php } ?>

.asmh-header .description
{
  font-style: normal;
  font-size: <?php echo $c::num_to_px($s['site_desc_font_size']); ?>;
  margin: 0;
  line-height: 1;
<?php if (!empty($s['site_desc_color'])) { ?>;
  color: <?php echo $c::to_color($s['site_desc_color']); ?>;
<?php } ?>
}

@media (max-width: <?php echo $c::num_to_px($s['middle_hide_menu_width']); ?>)
{
  .asmh-header .description
  {
    line-height: 2;
  }
}

.asmh-header .brand img
{
  height: auto;
}

<?php if ($s['middle_position'] != 'center') { ?>
<?php if (!$s['show_description']) { ?>
.asmh-header .brand img
{
  vertical-align: middle;
}
<?php } ?>

.asmh-header .stick .brand img
{
  width: 80%;
  padding: 5px 0;
}
<?php } ?>

.asmh-header .primary
{
  overflow: visible;
}

.asmh-header .primary > ul
{
<?php if ($s['middle_position'] == 'left') { ?>
  float: left;
  margin:  0 0 0 <?php echo -1 * $s['header_paddings']; ?>px;
<?php } elseif ($s['middle_position'] == 'center') { ?>
  float: none;
  text-align: center;
  margin: 0;
<?php } else { ?>
  float: right;
  margin: 0;
<?php } ?>
  padding: 0;
  list-style: none;
}

.asmh-header .primary > ul > li
{
<?php if ($s['middle_position'] == 'center') { ?>
  float: none;
  display: inline-block;
<?php } else { ?>
  float: left;
  display: block;
<?php } ?>
  text-align: left;
  position: relative;
  padding: <?php echo $s['menu_padding']; ?>px 0;
<?php if ($s['hover_transition']) { ?>
  transition: background-color 0.4s ease-in-out;
<?php } ?>
}

.asmh-header .primary > ul > li.active,
.asmh-header .primary > ul > li.current-menu-item,
.asmh-header .primary > ul > li.current_page_item
{
  background-color: #<?php echo $s['middle_menu_item_background_active_color']?>;
}

.asmh-header .primary > ul > li:hover
{
  background-color: #<?php echo $s['middle_menu_item_background_color']?>;
}

.asmh-header .primary > ul > li.search:hover,
.asmh-header .primary > ul > li.secondary:hover
{
  background-color: transparent !important;
}

<?php if ($s['middle_position'] == 'right') { ?>
.asmh-header .primary > ul > li:last-child
{
  padding-right: 0 !important;
}
<?php } ?>

<?php if ($s['middle_position'] == 'left') { ?>
.asmh-header .primary > ul > li:first-child
{
  padding-left: 0 !important;
}
<?php } ?>

.asmh-header .primary > ul > li.secondary
{
  text-align: left;
  padding: <?php echo $s['menu_padding'] - 10; ?>px 10px 0;
  margin-top: 1px;
}

@media (max-width: <?php echo $c::num_to_px($s['middle_hide_menu_width']); ?>)
{
  .asmh-header .primary > ul > li.secondary
  {
    padding: 0;
  }
}

.asmh-header .primary > ul > li.search > a
{
  display: inline-block;
  padding-bottom: 0;
  vertical-align: top;
}

@media (max-width: <?php echo $c::num_to_px($s['middle_hide_menu_width']); ?>) {
  .asmh-header .primary > ul > li.search > a
  {
    padding: 15px;
  }
}

.asmh-header .primary > ul > li.search
{
  background-color: transparent;
}

.asmh-header .primary > ul > li.search > a:before
{
  display: inline-block;
  vertical-align: middle;
}

.asmh-header .primary > ul > li.search form
{
  width: 0;
  visibility: hidden;
  display: inline-block;
  overflow: visible !important;
  bottom: 5px;
  position: relative;
  padding: 0;
<?php if (!empty($s['middle_link_color'])) { ?>
  border-bottom: 1px solid <?php echo $c::to_color($s['middle_link_color']); ?>;
<?php } else { ?>
  border-bottom: 1px solid gray;
<?php } ?>
  transition: all 0.4s ease;
  -o-transition: all 0.4s ease;
  -moz-transition: all 0.4s ease;
  -webkit-transition: all 0.4s ease;
}

.asmh-header .primary > ul > li.search:hover form,
.asmh-header .primary > ul > li.search.a form
{
  margin-right: -1px;
  width: 180px;
  visibility: visible;
}

.asmh-header .primary > ul > li.search:hover > .icon-search,
.asmh-header .primary > ul > li.search.a > .icon-search
{
  position: relative;
}

@media (max-width: <?php echo $c::num_to_px($s['middle_hide_menu_width']); ?>)
{
  .asmh-header .primary > ul > li.search:hover > .icon-search,
  .asmh-header .primary > ul > li.search.a > .icon-search
  {
    margin-left: 0;
    left: 0;
  }
}

.asmh-header .primary > ul > li.search form input
{
  visibility: hidden;
}

.asmh-header .primary > ul > li.search.a form input
{
  visibility: visible;
}

.asmh-header .primary > ul > li.search > div:before,
.asmh-header .primary > ul > li.search > div:after
{
  content: "";
  display: none;
}

.asmh-header .primary > ul > li.search > div
{
  position: relative;
  width: 1px;
  height: 5px;
  bottom: -9px;
  display: none;
<?php if (!empty($s['middle_link_color'])) { ?>
  border-right: 1px solid <?php echo $c::to_color($s['middle_link_color']); ?>;
<?php } else { ?>
  border-right: 1px solid gray;
<?php } ?>
}

.asmh-header .primary > ul > li.search:hover > div,
.asmh-header .primary > ul > li.search.a > div
{
  display: inline-block;
}

.asmh-header .primary > ul > li.search form input
{
  width: 100%;
  border: none;
  background: transparent;
  -webkit-box-shadow: none;
  -moz-box-shadow: none;
  box-shadow: none;
  padding: 0 7px;
  margin: 0 0 2px;
  font-size: <?php echo $c::num_to_px($s['middle_text_size'] - 2); ?>;
<?php if ($s['middle_position'] == 'center') { ?>
  height: 32px;
<?php } ?>
}

@media (max-width: <?php echo $c::num_to_px($s['middle_hide_menu_width']); ?>)
{
  .asmh-header .primary > ul > li.search form input
  {
    padding: 0 7px;
  }
}

@media (max-width: <?php echo $c::num_to_px($s['middle_hide_menu_width']); ?>)
{
  .asmh-header .primary > ul > li
  {
    padding: 0;
  }
}

<?php if ($s['middle_position'] == 'center') { ?>
.asmh-header .primary > ul > li.search
{
  padding: <?php echo $s['menu_padding'] - 10; ?>px 10px;
}
<?php } else { ?>
.asmh-header .primary > ul > li.search
{
  padding: <?php echo $s['menu_padding']; ?>px 0 0;
}
<?php } ?>

@media (max-width: <?php echo $c::num_to_px($s['middle_hide_menu_width']); ?>)
{
  .asmh-header .primary > ul > li.search > a
  {
    padding: 10px <?php echo $c::num_to_px($s['header_paddings']); ?>;
  }

  .asmh-header .primary > ul > li.search
  {
    padding: 0;
  }
}

.asmh-header .primary > ul > li > a
{
<?php if (!empty($s['middle_link_color'])) { ?>
  color: <?php echo $c::to_color($s['middle_link_color']); ?>;
<?php } ?>
  font-size: <?php echo $c::num_to_px($s['middle_text_size']); ?>;
  padding: 0 <?php echo $c::num_to_px($s['middle_items_padding']); ?>;
  line-height: 1;
  display: block;
<?php if ($s['hover_transition']) { ?>
  transition: color 0.4s ease-in-out;
<?php } ?>
}

.asmh-header .primary > ul > li.search > a
{
  padding: 0 0 0 <?php echo $c::num_to_px($s['middle_items_padding']); ?>;
}

<?php if ($s['middle_position'] == 'center') { ?>
.asmh-header .primary > ul > li.search,
.asmh-header .primary > ul > li.secondary
{
  display: none;
}
<?php } ?>

.asmh-header .primary .sub-menu li > a
{
<?php if (!empty($s['middle_link_color'])) { ?>
  color: <?php echo $c::to_color($s['middle_link_color']); ?>;
<?php } ?>
  font-size: <?php echo $c::num_to_px($s['middle_text_size'] - 2); ?>;
  padding: 10px;
  line-height: 1;
  display: block;
}

.asmh-header .primary li .desc
{
  margin: 5px 0 0 0;
  line-height: 1;
  font-size: <?php echo $c::num_to_px($s['middle_text_size'] - 4); ?>;
}

.asmh-header .primary div.sub-menu
{
  padding: 10px;
}

.asmh-header .primary div.sub-menu ul
{
  padding: 0;
  margin: 0;
  list-style: none;
}

.asmh-header .primary div.sub-menu li > a
{
  padding: 10px 0;
  line-height: 1;
}

.asmh-header .middle .brand,
.asmh-header .middle .brand img
{
  vertical-align: middle;
  display: inline-block;
}

.asmh-header .primary > ul > li.search
{
  padding: <?php echo $s['menu_padding']; ?>px 10px 0;
}

.asmh-header .primary .sub-menu li
{
<?php if ($s['hover_transition']) { ?>
  transition: background-color 0.2s;
<?php } ?>
<?php if ($s['middle_position'] == 'center') { ?>
  text-align: left;
<?php } ?>
}

.asmh-header .primary .sub-menu li > a:hover
{
<?php if (!empty($s['middle_submenu_hover_color'])) { ?>
  background: <?php echo $c::to_color($s['middle_submenu_hover_color']); ?>;
<?php } else { ?>
  background: transparent;
<?php } ?>
}

<?php if (!empty($s['middle_submenu_hover_color'])) { ?>
@media (max-width: <?php echo $c::num_to_px($s['middle_hide_menu_width']); ?>) {
  .asmh-header .primary li > a:hover
  {
    background: <?php echo $c::to_color($s['middle_submenu_hover_color']); ?>;
  }
}
<?php } ?>

.asmh-header .primary .dropdown .sub-menu > li .sub-menu
{
  display: none;
  top: 0;
<?php if ($s['sub_menu_orientation'] == 'right') { ?>
  left: 100%;
<?php } else { ?>
  left: -100%;
<?php } ?>
  margin-top: -6px;
}

.asmh-header .primary .secondary.dropdown > a.icon-ellipsis-vert:before
{
  padding: 10px 15px 20px;
}

.asmh-header .primary .secondary.dropdown > a.icon-ellipsis-vert
{
  margin: 0 1px 0 0;
  padding-left: 0 !important;
  padding-right: 0 !important;
}

@media (max-width: <?php echo $c::num_to_px($s['middle_hide_menu_width']); ?>)
{
  .asmh-header .primary .secondary.dropdown > a.icon-ellipsis-vert
  {
    display: none;
  }
}

.asmh-header .primary .secondary.dropdown:hover > a.icon-ellipsis-vert
{
  position: relative;
  margin: 0;
  margin-left: -1px;
  margin-top: -1px;
  padding-top: 0;
  padding-bottom: 0;
  background-color: #<?php echo $s['middle_background_color']; ?>;
<?php if ($s['middle_bottom_border_width'] > 0) { ?>
  border: 1px solid #<?php echo $s['middle_bottom_border_color']; ?>;
  border: 1px solid rgba(<?php echo $c::hex2rgb($s['middle_bottom_border_color']); ?>, 0.3);
<?php } elseif ($s['middle_top_border_width'] > 0) { ?>
  border: 1px solid #<?php echo $s['middle_bottom_border_color']; ?>;
  border: 1px solid rgba(<?php echo $c::hex2rgb($s['middle_top_border_color']); ?>, 0.3);
<?php } else { ?>
  border: 1px solid rgb(0,0,0);
  border: 1px solid rgba(0,0,0, 0.3);
<?php } ?>
  border-bottom: none;
  z-index: 6;
}

.asmh-header .middle .primary .secondary.dropdown .sub-menu
{
  left: auto;
<?php if ($s['middle_position'] != 'center') { ?>
  right: 0;
<?php } else { ?>
  right: 10px;
<?php } ?>
  background-color: #<?php echo $s['middle_background_color']; ?>;
}

<?php if (!empty($s['middle_link_color'])) { ?>
.asmh-header .middle .primary .secondary.dropdown .sub-menu a
{
  color: #<?php echo $s['middle_link_color']; ?>;
}
<?php } ?>

<?php if (!empty($s['middle_hover_color'])) { ?>
.asmh-header .middle .primary .secondary.dropdown .sub-menu a:hover
{
  color: #<?php echo $s['middle_hover_color']; ?>;
}
<?php } ?>

.asmh-header .primary .secondary.dropdown:hover .sub-menu
{
  margin-top: -1px;
  z-index: 5;
<?php if ($s['middle_bottom_border_width'] > 0) { ?>
  border: 1px solid #<?php echo $s['middle_bottom_border_color']; ?>;
  border: 1px solid rgba(<?php echo $c::hex2rgb($s['middle_bottom_border_color']); ?>, 0.3);
<?php } elseif ($s['middle_top_border_width'] > 0) { ?>
  border: 1px solid #<?php echo $s['middle_bottom_border_color']; ?>;
  border: 1px solid rgba(<?php echo $c::hex2rgb($s['middle_top_border_color']); ?>, 0.3);
<?php } else { ?>
  border: 1px solid rgb(0,0,0);
  border: 1px solid rgba(0,0,0, 0.3);
<?php } ?>
}

@media (max-width: <?php echo $c::num_to_px($s['middle_hide_menu_width']); ?>)
{
  .asmh-header .primary .secondary.dropdown:hover .sub-menu
  {
    border: 0 none;
    margin-top: 0;
  }
}

.asmh-header .primary .sub-menu li:hover .sub-menu
{
  display: block;
}

.asmh-header .primary .dropdown .sub-menu > li .sub-menu .sub-menu
{
  display: none;
}

.asmh-header .primary .dropdown .sub-menu > li .sub-menu li:hover .sub-menu
{
  display: block;
}

<?php if (!empty($s['middle_link_color'])) { ?>
.asmh-header .middle .brand
{
  color: <?php echo $c::to_color($s['middle_link_color']); ?>;
}
<?php } ?>

<?php if (!empty($s['middle_hover_color'])) { ?>
.asmh-header .middle .brand:hover,
.asmh-header .primary ul > li > a:hover
{
  color: <?php echo $c::to_color($s['middle_hover_color']); ?>;
}
<?php } ?>

<?php if (!empty($s['middle_active_color'])) { ?>
.asmh-header .primary .current-menu-item > a,
.asmh-header .primary .current-menu-parent > a,
.asmh-header .primary .current-menu-ancestor > a
{
  color: <?php echo $c::to_color($s['middle_active_color']); ?> !important;
}
<?php } ?>

.asmh-header .middle .sub-menu
{
  position: absolute;
  top: 100%;
  left: 0;
  z-index: 1000;
  display: none;
  float: left;
  min-width: 180px;
  padding: 5px 0;
  margin: 0;
  list-style: none;
  font-size: 14px;
  background-color: <?php echo $c::to_color($s['middle_submenu_background_color']); ?>;
  background-color: rgba(<?php
      echo $c::hex2rgb(
              $s['middle_submenu_background_color'],
              $s['submenu_transparency_level']
           ); ?>);
  border: 1px solid <?php echo $c::to_color($s['middle_bottom_border_color']); ?>;
  border: 1px solid rgba(<?php echo $c::hex2rgb($s['middle_bottom_border_color']); ?>, 0.3);
  border-radius: 2px;
  -webkit-box-shadow: 0 3px 6px rgba(0,0,0,0.175);
  box-shadow: 0 3px 6px rgba(0,0,0,0.175);
  background-clip: padding-box;
}


.asmh-header .middle .dropdown:hover .sub-menu
{
  display: block;
  margin-top: 0;
  border-top-right-radius: 0;
  border-top-left-radius: 0;
  border-top-color: <?php echo $c::to_color($s['middle_bottom_border_color']); ?>;
}


.asmh-caret
{
  display: inline-block;
  width: 0;
  height: 0;
  margin-left: 2px;
  vertical-align: middle;
  border-top: 4px solid;
  border-right: 4px solid transparent;
  border-left: 4px solid transparent;
}


/***************************            *****************************/
/*************************** RESPONSIVE *****************************/
/***************************            *****************************/

@media (min-width: <?php echo $c::num_to_px($s['middle_hide_menu_width']); ?>)
{
  .asmh-header .primary
  {
    display: block;
  }
}

@media (max-width: <?php echo $c::num_to_px($s['middle_hide_menu_width']); ?>) {
  .asmh-header .primary
  {
    display: none;
    clear: both;
    margin: 0 -<?php echo $c::num_to_px($s['header_paddings']); ?>;
    float: none;
  }

  .asmh-header .primary.expand
  {
    display: block;
    background-color: <?php echo $c::to_color($s['middle_submenu_background_color']); ?>;
  }

  .asmh-header div.nav-wrap
  {
    width: 100%;
    padding: 15px 0;
    margin: 0 auto;
    float: none;
    text-align: center;
  }

  .asmh-header div.brand-wrap
  {
    float: left;
  }

  .asmh-header div.toggle-wrap
  {
    text-align: center;
    display: block;
    margin-top: 10px;
  }

  .asmh-header div.brand-wrap
  {
    float: none;
  }

  .asmh-header div.toggle-wrap
  {
    float: none;
  }

  .asmh-header .primary > ul
  {
    float: none;
    margin: 0;
  }

  .asmh-header .primary > ul > li
  {
    display: block;
    float: none;
    position: relative;
    text-align: left;
  }

  .asmh-header .primary ul > li > a
  {
    line-height: 1;
    padding: 10px <?php echo $c::num_to_px($s['header_paddings']); ?>;
  }

  .asmh-header nav.primary > ul > li:first-child > a
  {
    padding-left: <?php echo $c::num_to_px($s['header_paddings']); ?>;
  }

  .asmh-header .primary ul .sub-menu
  {
    position: static;
    top: 0;
    width: auto;
    float: none;
    display: block !important;
  }

  .asmh-header .primary .dropdown .sub-menu > li .sub-menu
  {
    display: block;
    left: auto;
  }

  .asmh-header .middle .primary > ul,
  .asmh-header .middle li
  {
    border-top: 1px solid rgba(<?php echo $c::hex2rgb($s['middle_bottom_border_color']); ?>, 0.2);
  }

  .asmh-header .middle .menu > li:first-child
  {
    border-top: none;
  }

  .asmh-header .middle .dropdown .sub-menu
  {
    border: none;
    background: none;
    box-shadow: none;
    -webkit-box-shadow: none;
  }

  .asmh-header .middle .dropdown:hover > ul.sub-menu
  {
    margin: 0 !important;
    padding: 0 !important;
  }

  .asmh-header .middle .sub-menu
  {
    padding: 0 0;
    margin: 0 0 0;
  }

  .asmh-header .middle .dropdown > .sub-menu > li > a
  {
    padding-left: <?php echo $c::num_to_px($s['header_paddings'] * 2); ?>;
  }

  .asmh-header .middle .dropdown > .sub-menu > li > .sub-menu > li > a
  {
    padding-left: <?php echo $c::num_to_px($s['header_paddings'] * 3); ?>;
  }

  .asmh-header .middle .dropdown > .sub-menu > li > .sub-menu > li > .sub-menu > li > a
  {
    padding-left: <?php echo $c::num_to_px($s['header_paddings'] * 4); ?>;
  }

  .asmh-header .primary .dropdown .sub-menu > li .sub-menu
  {
    margin-top: 0;
  }

  .asmh-header .primary > ul > li.search form
  {
    margin-top: 2px;
  }
}



/*************************** TOGGLE *****************************/

.asmh-header .toggle-wrap
{
  float: right;
  display: none;
  padding: 0;
}

.asmh-header .toggle
{
  background-color: transparent;
  background: transparent;
  padding: 0;
  border: none;
  height: 18px;
  width: 18px;
  margin: auto;
  cursor: pointer;
  position: relative;
}

.asmh-header .toggle .icon-bar {
  display: block;
  position: absolute;
  height: 2px;
  width: 100%;
  background: <?php echo $c::to_color($s['hamburger_color']); ?>;
  border-radius: 9px;
  opacity: 1;
  left: 0px;
  transform: rotate(0deg);
  transition: all 0.25s ease-in-out 0s;
}

.asmh-header .toggle .icon-bar:nth-child(1) {
  top: 0px;
}

.asmh-header .toggle .icon-bar:nth-child(2),
.asmh-header .toggle .icon-bar:nth-child(3) {
  top: 5px;
}

.asmh-header .toggle .icon-bar:nth-child(4) {
  top: 10px;
}

.asmh-header .toggle.open .icon-bar:nth-child(1) {
  top: 5px;
  width: 0%;
  left: 50%;
}

.asmh-header .toggle.open .icon-bar:nth-child(2) {
  -webkit-transform: rotate(45deg);
  -moz-transform: rotate(45deg);
  -o-transform: rotate(45deg);
  transform: rotate(45deg);
}

.asmh-header .toggle.open .icon-bar:nth-child(3) {
  -webkit-transform: rotate(-45deg);
  -moz-transform: rotate(-45deg);
  -o-transform: rotate(-45deg);
  transform: rotate(-45deg);
}

.asmh-header .toggle.open .icon-bar:nth-child(4) {
  top: 5px;
  width: 0%;
  left: 50%;
}

/*************************** END TOGGLE *****************************/


<?php
//
// Custom CSS
//
if (!empty($s['custom_css'])) {
  echo $s['custom_css'];
}
