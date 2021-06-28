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
        @change="getItems"
        
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
      model: {{ dates }}

      <export-excel
    class   = "btn btn-default"
    :data   = "json_data"
    :fields = "json_fields"
    worksheet = "My Worksheet"
    name    = "master.xls">
 
    Download Excel (you can customize this with html code!)
 
</export-excel>
    </v-col>
    
  </v-row>
</template>



<script>
  export default {
    data: () => ({
      dates: [],
      mensaje: '',
      json_fields: {
            'Nombre': 'full_name',
            'documento': 'documento',
            'Tipificación': 'tip',
            'Telefono 1' : 'telefono'
            },
        
        json_data: [ ],
        json_meta: [
            [
                {
                    'key': 'charset',
                    'value': 'utf-8'
                }
            ]
        ],
    
    }),
    
    methods: {
     getItems() {
        console.log(this.dates)
        axios.post('reportExcel',{
          'valor': this.fechaInicial.fechaFinal,
        }).then(response=>{
          this.json_data = response.data;
          console.log(this.json_data)
        })
      },

    },

  }
</script>
