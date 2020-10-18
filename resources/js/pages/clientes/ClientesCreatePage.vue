<template>
<div class="card mt-5">
    <validation-observer ref="observer" v-slot="{ handleSubmit }">
    <b-form @submit.stop.prevent="handleSubmit(ingresar_cliente)" >
    <div class="card-header">
        <label class="font-weight-bold">Insertar cliente</label>
        <button class="btn btn-primary float-right" type="submit">Guardar</button>
    </div>
    <div class="form-container mt-4">
        <b-row>
            <b-col cols="4">
                <b-form-group label="Identificación">
                    <validation-provider name="Identificación" :rules="{ required: true}" v-slot="validationContext">
                        <b-form-input :state="getValidationState(validationContext)" v-model="cliente.identificacion"></b-form-input>
                        <b-form-invalid-feedback id="input-2-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </validation-provider>   
                </b-form-group>
            </b-col>
            <b-col cols="8">
                <b-form-group label="Nombre">
                    <validation-provider name="Nombre" :rules="{ required: true}" v-slot="validationContext">
                        <b-form-input :state="getValidationState(validationContext)" v-model="cliente.nombre"></b-form-input>
                        <b-form-invalid-feedback id="input-2-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </validation-provider>  
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col cols="4">
                <b-form-group label="Teléfono">
                    <validation-provider name="Teléfono" :rules="{ required: true,numeric:true}" v-slot="validationContext">
                        <b-form-input :state="getValidationState(validationContext)" @keypress="soloNumeros($event)" v-model="cliente.telefono"></b-form-input>
                        <b-form-invalid-feedback id="input-2-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </validation-provider>
                </b-form-group>
            </b-col>
            <b-col cols="6">
                <b-form-group label="Correo electrónico">
                    <validation-provider name="Precio alquiler" :rules="{ required: true}" v-slot="validationContext">
                        <b-form-input type="email" :state="getValidationState(validationContext)" v-model="cliente.correo"></b-form-input>
                        <b-form-invalid-feedback id="input-2-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </validation-provider>
                </b-form-group>
            </b-col>
        </b-row>
    </div>
    </b-form>
    </validation-observer>
</div>
</template>

<script>
export default {
    props: {
       
    },
    data: () => ({
        cliente:{identificacion:null,nombre:null,telefono:null,correo:null}
    }),
    computed:{
    
    },
    methods:{
        ingresar_cliente(){
            var data =new FormData();
            data.append('identificacion', this.cliente.identificacion);
            data.append('nombre', this.cliente.nombre);
            data.append('telefono', this.cliente.telefono);
            data.append('correo', this.cliente.correo);
            data.append('_method','POST');
            axios.post("/clientes/store",data)
            .then(res => {    
                window.location.href="/clientes";    
                this.reset_form(); 
            })
            .catch(error => {
                console.log(error);
            });
        },
        reset_form(){
            this.cliente={identificacion:null,nombre:null,telefono:null,correo:null}
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