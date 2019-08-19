/Create a JS file and do this:
( function($) {
  $(document).ready(function(){
    // Add Print Classes for Modal
    $('.modal').on('shown.bs.modal',function() {
        $('.modal,.modal-backdrop').addClass('toPrint');
        $('body').addClass('non-print');
    });
    // Remove classes
    $('.modal').on('hidden.bs.modal',function() {
        $('.modal,.modal-backdrop').removeClass('toPrint');
        $('body').removeClass('non-print');
    });
  });
});
