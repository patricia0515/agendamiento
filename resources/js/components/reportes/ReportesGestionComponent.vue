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

      <export-excel
    class   = "btn btn-default"
    :data   = "json_data"
    :fields = "json_fields"
    worksheet = "My Worksheet"
    name    = "PPPPPPP.xls">
 
    Download Excel (you can customize this with html code!)
 
</export-excel>
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
      json_fields: {
            'Complete name': 'name',
            'City': 'city',
            'Telephone': 'phone.mobile',
            'Telephone 2' : {
                field: 'phone.landline',
                callback: (value) => {
                    return `Landline Phone - ${value}`;
                }
            },
        },
        json_data: [
            {
                'name': 'Tony Peña',
                'city': 'New York',
                'country': 'United States',
                'birthdate': '1978-03-15',
                'phone': {
                    'mobile': '1-541-754-3010',
                    'landline': '(541) 754-3010'
                }
            },
            {
                'name': 'Thessaloniki',
                'city': 'Athens',
                'country': 'Greece',
                'birthdate': '1987-11-23',
                'phone': {
                    'mobile': '+1 855 275 5071',
                    'landline': '(2741) 2621-244'
                }
            }
        ],
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
      descargar(){
        console.log(this.dates)
        axios.post('reportExcel',{
          'valor': this.dates,
        }).then(response=>{
          
          console.log('Tenemos una respuesta desde el controlador')
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
