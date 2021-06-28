<template>
  <v-row>
    <v-form @submit.prevent="exportarExcel">

    <v-col
      cols="12"
      sm="6"
    >
      <v-date-picker
        v-model="fechaInicial"
        locale="ES" 
        range
        
      ></v-date-picker>
       <v-date-picker
        v-model="fechaFinal"
        locale="ES" 
        range
        
      ></v-date-picker>
    </v-col>
    <v-col
      cols="12"
      sm="6"
    >

      <v-text-field
        label="Reporte Gestión"
        prepend-icon="mdi-calendar"
        readonly
      ></v-text-field>
      <v-btn type="submit" class="my-2" color="#1A237E" dark style="color: #fff" :loading="exporRep">
         <v-icon color="#fff" dark>mdi-cloud-download</v-icon>Descargar
      </v-btn>
    </v-col>

    </v-form>

  </v-row>
</template>



<script>
  export default {
    data: () => ({
      fechaInicial: ['2021-01-01'],
      fechaFinal: ['2021-01-01'],

      exporRep: false,

    }),
    methods: {
      descargargestion(){
        console.log(this.fechaInicial, this.fechaFinal)
        axios.post('reportExcel',{
          'valor': this.fechaInicial.fechaFinal,
        }).then(response=>{
          
          console.log('Tenemos una respuesta desde el controlador')
        })
      },

    },

  }
</script>
