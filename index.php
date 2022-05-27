<?php

require 'vendor/econea/nusoap/src/nusoap.php';
require 'app/Models/Usuario.php';

use App\Models\Usuario;

$namespace = 'Servicio_SOAP_ok';

$server = new soap_server();
$server->configureWSDL('Servicio SOAP', $namespace);
$server->wsdl->schemaTargetNamespace = $namespace;

//Agregar el tipo complejo
$server->wsdl->addComplexType(
    'usuario',
    'complexType',
    'array',
    '',
    'SOAP-ENC:Array',
    array(),
    array(
        array(
            'ref' => 'SOAP-ENC:arrayType',
            'wsdl:arrayType' => 'tns:usuario[]'
        )
    ),
);

$server->wsdl->addComplexType(
    "nuevoUsuario",
    "complexType",
    "struct",
    "all",
    "",
    array(
        "nombre" => array("name" => "nombre", "type" => "xsd:string"),
        "apellido" => array("name" => "apellido", "type" => "xsd:string"),
        "correo" => array("name" => "apellido", "type" => "xsd:string"),
        "contrasenia" => array("name" => "contrasenia", "type" => "xsd:string"),
        "edad" => array("name" => "edad", "type" => "xsd:int")
    )
);

$server->wsdl->addComplexType(
    "buscarUsuario",
    "complexType",
    "struct",
    "all",
    "",
    array(
        "id" => array("name" => "id", "type" => "xsd:int")
    )
);

$server->wsdl->addComplexType(
    "eliminarUsuario",
    "complexType",
    "struct",
    "all",
    "",
    array(
        "id" => array("name" => "id", "type" => "xsd:int")
    )
);

$server->wsdl->addComplexType(
    "editarUsuario",
    "complexType",
    "struct",
    "all",
    "",
    array(
        "id" => array("name" => "id", "type" => "xsd:int"),
        "nombre" => array("name" => "nombre", "type" => "xsd:string"),
        "apellido" => array("name" => "apellido", "type" => "xsd:string"),
        "correo" => array("name" => "apellido", "type" => "xsd:string"),
        "edad" => array("name" => "edad", "type" => "xsd:int")
    )
);

$server->wsdl->addComplexType(
    "respuesta",
    "complexType",
    "struct",
    "all",
    "",
    array(
        "codigo" => array("name" => "codigo", "type" => "xsd:int"),
        "mensaje" => array("name" => "mensaje", "type" => "xsd:string"),
    )
);

$server->wsdl->addComplexType(
    "respuestaCU",
    "complexType",
    "struct",
    "all",
    "",
    array(
        "codigo" => array("name" => "codigo", "type" => "xsd:int"),
        "mensaje" => array("name" => "mensaje", "type" => "xsd:string"),
        "Usuarios" => array("name" => "Usuarios", "type" => "tns:usuario"),
    )
);

$server->register(
    'nuevoUsuario',
    array('nuevoUsuario' => 'tns:nuevoUsuario'),
    array('return' => 'tns:respuesta'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'Registrar un nuevo usuario'
);

$server->register(
    'editarUsuario',
    array('editarUsuario' => 'tns:editarUsuario'),
    array('return' => 'tns:respuesta'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'Registrar un nuevo usuario'
);

$server->register(
    'buscarUsuario',
    array('buscarUsuario' => 'tns:buscarUsuario'),
    array('return' => 'tns:respuestaCU'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'Buscar un usuario'
);

$server->register(
    'obtenerUsuarios',
    array('obtenerUsuarios' => 'tns:obtenerUsuarios'),
    array('return' => 'tns:respuestaCU'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'Buscar un usuario'
);

$server->register(
    'eliminarUsuario',
    array('eliminarUsuario' => 'tns:eliminarUsuario'),
    array('return' => 'tns:respuesta'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'Buscar un usuario'
);

function nuevoUsuario($datos)
{
    $respuesta = Usuario::agregar($datos);
    // return $datos;
    return array(
        'codigo' => 200,
        'mensaje' => 'Usuario registrado correctamente'
    );
}

function buscarUsuario($datos){
    $respuesta = Usuario::obtener($datos);
    return array(
        'codigo' => 200,
        'mensaje' => 'Usuario encontrado '.$datos['id'],
        'Usuarios' => $respuesta
    );
}

function editarUsuario($datos){
    $respuesta = Usuario::editar($datos);
    return array(
        'codigo' => 200,
        'mensaje' => 'Usuario '.$datos['id'].' editado correctamente'
    );
}

function obtenerUsuarios(){
    $respuesta = Usuario::obtenerTodo();
    return array(
        'codigo' => 200,
        'mensaje' => 'Usuarios encontrados',
        'Usuarios' => $respuesta
    );
}

function eliminarUsuario($datos){
    $respuesta = Usuario::eliminar($datos);
    return array(
        'codigo' => 200,
        'mensaje' => 'Usuario '.$datos['id'].' eliminado correctamente',
    );
}

$POST_DATOS = file_get_contents("php://input");
$server->service($POST_DATOS);

exit();