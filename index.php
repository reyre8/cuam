<?php
include 'pages/common/header.php';
include 'libs/cuam-lib.php';

$rol = consulta('rol', array('id'), array('Nombre' => 'Estudiante'), true);
$listaEstudiante = consulta('usuario', array(), array('id_rol' => $rol['id']));
?>

<script>

    $(document).ready(function () {

        // Initialise required fields
        $('label.required').append('<span class="text-danger"> *</span>')

        // Initialise tooltips
        $('[data-toggle="tooltip"]').tooltip()

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
                    url: 'libs/estudiante.php',
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
                url: 'libs/estudiante.php',
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
                url: 'libs/estudiante.php',
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
                                        url: 'libs/estudiante.php',
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

    // Creates a message at the top of the page
    function message(container, type, title, message) {
        
        messageContainerId = '#message-container';
        if(container !== null) { 
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

    function cleanFormEstudiante(type) { 
        message();
        message('#estudiante-message-container');
        resetForm('#estudiante-form');
        $('#estudiante-form-action').val(type);
        $('#input-estudiante-id').val('');
    }

</script>

<div class='container font-site'>
    <h3>Estudiantes</h3>
    <div class="bg-info info-container">
        <ul>
            <li>Para agregar un nuevo estudiante, haga "click" en el boton <strong>Agregar estudiante</strong>.</li>
            <li>Para actualizar un estudiante existente, haga "click" en el icono <i class="glyphicon glyphicon-pencil"></i> en el registro del estudiante que desea modificar.</li>
            <li>Para eliminar un estudiante, haga "click" en el icono <i class="glyphicon glyphicon-minus-sign"></i> en el registro del estudiante que desea eliminar.</li>
        </ul>
    </div>
    <div class="table-btn-container">
        <button type="button" id="crear-estudiante-btn" class="btn btn-primary pull-right add-btn">
            <i class="glyphicon glyphicon-plus"></i>
            Agregar estudiante
        </button>
    </div>
    <table id="estudiante-table" class="table table-striped table-hover table-bordered"></table>
</div>

<div class="modal fade" id="crear-estudiante-modal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar estudiante</h4>
            </div>
            <div class="modal-body">
                <div id="estudiante-message-container"></div>
                <form id="estudiante-form" class="form-horizontal">
                    <input type="hidden" id="estudiante-form-action" name="accion" value="">
                    <input type="hidden" id="input-estudiante-id" name="input-estudiante-id" value="">
                    <div class="form-group">
                        <label for="input-nombre" class="col-sm-2 control-label required">Nombre</label>
                        <div class="col-sm-10">
                            <input name="input-nombre" type="text" class="form-control" id="input-nombre" placeholder="Nombre">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-apellido" class="col-sm-2 control-label required">Apellido</label>
                        <div class="col-sm-10">
                            <input name="input-apellido" type="text" class="form-control" id="input-apellido" placeholder="Apellido">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="select-sexo" class="col-sm-2 control-label required">Sexo</label>
                        <div class="col-sm-10">
                            <select name="select-sexo" type="text" class="form-control" id="select-sexo">
                                <option value="">- Seleccione -</option>
                                <option value="F">Femenino</option>
                                <option value="M">Masculino</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-cedula" class="col-sm-2 control-label required">Cedula</label>
                        <div class="col-sm-10">
                            <input name="input-cedula" type="text" class="form-control" id="input-cedula" placeholder="Indique el numero de cedula (solo numeros sin espacios)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input name="input-email" type="text" class="form-control" id="input-email" placeholder="cuenta@email.com">
                        </div>
                    </div>
                </form>
                <div class="bg-info info-container">
                    <ul>
                        <li>Los campos indicados con <span class="text-danger">*</span> son obligatorios.</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Cerrar</button>
                <button type="button" id="guardar-estudiante-btn" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>






<div class="modal fade" id="elminar-estudiante-modal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Eliminar estudiante</h4>
            </div>
            <div class="modal-body">
                    <p>¿Desea eliminar al estudiante?</p>
                    <div class="pull-center">
                        <button type="button" class="btn" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="eliminar-estudiante-btn" estudiante-id="">Eliminar</button>
                    </div>
            </div>
        </div>
    </div>
</div>



