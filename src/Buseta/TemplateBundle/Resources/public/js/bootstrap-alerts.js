var BtAlerts = function (selector, sticky) {
    if(selector === undefined) {
        console.error('Debe definir el selector en el cual insertar los mensajes de alerta.');
        return;
    }
    this.messagesHolder = $(selector);

    this.messagesIndex  = this.messagesHolder.data('index');
    if ( this.messagesIndex === undefined ) {
        this.messagesIndex = 0;
    }

    if ( sticky === undefined ) {
        this.sticky = true;
    } else {
        this.sticky = sticky;
    }
    this.delayTime = 5000;

    this.template = '<div class="alert alert-__type__ alert-dismissable fade in" id="alert__index__">' +
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                    '__message__' +
                    '</div>';


    this.addAlert = function (type, message) {
        var _message    = this.template.replace(/__type__/g, type);
        _message        = _message.replace(/__message__/g, message);
        _message        = _message.replace(/__index__/g, this.messagesIndex);

        this.messagesHolder.append(_message);
        $('#alert' + this.messagesIndex).alert();

        if (!this.sticky) {
            this.setSlideRemove(this.messagesIndex);
        }

        this.messagesIndex++;
        this.messagesHolder.data('index', this.messagesIndex);
    };

    this.addDanger = function (message) {
        var alertMessage = '<i class="fa-fw fa fa-times"></i> <strong>¡Peligro!</strong> ' + message;
        this.addAlert('danger', alertMessage);
    };

    this.addSuccess = function (message) {
        var alertMessage = '<i class="fa-fw fa fa-check"></i> <strong>Satisfactorio</strong> ' + message;
        this.addAlert('success', alertMessage);
    };

    this.addInfo = function (message) {
        var alertMessage = '<i class="fa-fw fa fa-info"></i> <strong>¡Info!</strong> ' + message;
        this.addAlert('info', alertMessage);
    };

    this.addWarning = function (message) {
        var alertMessage = '<i class="fa-fw fa fa-warning"></i> <strong>Alerta</strong> ' + message;
        this.addAlert('warning', alertMessage);
    };

    this.setSlideRemove = function (index) {
        var alert = $('#alert' + index);

        alert.delay(this.delayTime).slideToggle(500);

        setTimeout(function () {
            alert.remove();
        }, this.delayTime + 1000);
    }
};

var $btalerts = new BtAlerts('div#global-messages');
