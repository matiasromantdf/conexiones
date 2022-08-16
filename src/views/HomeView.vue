<script setup>

</script>

<template>
  <main>
    
    <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1>Menú Principal</h1>
            
          </div>
        </div>

        <div class="row">
          <div class="col-md-10">
           <router-link to="/consultas">
            <div class="boton">
                Consultas            
            </div>
             </router-link>
          </div>
        </div>

        <div class="row">
          <div class="col-md-10">
           <router-link to="/inspecciones">
            <div class="boton">
                Inspecciones            
            </div>
             </router-link>
          </div>
        </div>

        <div class="row">
          <div class="col-md-10">
           <router-link to="/consultas">
            <div class="boton">
                Conexiones            
            </div>
             </router-link>
          </div>
        </div>

         <div class="row">
          <div class="col-md-10">
           <router-link to="/nuevo-tramite">
            <div class="boton">
                Cargar Nuevo            
            </div>
             </router-link>
          </div>
        </div>

    </div>
  </main>
</template>
<style scoped>
.boton{
  margin-top: 20px;
  background-color: #00bcd4;
  color: white;
  height: 50px;
  text-align: center;
  vertical-align:middle;
  line-height: 50px;
  border-radius: 5px;
  font-size: 20px;
}
</style>