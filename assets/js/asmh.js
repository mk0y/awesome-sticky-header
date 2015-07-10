var Asmh = (function() {
  function Asmh($) {
    this.jq = $;
  }


  Asmh.prototype.setSearchItem = function() {
    var $ = this.jq;
    var search = $('.middle li.search');

    var form = search.find('form');

    search.on('hover', function() {
      $(this).addClass('a');
      setTimeout(function() { form.find('input').focus(); }, 400);
    });

    form.find('input').on('focusout', function() {
      $(this).closest('.search').removeClass('a');
    });
  }


  Asmh.prototype.toggleNav = function() {
    var $ = this.jq;

    $('.asmh-header .toggle').on('click', function(e) {
      $('.asmh-header .primary, .nav-wrap').toggleClass('expand');
      $(this).toggleClass('open');
    });
  }


  Asmh.prototype.handleSticky = function() {
    var $ = this.jq,
      header = $('.asmh-header > div'),
      admin_bar_height = $('#wpadminbar').height();

    if (admin_bar_height === null || !admin_bar_height) {
      admin_bar_height = 0;
    }

    if (header.length < 1) return;

    $('.dropdown.secondary').hover(function() {
      if ($(window).scrollTop() > asmhObject.sticky_scroll_position) {
        $(this).find('> .sub-menu').css({
          marginTop: -1 * (asmhObject.menu_padding_sticky - 10 + 1) + 'px'
        });
      }
    });
    
    $(window).scroll(function() {
      if ($(window).scrollTop() > asmhObject.sticky_scroll_position) {
        header[0].style.top = admin_bar_height + 'px';
        header.addClass('stick');
        var max_width = header.find('.middle .container').css('max-width');
        if (max_width !== 'none') {
          header.find('.middle .container').css('width', max_width);
        }

      } else {
        header[0].style.top = -header.height() + 'px';
        header.find('.secondary.dropdown > .sub-menu').removeAttr('style');
        header.removeClass('stick');
      }
    });
  }


  Asmh.prototype.loadTemplate = function() {
    var $ = this.jq,
        template = $('#asmh-tpl');

    if (!template.length) {
      return;
    }

    var tpl = template.html();
    $('body').append(tpl);
  }


  return Asmh;
})();


var asmh = new Asmh(jQuery);


jQuery(document).ready(function($) {
  asmh.loadTemplate();
  asmh.setSearchItem();
  asmh.toggleNav();
  asmh.handleSticky();
});
