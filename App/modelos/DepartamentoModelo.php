<?php

class DepartamentoModelo
{
    private $db;

    public function __construct()
    {
        $this->db = new Base;
    }

    public function get_departamento()
    {
        $this->db->query("SELECT * FROM departamentos WHERE est=1");

        return $this->db->registros();
    }
}
