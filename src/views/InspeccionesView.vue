<template>
  <h1>Inspecciones</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th hidden>Cod</th>
                            <th>N°</th>
                            <th>fecha</th>
                            <th>Titular</th>
                            <th>Matric.</th>
                            <th>Dirección</th>
                            <!-- <th>Num</th>
                            <th>Depto</th> -->
                            <th>R.</th>
                            <!-- <th>Foto</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="inspeccion in inspecciones" :key="inspeccion.id">
                            <td hidden>{{inspeccion.ID_TRAMITE}}</td>
                            <td>{{inspeccion.NUMERO_TRAMITE}}</td>
                            <td>{{inspeccion.FECHA_TRAMITE}}</td>
                            <td>{{inspeccion.TITULAR_TRAMITE}}</td>
                            <td>{{inspeccion.NOMBRE_MATRICULADO}}</td>
                            <td>{{inspeccion.CALLE_DIRECCION}} {{inspeccion.NUMERO_DIRECCION}} - {{inspeccion.DEPTO_DIRECCION}}</td>
                            <!-- <td>{{inspeccion.NUMERO_DIRECCION}}</td>
                            <td>{{inspeccion.DEPTO_DIRECCION}}</td> comento el codigo para agrupar la direccion--> 
                            <td>{{inspeccion.rechazos}}</td>

                            <!-- <td ><img :src=devolverRuta(inspeccion.FOTO) style="width:50px" v-if="inspeccion.FOTO != NULL" @click="verFoto(inspeccion.FOTO)"></td> -->
                            <td>
                                <button class="btn btn-primary" @click="inspeccionar(inspeccion.ID_TRAMITE)">Insp</button>
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
const url = import.meta.env.VITE_URL;

export default {
    data() {
        return {
            inspecciones: [],
            
        }
    },
    created() {
        this.getInspecciones();
    },
    methods: {
                
        getInspecciones() {
            axios.get(url+'inspecciones')
                .then(response => {
                    
                    this.inspecciones = response.data;
                    console.log(this.inspecciones);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        inspeccionar(id) {
            this.$router.push({name: 'inspeccion', params: {id: id}});
        }
    }

}
</script>

<style scoped>

</style>