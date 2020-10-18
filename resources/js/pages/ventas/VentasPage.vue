<template>
<div class="card mt-5">
    <div class="card-header">
        <label class="font-weight-bold">Ventas</label>
        <button class="btn btn-primary float-right" onclick="location.href='/ventas/crear'">Nuevo</button>
    </div>
    <div class="table-container  table-responsive">
        <table class="table mt-3 table-bordered table-hover">
            <thead>
                <tr>
                    <th v-for="(header, index) in headers" :key="index">{{header}}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(venta, index) in ventas" :key="index">
                    <td>{{venta.id_cliente}}</td>
                    <td>{{venta.nombre_cliente}}</td>
                    <td>{{venta.nombre_propiedad}}</td>
                    <td>{{venta.tipo}}</td>
                    <td>{{venta.precio}}</td>
                    <td>{{venta.estado}}</td>
                    <td class="acciones">
                        <button v-if="venta.estado=='VENDIDA'" class="btn btn-icon btn-danger" title="Anular" v-on:click="anular_venta(venta,index)">Anular</button>
                        <button v-else disabled class="btn btn-icon btn-danger" title="Anular">Anular</button>  
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
        headers:['ID cliente','Nombre cliente','Propiedad','Tipo','Precio','Estado','Acciones'],
        ventas:[]
    }),
    methods:{
        listar_ventas(){
            axios.get('/ventas/registros')
            .then(res => {
                this.ventas=res.data;
            })
            .catch(err => {
                console.error(err.response); 
            })
        },
        anular_venta(venta,index){
            Swal.fire({
            title: 'Está seguro que desea anular esta venta??',
            text: "Esta acción no se puede revertir",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Sí, anular!'
            }).then((result) => {
            if (result.value) {
                axios.post('/ventas/anular',venta)
                .then(res => {
                    this.ventas[index].estado="ANULADA";
                    Swal.fire(
                    'Anulado!',
                    'La venta ha sido anulada',
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
        this.listar_ventas();
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