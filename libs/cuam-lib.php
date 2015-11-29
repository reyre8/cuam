<?php

define('DB_SERVER', 'localhost');
define('DB_USER', 'cuam_web');
define('DB_PASSWORD', 'cuampass');
define('DB_NAME', 'cuam');

/*
 * Funcion para conectar y seleccionar a la base de datos 
 *  */
function connect() {
    $link = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
    if (!$link) {
        die('No se pudo establecer la conexion: ' . mysql_error());
    }
    
    mysql_select_db(DB_NAME, $link) or die('No se pudo seleccionar la base de datos: ' . DB_NAME);
    
    return $link;
}

/*
 * Funcion para poner en comillas los datos guardados en bd
 *  */
function quoteDb($data) { 
    return '"' . $data . '"';
}

/*
 * Funcion para responder un request
 *  */
function respond($status, $data) { 
    print json_encode(array(
        'status' => intval($status),
        'data'   => $data
    ));
    exit;
}

/*
 * Funcion para responder un request
 *  */
function consulta($tabla, $columnas = array(), $filtros = array(), $singleRecord = false) {
    
    $sqlColumnas = empty($columnas)?'*':implode(', ', $columnas);
    
    $sqlFiltros = array();
    foreach($filtros AS $index => $element) { 
        array_push($sqlFiltros, $index . ' = ' . quoteDb($element));
    }
    $sqlFiltros = !empty($sqlFiltros)?'WHERE ' . implode(' AND ', $sqlFiltros):'';
    
    $link = connect();
    $result = mysql_query("SELECT {$sqlColumnas} FROM {$tabla} {$sqlFiltros}", $link) or respond(400, mysql_error());
    
    $arrayResult = array();
    while ($row = mysql_fetch_assoc($result)) {
        array_push($arrayResult, $row);
    }

    if(!empty($singleRecord) && !empty($arrayResult)) {
        $arrayResult = $arrayResult[0];
    }
    
    return $arrayResult;
}

function convertirFecha($fecha) { 
 $arrFecha = explode('/', $fecha);
    return $arrFecha[2] . '-' . $arrFecha[1] . '-' . $arrFecha[0];
}