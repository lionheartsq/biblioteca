    @extends('principal')
    @section('contenido')

    <template v-if="menu==0">
        <admin></admin>
    </template>

    <template v-if="menu==1">
        <categorias></categorias>
    </template>

    <template v-if="menu==2">
        <editoriales></editoriales>
    </template>

    <template v-if="menu==3">
        <usuarios></usuarios>
    </template>

    <template v-if="menu==4">
        <autores></autores>
    </template>

    <template v-if="menu==5">
        <libros></libros>
    </template>

    @endsection
