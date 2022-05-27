<?php

namespace App\Conexion;

class ConexionDB {
    public static function conectar()
    {
        $USER = 'root';
        $PASS = '';
        $DB = 'servicio_soap';
        $HOST = 'localhost';

        $con = mysqli_connect($HOST, $USER, $PASS, $DB) or die ("Error al conectar con la base de datos");

        // mysql_select_db($DB, $con);

        return $con;
    }
}