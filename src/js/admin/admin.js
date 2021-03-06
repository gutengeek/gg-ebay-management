( function ( $ ) {
  var GGEM_Admin = {
    init: function () {
      GGEM_Admin.popup();
    },
    popup: function () {
      $( document ).on( 'click', '.ggem-open-popup', function ( event ) {
        event.preventDefault();
        $( this ).parents( '.ggem-open-popup-wrap' ).find( '.ggem-popup-wrap' ).show();
      } );

      $( document ).on( 'click', '.ggem-popup-close, .ggem-popup-done', function () {
        $( this ).parents( '.ggem-popup-wrap' ).hide();
      } );

      $( document ).on( 'click', '.close-ggem-modal', function ( e ) {
        e.preventDefault();
        $( '.ggem-modal ' ).hide();
      } );
    },
  };

  $( GGEM_Admin.init );

} )( jQuery );
