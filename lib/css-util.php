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
.asmh-preview
{
  width: 1170px;
  margin: 20px 0;
  z-index: 10;
  position: relative;
}

.asmh-preview .menu
{
  padding: 0;
}

.asmh-preview a
{
  text-decoration: none;
<?php if ($s['hover_transition']) { ?>
  transition: color 0.2s;
<?php } ?>
}

.asmh-preview ul > li > a,
.asmh-preview ul > li > a > span
{
  display: inline-block;
}

.asmh-preview .container:after
{
  clear: both;
}

.asmh-preview .primary:after,
.asmh-preview .primary:after ul
{
  clear: both;
}

.asmh-preview, .asmh-preview .container
{
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}

.asmh-preview ul:before, .asmh-preview ul:after,
.asmh-preview nav:before, .asmh-preview nav:after,
.asmh-preview div:before, .asmh-preview div:after
{
  content: " ";
  display: table;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}

.asmh-preview .container
{
  width: 100%;
  margin-left: auto;
  margin-right: auto;
  padding-left: 15px;
  padding-right: 15px;
  position: relative;
}

.asmh-preview > div.sticky
{
  position: fixed;
  width: 1170px;
  top: 49px;
}



/***************************        *****************************/
/*************************** MIDDLE *****************************/
/***************************        *****************************/



.asmh-preview .middle
{
  font-size: <?php echo $c::num_to_px($settings['middle_text_size']); ?>;
}

.asmh-preview .nav-wrap
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

.asmh-preview .brand
{
  display: block;
  font-size: <?php echo $c::num_to_px($s['site_title_font_size']); ?>;
  line-height: 1;
<?php if (!empty($s['site_title_color'])) { ?>;
  color: <?php echo $c::to_color($s['site_title_color']); ?>;
<?php } ?>
}

<?php if ($s['middle_position'] == 'center' && !$s['show_description']) { ?>
.asmh-preview .brand img
{
  vertical-align: middle;
}
<?php } ?>

<?php if (!empty($s['middle_hover_color'])) { ?>
.asmh-preview .middle .brand:hover
{
  color: <?php echo $c::to_color($s['middle_hover_color']); ?>;
}
<?php } ?>

<?php if (!empty($s['middle_active_color'])) { ?>
.asmh-preview .middle .brand:active,
.asmh-preview .primary a:active
{
  color: <?php echo $c::to_color($s['middle_active_color']); ?>;
}
<?php } ?>

.asmh-preview .description
{
  font-style: normal;
  font-size: <?php echo $c::num_to_px($s['site_desc_font_size']); ?>;
  line-height: 1.6;
  margin: 0;
<?php if (!empty($s['site_desc_color'])) { ?>;
  color: <?php echo $c::to_color($s['site_desc_color']); ?>;
<?php } ?>
}

.asmh-preview .brand img
{
  height: auto;
}

<?php if ($s['middle_position'] != 'center' && !$s['show_description']) { ?>
.asmh-preview .brand img
{
  vertical-align: middle;
}
<?php } ?>

.asmh-preview .primary
{
  overflow: visible;
  max-height: 640px;
}

.asmh-preview .middle > .container.left
{
}

.asmh-preview .middle > .container.right > .primary ul
{
  float: right;
}

.asmh-preview .middle > .container.right > .nav-wrap
{
  float: left;
}

.asmh-preview .middle > .container.left > .primary ul
{
  float: left;
}

.asmh-preview .middle > .container.left > .nav-wrap
{
  float: right;
}

.asmh-preview .middle > .container.center > .primary > ul
{
  float: none;
  text-align: center;
}

.asmh-preview .middle > .container.center > .primary > ul > li
{
  float: none;
  display: inline-block;
  text-align: left;
}

.asmh-preview .middle > .container.center > .nav-wrap
{
  float: none;
  text-align: center;
}

.asmh-preview .primary > ul
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

.asmh-preview .primary > ul > li
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
<?php if ($s['hover_transition']) { ?>
  transition: background-color 0.4s ease-in-out;
<?php } ?>
}

.asmh-preview .primary > ul > li.active,
.asmh-header .primary > ul > li.current-menu-item,
.asmh-header .primary > ul > li.current_page_item
{
  background-color: #<?php echo $s['middle_menu_item_background_active_color']?>;
}

