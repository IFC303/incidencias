<?php
if ($_SESSION["rol_id"] == 1) {
?>
    <nav class="side-menu">
        <ul class="side-menu-list">
            <li class="blue-dirty">
                <a href="..\home\">
                    <span class="glyphicon glyphicon-th"></span>
                    <span class="lbl">Inicio</span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\NuevaIncidencia\">
                    <span class="glyphicon glyphicon-th"></span>
                    <span class="lbl">Nueva Incidencia</span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\ConsultarIncidencia\">
                    <span class="glyphicon glyphicon-th"></span>
                    <span class="lbl">Consultar Incidencia</span>
                </a>
            </li>
        </ul>
    </nav>
<?php
} else {
?>
    <nav class="side-menu">
        <ul class="side-menu-list">
            <li class="blue-dirty">
                <a href="..\home\">
                    <span class="glyphicon glyphicon-th"></span>
                    <span class="lbl">Inicio</span>
                </a>
            </li>
            <li class="blue-dirty">
                <a href="..\NuevaIncidencia\">
                    <span class="glyphicon glyphicon-th"></span>
                    <span class="lbl">Nueva Incidencia</span>
                </a>
            </li>
            <li class="blue-dirty">
                <a href="..\ConsultarIncidencia\">
                    <span class="glyphicon glyphicon-th"></span>
                    <span class="lbl">Consultar Incidencia</span>
                </a>
            </li>
            <li class="blue-dirty">
                <a href="..\MntUsuario\">
                    <span class="glyphicon glyphicon-th"></span>
                    <span class="lbl">Mantenimiento Usuario</span>
                </a>
            </li>
        </ul>
    </nav>
<?php
}
?>