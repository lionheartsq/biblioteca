<template>
       <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Libros</li>
                </ol>
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Libros &nbsp;
                            <button type="button" @click="abrirModal('libro','crear')" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="libro">Nombre</option>
                                        <option value="editorial">Editorial</option>
                                        <option value="categoria">Categoría</option>
                                        <option value="autor">Autor</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarLibros(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarLibros(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Páginas</th>
                                        <th>Edición</th>
                                        <th>Fecha Edición</th>
                                        <th>Categoría</th>
                                        <th>Autor</th>
                                        <th>Editorial</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="libro in arrayLibros" :key="libro.id">
                                        <td>
                                            <button type="button" @click="abrirModal('libro','actualizar',libro)" class="btn btn-warning btn-sm">
                                            <i class="icon-pencil"></i>
                                            </button> &nbsp;

                                        <template v-if="libro.estado">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarLibros(libro.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-success btn-sm" @click="activarLibros(libro.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                        </td>
                                        <td v-text="libro.codigo"></td>
                                        <td v-text="libro.libro"></td>
                                        <td v-text="libro.paginas"></td>
                                        <td v-text="libro.edicion"></td>
                                        <td v-text="libro.fechaedicion"></td>
                                        <td v-text="libro.categoria"></td>
                                        <td v-text="libro.autor"></td>
                                        <td v-text="libro.editorial"></td>
                                        <td>
                                            <div v-if="libro.estado">
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
                                        <label class="col-md-3 form-control-label" for="text-input">Código</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="codigo" max="10" class="form-control" placeholder="Código de Identificación">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="libro" class="form-control" placeholder="Nombre del libro">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Páginas</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="paginas" max="10" class="form-control" placeholder="Páginas">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Edición</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="edicion" max="10" class="form-control" placeholder="Edición">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Año Edición</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="fechaedicion" max="10" class="form-control" placeholder="Año Edición">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Categoría</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="idCategoria">
                                                <option v-for="categoria in arrayCategorias" :key="categoria.idgenCategoria" :value="categoria.idgenCategoria" v-text="categoria.categoria"></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Autor</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="idAutor">
                                                <option v-for="autor in arrayAutores" :key="autor.idgenAutor" :value="autor.idgenAutor" v-text="autor.autor"></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Editorial</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="idEditorial">
                                                <option v-for="editorial in arrayEditoriales" :key="editorial.idgenEditorial" :value="editorial.idgenEditorial" v-text="editorial.editorial"></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row div-error" v-show="errorLibro">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearLibro()">Guardar</button>
                                <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="editarLibro()">Editar</button>
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
                idLibro:0,
                id:'',
                codigo:0,
                libro:'',
                paginas:0,
                edicion:0,
                fechaedicion:0,
                idCategoria:1,
                idAutor:1,
                idEditorial:1,
                estado:'',
                arrayLibros : [],
                arrayAutores : [],
                arrayCategorias : [],
                arrayEditoriales : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorLibro : 0,
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
                criterio : 'libro',
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
            listarLibros(page,buscar,criterio){
                let me=this;
                var url='/libro?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayLibros=respuesta.libros.data;
                me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            listarAutores(){
             let me=this;
             var url='/autor/selectautor';
             axios.get(url).then(function (response) {
             var respuesta=response.data;
             me.arrayAutores=respuesta.autores;
             })
             .catch(function (error) {
                 // handle error
                 console.log(error);
             })
            },
            listarEditoriales(){
             let me=this;
             var url='/editorial/selecteditorial';
             axios.get(url).then(function (response) {
             var respuesta=response.data;
             me.arrayEditoriales=respuesta.editorial;
             })
             .catch(function (error) {
                 // handle error
                 console.log(error);
             })
            },
            listarCategorias(){
             let me=this;
             var url='/categoria/selectcategoria';
             axios.get(url).then(function (response) {
             var respuesta=response.data;
             me.arrayCategorias=respuesta.categoria;
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
                me.listarLibros(page,buscar,criterio);
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
                me.listarLibros(page,buscar,criterio);
            },
            crearLibro(){
                //valido con el metodo de validacion creado
                if(this.validarLibro()){
                    return;
                }

                let me=this;
                axios.post('/libro/store',{
                    'codigo': this.codigo,
                    'libro': this.libro,
                    'paginas': this.paginas,
                    'edicion': this.edicion,
                    'fechaedicion': this.fechaedicion,
                    'idCategoria': this.idCategoria,
                    'idAutor': this.idAutor,
                    'idEditorial': this.idEditorial
                }).then(function (response) {
                me.cerrarModal();
                me.listarLibros(1,'','libro');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            editarLibro(){
                if(this.validarLibro()){
                    return;
                }

                let me=this;
                axios.put('/libro/update',{
                    'id': this.idLibro,
                    'codigo': this.codigo,
                    'libro': this.libro,
                    'paginas': this.paginas,
                    'edicion': this.edicion,
                    'fechaedicion': this.fechaedicion,
                    'idCategoria': this.idCategoria,
                    'idAutor': this.idAutor,
                    'idEditorial': this.idEditorial
                }).then(function (response) {
                me.cerrarModal();
                me.listarLibros(1,'','libro');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
             desactivarLibros(id){
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
                    axios.put('/libro/deactivate',{
                        'id': id
                    }).then(function (response) {
                    me.listarLibros(1,'','libro');
                    swalWithBootstrapButtons.fire(
                    'Libro desactivado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarLibros();
                }
                })
            },
            activarLibros(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Quiere activar este libro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-check fa-2x"></i> Activar!',
                cancelButtonText:  '<i class="fa fa-times fa-2x"></i> Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('/libro/activate',{
                        'id': id
                    }).then(function (response) {
                    me.listarLibros(1,'','libro');
                    swalWithBootstrapButtons.fire(
                    'Libro activado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarLibros();
                }
                })
            },
            validarLibro(){
                this.errorLibro=0;
                this.errorMensaje=[];

                if (!this.libro) this.errorMensaje.push("El Nombre no puede estar vacio");
                if (!this.paginas) this.errorMensaje.push("El número de páginas no puede estar vacio");
                if (this.paginas<0) this.errorMensaje.push("El número de páginas no puede ser negativo");
                if (!this.edicion) this.errorMensaje.push("El año de edición no puede estar vacio");
                if (this.edicion<0) this.errorMensaje.push("El año de edición no puede ser negativo");
                if (!this.fechaedicion) this.errorMensaje.push("La fecha de edición no puede estar vacia");
                if (this.fechaedicion<0) this.errorMensaje.push("La fecha de edición no puede ser negativa");
                if (!this.idAutor) this.errorMensaje.push("El autor no puede estar vacio");
                if (!this.idCategoria) this.errorMensaje.push("La categoría no puede estar vacia");
                if (!this.idEditorial) this.errorMensaje.push("La editorial no puede estar vacia");
                if (this.errorMensaje.length) this.errorLibro=1;

                return this.errorLibro;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.codigo='';
                this.libro='';
                this.paginas='';
                this.edicion='';
                this.fechaedicion='';
                this.idCategoria='';
                this.idAutor='';
                this.idEditorial='';
                this.errorLibro = 0,
                this.errorMensaje = [],
                this.forceRerender();
            },
            abrirModal(modelo, accion, data=[]){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){
                case "libro":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.libro='';
                            this.tituloModal='Crear nuevo libro';
                            this.tipoAccion= 1;
                            break;
                        }
                        case 'actualizar':{
                            //console.log(data);
                            this.modal=1;
                            this.tituloModal='Editar libro';
                            this.tipoAccion= 2;
                            this.idLibro=data['id'];
                            this.codigo=data['codigo'];
                            this.libro=data['libro'];
                            this.paginas=data['paginas'];
                            this.edicion=data['edicion'];
                            this.fechaedicion=data['fechaedicion'];
                            this.idCategoria=data['idCategoria'];
                            this.idAutor=data['idAutor'];
                            this.idEditorial=data['idEditorial'];
                            break;
                        }
                    }
                }
            }
            }
        },
        mounted() {
            this.listarLibros(1,this.buscar,this.criterio);
            this.listarAutores();
            this.listarCategorias();
            this.listarEditoriales();
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
