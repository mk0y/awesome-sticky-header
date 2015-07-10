var Asmh = (function() {
  function Asmh($) {
    this.jq = $;
  }


  Asmh.prototype.enable = function(type, el) {
    var $ = this.jq;

    if ($(el).is(':checked')) {
      $('.asmh-preview .' + type).show();
    } else {
      $('.asmh-preview .' + type).hide();
    }
  }


  Asmh.prototype.headerLogo = function(el) {
    var $ = this.jq;

    var el = $(el);
    var val = el.val();
    var brand = $('.asmh-preview .brand');

    switch(val) {
      case 'image':
        var img = new Image;
        img.src = $('.asmh-upload-preview').attr('src');
        brand.html(img);
        //brand.css({
        //  lineHeight: 1
        //});
        //asmh.setPreviewHeight();
        break;
          
      case 'text':
        brand.text(el.siblings('input').val());
        //asmh.setPreviewHeight();
        break;

      case 'site':
        brand.text($('#wp-admin-bar-site-name > a').text());
        //asmh.setPreviewHeight();
        break;
    }
  }


  Asmh.prototype.logoText = function(el) {
    var $ = this.jq;

    var val = $(el).val();
    var brand = $('.asmh-preview .brand a');

    brand.text(val);
  }


  Asmh.prototype.textSize = function(type, el) {
    var $ = this.jq;

    $('.asmh-preview .' + type).find('ul a, ul a > span, .logo').css({
      fontSize: $(el).val() + 'px'
    });
  }


  Asmh.prototype.middlePosition = function(el) {
    var $ = this.jq;

    var menu = $('.asmh-preview .primary > ul');
    var logo = $('.asmh-preview .nav-wrap');
    var side = $(el).val();

    switch (side) {
      case 'left':
        menu.find('li.search,li.secondary').css('display', 'inline-block');
        menu.closest('.container').removeClass('center right').addClass('left');
        break;

      case 'right':
        menu.find('li.search,li.secondary').css('display', 'inline-block');
        menu.closest('.container').removeClass('center left').addClass('right');
        break;

      case 'center':
        menu.find('li.search,li.secondary').hide();
        menu.closest('.container').removeClass('left right').addClass('center');
        break;
    }
  }


  Asmh.prototype.centerContent = function(type, el) {
    var $ = this.jq;
    var header = $('.asmh-preview .' + type);

    if ($(el).is(':checked')) {
      header.find('li').css({
        float: 'none',
        display: 'inline-block'
      });

      header.find('nav').css({
        float: 'none',
        textAlign: 'center'
      });

      header.find('.left ul li:first-child').css('padding', '0 4px');
      header.find('.right ul li:last-child').css('padding', '0 4px');

    } else {
      header.find('li').css({
        float: 'left',
        display: 'block'
      });

      header.find('nav').css({
        textAlign: 'none'
      });

      header.find('nav.left').css({
        float: 'left'
      });

      header.find('nav.right').css({
        float: 'right'
      });

      header.find('.left ul li:first-child').css('padding', '0 4px 0 0');
      header.find('.right ul li:last-child').css('padding', '0 0 0 4px');
    }
  }


  Asmh.prototype.backgroundColor = function(type, el) {
    var $ = this.jq,
        preview,
        obj;

    if (type === 'submenu') {
      obj = $('.asmh-preview .middle');
      preview = $('.asmh-preview ul.sub-menu');
    } else {
      obj = $('.asmh-preview .' + type);
      preview = obj;
    }

    preview.css({
      backgroundColor: '#' + $(el).val()
    });

    if (type === 'submenu') {
      obj.data('bgcolorsm', $(el).val());
    } else {
      preview.data('bgcolor', $(el).val());
    }
  }


  Asmh.prototype.siteTitleColor = function(el) {
    var $ = this.jq,
        preview = $('.asmh-preview .brand');

    preview.css({
      color: '#' + $(el).val()
    });
  }


  Asmh.prototype.siteDescColor = function(el) {
    var $ = this.jq,
        preview = $('.asmh-preview .middle .description');

    preview.css({
      color: '#' + $(el).val()
    });
  }


  Asmh.prototype.siteTitleSize = function(el) {
    var $ = this.jq,
        preview = $('.asmh-preview .brand');

    preview.css({
      fontSize: $(el).val() + 'px'
    });
  }


  Asmh.prototype.linkColor = function(type, el) {
    var $ = this.jq;
    var preview = $('.asmh-preview .' + type);

    preview.find('.primary > ul li a').css({
      color: '#' + $(el).val()
    });
  }


  Asmh.prototype.backgroundImage = function(type, el) {
    var $ = this.jq;
    var preview = $('.asmh-preview .' + type);

    preview.css({
      backgroundImage: 'url(' + $(el).val() + ')'
    });
  }


  Asmh.prototype.backgroundRepeat = function(type, el) {
    var $ = this.jq;
    var preview = $('.asmh-preview .' + type);

    preview.css({
      backgroundRepeat: $(el).val()
    });
  }


  Asmh.prototype.setSearchItem = function() {
    var $ = this.jq;
    var search = $('.middle li.search');

    if ($('li.search input').parent()[0].tagName !== 'FORM') {
      $('li.search input').wrap('<form></form>');
    }

    var form = search.find('form');

    search.on('hover', function() {
      $(this).addClass('a');
      _.delay(function() { form.find('input').focus(); }, 400);
    });

    form.find('input').on('focusout', function() {
      $(this).closest('.search').removeClass('a');
    });
  }


  Asmh.prototype.borderColor = function(type, line, el) {
    var $ = this.jq;
    var preview = $('.asmh-preview .' + type);

    preview.css('border-' + line + '-color', '#' + $(el).val());
  }


  Asmh.prototype.borderWidth = function(type, line, el) {
    var $ = this.jq;
    var preview = $('.asmh-preview .' + type);

    preview.css('border-' + line + '-width', $(el).val() + 'px');
  }


  Asmh.prototype.toggleSearch = function() {
    this.jq('li.search').toggle();
  }


  Asmh.prototype.toggleSecondary = function() {
    this.jq('li.secondary.dropdown').toggle();
  }


  Asmh.prototype.toggleBottomMenuOption = function(el) {
    var $ = this.jq,
        val = $(el).val();

    if ('menu' === val) {
      $(el).next('.asmh-bottom-menu-select').show();
    } else {
      $(el).next('.asmh-bottom-menu-select').hide();
    }
  }


  Asmh.prototype.toggleDescription = function() {
    var $ = this.jq;
    var desc = $('.asmh-preview .description');

    desc.toggle();

    asmhObject.settings.show_description = desc.is(':visible');
  }


  Asmh.prototype.menuPadding = function(el) {
    var $ = this.jq,
        menu = $('.asmh-preview .primary > ul > li'),
        search = $('.asmh-preview .primary > ul > li.search'),
        sec = $('.asmh-preview .primary > ul > li.secondary'),
        val = $(el).val();

    menu.css({
      paddingTop: val + 'px',
      paddingBottom: val + 'px'
    });

    search.css({
      paddingBottom: 0
    });

    sec.css({
      paddingTop: val - 10 + 'px',
      paddingBottom: 0
    });

    sec.find('> .sub-menu').css({
      marginTop: -(val - 10 + 1) + 'px'
    });
  }


  Asmh.prototype.topMenuPadding = function(el) {
    var $ = this.jq,
        li = $('.asmh-preview .top ul > li'),
        val = $(el).val();

    li.css({
      paddingTop: val + 'px',
      paddingBottom: val + 'px'
    });
  }


  Asmh.prototype.brandPadding = function(el) {
    var $ = this.jq,
        brand = $('.asmh-preview .nav-wrap'),
        val = $(el).val();

    brand.css({
      paddingTop: val + 'px',
      paddingBottom: val + 'px'
    });
  }


  Asmh.prototype.genericonsText = function(el) {
    var $ = this.jq,
        ul = $('.asmh-preview ul'),
        checked = $(el).is(':checked');

    if (checked) {
      $(ul).addClass('a');
    } else {
      $(ul).removeClass('a');
    }
  }


  Asmh.prototype.setPreviewHeight = function() {
    var $ = this.jq;
    var preview = $('.asmh-preview');

    preview.height(preview.find('.middle').height() + 
      preview.find('.top').height() +
      preview.find('.bottom').height()
    );
  }


  Asmh.prototype.handleSticky = function() {
    var $ = this.jq;
    var preview = $('.asmh-preview');
    var mt = parseInt(preview.css('margin-top'));
    var navst = parseInt($('.header-navs').css('margin-top'));
    var hnHeight = $('.header-navs').height();
    var toptop = mt + navst + hnHeight;

    $(window).scroll(function() {
      if ($(window).scrollTop() > toptop) {
        preview.find('> div').addClass('sticky');
      } else {
        preview.find('> div').removeClass('sticky');
      }
    });
  }


  Asmh.prototype.setTransparency = function(type, value) {
    if (asmhObject.settings[type + '_transparency_level_on_sticky']) {
      return;
    }

    var $ = this.jq,
        obj,
        header,
        rgb;

    if (type === 'submenu') {
      header = $('.asmh-preview .middle');
      obj = $('.asmh-preview ul.sub-menu');
    } else {
      header = $('.asmh-preview .' + type);
      obj = header;
    }

    if (type === 'submenu') {
      rgb = this.hex2rgb(header.data('bgcolorsm'));
    } else {
      rgb = this.hex2rgb(header.data('bgcolor'));
    }

    obj.css({
      backgroundColor: 'rgba('
        + rgb.r + ', '
        + rgb.g + ', '
        + rgb.b + ', '
        + (parseFloat(value / 100).toFixed(2)) + ')'
    });
  }


  Asmh.prototype.stickyTransparency = function(el, type) {
    var $ = this.jq,
        header = $('.asmh-preview .' + type);

    var obj;
    if (type === 'submenu') {
      obj = $('.asmh-preview ul.sub-menu');
    } else {
      obj = header;
    }

    asmhObject.settings[type + '_transparency_level_on_sticky'] = $(el).is(':checked');

    if ($(el).is(':checked')) {
      obj.css({backgroundColor: '#' + header.data('bgcolor')});
    } else {
      obj.removeAttr('style');
    }
  }


  Asmh.prototype.setTransparencySliders = function(type) {
    var $ = this.jq,
      top = $('#asmh-slider-top'),
      submenu = $('#asmh-slider-submenu'),
      middle= $('#asmh-slider-middle'),
      bottom = $('#asmh-slider-bottom'),
      type = ['top', 'middle', 'bottom']
      self = this;

    if (top.length) {
      top.slider({
        range: "max",
        min: 0,
        max: 100,
        value: $('#asmh-slider-top-val').val(),
        slide: function(event, ui) {
          $('#asmh-slider-top-amount').text(ui.value);
          $('#asmh-slider-top-val').val(ui.value);
          self.setTransparency('top', ui.value);
        }
      });
    }

    if (middle.length) {
      middle.slider({
        range: "max",
        min: 0,
        max: 100,
        value: $('#asmh-slider-middle-val').val(),
        slide: function(event, ui) {
          $('#asmh-slider-middle-amount').text(ui.value);
          $('#asmh-slider-middle-val').val(ui.value);
          self.setTransparency('middle', ui.value);
        }
      });
    }

    if (submenu.length) {
      submenu.slider({
        range: "max",
        min: 0,
        max: 100,
        value: $('#asmh-slider-submenu-val').val(),
        slide: function(event, ui) {
          $('#asmh-slider-submenu-amount').text(ui.value);
          $('#asmh-slider-submenu-val').val(ui.value);
          self.setTransparency('submenu', ui.value);
        }
      });
    }

    if (bottom.length) {
      bottom.slider({
        range: "max",
        min: 0,
        max: 100,
        value: $('#asmh-slider-bottom-val').val(),
        slide: function(event, ui) {
          $('#asmh-slider-bottom-amount').text(ui.value);
          $('#asmh-slider-bottom-val').val(ui.value);
          self.setTransparency('bottom', ui.value);
        }
      });
    }
  }


  Asmh.prototype.logoMaxWidth = function(el) {
    var $ = this.jq,
        el = $(el);

    $('.asmh-preview .brand img').css({
      maxWidth: $(el).val() + 'px'
    });
  }


  Asmh.prototype.middleItemsPadding = function(el) {
    var $ = this.jq,
        el = $(el);

    $('.asmh-preview .primary > ul > li > a').css({
      paddingLeft:  $(el).val() + 'px',
      paddingRight: $(el).val() + 'px'
    });

    if ($('.asmh-preview .primary > ul > li.search > a').length) {
      $('.asmh-preview .primary > ul > li.search > a').css({
        paddingRight: 0
      });
    }

    if ($('.asmh-preview .primary > ul > li.secondary > a').length) {
      $('.asmh-preview .primary > ul > li.secondary > a,').css({
        paddingRight: 0
      });
    }
  }


  Asmh.prototype.hex2rgb = function(hex) {
      var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);

      return result ? {
          r: parseInt(result[1], 16),
          g: parseInt(result[2], 16),
          b: parseInt(result[3], 16)
      } : null;
  }


  return Asmh;
})();

var asmh = new Asmh(jQuery);

jQuery(document).ready(function($) {
  asmh.setSearchItem();
  asmh.setPreviewHeight();
  asmh.handleSticky();
  asmh.setTransparencySliders();

  $('.header-navs a').click(function(e) {
    e.preventDefault();
    var index = $(this).index();
    var el = $('.nav-tab-content:eq('+index+')');

    if (el.is(':visible')) return;

    $('.nav-tab-content').hide();
    el.fadeIn(200);
    $('.header-navs .nav-tab').removeClass('nav-tab-active');
    $(this).addClass('nav-tab-active');
  });

  $('.asmh-upload').asmh_uploader({
    callback: function() {
      if (! $('input[value="image"]').is(':checked') ) {
        return;
      }

      var src = $($(this)[0].preview).attr('src');
      var im = new Image;
      im.src = src;

      var brand = $('.asmh-preview .brand a');

      brand.html(im);
    }
  });

  $('.button.reset').click(function(e) {
    e.preventDefault();
    var j = confirm('Are you sure?');

    if (true === j) {
      $(this).unbind('click');
      $(this).trigger('click');
    }
  });
});
