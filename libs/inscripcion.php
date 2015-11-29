<?php 

include 'cuam-lib.php';

/*
 * Funcion para validar una inscripcion
 *  */
function validarInscripcion($data) { 

    $error = array();
    if(empty($data['select-estudiante'])) {
        array_push($error, 'El campo Estudiante es obligatorio.');
    }
    if(empty($data['select-mencion'])) {
        array_push($error, 'El campo Mencion es obligatorio.');
    }
    if(empty($data['input-fechadeinscripcion'])) {
        array_push($error, 'El campo Fecha de Inscripcion es obligatorio.');
    }
    return $error;
}

/*
 * Funcion para crear una inscripcion
 *  */
function crearInscripcion($data) {
    
    $error = validarInscripcion($data);
    if(!empty($error)) { 
        respond(400, $error);
    }

    $link = connect();
    $sql = ' INSERT INTO inscripcion (id_usuario,'
            . '                       id_mencion, '
            . '                       FechaDeInscripcion)'
            . ' VALUES (' . quoteDb($data['select-estudiante']) . ','
            . '         ' . quoteDb($data['select-mencion']) . ','
            . '         ' . quoteDb(convertirFecha($data['input-fechadeinscripcion'])) . ')';
    
    $result = mysql_query($sql, $link) or respond(400, mysql_error());
    respond(200, 'Inscripcion creada de forma satisfactoria.');
}

/*
 * Funcion para actualizar una inscripcion
 *  */
function actualizarInscripcion($data) {
    
    $error = validarInscripcion($data);
    if(!empty($error)) { 
        respond(400, $error);
    }

    $link = connect();
    $sql = ' UPDATE inscripcion SET id_usuario = ' . quoteDb($data['select-estudiante']) . ', '
         . '                        id_mencion = ' . quoteDb($data['select-mencion']) . ', '
         . '                FechaDeInscripcion = ' . quoteDb(convertirFecha($data['input-fechadeinscripcion']))
         . '  WHERE id = ' . quoteDb($data['input-inscripcion-id']);

    $result = mysql_query($sql, $link) or respond(400, mysql_error());
    respond(200, 'Inscripcion actualizada de forma satisfactoria.');
}

/*
 * Funcion para eliminar una inscripcion
 *  */
function eliminarInscripcion($data) {
    $link = connect();
    $sql = "DELETE FROM inscripcion WHERE id = {$data['id']}";
    $result = mysql_query($sql, $link) or respond(400, mysql_error());
    respond(200, 'Inscripcion eliminada de forma satisfactoria.');
}

/*
 * Funcion para consultar una inscripcion
 *  */
function consultarInscripcion($data) {
    $inscripcion = consulta('inscripcion', array(), array('id' => $data['id']), true);
    $inscripcion['FechaDeInscripcion'] = date('d/m/Y', strtotime($inscripcion['FechaDeInscripcion']));
    respond(200, $inscripcion);
}

/*
 * Funcion para listar inscripciones
 *  */
function listarInscripciones($data) {
    
    $link = connect();
    $sql = 'SELECT i.id AS id, m.Nombre AS Mencion, CONCAT(u.Cedula, " - ", u.Nombre, " - ", u.Apellido) AS Estudiante, i.FechaDeInscripcion AS FechaDeInscripcion' .
           '  FROM inscripcion i' .
           '  JOIN mencion m ON m.id = i.id_mencion' .
           '  JOIN usuario u ON u.id = i.id_usuario';
    
    $result = mysql_query($sql, $link) or respond(400, mysql_error());
    
    $arrayResult = array();
    while ($row = mysql_fetch_assoc($result)) {
        $row['FechaDeInscripcion'] = date('d/m/Y', strtotime($row['FechaDeInscripcion']));
        array_push($arrayResult, $row);
    }
    
    respond(200, $arrayResult);
}

/*
 * Lista de estudiantes
 *  */
function listaDeEstudiantes($data) {
    $rol = consulta('rol', array('id'), array('Nombre' => 'Estudiante'), true);
    $listaDeEstudiantes = consulta('usuario', array(), array('id_rol' => $rol['id']));
    respond(200, $listaDeEstudiantes);
}

/*
 * Lista de menciones
 *  */
function listaDeMenciones($data) {
    $listaDeMenciones = consulta('mencion');
    respond(200, $listaDeMenciones);
}

/*
 * Funcion para ejecutar una accion, segun sea la accion definida en el arreglo $_GET o $_POST
 *  */
function ejecutarAccion($data) {

    switch ($data['accion']) {

        case 'crear':
            crearInscripcion($data);
            break;
        case 'actualizar':
            actualizarInscripcion($data);
            break;
        case 'eliminar':
            eliminarInscripcion($data);
            break;
        case 'consultar':
            consultarInscripcion($data);
            break;
        case 'listar':
            listarInscripciones($data);
            break;
        case 'listadeestudiantes':
            listaDeEstudiantes($data);
            break;
        case 'listademenciones':
            listaDeMenciones($data);
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