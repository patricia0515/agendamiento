<template>
  <v-row>
    <v-col
      cols="12"
      sm="6"
    >
      <v-date-picker
        v-model="dates"
        range
        @change="getItems"
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
      Filtro: {{ dates }}

      <export-excel
    class   = "btn btn-default"
    :data   = "json_data"
    :fields = "json_fields"
    worksheet = "My Worksheet"
    name    = "master.xls">
    <h4>Descargar reporte de gestiones en formato Excel.</h4>
 
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
          'valor': this.dates,
        }).then(response=>{
          this.json_data = response.data;
          console.log(this.json_data)
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
