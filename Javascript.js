jQuery(document).ready(function($) {
  // Code for image upload and preview
  $('#image-upload').change(function() {
    var input = this;
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#image-preview').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  });
  
  // Code for crop preview
  $('#image-size-select').change(function() {
    var size = $(this).val();
    var width = 0, height = 0;
    switch (size) {
      case '4x6':
        width = 400; height = 600;
        break;
      case '5x7':
        width = 500; height = 700;
        break;
      case '8x10':
        width = 800; height = 1000;
        break;
    }
    $('#crop-preview').css({
      'width': width + 'px',
      'height': height + 'px'
    });
  });
  
  // Code for adding images to cart
  $('#add-to-cart').click(function() {
    // Code for adding image to cart
  });
});
