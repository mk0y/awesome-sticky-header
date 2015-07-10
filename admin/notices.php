<?php
function asmh_phpversion() {
  echo '<div class="error fade">'
    . '<p>' . __('Your PHP version is too old for Awesome Sticky Header plugin to work.', ASMH_LANG)
    . ' ' . __('At least version 5.4 is required.', ASMH_LANG) . '</p>'
    . '</div>';
}
