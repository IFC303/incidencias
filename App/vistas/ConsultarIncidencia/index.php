<?php require_once(RUTA_APP . "/vistas/MainHead/head.php"); ?>
<title>Consultar Incidencia</title>
</head>

<body class="with-side-menu">

	<?php require_once(RUTA_APP . "/vistas/MainHeader/header.php"); ?>

	<div class="mobile-menu-left-overlay"></div>

	<?php require_once(RUTA_APP . "/vistas/MainNav/nav.php"); ?>

	<!-- Contenido -->
	<div class="page-content">
		<div class="container-fluid">

			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h5>Consultar Incidencia</h5>
						</div>
					</div>
				</div>
			</header>

			<div class="box-typical box-typical-padding">
				<table id="incidencia_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
					<thead>
						<tr>
							<th style="width: 5%;">Nro.incidencia</th>
							<th style="width: 15%;">Departamento</th>
							<th class="d-none d-sm-table-cell" style="width: 40%;">Titulo</th>
							<th class="d-none d-sm-table-cell" style="width: 5%;">Estado</th>
							<th class="d-none d-sm-table-cell" style="width: 10%;">Fecha Creación</th>
							<th class="d-none d-sm-table-cell" style="width: 10%;">Fecha Asignación</th>
							<th class="d-none d-sm-table-cell" style="width: 10%;">Técnico</th>
							<th class="text-center" style="width: 5%;"></th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>

		</div>
	</div>
	<!-- Contenido -->
	<?php require_once("modalasignar.php"); ?>

	<?php require_once(RUTA_APP . "/vistas/MainJs/js.php"); ?>

	<script type="text/javascript" src="<?php echo RUTA_URL ?>/js/consultarincidencia.js"></script>

</body>