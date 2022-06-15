<?php require_once(RUTA_APP . "/vistas/MainHead/head.php"); ?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<title>Home</title>
</head>

<body class="with-side-menu">

	<?php require_once(RUTA_APP . "/vistas/MainHeader/header.php"); ?>

	<div class="mobile-menu-left-overlay"></div>

	<?php require_once(RUTA_APP . "/vistas/MainNav/nav.php"); ?>

	<!-- Contenido -->
	<div class="page-content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-12">
					<div class="row">
						<div class="col-sm-4">
							<article class="statistic-box green">
								<div>
									<div class="number" id="lbltotal"></div>
									<div class="caption">
										<div>Total de Incidencias</div>
									</div>
								</div>
							</article>
						</div>
						<div class="col-sm-4">
							<article class="statistic-box yellow">
								<div>
									<div class="number" id="lbltotalabierta"></div>
									<div class="caption">
										<div>Total de Incidencias Abiertas</div>
									</div>
								</div>
							</article>
						</div>
						<div class="col-sm-4">
							<article class="statistic-box red">
								<div>
									<div class="number" id="lbltotalcerrada"></div>
									<div class="caption">
										<div>Total de Incidencias Cerradas</div>
									</div>
								</div>
							</article>
						</div>
					</div>
				</div>
			</div>

			<section class="card">
				<header class="card-header">
					Grafico Estadístico
				</header>
				<div class="card-block">
					<div id="divgrafico" style="height: 250px;"></div>
				</div>
			</section>

		</div>
	</div>
	<!-- Contenido -->

	<?php require_once(RUTA_APP . "/vistas/MainJs/js.php"); ?>

	<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script type="text/javascript" src="<?php echo RUTA_URL ?>/js/home.js"></script>

</body>