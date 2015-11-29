<?php

include 'cuam-lib.php';

function validarMencionInscrita($mencionId) {
    
    $link = connect();
    $sql = 'SELECT i.id' .
           '  FROM inscripcion i' .
           ' WHERE i.id_mencion = ' . quoteDb($mencionId);
    
    $result = mysql_query($sql, $link) or respond(400, mysql_error());
    $arrayResult = array();
    
    while ($row = mysql_fetch_assoc($result)) {
        return true;
        break;
    }
    return false;
}

/*
 * Funcion para validar una mencion
 *  */
function validarMencion($data) {

    $error = array();
    if(empty($data['input-nombre'])) {
        array_push($error, 'El campo Nombre es obligatorio.');
    }
    
    return $error;
}

/*
 * Funcion para crear una mencion
 *  */
function crearMencion($data) {
    
    $error = validarMencion($data);
    if(!empty($error)) {
        respond(400, $error);
    }

    $link = connect();
    $sql = ' INSERT INTO mencion (Nombre)'
            . ' VALUES (' . quoteDb($data['input-nombre']) . ')';

    $result = mysql_query($sql, $link) or respond(400, mysql_error());
    respond(200, 'Mencion creada de forma satisfactoria.');
}

/*
 * Funcion para actualizar una mencion
 *  */
function actualizarMencion($data) {
    
    $error = validarMencion($data);
    if(!empty($error)) { 
        respond(400, $error);
    }

    $link = connect();
    $sql = ' UPDATE mencion SET Nombre = ' . quoteDb($data['input-nombre'])
         . '  WHERE id = ' . quoteDb($data['input-mencion-id']);

    $result = mysql_query($sql, $link) or respond(400, mysql_error());
    respond(200, 'Mencion actualizada de forma satisfactoria.');
}

/*
 * Funcion para eliminar una mencion
 *  */
function eliminarMencion($data) {
    $link = connect();
    
    if(!empty($data['id']) && validarMencionInscrita($data['id'])) {
        respond(400, 'La mencion se encuentra asignada a algun estudiante. Para eliminar la mencion primero debe eliminar a los estudiantes asociadas a esta.');
    }
    
    $sql = "DELETE FROM mencion WHERE id = {$data['id']}";
    $result = mysql_query($sql, $link) or respond(400, mysql_error());
    respond(200, 'Mencion eliminada de forma satisfactoria.');
}

/*
 * Funcion para consultar una mencion
 *  */
function consultarMencion($data) {
    $mencion = consulta('mencion', array(), array('id' => $data['id']), true);
    respond(200, $mencion);
}

/*
 * Funcion para listar menciones
 *  */
function listarMenciones($data) {
    $menciones = consulta('mencion');
    respond(200, $menciones);
}

/*
 * Funcion para ejecutar una accion, segun sea la accion definida en el arreglo $_GET o $_POST
 *  */
function ejecutarAccion($data) {

    switch ($data['accion']) {

        case 'crear':
            crearMencion($data);
            break;
        case 'actualizar':
            actualizarMencion($data);
            break;
        case 'eliminar':
            eliminarMencion($data);
            break;
        case 'consultar':
            consultarMencion($data);
            break;
        case 'listar':
            listarMenciones($data);
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