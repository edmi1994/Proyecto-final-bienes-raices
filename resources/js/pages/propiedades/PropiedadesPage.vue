<template>
<div class="card mt-5">
    <div class="card-header">
        <label class="font-weight-bold">Propiedades</label>
        <button class="btn btn-primary float-right" onclick="location.href='/propiedades/crear'">Nuevo</button>
    </div>
    <div class="table-container  table-responsive">
        <table class="table mt-3 table-bordered table-hover">
            <thead>
                <tr>
                    <th v-for="(header, index) in headers" :key="index">{{header}}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(propiedad, index) in propiedades" :key="index">
                    <td>{{propiedad.titulo}}</td>
                    <td>{{propiedad.descripcion}}</td>
                    <td>{{propiedad.tipo}}</td>
                    <td>{{propiedad.estado}}</td>
                    <td>{{propiedad.precio_alquiler}}</td>
                    <td>{{propiedad.precio_venta}}</td>
                    <td class="acciones">
                        <button class="btn btn-icon btn-danger" title="Eliminar" v-on:click="eliminar_propiedad(propiedad.id,index)">Eliminar</button>
                        <button class="btn btn-icon btn-success" title="Editar"  v-on:click="editar_propiedad(propiedad.id)">Editar</button>
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
        headers:['Título','Descripción','Tipo','Estado','Precio Alquiler','Precio venta','Acciones'],
        propiedades:[]
    }),
    methods:{
        editar_propiedad(id){
            window.location.href='/propiedades/editar/'+id
        },
        listar_propiedades(){
            axios.get('/propiedades/registros')
            .then(res => {
                this.propiedades=res.data;
            })
            .catch(err => {
                console.error(err.response); 
            })
        },
        ver_propiedad(id){
            window.location.href='/propiedades/ver/'+id
        },
        eliminar_propiedad(propiedad_id,index){
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
                axios.post('/propiedades/destroy',{'propiedad_id':propiedad_id })
                .then(res => {
                    this.propiedades.splice(index, 1);
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
        this.listar_propiedades();
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