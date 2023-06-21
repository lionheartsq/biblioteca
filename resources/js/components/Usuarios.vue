<template>
       <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Usuarios</li>
                </ol>
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Usuarios &nbsp;
                            <button type="button" @click="abrirModal('usuario','crear')" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="document">Documento</option>
                                        <option value="name">Nombre</option>
                                        <option value="email">Correo</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarUsuarios(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarUsuarios(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Documento</th>
                                        <th>Nombre</th>
                                        <th>Dirección</th>
                                        <th>Telefono</th>
                                        <th>Correo</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="usuario in arrayUsuarios" :key="usuario.id">
                                        <td>
                                            <button type="button" @click="abrirModal('usuario','actualizar',usuario)" class="btn btn-warning btn-sm">
                                            <i class="icon-pencil"></i>
                                            </button> &nbsp;

                                        <template v-if="usuario.estado">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarUsuarios(usuario.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-success btn-sm" @click="activarUsuarios(usuario.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                        </td>
                                        <td v-text="usuario.document"></td>
                                        <td v-text="usuario.name"></td>
                                        <td v-text="usuario.address"></td>
                                        <td v-text="usuario.phone"></td>
                                        <td v-text="usuario.email"></td>
                                        <td>
                                            <div v-if="usuario.estado">
                                            <span class="badge badge-success">Activo</span>
                                            </div>
                                            <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            </div>
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item" v-if="pagination.current_page > 1">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                    </li>
                                    <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                    </li>
                                    <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <!-- Fin ejemplo de tabla Listado -->
                </div>
                <!--Inicio del modal agregar/actualizar-->
                <div class="modal fade" tabindex="-1" :class="{'mostrar':modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-primary modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" v-text="tituloModal"></h4>
                                <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                                <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Documento</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="documento" max="10" class="form-control" placeholder="Documento de Identificación">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Nombre completo</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="nombre" class="form-control" placeholder="Nombre del usuario">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Dirección</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="direccion" class="form-control" placeholder="Dirección">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Telefono</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="telefono" max="10" class="form-control" placeholder="Telefono">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Correo</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="correo" class="form-control" placeholder="Correo">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Rol</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="idRol">
                                                <option value="1" v-if="idRol<2">SuperAdministrador</option>
                                                <option value="2" v-if="idRol<3">Administrador</option>
                                                <option value="3" v-if="idRol<4">Usuario</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row div-error" v-show="errorUsuario">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearUsuario()">Guardar</button>
                                <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="editarUsuario()">Editar</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!--Fin del modal-->
        </main>
</template>

<script>
    export default {
        data(){
            return{
                idUsuario:0,
                id:'',
                documento:0,
                nombre:'',
                direccion:'',
                telefono:0,
                correo:'',
                idRol:2,
                estado:'',
                arrayUsuarios : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorUsuario : 0,
                errorMensaje : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'document',
                buscar : ''
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginacion
            pagesNumber: function(){
                if (!this.pagination.to) {
                    return[];
                }

                var from=this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },
        methods : {
            listarUsuarios(page,buscar,criterio){
                let me=this;
                var url='/usuario?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayUsuarios=respuesta.usuarios.data;
                me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                //envia peticion para ver los valores asociados a esa pagina
                me.listarUsuarios(page,buscar,criterio);
            },
            indexChange: function(args) {
                let newIndex = args.value
                console.log('Current tab index: ' + newIndex)
                },
            forceRerender() {
                this.componentKey += 1;
               },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                //envia peticion para ver los valores asociados a esa pagina
                me.listarUsuarios(page,buscar,criterio);
            },
            crearUsuario(){
                //valido con el metodo de validacion creado
                if(this.validarUsuario()){
                    return;
                }

                let me=this;
                axios.post('/usuario/store',{
                    'documento': this.documento,
                    'nombre': this.nombre,
                    'direccion': this.direccion,
                    'telefono': this.telefono,
                    'correo': this.correo,
                    'idRol': this.idRol
                }).then(function (response) {
                me.cerrarModal();
                me.listarUsuarios(1,'','usuario');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            editarUsuario(){
                if(this.validarUsuario()){
                    return;
                }

                let me=this;
                axios.put('/usuario/update',{
                    'id': this.idUsuario,
                    'document': this.documento,
                    'name': this.nombre,
                    'address': this.direccion,
                    'phone': this.telefono,
                    'email': this.correo,
                    'idRol': this.idRol,
                    'idexRol': this.idexRol
                }).then(function (response) {
                me.cerrarModal();
                me.listarUsuarios(1,'','usuario');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
             desactivarUsuarios(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Está seguro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-check fa-2x"></i> Desactivar!',
                cancelButtonText:  '<i class="fa fa-times fa-2x"></i> Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('/usuario/deactivate',{
                        'id': id
                    }).then(function (response) {
                    me.listarUsuarios(1,'','usuario');
                    swalWithBootstrapButtons.fire(
                    'Usuario desactivado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarUsuarios();
                }
                })
            },
            activarUsuarios(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Quiere activar este usuario?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-check fa-2x"></i> Activar!',
                cancelButtonText:  '<i class="fa fa-times fa-2x"></i> Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('/usuario/activate',{
                        'id': id
                    }).then(function (response) {
                    me.listarUsuarios(1,'','usuario');
                    swalWithBootstrapButtons.fire(
                    'Usuario activado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarUsuarios();
                }
                })
            },
            validarUsuario(){
                this.errorUsuario=0;
                this.errorMensaje=[];

                if (!this.documento) this.errorMensaje.push("El Documento no puede estar vacio");
                if (this.documento<0) this.errorMensaje.push("El Documento no puede ser negativo");
                if (!this.nombre) this.errorMensaje.push("El Nombre no puede estar vacio");
                if (!this.direccion) this.errorMensaje.push("La Dirección no puede estar vacia");
                if (!this.telefono) this.errorMensaje.push("El Telefono no puede estar vacio");
                if (this.telefono<0) this.errorMensaje.push("El Telefono no puede ser negativo");
                if (!this.correo) this.errorMensaje.push("El Correo no puede estar vacio");
                if (this.errorMensaje.length) this.errorUsuario=1;

                return this.errorUsuario;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.cliente='';
                this.documento='';
                this.nombre='';
                this.direccion='';
                this.telefono='';
                this.correo='';
                this.errorUsuario = 0,
                this.errorMensaje = [],
                this.forceRerender();
            },
            abrirModal(modelo, accion, data=[]){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){
                case "usuario":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.usuario='';
                            this.tituloModal='Crear nuevo usuario';
                            this.tipoAccion= 1;
                            break;
                        }
                        case 'actualizar':{
                            //console.log(data);
                            this.modal=1;
                            this.tituloModal='Editar usuario';
                            this.tipoAccion= 2;
                            this.idUsuario=data['id'];
                            this.documento=data['document'];
                            this.nombre=data['name'];
                            this.direccion=data['address'];
                            this.telefono=data['phone'];
                            this.correo=data['email'];
                            this.idRol=data['idRol'];
                            this.idexRol=data['idexRol'];
                            break;
                        }
                    }
                }
            }
            }
        },
        mounted() {
            this.listarUsuarios(1,this.buscar,this.criterio);
        }
    }
</script>
<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
