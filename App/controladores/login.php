<?php

class Login extends Controlador
{
    public function __construct()
    {
        $this->loginModelo = $this->modelo('LoginModelo');
    }

    public function index($error = '')
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->datos['usu_correo'] = trim($_POST['usu_correo']);
            $this->datos['usu_pass'] = trim($_POST['usu_pass']);
            if (empty($this->datos['usu_correo']) or empty($this->datos['usu_pass'])) {
                redireccionar("/index.php?error=vacio");
                exit();
            }
            $usuarioSesion = $this->loginModelo->loginEmail($this->datos['usu_correo'], md5($this->datos['usu_pass']));
            if (isset($usuarioSesion) && !empty($usuarioSesion)) {       // si tiene datos el objeto devuelto entramos
                Sesion::crearSesion($usuarioSesion);
                redireccionar("/portal/home/");
                exit();
            } else redireccionar('/index.php?error=incorrecto');
        } else {
            if (Sesion::sesionCreada($this->datos)) {    // si ya estamos logueados redirecciona a la raiz
                redireccionar('/portal/home/');
            } else {
                $this->datos['error'] = $error;

                $this->vista('login', $this->datos);
            }
        }
    }

    public function logout()
    {
        Sesion::iniciarSesion($this->datos);        // controlamos si no esta iniciada la sesion y cogemos los datos de la sesion
        $this->loginModelo->registroFinSesion($this->datos['usuarioSesion']->id_usuario);       // registramos fecha cierre de sesion
        Sesion::cerrarSesion();
        redireccionar('/');
    }
}
