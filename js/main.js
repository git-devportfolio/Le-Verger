var initContactForm = function () {

    /*
     *  FORMULAIRE DE CONTACT 
    */

    $( "#nous-contacter > form" ).submit( function ( event ) {

        // Stop form from submitting normally
        event.preventDefault();

        // Get some values from elements on the page:
        var $form = $( this ),
            urlAction = $form.attr( "action" );

        var $el_name = $form.find( "input[name='name']" ),
            $el_email = $form.find( "input[name='email-from']" ),
            $el_dtFrom = $form.find( "input[name='visit-date-from']" ),
            $el_dtTo = $form.find( "input[name='visit-date-to']" ),
            $el_message = $form.find( "textarea[name='message']" );

        if ( !$el_name.get( 0 ).validity.valid ) {
            $el_name.addClass( "invalid" );
            return;
        }

        if ( !$el_email.get( 0 ).validity.valid ) {
            $el_email.addClass( "invalid" );
            return;
        }

        if ( !$el_message.get( 0 ).validity.valid ) {
            $el_message.addClass( "invalid" );
            return;
        }

        $form.find( "input[name='send']" ).val( 'Envoi en cours...' );
        $form.find( "input[name='send']" ).prop( 'disabled', true );

        $.ajax( {
            url: urlAction,
            type: "POST",
            data: {
                name: $el_name.val(),
                email: $el_email.val(),
                dtfrom: $el_dtFrom.val(),
                dtto: $el_dtTo.val(),
                message: $el_message.val()
            },
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
