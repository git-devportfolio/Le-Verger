var initContactForm = function () {

    /*
     *  FORMULAIRE DE CONTACT 
    */

    $( "#nous-contacter > form" ).submit( function ( event ) {

        // Stop form from submitting normally
        event.preventDefault();

        // Get some values from elements on the page:
        var $form = $( this );
		
        var name = $form.find( "input[name='name']" ).val();
        var email = $form.find( "input[name='email-from']" ).val();
        var dtFrom = $form.find( "input[name='visit-date-from']" ).val();
        var dtTo = $form.find( "input[name='visit-date-to']" ).val();
        var message = $form.find( "textarea[name='message']" ).val();
        var url = $form.attr( "action" );

        if ( !name || !email || !message ) {
            return;
        }

        $.ajax( {
            url: url,
            type: "POST",
            data: { name: name, email: email, from: dtFrom, to: dtTo, message: message },
            success: function ( data, textStatus, jqXHR ) {

                if ( data === 'SUCCESS' ) {

                    $form.find( ".article-button" ).hide();
                    $form.find( "p.success" ).removeClass( "visually-hidden" ).hide().fadeIn();
                }
                else {

                    $form.find( ".article-button" ).hide();
                    $form.find( "p.warning" ).removeClass( "visually-hidden" ).hide().fadeIn();
                }
            },
            error: function ( jqXHR, textStatus, errorThrown ) {

                $form.find( ".article-button" ).hide();
                $form.find( "p.warning" ).removeClass( "visually-hidden" ).hide().fadeIn();
            }
        } );

    } );
};

var initCarousel = function () {

    $( "#owl-slider" ).owlCarousel( { items: 3 } );
};

var initCalendar = function () {

    $( '.datepicker' ).pickadate();
};

$( document ).ready( function () {

    initCarousel();
    initCalendar();
    initContactForm();

} );
