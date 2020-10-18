<template>
<div class="card mt-5">
    <div class="card-header">
        <label class="font-weight-bold">Propiedades</label>
    </div>
    <div class="table-container  table-responsive" style="overflow-x:hidden">
        <b-row class="mt-3">
            <b-col cols="3">
                <b-form-group label="Tipo">
                        <b-form-select @change="busqueda()" v-model="filtros.tipo" :options="tipos_modificados"></b-form-select>
                </b-form-group>
            </b-col>
        </b-row>
         <b-card-group style="overflow-x:hidden">
             <b-col cols="4" v-for="(propiedad, index) in propiedades" :key="index">
                <b-card class="mt-4 cards" img-top>
                  <b-card-img style="max-width: -webkit-fill-available;background-color:transparent;width:250px;height:250px" :src="propiedad.url_imagen" alt="Image" bottom></b-card-img>
                   <b-card-title style="margin-top:10px;font-family:fuente-navbar; color:#0095ED">{{propiedad.titulo}}</b-card-title>
                  <b-card-text >
                        <b-list-group>
                            <b-list-group-item>{{propiedad.descripcion.substr(0,30)}}...</b-list-group-item>
                            <b-list-group-item>{{propiedad.tipo}}</b-list-group-item>
                            <b-list-group-item>Precio alquiler: {{propiedad.precio_alquiler}}</b-list-group-item>
                            <b-list-group-item>Precio venta: {{propiedad.precio_venta}}</b-list-group-item>
                            <b-list-group-item><b-badge>{{propiedad.estado}}</b-badge></b-list-group-item>
                        </b-list-group>
                  </b-card-text>
                </b-card>
              </b-col>
        </b-card-group>
    </div>
</div>
</template>

<script>

export default {
    props: {
        tipos:{
            type:Array,
            required: true
        }
    },
    data: () => ({
        propiedades:[],
        filtros:{tipo:null}
    }),
    methods:{
        busqueda(){
            axios.post('/filtros/propiedades',this.filtros)
            .then(res => {
                this.propiedades=res.data;
                console.log(this.propiedades);
            })
            .catch(err => {
                console.error(err.response); 
            })
        },
        listar_propiedades(){
            axios.get('/propiedades/registros')
            .then(res => {
                this.propiedades=res.data;
                console.log(this.propiedades);
            })
            .catch(err => {
                console.error(err.response); 
            })
        }
    },
    computed:{
        tipos_modificados:function(){
            this.tipos.unshift({value:null,text:'Seleccione una opción'});
            return this.tipos;
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