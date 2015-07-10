(function($) {
  $(function() {
    $.fn.asmh_uploader = function(options) {
      var sel = $(this).selector;

      var defaults = {
        'logo': '.brand.logo',
        'button': '.asmh-upload',
        'handler': '.asmh-logo-wrap',
        'preview' : '.asmh-upload-preview',
        'text'  : '.asmh-upload-text',
        'upload_id'  : '#asmh-upload-id',
        'upload_url_val'  : '.asmh-upload-url',
        'multi' : false,
        'callback' : ''
      }

      var options = $.extend(defaults, options);
      var frame;

      $(options.handler).on('click', options.preview, function(e) {
        $(options.button).trigger('click');
      });

      $(options.handler).on('click', options.button, function(e) {
        e.preventDefault();

        if (typeof(frame) !== 'undefined') {
          frame.close();
        }

        frame = wp.media.frames.customHeader = wp.media({
          title: 'ASMH Media Uploader',
          offsetWidth: 800,
          library: {
            type: 'image'
          },
          button: {
            text: 'Select'
          },
          multiple: options.multi
        });

        frame.on('select', function() {
          var attachment = frame.state()
            .get('selection').first().toJSON();
          var img = new Image;
          img.src = attachment.url;
          $(options.logo).html(img);

          $(options.text).text(attachment.url);
          $(options.preview).attr('src', attachment.url);
          $(options.upload_id).val(attachment.id);
          $(options.upload_url_val).val(attachment.url);

          if (typeof(options.callback) !== 'undefined') {
            options.callback();
          }
        });

        frame.open();
      });
    }
  });
} (jQuery) );
