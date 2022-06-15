<?php

class UsuarioModelo
{
    private $db;

    public function __construct()
    {
        $this->db = new Base;
    }

    public function insert_usuario($usu_nom, $usu_ape, $usu_correo, $usu_pass, $rol_id)
    {
        $this->db->query("INSERT INTO usuarios (usu_id, usu_nom, usu_ape, usu_correo, usu_pass, rol_id, fech_crea, fech_modi, fech_elim, est) VALUES (NULL,?,?,?,MD5(?),?,now(), NULL, NULL, '1');");

        $this->db->bind(1, $usu_nom);
        $this->db->bind(2, $usu_ape);
        $this->db->bind(3, $usu_correo);
        $this->db->bind(4, $usu_pass);
        $this->db->bind(5, $rol_id);

        return $this->db->registros();
    }

    public function update_usuario($usu_id, $usu_nom, $usu_ape, $usu_correo, $usu_pass, $rol_id)
    {
        $this->db->query(
            "UPDATE usuarios set
            usu_nom = ?,
            usu_ape = ?,
            usu_correo = ?,
            usu_pass = ?,
            rol_id = ?
            WHERE
            usu_id = ?"
        );

        $this->db->bind(1, $usu_nom);
        $this->db->bind(2, $usu_ape);
        $this->db->bind(3, $usu_correo);
        $this->db->bind(4, $usu_pass);
        $this->db->bind(5, $rol_id);
        $this->db->bind(6, $usu_id);

        return $this->db->registros();
    }

    public function delete_usuario($usu_id)
    {
        $this->db->query("call sp_borrar_usuario(?)");

        $this->db->bind(1, $usu_id);

        return $this->db->registros();
    }

    public function get_usuario()
    {
        $this->db->query("call sp_obtener_usuarios()");

        return $this->db->registros();
    }

    public function get_usuario_x_rol()
    {
        $this->db->query("SELECT * FROM usuarios where est=1 and rol_id=2");

        return $this->db->registros();
    }

    public function get_usuario_x_id($usu_id)
    {
        $this->db->query("call sp_obtener_usuario(?)");

        $this->db->bind(1, $usu_id);

        return $this->db->registros();
    }

    public function get_usuario_total_x_id($usu_id)
    {
        $this->db->query("SELECT COUNT(*) as TOTAL FROM incidencias where usu_id = ?");

        $this->db->bind(1, $usu_id);

        return $this->db->registros();
    }

    public function get_usuario_totalabierta_x_id($usu_id)
    {
        $this->db->query("SELECT COUNT(*) as TOTAL FROM incidencias where usu_id = ? and incidencia_estado='Abierta'");

        $this->db->bind(1, $usu_id);

        return $this->db->registros();
    }

    public function get_usuario_totalcerrada_x_id($usu_id)
    {
        $this->db->query("SELECT COUNT(*) as TOTAL FROM incidencias where usu_id = ? and incidencia_estado='Cerrada'");

        $this->db->bind(1, $usu_id);

        return $this->db->registros();
    }

    public function get_usuario_grafico($usu_id)
    {
        $this->db->query("
        SELECT departamentos.cat_nom as nom,COUNT(*) AS total
                FROM   incidencias  JOIN  
                    departamentos ON incidencias.cat_id = departamentos.cat_id  
                WHERE    
                incidencias.est = 1
                and incidencias.usu_id = ?
                GROUP BY 
                departamentos.cat_nom 
                ORDER BY total DESC");

        $this->db->bind(1, $usu_id);

        return $this->db->registros();
    }

    public function update_usuario_pass($usu_id, $usu_pass)
    {
        $this->db->query("UPDATE usuarios
        SET
            usu_pass = MD5(?)
        WHERE
            usu_id = ?
        ");

        $this->db->bind(1, $usu_pass);
        $this->db->bind(2, $usu_id);

        return $this->db->registros();
    }
}