.asmh-preview .primary > ul > li:hover
{
  background-color: #<?php echo $s['middle_menu_item_background_color']?>;
}

.asmh-preview .primary > ul > li.search:hover,
.asmh-preview .primary > ul > li.secondary:hover
{
  background-color: transparent !important;
}

<?php if (!empty($s['middle_link_color'])) { ?>
.asmh-preview .primary > ul > li:hover > a
{
  color: <?php echo $c::to_color($s['middle_link_color']); ?>;
}
<?php } ?>

<?php if ($s['middle_position'] == 'right') { ?>
.asmh-preview .primary > ul > li:last-child
{
  padding-right: 0 !important;
}
<?php } ?>

<?php if ($s['middle_position'] == 'left') { ?>
.asmh-preview .primary > ul > li:first-child
{
  padding-left: 0 !important;
}
<?php } ?>

.asmh-preview .primary > ul > li.secondary
{
  text-align: left;
  padding: <?php echo $s['menu_padding'] - 10; ?>px 0 0 10px;
}

.asmh-preview .primary > ul > li.search > a
{
  display: inline-block;
  padding-bottom: 0;
  vertical-align: top;
}

.asmh-preview .primary > ul > li.search
{
  background-color: transparent;
}

.asmh-preview .primary > ul > li.search > a:before
{
  display: inline-block;
  vertical-align: middle;
  margin-right: 0 !important;
}

