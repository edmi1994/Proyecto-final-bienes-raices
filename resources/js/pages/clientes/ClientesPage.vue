<template>
<div class="card mt-5">
    <div class="card-header">
        <label class="font-weight-bold">Clientes</label>
        <button class="btn btn-primary float-right" onclick="location.href='/clientes/crear'">Nuevo</button>
    </div>
    <div class="table-container  table-responsive">
        <table class="table mt-3 table-bordered table-hover">
            <thead>
                <tr>
                    <th v-for="(header, index) in headers" :key="index">{{header}}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(cliente, index) in clientes" :key="index">
                    <td>{{cliente.identificacion}}</td>
                    <td>{{cliente.nombre}}</td>
                    <td>{{cliente.telefono}}</td>
                    <td>{{cliente.correo}}</td>
                    <td class="acciones">
                        <button class="btn btn-icon btn-danger" title="Eliminar" v-on:click="eliminar_cliente(cliente.id,index)">Eliminar</button>
                        <button class="btn btn-icon btn-success" title="Editar"  v-on:click="editar_cliente(cliente.id)">Editar</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</template>

<script>
import Swal from 'sweetalert2/dist/sweetalert2.js'
import 'sweetalert2/src/sweetalert2.scss'
export default {
    props: {
    },
    data: () => ({
        headers:['Identificación','Nombre','Teléfono','Correo','Acciones'],
        clientes:[]
    }),
    methods:{
        editar_cliente(id){
            window.location.href='/clientes/editar/'+id
        },
        listar_clientes(){
            axios.get('/clientes/registros')
            .then(res => {
                this.clientes=res.data;
            })
            .catch(err => {
                console.error(err.response); 
            })
        },
        ver_cliente(id){
            window.location.href='/clientes/ver/'+id
        },
        eliminar_cliente(cliente_id,index){
            Swal.fire({
            title: 'Está seguro que desea eliminar el registro??',
            text: "Esta acción no se puede revertir",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Sí, eliminar!'
            }).then((result) => {
            if (result.value) {
                axios.post('/clientes/destroy',{'cliente_id':cliente_id })
                .then(res => {
                    this.clientes.splice(index, 1);
                    Swal.fire(
                    'Eliminado!',
                    'El registro ha sido eliminado.',
                    'success'
                    )
                })
                .catch(err => {
                    if(err.response.status==403){
                        Swal.fire(
                        'Error!',
                        'Usted no puede realizar esta acción.',
                        'error'
                        )
                    }
                })
            }
            })
        }
    },
    mounted() {
    },
    created(){
        this.listar_clientes();
    }
};
</script>

<style scoped>
.acciones{
    text-align: center;
}
.table-container {
  width:80%;
  margin-left:auto;
  margin-right: auto;
}

.card {
  width:80%;
  margin-left:auto;
  margin-right: auto;
}

@media only screen and (max-width: 768px) {
  /* Para celulares */
  .table-container {
  width:100%;
  margin-left:auto;
  margin-right: auto;
}

.card {
  width:100%;
  margin-left:auto;
  margin-right: auto;
}
}

</style>