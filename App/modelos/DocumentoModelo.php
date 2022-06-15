<?php

class DocumentoModelo
{
    private $db;

    public function __construct()
    {
        $this->db = new Base;
    }

    public function insert_documento($incidencia_id, $doc_nom)
    {
        $this->db->query("INSERT INTO documentos (doc_id,incidencia_id,doc_nom,fech_crea,est) VALUES (null,?,?,now(),1);");

        $this->db->bind(1, $incidencia_id);
        $this->db->bind(2, $doc_nom);

        $this->db->execute();
    }

    public function get_documento_x_incidencia($incidencia_id)
    {
        $this->db->query("SELECT * FROM documentos WHERE incidencia_id=?");

        $this->db->bind(1, $incidencia_id);

        return $this->db->registros();
    }
}
