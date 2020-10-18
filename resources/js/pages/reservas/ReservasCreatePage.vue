<template>
<div class="card mt-5">
    <validation-observer ref="observer" v-slot="{ handleSubmit }">
    <b-form @submit.stop.prevent="handleSubmit(ingresar_reserva)" >
    <div class="card-header">
        <label class="font-weight-bold">Insertar reserva</label>
        <button v-if="visualizar_reserva" class="btn btn-primary float-right" type="submit">Guardar</button>
    </div>
    <div class="form-container mt-4">
        <b-row>
           <b-col cols="4">
                <b-form-group label="Cliente">
                    <b-input-group>
                        <b-form-input readonly></b-form-input>
                        <b-input-group-append>
                        <b-button variant="outline-success" @click="show_clientes=true,traer_clientes()">Buscar</b-button>
                        </b-input-group-append>
                    </b-input-group>
                </b-form-group>
            </b-col> 
        </b-row>
        <b-row>
            <b-col cols="4">
                <b-form-group label="ID Cliente">
                    <validation-provider name="ID Cliente" :rules="{ required: true,numeric:true}" v-slot="validationContext">
                        <b-form-input disabled :state="getValidationState(validationContext)" v-model="reserva.cliente_identificacion"></b-form-input>
                        <b-form-invalid-feedback id="input-2-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </validation-provider>
                </b-form-group>
            </b-col>
            <b-col cols="8">
                <b-form-group label="Nombre Cliente">
                        <b-form-input disabled v-model="reserva.cliente_nombre"></b-form-input>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
           <b-col cols="4">
                <b-form-group label="Propiedad">
                    <b-input-group>
                        <b-form-input readonly></b-form-input>
                        <b-input-group-append>
                        <b-button variant="outline-success" @click="show_propiedades=true,traer_propiedades()">Buscar</b-button>
                        </b-input-group-append>
                    </b-input-group>
                </b-form-group>
            </b-col> 
        </b-row>
        <b-row>
            <b-col cols="4">
                <b-form-group label="Nombre Propiedad">
                    <validation-provider name="Nombre propiedad" :rules="{ required: true}" v-slot="validationContext">
                        <b-form-input disabled :state="getValidationState(validationContext)" v-model="reserva.propiedad_nombre"></b-form-input>
                        <b-form-invalid-feedback id="input-2-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </validation-provider>
                </b-form-group>
            </b-col>
            <b-col cols="4">
                <b-form-group label="Tipo">
                    <validation-provider name="Tipo" :rules="{ required: true}" v-slot="validationContext">
                        <b-form-input disabled :state="getValidationState(validationContext)" v-model="reserva.propiedad_tipo"></b-form-input>
                        <b-form-invalid-feedback id="input-2-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </validation-provider>
                </b-form-group>
            </b-col>
            <b-col cols="4">
                <b-form-group label="Precio">
                    <validation-provider name="Precio" :rules="{ required: true}" v-slot="validationContext">
                        <b-form-input disabled :state="getValidationState(validationContext)" v-model="reserva.precio_noche"></b-form-input>
                        <b-form-invalid-feedback id="input-2-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </validation-provider>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col cols="2"></b-col>
            <b-col cols="4">
                <b-form-group label="Fecha entrada">
                    <b-calendar v-model="reserva.fecha_entrada" @input="fecha_fin()" :min="min_date_entrada" locale="es" block></b-calendar>
                </b-form-group>
                
            </b-col>
            <b-col cols="4">
                <b-form-group label="Fecha salida">
                    <b-calendar v-model="reserva.fecha_salida" :min="min_date_salida" locale="es" block></b-calendar>
                </b-form-group>  
            </b-col>
             <b-col cols="2"></b-col>
        </b-row>
        <b-row>
            <b-button variant="success" @click="generar_reserva()">Visualizar reserva</b-button>
        </b-row>
        <b-row>
            <table class="table mt-3 table-bordered table-hover">
            <thead>
                <tr>
                    <th v-for="(header, index) in headers" :key="index">{{header}}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(reserva,index) in reservas" :key="index">
                    <td>{{reserva.cliente_identificacion}}</td>
                    <td>{{reserva.cliente_nombre}}</td>
                    <td>{{reserva.propiedad_nombre}}</td>
                    <td>{{reserva.propiedad_tipo}}</td>
                    <td>{{reserva.fecha_entrada}}</td>
                    <td>{{reserva.fecha_salida}}</td>
                    <td>{{reserva.precio_noche}}</td>
                    <td>{{reserva.precio_total}}</td>
                </tr>
            </tbody>
        </table>
        </b-row>
    </div>
    </b-form>
    </validation-observer>
    <!-- MODAL CLIENTES -->
        <b-modal size="lg" ref="modal" v-model="show_clientes" no-close-on-esc no-close-on-backdrop>
         <template v-slot:modal-header="{ close }">
            <h5>Buscar cliente</h5>
            <a @click="show_clientes=false" style="cursor: pointer">X</a>
        </template>
        <b-row>
        <b-col lg="6" class="my-1">
            <b-form-group label="Buscar" label-cols-sm="3" label-align-sm="right" label-size="sm" label-for="filterInput" class="mb-0">
            <b-input-group size="sm">
                <b-form-input v-model="filter" type="search" placeholder="Ingrese lo que desea buscar" ></b-form-input>
                <b-input-group-append>
                <b-button :disabled="!filter" @click="filter = ''">Limpiar</b-button>
                </b-input-group-append>
            </b-input-group>
            </b-form-group>
        </b-col>
        </b-row>
        <b-row style="width:98%; margin-right:auto; margin-left:auto" class="mt-4">
           <b-table show-empty small stacked="md" :items="clientes" :fields="fields_clientes" :filter="filter">
                <template v-slot:cell(accion)="row">
                    <b-button variant="primary" size="sm" @click="asignar_cliente(row.item, row.index, $event.target)" class="mr-1">
                    Escoger
                    </b-button>
                </template>
            </b-table>
        </b-row>
    <template v-slot:modal-footer>
        <div class="w-100">
        </div>
      </template>
    </b-modal>

    <!-- MODAL PROPIEDADES -->
     <b-modal size="lg" ref="modal" v-model="show_propiedades" no-close-on-esc no-close-on-backdrop>
         <template v-slot:modal-header="{ close }">
            <h5>Buscar propiedades</h5>
            <a @click="show_propiedades=false" style="cursor: pointer">X</a>
        </template>
        <b-row>
        <b-col lg="6" class="my-1">
            <b-form-group label="Buscar" label-cols-sm="3" label-align-sm="right" label-size="sm" label-for="filterInput" class="mb-0">
            <b-input-group size="sm">
                <b-form-input v-model="filter_propiedad" type="search" placeholder="Ingrese lo que desea buscar" ></b-form-input>
                <b-input-group-append>
                <b-button :disabled="!filter_propiedad" @click="filter_propiedad = ''">Limpiar</b-button>
                </b-input-group-append>
            </b-input-group>
            </b-form-group>
        </b-col>
        </b-row>
        <b-row style="width:98%; margin-right:auto; margin-left:auto" class="mt-4">
           <b-table show-empty small stacked="md" :items="propiedades" :fields="fields_propiedades" :filter="filter_propiedad">
                <template v-slot:cell(accion)="row">
                    <b-button variant="primary" size="sm" @click="asignar_propiedad(row.item, row.index, $event.target)" class="mr-1">
                    Escoger
                    </b-button>
                </template>
            </b-table>
        </b-row>
    <template v-slot:modal-footer>
        <div class="w-100">
        </div>
      </template>
    </b-modal>
