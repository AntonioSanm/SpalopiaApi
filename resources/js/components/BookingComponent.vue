<template>
    <div>
        <h1>Reservas</h1>
        Nombre: <input v-model="nombre" > <br><br>
        Comentarios: <textarea v-model="comentarios" ></textarea> <br><br>
        Fecha: <datepicker v-model="fecha" :format="customFormatter"></datepicker> <br><br> 
        Hora: <vue-timepicker v-model="hora" :format="FormatoHora" :minute-interval="30" ></vue-timepicker><br><br> 
        Servicio:   <select v-model="servicio">
                        <option v-for="(item, i) of servicios" :key="i" v-bind:value="item">
                            {{item.nombre}} - {{item.precio}} €
                        </option>
                    </select>
            <br><br>
        <button v-on:click="reservar" >Reservar</button>
        <p style="color:red">{{error}} </p>
        <p style="color:green">{{success}} </p>


    </div>
</template>

<script>
import Datepicker from 'vuejs-datepicker';
import VueTimepicker from 'vue2-timepicker'
var moment = require('moment');

export default {
    components: {
        Datepicker,
        VueTimepicker
    },
    data () {
        return {
        FormatoHora: 'hh:mm',
        hora: {
            hh: '09',
            mm: '00'
        },
        info: null,
        nombre: '',
        comentarios: '',
        fecha: '',
        servicios: '',
        servicio: '' ,
        error: '',
        success: ''
        }
    },
    methods:{
        customFormatter(date) {
            return moment(date).format('DD MM YYYY');
        },
        reservar: function(event){
            var fecha = moment(this.fecha).format('DD MM YYYY 00:00:00');
            fecha = moment(fecha).add(this.hora.hh,'hours').add(this.hora.mm,'minutes').format('YYYY-MM-DD HH:mm:ss');
            
            axios.post('http://localhost:8000/api/reservas', {
                servicio_id: this.servicio.id,
                nombreCliente: this.nombre,
                comentarios: this.comentarios,
                precio: this.servicio.precio,
                dia: fecha,
                hora: moment(fecha).format('HH:mm')

            }).then((response) => {
                this.response = response;

                if(this.response.data.error){
                    this.error = this.response.data.error;
                }

                if(this.response.data.validation){
                    this.error = this.response.data.validation;
                }

                if(this.response.data.success){
                    this.error = '';
                    this.success = this.response.data.success;
                }
            })
        },
    },
    mounted () {
            axios
      .get('http://localhost:8000/api/servicios')
      .then(response => (this.servicios = response.data))
    }
}
</script>
