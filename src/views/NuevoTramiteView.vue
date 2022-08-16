<template>
<loading :active="isLoading"
        :can-cancel="false"
        :is-full-page="fullPage"
        :color="color"></loading>
    <div>
        <h1>Registrar  Legajo/MAT</h1>

    </div>
    <div class="container">
        <div class="row mt-5">
            <div class ="col-md-10">
                <form action="" method="" id="formulario">
                    <div class="form-group">
                        <select class="form-control" id="exampleFormControlSelect1" name="TIPO_TRAMITE">
                            <option value="legajo">Legajo</option>
                            <option value="mat">MAT</option>
                        </select>
                        <br>
                        <input type="text"  required name="NUMERO_TRAMITE" placeholder="N° de MAT/Legajo" class="form-control" style="float:left;width:250px" id="numero_tramite">
                        <p style="float:left;font-size:larger; margin-left: 30px;margin-right: 30px;">/</p>
                        <input type="number" required minlength="4" name="ANIO_TRAMITE" placeholder="Año" class="form-control" style="float: left; width:80px" id="anio_tramite">
                        <br>
                        <br>
                        <input type="text" required name="TITULAR_TRAMITE" placeholder="Apellido y Nombre del Titular" class="form-control" id="titular_tramite">
                        <br>
                        <small id="emailHelp" class="form-text text-muted">Fecha de Inicio</small>
                        <input type="date" required name="FECHA_TRAMITE" placeholder="Fecha de Inicio" class="form-control" id="fecha_inicio">
                        <br>
                        <div class="w-50" style="float:left">
                            <input type="number" id="nMatricula" name="NUMERO_MATRICULA" placeholder="Matriculado Nro" class="form-control">
                        </div>
                        <div class="w-25" style="float:right">
                            <div class="btn btn-primary" @click="buscar" role="button">Buscar</div>

                        </div>
                        <br>
                        <br>
                        <div class="w-75">
                            {{matriculado.NOMBRE_MATRICULADO}}

                        </div>

                        <hr>
                        <div class="form-inline">
                            <input type="text" name="CALLE_DIRECCION" placeholder="Calle" class="form-control w-75 " id="calle">
                            <input type="number" required name="NUMERO_DIRECCION" placeholder="N°" class="form-control w-25 " id="numero">

                        </div>
                        <br>
                        <input type="text" required name="DEPTO_DIRECCION" placeholder="Piso - Depto" class="form-control" id="depto">
                        <br>
                        <input type="text" required name="ZONA_DIRECCION" placeholder="Zona" class="form-control w-50" id="zona">
                        <br>
                        <!-- subir fotos   -->
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Subir Foto</label>
                            <input type="file" class="form-control-file" id="fotos" name="FOTOS[]" multiple>
                        </div>

                        <button type="button" class="btn btn-success" @click="enviar">Enviar</button>
                        <button type="button" class="btn btn-secondary" @click="volver" style="float:right">Volver</button>


                    </div>

                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Loading from 'vue-loading-overlay';
    // Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';

const url = import.meta.env.VITE_URL;

    export default {
        mounted() {


        },
        components: {
            Loading
        },
        data(){
            return{
                matriculado:'',
                isLoading: false,
                fullPage: true,
                color: '#333B9C',
                url:''
            }
        }
        ,
        methods:{
            validar(){
                //validar que todos los campos esten completos
                var formulario = document.getElementById("formulario");
                var anio = document.getElementById("anio_tramite").value;
                if(formulario.checkValidity() & anio.length == 4){
                    return true;
                    }
                else{
                    return false;
                }
            },
            enviar(){
                //si estan todos los campos llenos
                if(this.validar()){

                this.isLoading = true;

                var datos = new FormData(document.getElementById('formulario'));
                axios.post(url+'tramite/',datos)
                .catch(error => {
                    this.isLoading = false;
                        this.$swal({
                        title: '¡Error!',
                        text: 'No se pudo registrar',
                        icon: 'error',
                        confirmButtonText: 'cerrar'
                        });
                })
                .then(response => {
                    console.log(response);
                    if(response.status == 200){
                        
                        this.isLoading = false;
                        this.$swal({
                        title: '¡Exito!',
                        text: 'Se registro correctamente',
                        type: 'success',
                        confirmButtonText: 'cerrar'
                        });
                    }
                });
            
                }else{
                    this.$swal({
                        title: '¡Error!',
                        text: 'Complete todos los campos',
                        icon: 'error',
                        confirmButtonText: 'cerrar'
                        });
                }
              
              
                    //si se creo el tramite
                //     if(response.data.status == 200){
                //         this.isLoading = false;
                //         //vaciar el campo archivo
                //         document.getElementById('fotos').value = '';
                //          this.$swal({
                //         title: '¡Ok!',
                //         text: 'Se registro correctamente',
                //         type: 'success',
                //         confirmButtonText: 'cerrar'
                //         });
                //     }
                //     else{
                //         this.isLoading = false;
                //         this.$swal({
                //         title: '¡Error!',
                //         text: 'No se pudo registrar',
                //         type: 'error',
                //         confirmButtonText: 'cerrar'
                //         });
                //     }
                //     console.log(response.data);
                // })
                // .catch(error=>{
                //     console.log(error);
                // })
            },
            buscar(){
                this.isLoading = true;

                var num_matricula = document.getElementById('nMatricula').value;
                alert(num_matricula);
                axios.get(url+'matriculados/'+num_matricula)
                .then(response=>{
                    this.matriculado=response.data;
                    console.log(response.data);
                    console.log(this.matriculado);
                    this.isLoading = false;
                })
                .catch(error=>{
                    console.log(error);
                })

            },

            volver(){
                this.$router.push('/');
            }



        }

    }
</script>

<style scoped>

</style>