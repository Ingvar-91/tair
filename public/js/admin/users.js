(function ($) {
    /**/
    function handleFileSelect(evt) {
        var files = evt.target.files;
        for (var i = 0, f; f = files[i]; i++) {
          if (!f.type.match('image.*')) {
            continue;
          }

          var reader = new FileReader();
          reader.onload = (function(theFile) {
            return function(e) {
                var $img = '<img class="avatar img-thumbnail" src="'+e.target.result+'" title="'+ escape(theFile.name) +'"/>';
                $('#avatar-img').html($img);
            };
          })(f);
          reader.readAsDataURL(f);
        }
      }

      document.getElementById('avatar').addEventListener('change', handleFileSelect, false);
    /**/
    
})(jQuery);