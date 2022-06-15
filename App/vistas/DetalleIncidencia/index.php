<?php require_once(RUTA_APP . "/vistas/MainHead/head.php"); ?>
<title>Detalle incidencia</title>
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
              <h3 id="lblnomidincidencia">Detalle incidencia - 1</h3>
              <div id="lblestado"></div>
              <span class="label label-pill label-primary" id="lblnomusuario"></span>
              <span class="label label-pill label-default" id="lblfechcrea"></span>
              <ol class="breadcrumb breadcrumb-simple">
                <li><a href="#">Home</a></li>
                <li class="active">Detalle incidencia</li>
              </ol>
            </div>
          </div>
        </div>
      </header>

      <div class="box-typical box-typical-padding">
        <div class="row">

          <div class="col-lg-6">
            <fieldset class="form-group">
              <label class="form-label semibold" for="cat_nom">Departamento</label>
              <input type="text" class="form-control" id="cat_nom" name="cat_nom" readonly>
            </fieldset>
          </div>

          <div class="col-lg-6">
            <fieldset class="form-group">
              <label class="form-label semibold" for="incidencia_titulo">Titulo</label>
              <input type="text" class="form-control" id="incidencia_titulo" name="incidencia_titulo" readonly>
            </fieldset>
          </div>

          <div class="col-lg-12">
            <fieldset class="form-group">
              <label class="form-label semibold" for="incidencia_titulo">Documentos Adicionales</label>
              <table id="documentos_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                <thead>
                  <tr>
                    <th style="width: 90%;">Nombre</th>
                    <th class="text-center" style="width: 10%;"></th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </fieldset>
          </div>


          <div class="col-lg-12">
            <fieldset class="form-group">
              <label class="form-label semibold" for="incid_descripusu">Descripción</label>
              <div class="summernote-theme-1">
                <textarea id="incid_descripusu" name="incid_descripusu" class="summernote" name="name"></textarea>
              </div>

            </fieldset>
          </div>

        </div>
      </div>

      <section class="activity-line" id="lbldetalle">

      </section>

      <div class="box-typical box-typical-padding" id="pnldetalle">
        <p>
          Ingrese su duda o consulta
        </p>
        <div class="row">
          <div class="col-lg-12">
            <fieldset class="form-group">
              <label class="form-label semibold" for="incid_descrip">Descripción</label>
              <div class="summernote-theme-1">
                <textarea id="incid_descrip" name="incid_descrip" class="summernote" name="name"></textarea>
              </div>
            </fieldset>
          </div>
          <div class="col-lg-12">
            <button type="button" id="btnenviar" class="btn btn-rounded btn-inline btn-primary">Enviar</button>
            <button type="button" id="btncerrarincidencia" class="btn btn-rounded btn-inline btn-warning">Cerrar incidencia</button>
          </div>
        </div>
      </div>

    </div>
  </div>
  <!-- Contenido -->

  <?php require_once(RUTA_APP . "/vistas/MainJs/js.php"); ?>

  <script type="text/javascript" src="<?php echo RUTA_URL ?>/js/detalleincidencia.js"></script>

</body>