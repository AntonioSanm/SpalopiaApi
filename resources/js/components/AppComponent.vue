<template>
    <div>
        <h1>ListadoServicios</h1>
        
   <ul>
       <li v-for="(item, i) of info" :key="i">
           {{item.nombre}} - {{item.descripcion}} : {{item.precio}} €
       </li>
   </ul>
    </div>
</template>

<script>
export default {
  data () {
    return {
      info: null
    }
  },
  mounted () {
      
    axios
      .get('http://localhost:8000/api/servicios')
      .then(response => (this.info = response.data))
  }
}
</script>
