<template>
    <main class="main">
             <!-- Breadcrumb -->
             <ol class="breadcrumb">
                 <li class="breadcrumb-item">Home</li>
                 <li class="breadcrumb-item active">Autores</li>
             </ol>
             <div class="container-fluid">
                 <!-- Ejemplo de tabla Listado -->

                 <div class="card">
                     <div class="card-header">
                         <i class="fa fa-align-justify"></i> Autores &nbsp;
                         <button type="button" @click="abrirModal('autor','crear')" class="btn btn-secondary">
                             <i class="icon-plus"></i>&nbsp;Nuevo
                         </button>
                     </div>
                     <div class="card-body">
                         <div class="form-group row">
                             <div class="col-md-9">
                                 <div class="input-group">
                                     <select class="form-control col-md-3" v-model="criterio">
                                     <option value="autor">Autor</option>
                                     <option value="seudonimo">Seudónimo</option>
                                     </select>
                                     <input type="text" v-model="buscar" @keyup.enter="listarAutores(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                     <button type="submit" @click="listarAutores(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                 </div>
                             </div>
                         </div>
                         <div class="table-responsive">
                         <table class="table table-bordered table-striped table-sm">
                             <thead>
                                 <tr>
                                     <th>Opciones</th>
                                     <th>Autor</th>
                                     <th>Seudónimo</th>
                                     <th>Pais</th>
                                 </tr>
                             </thead>
                             <tbody>

                                 <tr v-for="autors in arrayAutores" :key="autors.id">
                                     <td>
                                         <button type="button" @click="abrirModal('autor','actualizar',autors)" class="btn btn-warning btn-sm">
                                         <i class="icon-pencil"></i>
                                         </button> &nbsp;
                                     </td>
                                     <td v-text="autors.autor"></td>
                                     <td v-text="autors.seudonimo"></td>
                                     <td v-text="autors.pais"></td>
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
                                     <label class="col-md-3 form-control-label" for="text-input">Autor</label>
                                     <div class="col-md-9">
                                         <input type="text" v-model="autor" max="10" class="form-control" placeholder="Nombre del autor">
                                     </div>
                                 </div>
                                 <div class="form-group row">
                                     <label class="col-md-3 form-control-label" for="text-input">Seudónimo</label>
                                     <div class="col-md-9">
                                         <input type="text" v-model="seudonimo" class="form-control" placeholder="Seudónimo del autor">
                                     </div>
                                 </div>
                                 <div class="form-group row">
                                     <label class="col-md-3 form-control-label" for="text-input">Pais</label>
                                     <div class="col-md-9">
                                         <select class="form-control" v-model="idPais">
                                            <option v-for="pais in arrayPaises" :key="pais.idgenPais" :value="pais.idgenPais" v-text="pais.pais"></option>
                                         </select>
                                     </div>
                                 </div>

                                 <div class="form-group row div-error" v-show="errorAutor">
                                     <div class="text-center text-error">
                                         <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                     </div>
                                 </div>

                             </form>
                         </div>
                         <div class="modal-footer">
                             <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                             <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearAutor()">Guardar</button>
                             <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="editarAutor()">Editar</button>
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
             idAutor:0,
             id:'',
             autor:'',
             seudonimo:'',
             idPais:1,
             arrayAutores : [],
             arrayPaises : [],
             modal : 0,
             tituloModal : '',
             tipoAccion : 0,
             errorAutor : 0,
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
             criterio : 'autor',
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
         listarAutores(page,buscar,criterio){
             let me=this;
             var url='/autor?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
             axios.get(url).then(function (response) {
             var respuesta=response.data;
             me.arrayAutores=respuesta.autores.data;
             me.pagination=respuesta.pagination;
             })
             .catch(function (error) {
                 // handle error
                 console.log(error);
             })
         },
         listarPaises(){
             let me=this;
             var url='/pais/selectpais';
             axios.get(url).then(function (response) {
             var respuesta=response.data;
             me.arrayPaises=respuesta.paises;
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
             me.listarAutores(page,buscar,criterio);
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
             me.listarAutores(page,buscar,criterio);
         },
         crearAutor(){
             //valido con el metodo de validacion creado
             if(this.validarAutor()){
                 return;
             }

             let me=this;
             axios.post('/autor/store',{
                 'autor': this.autor,
                 'seudonimo': this.seudonimo,
                 'idPais': this.idPais
             }).then(function (response) {
             me.cerrarModal();
             me.listarAutores(1,'','autor');
             })
             .catch(function (error) {
                 console.log(error);
             });
         },
         editarAutor(){
             if(this.validarAutor()){
                 return;
             }

             let me=this;
             axios.put('/autor/update',{
                'id': this.idAutor,
                'autor': this.autor,
                'seudonimo': this.seudonimo,
                'idPais': this.idPais
             }).then(function (response) {
             me.cerrarModal();
             me.listarAutores(1,'','autor');
             })
             .catch(function (error) {
                 console.log(error);
             });
         },
         validarAutor(){
             this.errorAutor=0;
             this.errorMensaje=[];

             if (!this.autor) this.errorMensaje.push("El nombre no puede estar vacio");
             if (this.errorMensaje.length) this.errorAutor=1;

             return this.errorAutor;
         },
         cerrarModal(){
             this.modal=0;
             this.tituloModal='';
             this.autor='';
             this.seudonimo='';
             this.idPais=1;
             this.errorUsuario = 0,
             this.errorMensaje = [],
             this.forceRerender();
         },
         abrirModal(modelo, accion, data=[]){
         //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
         switch(modelo){
             case "autor":
             {
                 switch (accion) {
                     case 'crear':{
                         this.modal=1;
                         this.autor='';
                         this.tituloModal='Crear nuevo autor';
                         this.tipoAccion= 1;
                         this.idPais=1;
                         break;
                     }
                     case 'actualizar':{
                         //console.log(data);
                         this.modal=1;
                         this.tituloModal='Editar autor';
                         this.tipoAccion= 2;
                         this.idAutor=data['id'];
                         this.autor=data['autor'];
                         this.seudonimo=data['seudonimo'];
                         this.idPais=data['idPais'];
                         break;
                     }
                 }
             }
         }
         }
     },
     mounted() {
         this.listarAutores(1,this.buscar,this.criterio);
         this.listarPaises();
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
