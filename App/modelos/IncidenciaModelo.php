<?php

class IncidenciaModelo
{
    private $db;

    public function __construct()
    {
        $this->db = new Base;
    }

    public function insert_incidencia($usu_id, $cat_id, $incidencia_titulo, $incidencia_descrip)
    {
        $this->db->query("INSERT INTO incidencias (incidencia_id,usu_id,cat_id,incidencia_titulo,incidencia_descrip,incidencia_estado,fech_crea,usu_asig,fech_asig,est) VALUES (NULL,?,?,?,?,'Abierta',now(),NULL,NULL,'1');");

        //vinculamos los valores
        $this->db->bind(1, $usu_id);
        $this->db->bind(2, $cat_id);
        $this->db->bind(3, $incidencia_titulo);
        $this->db->bind(4, $incidencia_descrip);

        //ejecutamos
        $this->db->execute();

        //devolvemos la última incidencia insertada
        $this->db->query("select last_insert_id() as 'incidencia_id';");
        return $this->db->registros();
    }

    public function listar_incidencia_x_usu($usu_id)
    {
        $this->db->query("SELECT 
        incidencias.incidencia_id,
        incidencias.usu_id,
        incidencias.cat_id,
        incidencias.incidencia_titulo,
        incidencias.incidencia_descrip,
        incidencias.incidencia_estado,
        incidencias.fech_crea,
        incidencias.usu_asig,
        incidencias.fech_asig,
        usuarios.usu_nom,
        usuarios.usu_ape,
        departamentos.cat_nom
        FROM 
        incidencias
        INNER join departamentos on incidencias.cat_id = departamentos.cat_id
        INNER join usuarios on incidencias.usu_id = usuarios.usu_id
        WHERE
        incidencias.est = 1
        AND usuarios.usu_id=?");

        $this->db->bind(1, $usu_id);

        return $this->db->registros();
    }

    public function listar_incidencia_x_id($incidencia_id)
    {

        $this->db->query("SELECT 
        incidencias.incidencia_id,
        incidencias.usu_id,
        incidencias.cat_id,
        incidencias.incidencia_titulo,
        incidencias.incidencia_descrip,
        incidencias.incidencia_estado,
        incidencias.fech_crea,
        usuarios.usu_nom,
        usuarios.usu_ape,
        usuarios.usu_correo,
        departamentos.cat_nom
        FROM 
        incidencias
        INNER join departamentos on incidencias.cat_id = departamentos.cat_id
        INNER join usuarios on incidencias.usu_id = usuarios.usu_id
        WHERE
        incidencias.est = 1
        AND incidencias.incidencia_id = ?");

        $this->db->bind(1, $incidencia_id);
        return $this->db->registros();
    }

    public function listar_incidencia()
    {
        $this->db->query("SELECT
        incidencias.incidencia_id,
        incidencias.usu_id,
        incidencias.cat_id,
        incidencias.incidencia_titulo,
        incidencias.incidencia_descrip,
        incidencias.incidencia_estado,
        incidencias.fech_crea,
        incidencias.usu_asig,
        incidencias.fech_asig,
        usuarios.usu_nom,
        usuarios.usu_ape,
        departamentos.cat_nom
        FROM 
        incidencias
        INNER join departamentos on incidencias.cat_id = departamentos.cat_id
        INNER join usuarios on incidencias.usu_id = usuarios.usu_id
        WHERE
        incidencias.est = 1
        ");

        return $this->db->registros();
    }

    public function listar_incidenciadetalle_x_incidencia($incidencia_id)
    {
        $this->db->query("SELECT
        incidenciasdetalle.incid_id,
        incidenciasdetalle.incid_descrip,
        incidenciasdetalle.fech_crea,
        usuarios.usu_nom,
        usuarios.usu_ape,
        usuarios.rol_id
        FROM 
        incidenciasdetalle
        INNER join usuarios on incidenciasdetalle.usu_id = usuarios.usu_id
        WHERE 
        incidencia_id =?");

        $this->db->bind(1, $incidencia_id);
        return $this->db->registros();
    }

    public function insert_incidenciadetalle($incidencia_id, $usu_id, $incid_descrip)
    {
        $this->db->query("INSERT INTO incidenciasdetalle (incid_id,incidencia_id,usu_id,incid_descrip,fech_crea,est) VALUES (NULL,?,?,?,now(),'1');");

        $this->db->bind(1, $incidencia_id);
        $this->db->bind(2, $usu_id);
        $this->db->bind(3, $incid_descrip);

        return $this->db->registros();
    }

    public function insert_incidenciadetalle_cerrar($incidencia_id, $usu_id)
    {
        $this->db->query("call sp_cerrar_incidencia(?,?)");

        $this->db->bind(1, $incidencia_id);
        $this->db->bind(2, $usu_id);

        return $this->db->registros();
    }

    public function insert_incidenciadetalle_reabrir($incidencia_id, $usu_id)
    {
        $this->db->query("INSERT INTO incidenciasdetalle 
        (incid_id,incidencia_id,usu_id,incid_descrip,fech_crea,est) 
        VALUES 
        (NULL,?,?,'incidencia Re-Abierta...',now(),'1');");

        $this->db->bind(1, $incidencia_id);
        $this->db->bind(2, $usu_id);

        return $this->db->registros();
    }

    public function update_incidencia($incidencia_id)
    {
        $this->db->query("update incidencias 
        set	
            incidencia_estado = 'Cerrada'
        where
            incidencia_id = ?");

        $this->db->bind(1, $incidencia_id);

        return $this->db->registros();
    }

    public function reabrir_incidencia($incidencia_id)
    {
        $this->db->query("update incidencias 
        set	
            incidencia_estado = 'Abierta'
        where
            incidencia_id = ?");

        $this->db->bind(1, $incidencia_id);

        return $this->db->registros();
    }

    public function update_incidencia_asignacion($incidencia_id, $usu_asig)
    {
        $this->db->query("update incidencias 
        set	
            usu_asig = ?,
            fech_asig = now()
        where
            incidencia_id = ?");

        $this->db->bind(1, $usu_asig);
        $this->db->bind(2, $incidencia_id);

        return $this->db->registros();
    }

    public function get_incidencia_total()
    {
        $this->db->query("SELECT COUNT(*) as TOTAL FROM incidencias");

        return $this->db->registros();
    }

    public function get_incidencia_totalabierta()
    {
        $this->db->query("SELECT COUNT(*) as TOTAL FROM incidencias where incidencia_estado='Abierta'");

        return $this->db->registros();
    }

    public function get_incidencia_totalcerrada()
    {
        $this->db->query("SELECT COUNT(*) as TOTAL FROM incidencias where incidencia_estado='Cerrada'");

        return $this->db->registros();
    }

    public function get_incidencia_grafico()
    {
        $this->db->query("SELECT departamentos.cat_nom as nom,COUNT(*) AS total
        FROM   incidencias  JOIN  
            departamentos ON incidencias.cat_id = departamentos.cat_id  
        WHERE    
        incidencias.est = 1
        GROUP BY 
        departamentos.cat_nom 
        ORDER BY total DESC");

        return $this->db->registros();
    }
}
