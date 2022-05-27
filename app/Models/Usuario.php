<?php

namespace App\Models;

require 'app/Conexion/ConexionDB.php';

use App\Conexion\ConexionDB;

class Usuario {

    public static function agregar($datos)
    {
        $con = ConexionDB::conectar();

		$sql = "INSERT INTO usuarios (nombre, apellido, correo, contrasenia, edad) VALUES (?,?,?,?,?)";
		
		$pre = mysqli_prepare($con, $sql);
		
		$pre->bind_param('ssssi', $datos['nombre'], $datos['apellido'], $datos['correo'], $datos['contrasenia'], $datos['edad']);
		
		$pre->execute();
    }

    public static function obtenerTodo()
    {
		$con = ConexionDB::conectar();
        
		$sql = "SELECT id, nombre, apellido, correo, edad FROM usuarios";
        
		$pre = mysqli_prepare($con, $sql);
        
		$pre->execute();
        
		$res = $pre->get_result();
        
		while ($registro = mysqli_fetch_assoc($res)) {
			$registros[] = $registro;
		}
        
		return $registros;
    }

    public static function obtener($datos)
    {
		$con = ConexionDB::conectar();
        
		$sql = "SELECT nombre, apellido, correo, edad FROM usuarios WHERE id = ?";
        
		$pre = mysqli_prepare($con, $sql);

        $pre->bind_param('i', $datos['id']);
        
		$pre->execute();
        
		$res = $pre->get_result();
        
		while ($registro = mysqli_fetch_assoc($res)) {
			$registros[] = $registro;
		}
        
		return $registros;
    }

    public static function editar($datos)
    {
        $con = ConexionDB::conectar();

		$sql = "UPDATE usuarios SET nombre = ?, apellido = ?, correo = ?, edad = ? WHERE id = ?";
		
		$pre = mysqli_prepare($con, $sql);
		
		$pre->bind_param('sssii', $datos['nombre'], $datos['apellido'], $datos['correo'], $datos['edad'], $datos['id']);
		
		$pre->execute();
    }

    public static function eliminar($datos)
    {
        $con = ConexionDB::conectar();

		$sql = "DELETE FROM usuarios WHERE id = ?";
		
		$pre = mysqli_prepare($con, $sql);
		
		$pre->bind_param('i', $datos['id']);
		
		$pre->execute();
    }
}