.asmh-preview .primary > ul > li.search form
{
  width: 0;
  visibility: hidden;
  display: inline-block;
  overflow: visible !important;
<?php if ($s['middle_position'] != 'center') { ?>
  bottom: 3px;
<?php } else { ?>
  bottom: 4px;
<?php } ?>
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

.asmh-preview .primary > ul > li.search:hover form,
.asmh-preview .primary > ul > li.search.a form
{
  margin-right: -1px;
  width: 180px;
  visibility: visible;
}

.asmh-preview .primary > ul > li.search:hover > .icon-search,
.asmh-preview .primary > ul > li.search.a > .icon-search
{
  position: relative;
}

.asmh-preview .primary > ul > li.search > div:before,
.asmh-preview .primary > ul > li.search > div:after
{
  content: "";
  display: none;
}

.asmh-preview .primary > ul > li.search > div
{
  position: relative;
  width: 1px;
  height: 5px;
  bottom: -8px;
  display: none;
<?php if (!empty($s['middle_link_color'])) { ?>
  border-right: 1px solid <?php echo $c::to_color($s['middle_link_color']); ?>;
<?php } else { ?>
  border-right: 1px solid gray;
<?php } ?>
}

.asmh-preview .primary > ul > li.search:hover > div,
.asmh-preview .primary > ul > li.search.a > div
{
  display: inline-block;
}

.asmh-preview .primary > ul > li.search form input
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

input:-webkit-autofill
{
  background-color: transparent;
}

.asmh-preview .primary > ul > li
{
  padding: <?php echo $s['menu_padding']; ?>px 0;
}

<?php if ($s['middle_position'] == 'center') { ?>
.asmh-preview .primary > ul > li.search
{
  padding: <?php echo $s['menu_padding'] - 10; ?>px <?php echo $s['middle_items_padding']; ?>px;
}
<?php } else { ?>
.asmh-preview .primary > ul > li.search
{
  padding: <?php echo $s['menu_padding']; ?>px 0 0;
}
<?php } ?>

.asmh-preview .container.right .primary > ul > li.search,
.asmh-preview .container.left .primary > ul > li.search
{
  padding: <?php echo $s['menu_padding']; ?>px 0 0;
}

.asmh-preview .container.left .primary > ul > li,
.asmh-preview .container.right .primary > ul > li
{
  float: left;
}

.asmh-preview .primary ul > li > a
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

.asmh-preview .primary ul > li.search > a
{
  padding: 0 0 0 <?php echo $c::num_to_px($s['middle_items_padding']); ?>;
}

.asmh-preview .primary div.sub-menu
{
  padding: 10px;
}

.asmh-preview .primary div.sub-menu ul
{
  padding: 0;
  margin: 0;
}

.asmh-preview .primary div.sub-menu li > a
{
  padding: 10px 0;
  line-height: 1;
}

.asmh-preview .primary .sub-menu li > a
{
<?php if (!empty($s['middle_link_color'])) { ?>
  color: <?php echo $c::to_color($s['middle_link_color']); ?>;
<?php } ?>
  font-size: <?php echo $c::num_to_px($s['middle_text_size'] - 2); ?>;
  padding: 10px;
  line-height: 1;
  display: block;
}

.asmh-preview .primary li .desc
{
  margin: 5px 0 0 0;
  line-height: 1;
  font-size: <?php echo $c::num_to_px($s['middle_text_size'] - 6); ?>;
}

.asmh-preview .primary ul.sub-menu li:hover
{
<?php if (!empty($s['middle_submenu_hover_color'])) { ?>
  background: <?php echo $c::to_color($s['middle_submenu_hover_color']); ?>;
<?php } else { ?>
  background: transparent;
<?php } ?>
}

.asmh-preview .primary .sub-menu li
{
<?php if ($s['hover_transition']) { ?>
  transition: background-color 0.2s;
<?php } ?>
<?php if ($s['middle_position'] == 'center') { ?>
  text-align: left;
<?php } ?>
}

.asmh-preview .primary .dropdown .sub-menu > li .sub-menu
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

.asmh-preview .primary .secondary.dropdown > a.icon-ellipsis-vert:before
{
  padding: 10px 15px 20px;
  margin-right: 0 !important;
  margin-top: 1px;
}

.asmh-preview .primary .secondary.dropdown > a.icon-ellipsis-vert
{
  margin: 0 1px 0 0;
  padding-left: 0 !important;
  padding-right: 0 !important;
}

.asmh-preview .primary .secondary.dropdown:hover > a.icon-ellipsis-vert
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

/**** preview ****/
.asmh-preview .primary .secondary.dropdown.a:hover > a.icon-ellipsis-vert
{
  padding-top: 0 !important;
  padding-bottom: 0 !important;
  top: <?php echo $s['header_paddings']; ?>px;
}

.asmh-preview .primary .secondary.dropdown.a:hover .sub-menu
{
  margin-top: <?php echo $s['header_paddings'] - 1; ?>px;
}

.asmh-preview .primary.center .secondary.dropdown:hover .sub-menu
{
  margin-top: -1px;
}

.asmh-preview .primary.center .secondary.dropdown:hover > a.icon-ellipsis-vert
{
  top: 0;
}
/**** preview ****/

.asmh-preview .middle .primary .secondary.dropdown .sub-menu
{
  left: auto;
  right: 0;
  background-color: #<?php echo $s['middle_background_color']; ?>;
}

<?php if (!empty($s['middle_link_color'])) { ?>
.asmh-preview .middle .primary .secondary.dropdown .sub-menu a
{
  color: #<?php echo $s['middle_link_color']; ?>;
}
<?php } ?>

<?php if (!empty($s['middle_hover_color'])) { ?>
.asmh-preview .middle .primary .secondary.dropdown .sub-menu a:hover
{
  color: #<?php echo $s['middle_hover_color']; ?>;
}
<?php } ?>

.asmh-preview .primary .secondary.dropdown:hover .sub-menu
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

<?php if (!$s['has_secondary']) { ?>
.asmh-preview .primary > ul > li.search > a,
.asmh-preview .primary > ul > li.search
{
  padding-right: 0;
}
<?php } ?>

<?php if ($s['middle_position'] == 'center') { ?>
.asmh-preview .primary > ul > li.search,
.asmh-preview .primary > ul > li.secondary
{
  display: none;
}
<?php } ?>

.asmh-preview .primary > ul > li:last-child > a
{
  padding-right: 0;
}

.asmh-preview .primary .sub-menu li:hover .sub-menu
{
  display: block;
}

.asmh-preview .primary .dropdown .sub-menu > li .sub-menu .sub-menu
{
  display: none;
}

.asmh-preview .primary .dropdown .sub-menu > li .sub-menu li:hover .sub-menu
{
  display: block;
}

<?php if (!empty($s['middle_hover_color'])) { ?>
.asmh-preview .primary ul > li > a:hover
{
  color: <?php echo $c::to_color($s['middle_hover_color']); ?>;
}
<?php } ?>

.asmh-preview .middle
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

.asmh-preview .middle
{
  background-color: <?php echo $c::to_color($settings['middle_background_color']); ?>;
  background-color: rgba(<?php
      echo $c::hex2rgb(
              $asmh->settings['middle_background_color'],
              $asmh->settings['middle_transparency_level']
           ); ?>);
  <?php if (!empty($settings['middle_background_image'])) {
    echo 'background-image: '
      . $c::to_url($settings['middle_background_image']) . ';';
  } ?>
  background-repeat: <?php echo $settings['middle_background_repeat']; ?>;
}

.asmh-preview .middle .sub-menu
{
  position: absolute;
  top: 100%;
  left: 0;
  z-index: 1000;
  display: none;
  float: left;
  min-width: 180px;
  padding: 5px 0;
  margin: 2px 0 0;
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

.asmh-preview .middle .dropdown:hover .sub-menu
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

<?php if ($asmh->settings['use_genericons']) { ?>
<?php echo $c::get_css_a_genericons('preview'); ?>
{
<?php if ($s['use_genericons_text']) { ?>
  width: auto;
<?php } else { ?>
  width: <?php echo $s['top_text_size'] + 2; ?>px;
<?php } ?>
  height: <?php echo $s['top_text_size'] + 2; ?>px;
  line-height: <?php echo $s['top_text_size'] + 2; ?>px;
  overflow: hidden;
  text-align: center;
<?php if ($s['use_genericons_text']) { ?>
  padding: 0 7px !important;
<?php } else { ?>
  padding: 0 5px !important;
<?php } ?>
  font-size: <?php echo $s['top_text_size']; ?>px;
  -webkit-font-smoothing: antialiased;
  font-family: 'Genericons';
  vertical-align: middle;
  white-space: nowrap;
  display: inline-block;
  text-decoration: none;
  text-transform: none;
  font-weight: normal;
  font-style: normal;
  font-variant: normal;
  position: relative;
  speak: none;
<?php if ($s['use_genericons']) { ?>
  margin-bottom: 1px;
<?php } ?>
}

.asmh-preview ul.a li > a
{
  width: auto;
  padding-left: 7px !important;
  padding-right: 7px !important;
}

<?php if (!$s['has_secondary']) { ?>
.asmh-preview .primary > ul.a > li.search > a
{
  padding-right: 0 !important;
}
<?php } ?>

.asmh-preview ul.search.a li > a
{
  width: auto;
  padding-left: 10px !important;
  padding-right: 10px !important;
}

.asmh-preview ul.a li > a:before
{
  margin-right: 2px;
}

<?php echo $c::get_css_a_genericons_before('preview'); ?>
{
<?php if ($s['use_genericons_text']) { ?>
  margin-right: 2px;
<?php } else { ?>
  margin-right: 8px;
<?php } ?>
}

.asmh-preview li a[href*="twitter.com"]:before {
  content: '\f202';
}
.asmh-preview li a[href*="facebook.com"]:before {
  content: '\f203';
}
.asmh-preview li a[href*="plus.google.com"]:before {
  content: '\f206';
}
.asmh-preview li a[href*="linkedin.com"]:before {
  content: '\f208';
}
.asmh-preview li a[href*="pinterest.com"]:before {
  content: '\f210';
}
.asmh-preview li a[href*="wordpress.com"]:before,
.asmh-preview li a[href*="wordpress.org"]:before {
  content: '\f205';
}
.asmh-preview li a[href*="vimeo.com"]:before {
  content: '\f212';
}
.asmh-preview li a[href*="youtube.com"]:before {
  content: '\f213';
}
.asmh-preview li a[href*="tumblr.com"]:before {
  content: '\f214';
}
.asmh-preview li a[href*="instagram.com"]:before {
  content: '\f215';
}
.asmh-preview li a[href*="path.com"]:before {
  content: '\f219';
}
.asmh-preview li a[href*="reddit.com"]:before {
  content: '\f222';
}
.asmh-preview li a[href*="stumbleupon.com"]:before {
  content: '\f223';
}
.asmh-preview li a[href*="dribbble.com"]:before {
  content: '\f201';
}
.asmh-preview li a[href*="github.com"]:before {
  content: '\f200';
}
<?php } ?>

.brand-wrap img
{
  max-width: <?php echo $s['logo_max_width']; ?>px;
}

.asmh-upload-preview
{
  max-width: 200px;
}


<?php
//
// Custom CSS
//
if (!empty($s['custom_css'])) {
  echo str_replace('asmh-header', 'asmh-preview', $s['custom_css']);
}
