<?php

include 'cuam-lib.php';

/*
 * Funcion para validar un estudiante
 *  */
function validarEstudiante($data) { 

    $error = array();
    if(empty($data['input-nombre'])) {
        array_push($error, 'El campo Nombre es obligatorio.');
    }
    if(empty($data['input-apellido'])) {
        array_push($error, 'El campo Apellido es obligatorio.');
    }
    if(empty($data['input-cedula'])) {
        array_push($error, 'El campo Cedula es obligatorio.');
    }
    if (filter_var($data['input-cedula'], FILTER_VALIDATE_INT) === false) {
        array_push($error, 'El campo Cedula debe ser numerico.');
    }
    if(empty($data['select-sexo'])) {
        array_push($error, 'El campo Sexo es obligatorio.');
    }
    
    if (!empty($data['input-email']) && filter_var($data['input-email'], FILTER_VALIDATE_EMAIL) === false) {
        array_push($error, 'El campo Email no es un email valido.');
    }
    
    return $error;
}

/*
 * Funcion para crear un estudiante
 *  */
function crearEstudiante($data) {
    
    $error = validarEstudiante($data);
    if(!empty($error)) { 
        respond(400, $error);
    }

    $link = connect();
    $rol = consulta('rol', array('id'), array('Nombre' => 'Estudiante'), true);
    
    $sql = ' INSERT INTO usuario (id_rol,'
            . '                      Nombre,'
            . '                    Apellido,'
            . '                      Cedula,'
            . '                        Sexo,'
            . '           FechaDeNacimiento,'
            . '                       Email)'
            . ' VALUES (' . quoteDb($rol['id']) . ','
            . '         ' . quoteDb($data['input-nombre']) . ','
            . '         ' . quoteDb($data['input-apellido']) . ','
            . '         ' . quoteDb($data['input-cedula']) . ','
            . '         ' . quoteDb($data['select-sexo']) . ','
            . '         now(),'
            . '         ' . quoteDb($data['input-email']) . ')';

    $result = mysql_query($sql, $link) or respond(400, mysql_error());
    respond(200, 'Estudiante creado de forma satisfactoria.');
}

/*
 * Funcion para actualizar un estudiante
 *  */
function actualizarEstudiante($data) {
    
    $error = validarEstudiante($data);
    if(!empty($error)) { 
        respond(400, $error);
    }

    $link = connect();
    $sql = ' UPDATE usuario SET Nombre = ' . quoteDb($data['input-nombre']) . ', '
         . '                    Apellido = ' . quoteDb($data['input-apellido']) . ', '
         . '                    Cedula = ' . quoteDb($data['input-cedula']) . ', '
         . '                    Sexo = ' . quoteDb($data['select-sexo']) . ', '
         . '                    Email = ' . quoteDb($data['input-email'])
         . '  WHERE id = ' . quoteDb($data['input-estudiante-id']);

    $result = mysql_query($sql, $link) or respond(400, mysql_error());
    respond(200, 'Estudiante actualizado de forma satisfactoria.');
}

/*
 * Funcion para eliminar un estudiante
 *  */
function eliminarEstudiante($data) {
    $link = connect();
    $sql = "DELETE FROM usuario WHERE id = {$data['id']}";
    $result = mysql_query($sql, $link) or respond(400, mysql_error());
    respond(200, 'Estudiante eliminado de forma satisfactoria.');
}

/*
 * Funcion para consultar un estudiante
 *  */
function consultarEstudiante($data) {
    $estudiante = consulta('usuario', array(), array('id' => $data['id']), true);
    respond(200, $estudiante);
}

/*
 * Funcion para eliminar un estudiante
 *  */
function listarEstudiantes($data) {
    $rol = consulta('rol', array('id'), array('Nombre' => 'Estudiante'), true);
    $estudiantes = consulta('usuario', array(), array('id_rol' => $rol['id']));
    respond(200, $estudiantes);
}

/*
 * Funcion para ejecutar una accion, segun sea la accion definida en el arreglo $_GET o $_POST
 *  */
function ejecutarAccion($data) {

    switch ($data['accion']) {

        case 'crear':
            crearEstudiante($data);
            break;
        case 'actualizar':
            actualizarEstudiante($data);
            break;
        case 'eliminar':
            eliminarEstudiante($data);
            break;
        case 'consultar':
            consultarEstudiante($data);
            break;
        case 'listar':
            listarEstudiantes($data);
            break;
        default:
            respond(400, 'Accion no definida');
            break;
    }
}

$accion = null;
if(!empty($_GET) && empty($_POST)) { 
    $accion = $_GET;
} else {
    $accion = $_POST;
}

ejecutarAccion($accion);