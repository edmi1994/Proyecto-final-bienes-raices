<template>
<div class="card mt-5">
    <div class="card-header">
        <label class="font-weight-bold">Reservas</label>
        <button class="btn btn-primary float-right" onclick="location.href='/reservas/crear'">Nuevo</button>
    </div>
    <div class="table-container  table-responsive">
        <table class="table mt-3 table-bordered table-hover">
            <thead>
                <tr>
                    <th v-for="(header, index) in headers" :key="index">{{header}}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(reserva, index) in reservas" :key="index">
                    <td>{{reserva.id_cliente}}</td>
                    <td>{{reserva.nombre_cliente}}</td>
                    <td>{{reserva.nombre_propiedad}}</td>
                    <td>{{reserva.tipo}}</td>
                    <td>{{reserva.precio_noche}}</td>
                    <td>{{reserva.precio_total}}</td>
                    <td>{{reserva.fecha_inicio}}</td>
                    <td>{{reserva.fecha_fin}}</td>
                    <td>{{reserva.estado}}</td>
                    <td class="acciones">
                        <button v-if="reserva.estado=='EN ALQUILER'" class="btn btn-icon btn-danger" title="Anular" v-on:click="anular_reserva(reserva,index)">Anular</button>
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
        headers:['ID cliente','Nombre cliente','Propiedad','Tipo','Precio noche','Precio total','Fecha inicio','Fecha salida','Estado','Acciones'],
        reservas:[]
    }),
    methods:{
        listar_reservas(){
            axios.get('/reservas/registros')
            .then(res => {
                this.reservas=res.data;
                console.log(this.reservas);
            })
            .catch(err => {
                console.error(err.response); 
            })
        },
        anular_reserva(reserva,index){
            Swal.fire({
            title: 'Está seguro que desea anular esta reserva??',
            text: "Esta acción no se puede revertir",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Sí, anular!'
            }).then((result) => {
            if (result.value) {
                axios.post('/reservas/anular',reserva)
                .then(res => {
                    this.reservas[index].estado="ANULADA";
                    Swal.fire(
                    'Anulado!',
                    'La reserva ha sido anulada',
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
        this.listar_reservas();
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