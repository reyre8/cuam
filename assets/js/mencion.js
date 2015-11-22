$(document).ready(function() { 
    
    // Display mencion form when clicking on crear mencion button
    $('#crear-mencion-btn').bind('click', function () {
        cleanFormMencion('crear');
        $('#crear-mencion-modal').modal('show');
    });
    
    // Save a new mencion
    $('#guardar-mencion-btn').bind('click', function () {
        $('#guardar-mencion-btn').text('Guardando...').attr('disabled', true);
        message();
        message('#mencion-message-container');
        $.ajax({
        type: "POST",
                url: DOCUMENT_ROOT + '/libs/mencion.php',
                data: $('#mencion-form').serialize(),
                success: function (data) {
                    response = jQuery.parseJSON(data);
                    switch(response.status) {

                        case 200:
                            message(null, 'success', 'Agregar mencion', response.data);
                            $('#crear-mencion-modal').modal('hide');
                            $(document).scrollTop(0);
                            break
                        default:
                            message('#mencion-message-container', 'error', 'Agregar mencion', response.data);
                            break;
                    }
                }
        }).always(function(data) {
            $('#guardar-mencion-btn').text('Guardar').attr('disabled', false);
            listarMenciones();
        });
    });
    
        // eliminar mencion
        $('#eliminar-mencion-btn').bind('click', function () {
            $('#eliminar-mencion-btn').text('Eliminando...').attr('disabled', true);
            var data = { 'accion': 'eliminar', 'id': $('#eliminar-mencion-btn').attr('mencion-id') };
            message();
            $.ajax({
                type: "POST",
                url: DOCUMENT_ROOT + '/libs/mencion.php',
                data: data,
                success: function (data) {
                    response = jQuery.parseJSON(data);
                    switch(response.status) {
                        case 200:
                            message(null, 'success', 'Eliminar mencion', response.data);
                            break;
                        default:
                            message(null, 'error', 'Eliminar mencion', response.data);
                            break;
                    }
                    $('#elminar-mencion-modal').modal('hide');
                    $(document).scrollTop(0);
                }
            }).always(function(data) {
                $('#eliminar-mencion-btn').text('Eliminar').attr('disabled', false);
                listarMenciones();
            });
        });
    
    // List menciones
    function listarMenciones() {

            var data = { 'accion': 'listar' };
            $.ajax({
            type: "GET",
            url: DOCUMENT_ROOT + '/libs/mencion.php',
            data: data,
            success: function (data) {
                response = jQuery.parseJSON(data);
                switch(response.status) {
                    case 200:

                        $('#mencion-table').html('');

                        var header = 
                          '<tr class="tr-head">' +
                              '<th>Nombre</th>' +
                              '<th colspan="2" class="pull-center">Accion</th>' +
                          '</tr>';

                          $('#mencion-table').append($(header));
                          for (i = 0; i < response.data.length; i++) {
                              var tr = $('<tr mencion-id="' + response.data[i].id + '"></tr>');
                              $(tr).append('<td>' + response.data[i].Nombre  + '</td>');
                              $(tr).append('<td class="pull-center"><i class="glyphicon glyphicon-pencil editar" data-toggle="tooltip" data-placement="top" title="Actualizar"></i></td>');
                              $(tr).append('<td class="pull-center"><i class="glyphicon glyphicon-minus-sign eliminar" data-toggle="tooltip" data-placement="top" title="Eliminar"></i></td>');
                              $('#mencion-table').append($(tr));
                          }


                            // Eliminar mencion
                            $('#mencion-table tr td i.eliminar').click(function () {
                                $('#eliminar-mencion-btn').attr('mencion-id', $(this).closest('tr').attr('mencion-id'));
                                $('#elminar-mencion-modal').modal('show');
                            });

                            // Editar mencion
                            $('#mencion-table tr td i.editar').click(function () {

                                var data = { 'accion': 'consultar', 'id': $(this).closest('tr').attr('mencion-id') };
                                cleanFormMencion('actualizar');

                                $.ajax({
                                    type: "GET",
                                    url:  DOCUMENT_ROOT + '/libs/mencion.php',
                                    data: data,
                                    success: function (data) {
                                        response = jQuery.parseJSON(data);
                                        switch(response.status) {
                                            case 200:
                                                $('#input-mencion-id').val(response.data.id);
                                                $('#input-nombre').val(response.data.Nombre);
                                                $('#crear-mencion-modal').modal('show');
                                                break
                                            default:
                                                message('#mencion-message-container', 'error', 'Editar mencion', response.data);
                                                break;
                                        }
                                    }
                                }).always(function(data) {

                                });
                            });

                        break
                    default:
                        message('#mencion-message-container', 'error', 'Listar mencion', response.data);
                        break;
                }
            }
        }).always(function(data) {

        });
    }

    listarMenciones();

});

    function cleanFormMencion(type) { 
        message();
        message('#mencion-message-container');
        resetForm('#mencion-form');
        $('#mencion-form-action').val(type);
        $('#input-mencion-id').val('');
    }