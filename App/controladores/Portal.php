<?php

class Portal extends Controlador
{

    public function __construct()
    {
        Sesion::iniciarSesion($this->datos);
        $this->datos['rolesPermitidos'] = [1, 2];          // Definimos los roles que tendran acceso

        if (!tienePrivilegios($this->datos['usuarioSesion']->rol_id, $this->datos['rolesPermitidos'])) {
            redireccionar('/');
        }

        if (!isset($_GET["op"])) : ?>
            <script>
                window.ruta_app = "<?php echo RUTA_URL ?>";
            </script>
            <?php endif;

        $this->usuarioModelo = $this->modelo('UsuarioModelo');
        $this->documentoModelo = $this->modelo('DocumentoModelo');
        $this->incidenciaModelo = $this->modelo('IncidenciaModelo');
        $this->departamentoModelo = $this->modelo('DepartamentoModelo');
    }

    public function index()
    {
        redireccionar("/");
    }

    public function Home()
    {
        $this->vista('Home/index', $this->datos);
    }

    public function NuevaIncidencia()
    {
        if (isset($_GET["op"])) {
            $html = "";

            switch ($_GET["op"]) {
                case "combo":
                    $datos = $this->departamentoModelo->get_departamento();
                    if (is_array($datos) == true and count($datos) > 0) {
                        foreach ($datos as $row) {
                            $html .= "<option value='" . $row->cat_id . "'>" . $row->cat_nom . "</option>";
                        }
                        echo $html;
                    }
                    break;
            }
        } else $this->vista('NuevaIncidencia/index', $this->datos);
    }