</div>
</template>

<script>
import moment from 'moment'
export default {
    props: {
       
    },
    data: () => ({
        headers:['ID cliente','Nombre cliente','Propiedad','Tipo','Fecha inicio','Fecha salida','Precio noche','Precio total',],
        reserva:{cliente_identificacion:null,cliente_nombre:null,propiedad_nombre:null,propiedad_tipo:null,precio_noche:null,precio_total:null,id_propiedad:null,fecha_entrada:null,fecha_salida:null},
        clientes:[],
        propiedades:[],
        show_clientes:false,
        show_propiedades:false,
        filter: null,
        filter_propiedad:null,
        fields_clientes:[
            { key: 'accion', label: 'Escoger', sortable: true, sortDirection: 'desc' },
            { key: 'identificacion', label: 'Identificiación', sortable: true, sortDirection: 'desc' },
            { key: 'nombre', label: 'Nombre', sortable: true, sortDirection: 'desc' }
        ],
        fields_propiedades:[
            { key: 'accion', label: 'Escoger', sortable: true, sortDirection: 'desc' },
            { key: 'nombre', label: 'Nombre', sortable: true, sortDirection: 'desc' },
            { key: 'tipo', label: 'Tipo', sortable: true, sortDirection: 'desc' },
            { key: 'precio_alquiler', label: 'Precio', sortable: true, sortDirection: 'desc' }
        ],
        min_date_salida:null,
        visualizar_reserva:false,
        reservas:[]
    }),
    computed:{
        min_date_entrada:function(){
            var fecha_actual = new Date();
            var fecha_minima_entrada=new Date(fecha_actual.setDate(fecha_actual.getDate()+1));
            return fecha_minima_entrada;
        }
    },
    methods:{
        generar_reserva(){
            this.reservas=[];
            
            var fecha_entrada=moment(this.reserva.fecha_entrada);
            var fecha_salida=moment(this.reserva.fecha_salida);
            var dias = null;
            dias=fecha_salida.diff(fecha_entrada,'days');
            this.reserva.precio_total=dias*this.reserva.precio_noche;
            this.reservas.push(this.reserva);
            
            
            console.log(dias);
            this.visualizar_reserva=true;
            
        },
        fecha_fin(){
            var fecha =moment(this.reserva.fecha_entrada).add(1,'d');
            this.min_date_salida = moment(fecha).format();
        },
        asignar_cliente(cliente,$event){
             console.log(cliente);
            this.reserva.cliente_identificacion=cliente.identificacion;
            console.log(this.reserva.cliente_identificacion);
            console.log(cliente.identificacion);
            this.reserva.cliente_nombre=cliente.nombre;
            this.show_clientes=false;
        },
        asignar_propiedad(propiedad){
            console.log(propiedad);
            this.reserva.propiedad_nombre=propiedad.nombre;
            this.reserva.propiedad_tipo=propiedad.tipo;
            this.reserva.precio_noche=propiedad.precio_alquiler;
            this.reserva.id_propiedad=propiedad.id;
            this.show_propiedades=false;
        },
        traer_propiedades(){
            axios.get("/propiedades/traer")
            .then(res => {    
                this.propiedades=res.data;
                console.log(this.propiedades);
            })
            .catch(error => {
                console.log(error);
            }); 
        },
        traer_clientes(){
          axios.get("/clientes/traer")
            .then(res => {    
                this.clientes=res.data;
            })
            .catch(error => {
                console.log(error);
            });  
        },
        ingresar_reserva(){
            axios.post("/reservas/store",this.reserva)
            .then(res => {    
                window.location.href="/reservas";    
                this.reset_form(); 
            })
            .catch(error => {
                console.log(error);
            });
        },
        reset_form(){
            this.reserva={cliente_identificacion:null,cliente_nombre:null,propiedad_nombre:null,propiedad_tipo:null,precio_noche:null,precio_total:null,id_propiedad:null,fecha_entrada:null,fecha_salida:null};
        },
        getValidationState({ dirty, validated, valid = null }) {
            return dirty || validated ? valid : null;
        },
        soloNumeros(e){
        var key = window.event ? e.which : e.keyCode;
        if (key < 48 || key > 57) {
            e.preventDefault();
        }
    },
    },
    mounted() {
        
    }
};
</script>

<style scoped>
.form-container {
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