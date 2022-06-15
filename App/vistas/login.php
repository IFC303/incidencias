<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Iniciar sesión</title>
  <link rel="stylesheet" href="<?php echo RUTA_URL ?>/public/css/separate/pages/login.min.css">
  <link rel="stylesheet" href="<?php echo RUTA_URL ?>/public/css/lib/font-awesome/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo RUTA_URL ?>/public/css/lib/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo RUTA_URL ?>/public/css/main.css">
</head>

<body>
  <div class="page-center">
    <div class="page-center-in">
      <div class="container-fluid">

        <form class="sign-box" action="" method="post" id="login_form">

          <input type="hidden" id="rol_id" name="rol_id" value="1">

          <div class="sign-avatar">
            <img src="public/img/logo.png" alt="" id="imgtipo">
          </div>
          <header class="sign-title" id="lbltitulo">Incidencias</header>

          <?php
          if (isset($_GET["error"])) {
            switch ($_GET["error"]) {
              case "incorrecto";
          ?>
                <div class="alert alert-warning alert-icon alert-close alert-dismissible fade in" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                  <i class="font-icon font-icon-warning"></i>
                  Usuario/contraseña incorrecta
                </div>
              <?php
                break;

              case "vacio";
              ?>
                <div class="alert alert-warning alert-icon alert-close alert-dismissible fade in" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                  <i class="font-icon font-icon-warning"></i>
                  Los campos estan vacios.
                </div>
          <?php
                break;
            }
          }
          ?>

          <div class="form-group">
            <input type="text" id="usu_correo" name="usu_correo" class="form-control" placeholder="Email" required />
          </div>
          <div class="form-group">
            <input type="password" id="usu_pass" name="usu_pass" class="form-control" placeholder="Password" required/>
          </div>
          <input type="hidden" name="enviar" class="form-control" value="si">
          <button type="submit" class="btn btn-rounded">Iniciar sesión</button>
        </form>
      </div>
    </div>
  </div>

  <script src="<?php echo RUTA_URL ?>/public/js/lib/jquery/jquery.min.js"></script>
  <script src="<?php echo RUTA_URL ?>/public/js/lib/tether/tether.min.js"></script>
  <script src="<?php echo RUTA_URL ?>/public/js/lib/bootstrap/bootstrap.min.js"></script>
  <script src="<?php echo RUTA_URL ?>/public/js/plugins.js"></script>
  <script type="text/javascript" src="<?php echo RUTA_URL ?>/public/js/lib/match-height/jquery.matchHeight.min.js"></script>
  <script>
    $(function() {
      $('.page-center').matchHeight({
        target: $('html')
      });

      $(window).resize(function() {
        setTimeout(function() {
          $('.page-center').matchHeight({
            remove: true
          });
          $('.page-center').matchHeight({
            target: $('html')
          });
        }, 100);
      });
    });
    false
  </script>
  <script src="<?php echo RUTA_URL ?>/public/js/app.js"></script>

  <script type="text/javascript" src="<?php echo RUTA_URL ?>/public/js/datos.js"></script>
</body>