    public function ConsultarIncidencia()
    {
        if (isset($_GET["op"])) {
            $html = "";

            switch ($_GET["op"]) {

                case "insert":
                    $datos = $this->incidenciaModelo->insert_incidencia($_POST["usu_id"], $_POST["cat_id"], $_POST["incidencia_titulo"], $_POST["incidencia_descrip"]);
                    if (is_array($datos) == true and count($datos) > 0) {
                        foreach ($datos as $row) {
                            $output["incidencia_id"] = $row->incidencia_id;

                            if ($_FILES['files']['name'] == 0 || $_FILES['files']['name'] == "") {
                            } else {
                                $countfiles = count($_FILES['files']['name']);
                                $ruta = "../public/document/" . $output["incidencia_id"] . "/";
                                $files_arr = array();

                                if (!file_exists($ruta)) {
                                    mkdir($ruta, 0777, true);
                                }

                                for ($index = 0; $index < $countfiles; $index++) {
                                    $doc1 = $_FILES['files']['tmp_name'][$index];
                                    $destino = $ruta . $_FILES['files']['name'][$index];

                                    $this->documentoModelo->insert_documento($output["incidencia_id"], $_FILES['files']['name'][$index]);

                                    move_uploaded_file($doc1, $destino);
                                }
                            }
                        }
                    }
                    echo json_encode($datos);
                    break;

                case "update":
                    $this->incidenciaModelo->update_incidencia($_POST["incidencia_id"]);
                    $this->incidenciaModelo->insert_incidenciadetalle_cerrar($_POST["incidencia_id"], $_POST["usu_id"]);
                    break;

                case "reabrir":
                    $this->incidenciaModelo->reabrir_incidencia($_POST["incidencia_id"]);
                    $this->incidenciaModelo->insert_incidenciadetalle_reabrir($_POST["incidencia_id"], $_POST["usu_id"]);
                    break;

                case "asignar":
                    $this->incidenciaModelo->update_incidencia_asignacion($_POST["incidencia_id"], $_POST["usu_asig"]);
                    break;

                case "listar_x_usu":
                    $datos = $this->incidenciaModelo->listar_incidencia_x_usu($_POST["usu_id"]);
                    $data = array();
                    foreach ($datos as $row) {
                        $sub_array = array();
                        $sub_array[] = $row->incidencia_id;
                        $sub_array[] = $row->cat_nom;
                        $sub_array[] = $row->incidencia_titulo;

                        if ($row->incidencia_estado == "Abierta") {
                            $sub_array[] = '<span class="label label-pill label-success">Abierta</span>';
                        } else {
                            $sub_array[] = '<a onClick="CambiarEstado(' . $row->incidencia_id . ')"><span class="label label-pill label-danger">Cerrada</span></a>';
                        }

                        $sub_array[] = date("d/m/Y H:i:s", strtotime($row->fech_crea));

                        if ($row->fech_asig == null) {
                            $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
                        } else {
                            $sub_array[] = date("d/m/Y H:i:s", strtotime($row->fech_asig));
                        }

                        if ($row->usu_asig == null) {
                            $sub_array[] = '<span class="label label-pill label-warning">Sin Asignar</span>';
                        } else {
                            $datos1 = $this->usuarioModelo->get_usuario_x_id($row->usu_asig);
                            foreach ($datos1 as $row1) {
                                $sub_array[] = '<span class="label label-pill label-success">' . $row1->usu_nom . '</span>';
                            }
                        }

                        $sub_array[] = '<button type="button" onClick="ver(' . $row->incidencia_id . ');"  id="' . $row->incidencia_id . '" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                        $data[] = $sub_array;
                    }

                    $results = array(
                        "sEcho" => 1,
                        "iTotalRecords" => count($data),
                        "iTotalDisplayRecords" => count($data),
                        "aaData" => $data
                    );
                    echo json_encode($results);
                    break;

                case "listar":
                    $datos = $this->incidenciaModelo->listar_incidencia();
                    $data = array();
                    foreach ($datos as $row) {
                        $sub_array = array();
                        $sub_array[] = $row->incidencia_id;
                        $sub_array[] = $row->cat_nom;
                        $sub_array[] = $row->incidencia_titulo;

                        if ($row->incidencia_estado == "Abierta") {
                            $sub_array[] = '<span class="label label-pill label-success">Abierta</span>';
                        } else {
                            $sub_array[] = '<a onClick="CambiarEstado(' . $row->incidencia_id . ')"><span class="label label-pill label-danger">Cerrada</span><a>';
                        }

                        $sub_array[] = date("d/m/Y H:i:s", strtotime($row->fech_crea));

                        if ($row->fech_asig == null) {
                            $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
                        } else {
                            $sub_array[] = date("d/m/Y H:i:s", strtotime($row->fech_asig));
                        }

                        if ($row->usu_asig == null) {
                            $sub_array[] = '<a onClick="asignar(' . $row->incidencia_id . ');"><span class="label label-pill label-warning">Sin Asignar</span></a>';
                        } else {
                            $datos1 = $this->usuarioModelo->get_usuario_x_id($row->usu_asig);
                            foreach ($datos1 as $row1) {
                                $sub_array[] = '<span class="label label-pill label-success">' . $row1->usu_nom . '</span>';
                            }
                        }

                        $sub_array[] = '<button type="button" onClick="ver(' . $row->incidencia_id . ');"  id="' . $row->incidencia_id . '" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                        $data[] = $sub_array;
                    }

                    $results = array(
                        "sEcho" => 1,
                        "iTotalRecords" => count($data),
                        "iTotalDisplayRecords" => count($data),
                        "aaData" => $data
                    );
                    echo json_encode($results);
                    break;

                case "listardetalle":
                    $datos = $this->incidenciaModelo->listar_incidenciadetalle_x_incidencia($_POST["incidencia_id"]);
            ?>
                    <?php
                    foreach ($datos as $row) {
                    ?>
                        <article class="activity-line-item box-typical">
                            <div class="activity-line-date">
                                <?php echo date("d/m/Y", strtotime($row->fech_crea)); ?>
                            </div>
                            <header class="activity-line-item-header">
                                <div class="activity-line-item-user">
                                    <div class="activity-line-item-user-photo">
                                        <a href="#">
                                            <img src="../../public/<?php echo $row->rol_id ?>.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="activity-line-item-user-name"><?php echo $row->usu_nom . ' ' . $row->usu_ape; ?></div>
                                    <div class="activity-line-item-user-status">
                                        <?php
                                        if ($row->rol_id == 1) {
                                            echo 'Profesor';
                                        } else {
                                            echo 'Técnico';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </header>
                            <div class="activity-line-action-list">
                                <section class="activity-line-action">
                                    <div class="time"><?php echo date("H:i:s", strtotime($row->fech_crea)); ?></div>
                                    <div class="cont">
                                        <div class="cont-in">
                                            <p>
                                                <?php echo $row->incid_descrip; ?>
                                            </p>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </article>
                    <?php
                    }
                    ?>
<?php
                    break;

                case "mostrar";
                    $datos = $this->incidenciaModelo->listar_incidencia_x_id($_POST["incidencia_id"]);
                    if (is_array($datos) == true and count($datos) > 0) {
                        foreach ($datos as $row) {
                            $output["incidencia_id"] = $row->incidencia_id;
                            $output["usu_id"] = $row->usu_id;
                            $output["cat_id"] = $row->cat_id;

                            $output["incidencia_titulo"] = $row->incidencia_titulo;
                            $output["incidencia_descrip"] = $row->incidencia_descrip;

                            if ($row->incidencia_estado == "Abierta") {
                                $output["incidencia_estado"] = '<span class="label label-pill label-success">Abierta</span>';
                            } else {
                                $output["incidencia_estado"] = '<span class="label label-pill label-danger">Cerrada</span>';
                            }

                            $output["incidencia_estado_texto"] = $row->incidencia_estado;

                            $output["fech_crea"] = date("d/m/Y H:i:s", strtotime($row->fech_crea));
                            $output["usu_nom"] = $row->usu_nom;
                            $output["usu_ape"] = $row->usu_ape;
                            $output["cat_nom"] = $row->cat_nom;
                        }
                        echo json_encode($output);
                    }
                    break;

                case "insertdetalle":
                    $this->incidenciaModelo->insert_incidenciadetalle($_POST["incidencia_id"], $_POST["usu_id"], $_POST["incid_descrip"]);
                    break;

                case "total";
                    $datos = $this->incidenciaModelo->get_incidencia_total();
                    if (is_array($datos) == true and count($datos) > 0) {
                        foreach ($datos as $row) {
                            $output["TOTAL"] = $row->TOTAL;
                        }
                        echo json_encode($output);
                    }
                    break;

                case "totalabierta";
                    $datos = $this->incidenciaModelo->get_incidencia_totalabierta();
                    if (is_array($datos) == true and count($datos) > 0) {
                        foreach ($datos as $row) {
                            $output["TOTAL"] = $row->TOTAL;
                        }
                        echo json_encode($output);
                    }
                    break;

                case "totalcerrada";
                    $datos = $this->incidenciaModelo->get_incidencia_totalcerrada();
                    if (is_array($datos) == true and count($datos) > 0) {
                        foreach ($datos as $row) {
                            $output["TOTAL"] = $row->TOTAL;
                        }
                        echo json_encode($output);
                    }
                    break;

                case "grafico";
                    $datos = $this->incidenciaModelo->get_incidencia_grafico();
                    echo json_encode($datos);
                    break;
            }
        } else $this->vista('ConsultarIncidencia/index', $this->datos);
    }

    public function MntPerfil()
    {
        $this->vista('MntPerfil/index', $this->datos);
    }

    public function Logout()
    {
        session_destroy();
        redireccionar("/");
        exit();
    }

    public function MntUsuario()
    {
        $this->datos['rolesPermitidos'] = [1, 2];          // Definimos los roles que tendran acceso
        if (!tienePrivilegios($this->datos['usuarioSesion']->rol_id, $this->datos['rolesPermitidos'])) {
            redireccionar('/');
        } else if (isset($_GET["op"])) {
            $html = "";

            switch ($_GET["op"]) {
                case "guardaryeditar":
                    if (empty($_POST["usu_id"])) {
                        $this->usuarioModelo->insert_usuario($_POST["usu_nom"], $_POST["usu_ape"], $_POST["usu_correo"], $_POST["usu_pass"], $_POST["rol_id"]);
                    } else {
                        $this->usuarioModelo->update_usuario($_POST["usu_id"], $_POST["usu_nom"], $_POST["usu_ape"], $_POST["usu_correo"], $_POST["usu_pass"], $_POST["rol_id"]);
                    }
                    break;

                case "listar":
                    $datos = $this->usuarioModelo->get_usuario();
                    $data = array();
                    foreach ($datos as $row) {
                        $sub_array = array();
                        $sub_array[] = $row->usu_nom;
                        $sub_array[] = $row->usu_ape;
                        $sub_array[] = $row->usu_correo;
                        $sub_array[] = $row->usu_pass;

                        if ($row->rol_id == "1") {
                            $sub_array[] = '<span class="label label-pill label-success">Profesor</span>';
                        } else {
                            $sub_array[] = '<span class="label label-pill label-info">Técnico</span>';
                        }

                        $sub_array[] = '<button type="button" onClick="editar(' . $row->usu_id . ');"  id="' . $row->usu_id . '" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
                        $sub_array[] = '<button type="button" onClick="eliminar(' . $row->usu_id . ');"  id="' . $row->usu_id . '" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
                        $data[] = $sub_array;
                    }

                    $results = array(
                        "sEcho" => 1,
                        "iTotalRecords" => count($data),
                        "iTotalDisplayRecords" => count($data),
                        "aaData" => $data
                    );
                    echo json_encode($results);
                    break;

                case "eliminar":
                    $this->usuarioModelo->delete_usuario($_POST["usu_id"]);
                    break;

                case "mostrar";
                    $datos = $this->usuarioModelo->get_usuario_x_id($_POST["usu_id"]);
                    if (is_array($datos) == true and count($datos) > 0) {
                        foreach ($datos as $row) {
                            $output["usu_id"] = $row->usu_id;
                            $output["usu_nom"] = $row->usu_nom;
                            $output["usu_ape"] = $row->usu_ape;
                            $output["usu_correo"] = $row->usu_correo;
                            $output["usu_pass"] = $row->usu_pass;
                            $output["rol_id"] = $row->rol_id;
                        }
                        echo json_encode($output);
                    }
                    break;

                case "total";
                    $datos = $this->usuarioModelo->get_usuario_total_x_id($_POST["usu_id"]);
                    if (is_array($datos) == true and count($datos) > 0) {
                        foreach ($datos as $row) {
                            $output["TOTAL"] = $row->TOTAL;
                        }
                        echo json_encode($output);
                    }
                    break;

                case "totalabierta";
                    $datos = $this->usuarioModelo->get_usuario_totalabierta_x_id($_POST["usu_id"]);
                    if (is_array($datos) == true and count($datos) > 0) {
                        foreach ($datos as $row) {
                            $output["TOTAL"] = $row->TOTAL;
                        }
                        echo json_encode($output);
                    }
                    break;

                case "totalcerrada";
                    $datos = $this->usuarioModelo->get_usuario_totalcerrada_x_id($_POST["usu_id"]);
                    if (is_array($datos) == true and count($datos) > 0) {
                        foreach ($datos as $row) {
                            $output["TOTAL"] = $row->TOTAL;
                        }
                        echo json_encode($output);
                    }
                    break;

                case "grafico";
                    $datos = $this->usuarioModelo->get_usuario_grafico($_POST["usu_id"]);
                    echo json_encode($datos);
                    break;

                case "combo";
                    $datos = $this->usuarioModelo->get_usuario_x_rol();
                    if (is_array($datos) == true and count($datos) > 0) {
                        $html .= "<option label='Seleccionar'></option>";
                        foreach ($datos as $row) {
                            $html .= "<option value='" . $row->usu_id . "'>" . $row->usu_nom . "</option>";
                        }
                        echo $html;
                    }
                    break;
                    /* Controller para actualizar contraseña */
                case "password":
                    $this->usuarioModelo->update_usuario_pass($_POST["usu_id"], $_POST["usu_pass"]);
                    break;
            }
        } else $this->vista('MntUsuario/index', $this->datos);
    }

    public function DetalleIncidencia()
    {
        if (isset($_GET["op"])) {

            /* opciones del controlador */
            switch ($_GET["op"]) {
                    /* manejo de json para poder listar en el datatable, formato de json segun documentacion */
                case "listar":
                    $datos = $this->documentoModelo->get_documento_x_incidencia($_POST["incidencia_id"]);
                    $data = array();
                    foreach ($datos as $row) {
                        $sub_array = array();
                        $sub_array[] = '<a href="../../public/document/' . $_POST["incidencia_id"] . '/' . $row->doc_nom . '" target="_blank">' . $row->doc_nom . '</a>';
                        $sub_array[] = '<a type="button" href="../../public/document/' . $_POST["incidencia_id"] . '/' . $row->doc_nom . '" target="_blank" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></a>';
                        $data[] = $sub_array;
                    }

                    $results = array(
                        "sEcho" => 1,
                        "iTotalRecords" => count($data),
                        "iTotalDisplayRecords" => count($data),
                        "aaData" => $data
                    );
                    echo json_encode($results);
                    break;
            }
        } else $this->vista('DetalleIncidencia/index', $this->datos);
    }
}
