$(document).ready(function () {
    
    $('#input-fechadeinscripcion').datetimepicker({
        locale: 'es',
        format: 'DD/MM/YYYY'
    });
    
    // Display inscripcion form when clicking on agregar inscripcion button
    $('#crear-inscripcion-btn').bind('click', function () {
        cleanFormInscripcion('crear');
        $('#crear-inscripcion-modal').modal('show');
    });

    // Save a new inscripcion
    $('#guardar-inscripcion-btn').bind('click', function () {
        $('#guardar-inscripcion-btn').text('Guardando...').attr('disabled', true);
        message();
        message('#inscripcion-message-container');
        $.ajax({
        type: "POST",
                url: DOCUMENT_ROOT + '/libs/inscripcion.php',
                data: $('#inscripcion-form').serialize(),
                success: function (data) {
                    response = jQuery.parseJSON(data);
                    switch(response.status) {

                        case 200:
                            message(null, 'success', 'Agregar inscripcion', response.data);
                            $('#crear-inscripcion-modal').modal('hide');
                            $(document).scrollTop(0);
                            break
                        default:
                            message('#inscripcion-message-container', 'error', 'Agregar inscripcion', response.data);
                            break;
                    }
                }
        }).always(function(data) {
            $('#guardar-inscripcion-btn').text('Guardar').attr('disabled', false);
            listarInscripcion();
        });
    });

    // eliminar inscripcion
    $('#eliminar-inscripcion-btn').bind('click', function () {
        $('#eliminar-inscripcion-btn').text('Eliminando...').attr('disabled', true);
        var data = { 'accion': 'eliminar', 'id': $('#eliminar-inscripcion-btn').attr('inscripcion-id') };
        message();
        $.ajax({
            type: "POST",
            url: DOCUMENT_ROOT + '/libs/inscripcion.php',
            data: data,
            success: function (data) {
                response = jQuery.parseJSON(data);
                switch(response.status) {
                    case 200:
                        message(null, 'success', 'Eliminar inscripcion', response.data);
                        break;
                    default:
                        message(null, 'error', 'Eliminar inscripcion', response.data);
                        break;
                }
                $('#elminar-inscripcion-modal').modal('hide');
                $(document).scrollTop(0);
            }
        }).always(function(data) {
            $('#eliminar-inscripcion-btn').text('Eliminar').attr('disabled', false);
            listarInscripcion();
        });
    })

    // List inscripcion
    function listarInscripcion() {

            var data = { 'accion': 'listar' };
            $.ajax({
            type: "GET",
            url: DOCUMENT_ROOT + '/libs/inscripcion.php',
            data: data,
            success: function (data) {
                response = jQuery.parseJSON(data);
                switch(response.status) {
                    case 200:

                        $('#inscripcion-table').html('');

                        var header = 
                          '<tr class="tr-head">' +
                              '<th>Mencion</th>' +
                              '<th>Estudiante</th>' +
                              '<th>Fecha de Inscripcion</th>' +
                              '<th colspan="2" class="pull-center">Accion</th>' +
                          '</tr>';

                          $('#inscripcion-table').append($(header));
                          for (i = 0; i < response.data.length; i++) {
                              var tr = $('<tr inscripcion-id="' + response.data[i].id + '"></tr>');
                              $(tr).append('<td>' + response.data[i].Mencion  + '</td>');
                              $(tr).append('<td>' + response.data[i].Estudiante  + '</td>');
                              $(tr).append('<td>' + response.data[i].FechaDeInscripcion  + '</td>');
                              $(tr).append('<td class="pull-center"><i class="glyphicon glyphicon-pencil editar" data-toggle="tooltip" data-placement="top" title="Actualizar"></i></td>');
                              $(tr).append('<td class="pull-center"><i class="glyphicon glyphicon-minus-sign eliminar" data-toggle="tooltip" data-placement="top" title="Eliminar"></i></td>');
                              $('#inscripcion-table').append($(tr));
                          }
                          
                          if(response.data.length == 0) {
                              $('#inscripcion-table').append($('<tr><td colspan="4" class="td-center">No hay resultados que mostrar</td></tr>'));
                          }

                            // Eliminar inscripcion
                            $('#inscripcion-table tr td i.eliminar').click(function () {
                                $('#eliminar-inscripcion-btn').attr('inscripcion-id', $(this).closest('tr').attr('inscripcion-id'));
                                $('#elminar-inscripcion-modal').modal('show');
                            });

                            // Editar inscripcion
                            $('#inscripcion-table tr td i.editar').click(function () {

                                var data = { 'accion': 'consultar', 'id': $(this).closest('tr').attr('inscripcion-id') };
                                cleanFormInscripcion('actualizar');

                                $.ajax({
                                    type: "GET",
                                    url:  DOCUMENT_ROOT + '/libs/inscripcion.php',
                                    data: data,
                                    success: function (data) {
                                        response = jQuery.parseJSON(data);
                                        switch(response.status) {
                                            case 200:
                                                $('#input-inscripcion-id').val(response.data.id);
                                                $('#select-estudiante').val(response.data.id_usuario);
                                                $('#select-mencion').val(response.data.id_mencion);
                                                $('#input-fechadeinscripcion input').val(response.data.FechaDeInscripcion);
                                                $('#crear-inscripcion-modal').modal('show');
                                                break
                                            default:
                                                message('#inscripcion-message-container', 'error', 'Editar inscripcion', response.data);
                                                break;
                                        }
                                    }
                                }).always(function(data) {

                                });
                            });

                        break
                    default:
                        message('#inscripcion-message-container', 'error', 'Listar inscripcion', response.data);
                        break;
                }
            }
        }).always(function(data) {

        });
    }

    listarInscripcion();

    var data = { 'accion': 'listadeestudiantes' };
    $.ajax({
        type: "GET",
        url: DOCUMENT_ROOT + '/libs/inscripcion.php',
        data: data,
        success: function (data) {
            response = jQuery.parseJSON(data);
            switch(response.status) {
                case 200:
                    for (i = 0; i < response.data.length; i++) {
                        $('#select-estudiante').append('<option value="' + response.data[i].id + '" >' + response.data[i].Cedula + ' - ' + response.data[i].Nombre + ' ' + response.data[i].Apellido + '</option>');
                    }
                    break;
                default:
                    message('#inscripcion-message-container', 'error', 'Lista de estudiantes', response.data);
                    break;
            }
        }
    });

    var data = { 'accion': 'listademenciones' };
    $.ajax({
        type: "GET",
        url: DOCUMENT_ROOT + '/libs/inscripcion.php',
        data: data,
        success: function (data) {
            response = jQuery.parseJSON(data);
            switch(response.status) {
                case 200:
                    for (i = 0; i < response.data.length; i++) {
                        $('#select-mencion').append('<option value="' + response.data[i].id + '" >' + response.data[i].Nombre + '</option>');
                    }
                    break;
                default:
                    message('#inscripcion-message-container', 'error', 'Lista de menciones', response.data);
                    break;
            }
        }
    });
});

function cleanFormInscripcion(type) { 
    message();
    message('#inscripcion-message-container');
    resetForm('#inscripcion-form');
    $('#inscripcion-form-action').val(type);
    $('#input-inscripcion-id').val('');
}