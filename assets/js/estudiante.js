   $(document).ready(function () {

        // Display estudiante form when clicking on crear estudiante button
        $('#crear-estudiante-btn').bind('click', function () {
            cleanFormEstudiante('crear');
            $('#crear-estudiante-modal').modal('show');
        });
        
        // Save a new estudiante
        $('#guardar-estudiante-btn').bind('click', function () {
            $('#guardar-estudiante-btn').text('Guardando...').attr('disabled', true);
            message();
            message('#estudiante-message-container');
            $.ajax({
            type: "POST",
                    url: DOCUMENT_ROOT + '/libs/estudiante.php',
                    data: $('#estudiante-form').serialize(),
                    success: function (data) {
                        response = jQuery.parseJSON(data);
                        switch(response.status) {
                            
                            case 200:
                                message(null, 'success', 'Agregar estudiante', response.data);
                                $('#crear-estudiante-modal').modal('hide');
                                $(document).scrollTop(0);
                                break
                            default:
                                message('#estudiante-message-container', 'error', 'Agregar estudiante', response.data);
                                break;
                        }
                    }
            }).always(function(data) {
                $('#guardar-estudiante-btn').text('Guardar').attr('disabled', false);
                listarEstudiantes();
            });
        });
        
        // eliminar estudiante
        $('#eliminar-estudiante-btn').bind('click', function () {
            $('#eliminar-estudiante-btn').text('Eliminando...').attr('disabled', true);
            var data = { 'accion': 'eliminar', 'id': $('#eliminar-estudiante-btn').attr('estudiante-id') };
            message();
            $.ajax({
                type: "POST",
                url: DOCUMENT_ROOT + '/libs/estudiante.php',
                data: data,
                success: function (data) {
                    response = jQuery.parseJSON(data);
                    switch(response.status) {
                        case 200:
                            message(null, 'success', 'Eliminar estudiante', response.data);
                            break
                        default:
                            message(null, 'error', 'Eliminar estudiante', response.data);
                            break;
                    }
                    $('#elminar-estudiante-modal').modal('hide');
                    $(document).scrollTop(0);
                }
            }).always(function(data) {
                $('#eliminar-estudiante-btn').text('Eliminar').attr('disabled', false);
                listarEstudiantes();
            });
        });
        
        // List estudiantes
        function listarEstudiantes() {
            
                var data = { 'accion': 'listar' };
                $.ajax({
                type: "GET",
                url: DOCUMENT_ROOT + '/libs/estudiante.php',
                data: data,
                success: function (data) {
                    response = jQuery.parseJSON(data);
                    switch(response.status) {
                        case 200:
                            
                            $('#estudiante-table').html('');
                            
                            var header = 
                              '<tr class="tr-head">' +
                                  '<th>Nombre</th>' +
                                  '<th>Apellido</th>' +
                                  '<th>Sexo</th>' +
                                  '<th>Fecha de Nacimiento</th>' +
                                  '<th>Cedula</th>' +
                                  '<th>Email</th>' +
                                  '<th colspan="2" class="pull-center">Accion</th>' +
                              '</tr>';

                              $('#estudiante-table').append($(header));
                              for (i = 0; i < response.data.length; i++) {
                                  var tr = $('<tr estudiante-id="' + response.data[i].id + '"></tr>');
                                  $(tr).append('<td>' + response.data[i].Nombre  + '</td>');
                                  $(tr).append('<td>' + response.data[i].Apellido  + '</td>');
                                  $(tr).append('<td>' + response.data[i].Sexo  + '</td>');
                                  $(tr).append('<td>' + response.data[i].FechaDeNacimiento  + '</td>');
                                  $(tr).append('<td>' + response.data[i].Cedula  + '</td>');
                                  $(tr).append('<td>' + response.data[i].Email  + '</td>');
                                  $(tr).append('<td class="pull-center"><i class="glyphicon glyphicon-pencil editar" data-toggle="tooltip" data-placement="top" title="Actualizar"></i></td>');
                                  $(tr).append('<td class="pull-center"><i class="glyphicon glyphicon-minus-sign eliminar" data-toggle="tooltip" data-placement="top" title="Eliminar"></i></td>');
                                  $('#estudiante-table').append($(tr));
                              }
                              
                              
                                // Eliminar estudiante
                                $('#estudiante-table tr td i.eliminar').click(function () {
                                    $('#eliminar-estudiante-btn').attr('estudiante-id', $(this).closest('tr').attr('estudiante-id'));
                                    $('#elminar-estudiante-modal').modal('show');
                                });
                              
                                // Editar estudiante
                                $('#estudiante-table tr td i.editar').click(function () {

                                    var data = { 'accion': 'consultar', 'id': $(this).closest('tr').attr('estudiante-id') };
                                    cleanFormEstudiante('actualizar');

                                    $.ajax({
                                        type: "GET",
                                        url:  DOCUMENT_ROOT + '/libs/estudiante.php',
                                        data: data,
                                        success: function (data) {
                                            response = jQuery.parseJSON(data);
                                            switch(response.status) {
                                                case 200:
                                                    $('#input-estudiante-id').val(response.data.id);
                                                    $('#input-nombre').val(response.data.Nombre);
                                                    $('#input-apellido').val(response.data.Apellido);
                                                    $('#input-cedula').val(response.data.Cedula);
                                                    $('#select-sexo').val(response.data.Sexo);
                                                    $('#input-email').val(response.data.Email);
                                                    $('#crear-estudiante-modal').modal('show');
                                                    break
                                                default:
                                                    message('#estudiante-message-container', 'error', 'Editar estudiante', response.data);
                                                    break;
                                            }
                                        }
                                    }).always(function(data) {

                                    });
                                });
                              
                            break
                        default:
                            message('#estudiante-message-container', 'error', 'Listar estudiante', response.data);
                            break;
                    }
                }
            }).always(function(data) {
                
            });
    
        }
        
        // List of estudiantes
        listarEstudiantes();
        
    });

    function cleanFormEstudiante(type) { 
        message();
        message('#estudiante-message-container');
        resetForm('#estudiante-form');
        $('#estudiante-form-action').val(type);
        $('#input-estudiante-id').val('');
    }


