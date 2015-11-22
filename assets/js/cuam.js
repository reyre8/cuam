    var DOCUMENT_ROOT = '/cuam'

    $(document).ready(function() { 
    
        // Initialise required fields
        $('label.required').append('<span class="text-danger"> *</span>');

        // Initialise tooltips
        $('[data-toggle="tooltip"]').tooltip();
    
    });
    
    // Creates a message at the top of the page
    function message(container, type, title, message) {
        
        messageContainerId = '#message-container';
        if(typeof container != 'undefined' && container !== null) { 
            messageContainerId = container;
        }
        
        $(messageContainerId).html('');
        
        var cssClass = '';
        var iconclass = '';
        switch(type) { 
            case 'success':
                iconclass = 'text-success';
                cssClass = 'text-success bg-success';
                break;
            case 'error':
                iconclass = 'text-danger';
                cssClass = 'text-danger bg-danger';
                break;
            case 'info':
                iconclass = 'text-info';
                cssClass = 'text-info bg-info';
                break;
            default:
                return;
                break;
        }
        
        var htmlMessage = '<p>' + message + '</p>';
        if(typeof message == 'object') { 
            htmlMessage = $('<ul></ul>');
            for (i = 0; i < message.length; i++) {
                $(htmlMessage).append($('<li>' + message[i] + '</li>'));
            }
        }
        
        var messageContainer = $('<i class="glyphicon glyphicon-remove message-close-icon ' + iconclass + ' "></i><div class="' + cssClass + ' message-container"><h3>' + title + '</h3><p>' + $(htmlMessage).html() + '</p></div>');
        $(messageContainerId).html(messageContainer);
        $(messageContainerId).find('i').bind('click', function() { $(messageContainerId).html(''); });
    }

    /*
     * Resets the values in a form
     */
    function resetForm(form) {
        $(form).find("input[type=text], textarea, select").val('');
    }
