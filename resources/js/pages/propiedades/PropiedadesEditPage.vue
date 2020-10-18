<template>
<div class="card mt-5">
    <validation-observer ref="observer" v-slot="{ handleSubmit }">
    <b-form @submit.stop.prevent="handleSubmit(actualizar_propiedad)" >
    <div class="card-header">
        <label class="font-weight-bold">Editar Propiedad</label>
        <button class="btn btn-primary float-right" type="submit">Guardar</button>
    </div>
    <div class="form-container mt-4">
        <b-row>
            <b-col cols="4">
                <b-form-group label="Título">
                    <validation-provider name="Título" :rules="{ required: true}" v-slot="validationContext">
                        <b-form-input :state="getValidationState(validationContext)" v-model="propiedad.titulo"></b-form-input>
                        <b-form-invalid-feedback id="input-2-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </validation-provider>   
                </b-form-group>
            </b-col>
            <b-col cols="8">
                <b-form-group label="Descripción">
                    <validation-provider name="Descripción" :rules="{ required: true}" v-slot="validationContext">
                        <b-form-input :state="getValidationState(validationContext)" v-model="propiedad.descripcion"></b-form-input>
                        <b-form-invalid-feedback id="input-2-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </validation-provider>  
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col cols="4">
                <b-form-group label="Precio venta">
                    <validation-provider name="Precio venta" :rules="{ required: true,numeric:true}" v-slot="validationContext">
                        <b-form-input :state="getValidationState(validationContext)" @keypress="soloNumeros($event)" v-model="propiedad.precio_venta"></b-form-input>
                        <b-form-invalid-feedback id="input-2-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </validation-provider>
                </b-form-group>
            </b-col>
            <b-col cols="4">
                <b-form-group label="Precio alquiler">
                    <validation-provider name="Precio alquiler" :rules="{ required: true,numeric:true}" v-slot="validationContext">
                        <b-form-input :state="getValidationState(validationContext)" @keypress="soloNumeros($event)" v-model="propiedad.precio_alquiler"></b-form-input>
                        <b-form-invalid-feedback id="input-2-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </validation-provider>
                </b-form-group>
            </b-col>
            <b-col cols="4">
                <b-form-group label="Tipo">
                    <validation-provider name="Tipo" :rules="{ required: true}" v-slot="validationContext">
                        <b-form-select :state="getValidationState(validationContext)" v-model="propiedad.tipo_id" :options="tipos_modificados"></b-form-select>
                        <b-form-invalid-feedback id="input-2-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </validation-provider>
                </b-form-group>
            </b-col>
        </b-row>
        <!-- <b-row>
            <b-col cols="12">
                <b-form-group label="Imagen">
                    <validation-provider name="Imagen" :rules="{ required: true}" v-slot="validationContext">
                        <b-form-file :state="getValidationState(validationContext)" id="file-small" size="sm" browse-text="Buscar" placeholder="Ningún archivo seleccionado" v-model="propiedad.url_imagen"></b-form-file>
                        <b-form-invalid-feedback id="input-2-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </validation-provider>
                </b-form-group>
            </b-col>    
        </b-row> -->
    </div>
    </b-form>
    </validation-observer>
</div>
</template>

<script>
export default {
    props: {
        propiedad: {
            type: Object,
            required: true
        },
        tipos:{
            type: Array,
            required: true
        },
    },
    data: () => ({
        //propiedad:{titulo:null,descripcion:null,precio_alquiler:null,precio_venta:null,tipo:null,url_imagen:null}
    }),
    computed:{
        tipos_modificados:function(){
            this.tipos.unshift({value:null,text:'Seleccione una opción'});
            return this.tipos;
        }
    },
    methods:{
        actualizar_propiedad(){
            var data =new FormData();
            data.append('titulo', this.propiedad.titulo);
            data.append('descripcion', this.propiedad.descripcion);
            data.append('precio_alquiler', this.propiedad.precio_alquiler);
            data.append('precio_venta', this.propiedad.precio_venta);
            data.append('tipo_id', this.propiedad.tipo_id);
            data.append('url_imagen', this.propiedad.url_imagen);
            data.append('_method','POST');
            console.log(data);
            axios.post(`/propiedades/actualizar/${this.propiedad.id}`,data)
            .then(res => {    
                window.location.href="/propiedades";    
                this.reset_form(); 
            })
            .catch(error => {
                console.log(error);
            });
        },
        reset_form(){
            this.propiedad={titulo:null,descripcion:null,precio_alquiler:null,precio_venta:null,tipo:null,url_imagen:null}
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
        console.log(this.propiedad);
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