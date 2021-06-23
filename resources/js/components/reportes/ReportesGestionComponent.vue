<template>
  <v-row>
    <v-col
      cols="12"
      sm="6"
    >
      <v-date-picker
        v-model="dates"
        range
        
      ></v-date-picker>
    </v-col>
    <v-col
      cols="12"
      sm="6"
    >
      <v-text-field
        v-model="dateRangeText"
        label="Date range"
        prepend-icon="mdi-calendar"
        readonly
      ></v-text-field>
      model: {{ dates }}
    </v-col>
    <v-col>
      <v-btn
      class="white--text align-center"
      color="indigo"
      elevation="8"
      large
      @click="descargar()"
    >Descargar</v-btn>
    <!-- fin boton -->
    </v-col>
  </v-row>
</template>

<script>
  export default {
    data: () => ({
      dates: ['2019-09-10', '2019-09-20'],
      mensaje: '',
    }),
    methods: {
      descargar(){
        console.log(this.dates)
        axios.post('reportExcel',{
          'valor': this.dates,
        }).then(response=>{
          this.mensaje = response.data;
          console.log(this.mensaje)
        })
      }
    },
    computed: {
      dateRangeText () {
        return this.dates.join(' ~ ')
      },
    },

  }
</script>
