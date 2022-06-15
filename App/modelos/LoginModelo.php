<?php

class LoginModelo
{
    private $db;

    public function __construct()
    {
        $this->db = new Base;
    }


    public function loginEmail($usu_correo, $usu_pass)
    {
        $this->db->query("SELECT * FROM usuarios WHERE usu_correo = :usu_correo AND usu_pass = :usu_pass");
        $this->db->bind(':usu_correo', $usu_correo);
        $this->db->bind(':usu_pass', $usu_pass);
        
        return $this->db->registro();
    }


    public function registroSesion($id_usuario)
    {
        $this->db->query("INSERT INTO sesiones (id_sesion, id_usuario, fecha_inicio) 
                                        VALUES (:id_sesion, :id_usuario, NOW())");

        $this->db->bind(':id_sesion', session_id());
        $this->db->bind(':id_usuario', $id_usuario);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function registroFinSesion($id_usuario)
    {
        $this->db->query("UPDATE sesiones SET fecha_fin = NOW()  
                                    WHERE id_usuario = :id_usuario AND id_sesion = :id_sesion");

        $this->db->bind(':id_sesion', session_id());
        $this->db->bind(':id_usuario', $id_usuario);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
