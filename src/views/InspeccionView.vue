<template>
<h1>
    Inspeccion : {{$route.params.id}}
</h1>
  
</template>

<script>
import axios from 'axios'
const url = import.meta.env.VITE_URL;

export default {
    data(){

    },
    methods:{
        getTramite(){
            axios.get(url+'tramites/'+this.$route.params.id)
            .then(response => {
                console.log(response.data);
                this.tramite = response.data;
                console.log(this.tramite);
            })
            .catch(error => {
                console.log(error);
            });
        }
    },
    mounted(){
        this.getTramite();
    }
    

}
</script>

<style>

</style>