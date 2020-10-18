<template>
<div class="card mt-5">
    <validation-observer ref="observer" v-slot="{ handleSubmit }">
    <b-form @submit.stop.prevent="handleSubmit(ingresar_venta)" >
    <div class="card-header">
        <label class="font-weight-bold">Insertar venta</label>
        <button class="btn btn-primary float-right" type="submit">Guardar</button>
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
                        <b-form-input disabled :state="getValidationState(validationContext)" v-model="venta.cliente_identificacion"></b-form-input>
                        <b-form-invalid-feedback id="input-2-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </validation-provider>
                </b-form-group>
            </b-col>
            <b-col cols="8">
                <b-form-group label="Nombre Cliente">
                        <b-form-input disabled v-model="venta.cliente_nombre"></b-form-input>
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
                        <b-form-input disabled :state="getValidationState(validationContext)" v-model="venta.propiedad_nombre"></b-form-input>
                        <b-form-invalid-feedback id="input-2-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </validation-provider>
                </b-form-group>
            </b-col>
            <b-col cols="4">
                <b-form-group label="Tipo">
                    <validation-provider name="Tipo" :rules="{ required: true}" v-slot="validationContext">
                        <b-form-input disabled :state="getValidationState(validationContext)" v-model="venta.propiedad_tipo"></b-form-input>
                        <b-form-invalid-feedback id="input-2-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </validation-provider>
                </b-form-group>
            </b-col>
            <b-col cols="4">
                <b-form-group label="Precio">
                    <validation-provider name="Precio" :rules="{ required: true}" v-slot="validationContext">
                        <b-form-input disabled :state="getValidationState(validationContext)" v-model="venta.propiedad_precio"></b-form-input>
                        <b-form-invalid-feedback id="input-2-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </validation-provider>
                </b-form-group>
            </b-col>
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
export default {
    props: {
       
    },
    data: () => ({
        venta:{cliente_identificacion:null,cliente_nombre:null,propiedad_nombre:null,propiedad_tipo:null,propiedad_precio:null,id_propiedad:null},
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
            { key: 'precio', label: 'Precio', sortable: true, sortDirection: 'desc' }
        ]
    }),
    computed:{
    
    },
    methods:{
        asignar_cliente(cliente,$event){
            this.venta.cliente_identificacion=cliente.identificacion;
            this.venta.cliente_nombre=cliente.nombre;
            this.show_clientes=false;
        },
        asignar_propiedad(propiedad){
            this.venta.propiedad_nombre=propiedad.nombre;
            this.venta.propiedad_tipo=propiedad.tipo;
            this.venta.propiedad_precio=propiedad.precio;
            this.venta.id_propiedad=propiedad.id;
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
        ingresar_venta(){
            axios.post("/ventas/store",this.venta)
            .then(res => {    
                window.location.href="/ventas";    
                this.reset_form(); 
            })
            .catch(error => {
                console.log(error);
            });
        },
        reset_form(){
            this.venta={cliente_identificacion:null,cliente_nombre:null,propiedad_nombre:null,propiedad_tipo:null,propiedad_precio:null};
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