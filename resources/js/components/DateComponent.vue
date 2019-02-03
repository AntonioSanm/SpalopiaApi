<template>
    <div>
        <h1>Filtro por fecha</h1>
        <datepicker v-model="inicio" :format="customFormatter" :disabledDates="state.disabledDates" @selected="selectedInicio" >
        </datepicker>
        <datepicker v-model="fin" :format="customFormatter" :disabledDates="state.disabledDates" @selected="selectedFin" >
        </datepicker>
        <button v-on:click="buscar" >Buscar</button>
        <p style="color:red">{{error}} </p>
        <ul>
            <li v-for="(item, i) of response" :key="i">
                <b>{{item.nombre}}</b> {{item.inicio}} <b>Horario: </b> {{item.horaInicio}} - {{item.horaFin}} <p v-if="item.hora" style="color:red"> ocupado: {{item.hora}} </p>
            </li>
        </ul>

    </div>
</template>

<script>
import Datepicker from 'vuejs-datepicker';
var moment = require('moment');

export default {
    components: {
        Datepicker
    },
    data () {
        return {
        inicio: '',
        fin: '',
        error: '',
        state: {
            disabledDates:{
                to : '',
                from: ''
            }
        },
        response : ''
        }
  },
    methods: {
        customFormatter(date) {
            return moment(date).format('DD MM YYYY');
        },
        buscar: function (event) {

            if (!this.inicio || !this.fin) {
                this.error = 'Debe seleccionar una fecha';
                return;
            }

            axios.post('http://localhost:8000/api/horarios', {
                start_date: moment(this.inicio).format('DD MM YYYY 00:00:00'),
                end_date: moment(this.fin).format('DD MM YYYY 00:00:00')
            }).then((response) => {
                
                this.response = response.data;
                this.error = '';
                
                if(response.data == ''){
                    this.error = 'No hay servicios para esas fechas.'; 
                }
                

                if(this.response.data.error){
                    this.error = this.response.data.error;
                }

                if(this.response.data.validation){
                    this.error = this.response.data.validation;
                }


            })
            .catch((e) => {

            })
        },
        selectedInicio: function (date){
            this.state.disabledDates.to = date;
        },
        selectedFin: function (date){
            this.state.disabledDates.from = date
        }
        
  }
}
</script>
