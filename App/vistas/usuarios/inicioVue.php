<?php require_once RUTA_APP . '/vistas/inc/header.php' ?>


<div id="appVue">
    <table class="table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Rol</th>
                <?php if (tienePrivilegios($datos['usuarioSesion']->id_rol, [1])) : ?>
                    <th>Acciones</th>
                <?php endif ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datos['usuarios'] as $uruario) : ?>
                <tr>
                    <td><?php echo $uruario->id_usuario ?></td>
                    <td><?php echo $uruario->nombre ?></td>
                    <td><?php echo $uruario->email ?></td>
                    <td><?php echo $uruario->telefono ?></td>
                    <td><?php echo $uruario->id_rol ?></td>
                    <?php if (tienePrivilegios($datos['usuarioSesion']->id_rol, [1])) : ?>
                        <td>
                            <a href="<?php echo RUTA_URL ?>/usuarios/editar/<?php echo $uruario->id_usuario ?>">Editar</a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="<?php echo RUTA_URL ?>/usuarios/borrar/<?php echo $uruario->id_usuario ?>">Borrar</a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="#" @click="getSesiones(<?php echo $uruario->id_usuario ?>)">Sesiones</a>
                        </td>
                    <?php endif ?>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <?php if (tienePrivilegios($datos['usuarioSesion']->id_rol, [1])) : ?>
        <div class="col text-center">
            <a class="btn btn-success" href="<?php echo RUTA_URL ?>/usuarios/agregar/">+</a>
        </div>

        <div class="container" v-if="usuario">
            <br><br>
            <h2>Sesiones de: <span v-if="usuario">{{ usuario.nombre }}<span></h2>
            <table class="table text-center">
                <thead>
                    <tr>
                        <th scope="col">id_sesion</th>
                        <th scope="col">id_usuario</th>
                        <th scope="col">fecha_inicio</th>
                        <th scope="col">fecha_fin</th>
                        <th scope="col">estado</th>
                    </tr>
                </thead>
                <tbody id="tbodyTablaSesiones">
                    <tr v-for="(sesion, key) in sesiones" :key="key">
                        <td> {{ sesion.id_sesion }} </td>
                        <td> {{ sesion.id_usuario }}</td>
                        <td> {{ formatoFecha(sesion.fecha_inicio) }}</td>
                        <td> {{ formatoFecha(sesion.fecha_fin) }}</td>
                        <td>
                            <div class="col text-center" v-if="!sesion.fecha_fin">
                                <a class="btn btn-success" href="#" @click="cerrarSesion(sesion.id_sesion)">
                                    Cerrar
                                </a>
                            </div>
                            <span v-else>
                                Cerrada
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.11/dist/vue.js"></script>

<script>
    var app = new Vue({
        el: '#appVue',
        data() {
            return {
                sesiones: [],
                usuario: null,
            }
        },

        methods: {
            formatoFecha(fecha) {
                if (fecha) {
                    let fechaFin = new Date(fecha)
                    return fechaFin.toLocaleString()
                } else {
                    return '-'
                }
            },


            getSesiones(id_usuario) {
                fetch('<?php echo RUTA_URL ?>/usuarios/sesiones/' + id_usuario, {
                        headers: {
                            "Content-Type": "application/json"
                        },
                        credentials: 'include'
                    })
                    .then((resp) => resp.json())
                    .then((data) => {
                        this.sesiones = data['sesiones']
                        this.usuario = data['usuario']
                    })
            },


            cerrarSesion(id_sesion) {
                const data = new FormData();
                data.append('id_sesion', id_sesion);

                fetch('<?php echo RUTA_URL ?>/usuarios/cerrarSesion/', {
                        method: "POST",
                        body: data,
                    })
                    .then((resp) => resp.json())
                    .then((data) => {
                        if (Boolean(data)) {
                            this.getSesiones(this.usuario.id_usuario)
                        } else {
                            alert('Error al Cerrar la sesión')
                        }
                    })
            }
        }
    })
</script>

<?php endif ?>

<?php require_once RUTA_APP . '/vistas/inc/footer.php' ?>