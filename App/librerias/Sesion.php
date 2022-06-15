<?php

class Sesion
{

    public static function crearSesion($usuarioSesion)
    {
        $sessionTime = 365 * 24 * 60 * 60;                  // 1 año de duración
        session_set_cookie_params($sessionTime);
        session_start();
        session_regenerate_id();                            // Para crear un id de sesion distinto al antiguo
        $_SESSION["usuarioSesion"] = $usuarioSesion;
        $_SESSION["usu_id"] = $usuarioSesion->usu_id;
        $_SESSION["usu_nom"] = $usuarioSesion->usu_nom;
        $_SESSION["usu_ape"] = $usuarioSesion->usu_ape;
        $_SESSION["rol_id"] = $usuarioSesion->rol_id;
    }


    public static function iniciarSesion(&$datos = [])
    {
        session_start();
        if (isset($_SESSION["usuarioSesion"])) {
            $datos['usuarioSesion'] = $_SESSION["usuarioSesion"];       // pasamos por referencia los datos de la sesion
        } else {
            session_destroy();
            redireccionar('/login/');
        }
    }


    public static function sesionCreada(&$datos = [])
    {         // si no necesitamos datos de respuesta, le damos un valor por defecto
        session_start();
        if (isset($_SESSION["usuarioSesion"])) {
            $datos['usuarioSesion'] = $_SESSION["usuarioSesion"];       // pasamos por referencia los datos de la sesion
            return true;
        } else {
            return false;
        }
    }


    public static function cerrarSesion()
    {
        session_start();                    // no seria necesaria esta linea, pero por asegurarnos en futuros usos
        setcookie(session_name(), '', time() - 3600, "/");
        session_unset();
        session_destroy();
        $_SESSION = array();
    }
}
