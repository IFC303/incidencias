<?php require_once(RUTA_APP . "/vistas/MainHead/head.php"); ?>
<title>Nueva Incidencia</title>
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
							<h5>Nueva Incidencia</h5>
						</div>
					</div>
				</div>
			</header>

			<div class="box-typical box-typical-padding">
				<div class="row">
					<form method="post" id="incidencia_form">

						<input type="hidden" id="usu_id" name="usu_id" value="<?php echo $_SESSION["usu_id"] ?>">

						<div class="col-lg-12">
							<fieldset class="form-group">
								<label class="form-label semibold" for="incidencia_titulo">Titulo</label>
								<input type="text" class="form-control" id="incidencia_titulo" name="incidencia_titulo" placeholder="Ingrese Titulo">
							</fieldset>
						</div>

						<div class="col-lg-6">
							<fieldset class="form-group">
								<label class="form-label semibold" for="exampleInput">Departamento</label>
								<select id="cat_id" name="cat_id" class="form-control">

								</select>
							</fieldset>
						</div>

						<div class="col-lg-6">
							<fieldset class="form-group">
								<label class="form-label semibold" for="exampleInput">Documentos Adicionales</label>
								<input type="file" name="fileElem" id="fileElem" class="form-control" multiple>
							</fieldset>
						</div>

						<div class="col-lg-12">
							<fieldset class="form-group">
								<label class="form-label semibold" for="incidencia_descrip">Descripción</label>
								<div class="summernote-theme-1">
									<textarea id="incidencia_descrip" name="incidencia_descrip" class="summernote" name="name"></textarea>
								</div>
							</fieldset>
						</div>
						<div class="col-lg-12">
							<button type="submit" name="action" value="add" class="btn btn-rounded btn-inline btn-primary">Guardar</button>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
	<!-- Contenido -->

	<?php require_once(RUTA_APP . "/vistas/MainJs/js.php"); ?>

	<script type="text/javascript" src="<?php echo RUTA_URL ?>/js/nuevaincidencia.js"></script>

</body>