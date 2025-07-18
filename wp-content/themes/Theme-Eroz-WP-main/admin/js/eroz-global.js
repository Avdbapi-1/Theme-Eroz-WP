jQuery(document).ready(function($) {
    $('.custom_media_item_upload').on("click", function() {
      var send_attachment_bkp = wp.media.editor.send.attachment;
      var button = $(this);
      wp.media.editor.send.attachment = function(props, attachment) {
        $(button).next().val(attachment.id);
        $(button).prev().find('img').attr('src', attachment.url);
        $(button).prev().find('img').show();
        $(button).prev().show();
        $(button).next().next().show();
        wp.media.editor.send.attachment = send_attachment_bkp;
      }
      wp.media.editor.open(button);
      return false;
    });
    $('.custom_media_item_delete').on("click", function() {
      var button = $(this);
      $(button).hide();
      $(button).prev().prev().prev().find('img').attr('src', '');
      $(button).prev().prev().prev().hide();
      $(button).prev().val('');
      return false;
    });
  });