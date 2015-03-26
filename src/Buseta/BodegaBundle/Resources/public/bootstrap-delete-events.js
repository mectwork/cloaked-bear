var DeleteEvent = function ( uri, containerSelector, ajaxModal ) {
    this.uri = uri;
    this.container = containerSelector;
    this.ajaxModal = ajaxModal;

    if ( this.ajaxModal === undefined ) {
        this.ajaxModal = true;
    }

    this.start_events = function () {
        $( 'a.btn.btn-danger[href="#delete"]' ).on( 'click', { instance : this }, this.modal );
    };
    this.reload_list = function () {
        var url = this.uri,
            instance = this;
        $.get(url, function ( response ) {
            var content = $( response ).find( instance.container );
            $( instance.container ).replaceWith( content );

            instance.start_events();
        });
    };
    this.modal = function ( event ) {
        var href = $( this ).data( 'href' ),
            instance = event.data.instance;

        event.preventDefault();

        $.get(href, undefined, function ( json ) {
            $( 'div#modal-danger' ).replaceWith( json.view );
            $( 'div#modal-danger' ).find( 'button.btn.btn-danger' ).on( 'click', { instance : instance }, instance.delete );
            $( 'div#modal-danger' ).modal( 'show' );
        }, 'JSON').fail().always();
    };
    this.delete = function ( event ) {
        var instance = event.data.instance;

        if( event !== undefined ) {
            event.preventDefault();
        }

        var deleteForm = $( 'div#modal-danger' ).find( 'form' );
        if ( !instance.ajaxModal ) {
            deleteForm.submit();
            return;
        }

        deleteForm.ajaxSubmit({
            dataType: 'json',
            success: function ( json, statusText, jqXHR ) {
                if ( jqXHR.status == 202 ) {
                    $btalerts.addSuccess( json.message );
                    // on success delete
                    instance.reload_list();
                }
            },
            error: function ( error ) {
                $btalerts.addDanger( error.message );
            },
            complete: function () {
                $( 'div#modal-danger' ).modal( 'hide' ).delay(300).html('');
            }
        });
    };
};