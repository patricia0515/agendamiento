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
        label="Reportes Historico"
        prepend-icon="mdi-calendar"
        readonly
      ></v-text-field>
 
      <export-excel
      class   = "btn btn-success"
      :data   = "json_data"
      :fields = "json_fields"
      worksheet = "Reportes Historico"
      name    = "MasterHistorico.xls">
  
      Exportar Historico
  
      </export-excel>
    
    </v-col>
    <hr>
    <v-col
      cols="12"
      sm="6"
    >
      <v-date-picker
        v-model="dates2"
        range
        @change="getItems2"
        
      ></v-date-picker>
    </v-col>
    <v-col
      cols="12"
      sm="6"
    >
      <v-text-field
        v-model="dateRangeText2"
        label="Reportes Gestión"
        prepend-icon="mdi-calendar"
        readonly
      ></v-text-field>

      <export-excel
      class   = "btn btn-success"
      :data   = "json_data2"
      :fields = "json_fields2"
      worksheet = "Reportes Master"
      name    = "Master.xls">
  
      Exportar Gestión
  
      </export-excel>

      <!-- Inicio de Mensaje de Alerta   -->
      <v-snackbar 
      v-model="alert" 
      :color="colorMen" 
      :icon="icon"
      right top>
        {{mensajeAlert}}
        <v-btn color="black" text @click="alert = false"> Cerrar </v-btn>
      </v-snackbar>
      <!-- Fin de Mensaje de Alerta   -->

    
    </v-col>
  </v-row>
</template>



<script>
  export default {
    data: () => ({
      dates: [],
      dates2: [],
      mensaje: '',
      mensaje2: '',

      //Codigo de la alerta
      alert: false,
      mensajeAlert: [],
      typeAlert: "",
      colorMen: "",
      icon: "",

       //Codigo de la alerta 2
      alert2: false,
      mensajeAlert2: [],
      typeAlert: "",
      colorMen: "",
      icon: "",

      //Encabezados del archivo excel para la descarga de Master_Historico
      json_fields: {
            'Nombre': 'full_name',
            'Tipo_doc': 'tipo_doc',
            'Num_Doc_Persona': 'documento',
            'Telefono_1' : 'telefono_1',
            'Telefono_2': 'telefono_2',
            'Correo_Persona': 'correo_persona',
            'Fecha_agendamiento': 'fecha_agendamiento',
            'Tipificación': 'tipificacion',
            'Hora_Agendamiento': 'hora_agendamiento', 
            'Direcc_Residencia_Persona': 'direcc_residencia_persona',
            'Ciudad_Persona': 'ciudad_persona'
      },
      //Encabezados del archivo excel para la descarga de Master
      json_fields2: {
            'Nombre': 'full_name',
            'Tipo_doc': 'tipo_doc',
            'Num_Doc_Persona': 'documento',
            'Telefono_1' : 'telefono_1',
            'Telefono_2': 'telefono_2',
            'Correo_Persona': 'correo_persona',
            'Fecha_agendamiento': 'fecha_agendamiento',
            'Tipificación': 'tipificacion',
            'Hora_Agendamiento': 'hora_agendamiento', 
            'Direcc_Residencia_Persona': 'direcc_residencia_persona',
            'Ciudad_Persona': 'ciudad_persona'
      },
        //Por medio de este se generan los datos que se almacenara en el archivo excel
        json_data: [ ],
        json_data2: [ ],
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
      //Metodo para la descarga de Master historico
     getItems() {
       this.limpiarDatos()
        console.log(this.dates)
        axios.post('reportExcel',{
          'valor': this.dates,
        }).then(response=>{

          if(response.status==210){
            this.mensaje =response.data
            
            this.icon = "mdi-cancel"
            this.mensajeAlert = "¡No hay datos para exportar de Master_Historico!"
            this.alert = true
            this.colorMen = "error"

            console.log(this.mensaje)
          }else{
            this.json_data = response.data;
            //Mensaje de alerta
              this.alert = true;
              this.colorMen = "info";
              this.mensajeAlert = "Se han encontrado registros en Master_historico ¡De click en exportar Historico! ";
          }
        })
      },
      //Metodo para la descarga de Master
      getItems2(){
        this.limpiarDatos()
        console.log(this.dates2)
        axios.post('reportExcel2',{
          'valor': this.dates2,
        }).then(response=>{

          if(response.status==210){
            this.mensaje2 =response.data

            //Mensaje de alerta error
            this.icon = "mdi-cancel"
            this.mensajeAlert = "¡No hay datos para exportar de Master!"
            this.alert = true
            this.colorMen = "error"
          }else{
            this.json_data2 = response.data;

            //Mensaje de alerta succes
              this.alert = true;
              this.colorMen = "info";
              this.mensajeAlert = "Se han encontrado registros en Master ¡De click en exportar Gestión!";
          }
        })
      },
      //Por medio de este codigo se limpian los datos, cada vez que se genere una descarga
      limpiarDatos(){
        //Para Alerta gestion
        this.alert = false;
        this.mensajeAlert = [];
        this.typeAlert = "";
        this.colorMen = "";
        this.icon = "";

      }
    },
    computed: {
      dateRangeText () {
        return this.dates.join(' ~ ')
      },
      dateRangeText2 () {
        return this.dates2.join(' ~ ')
      },
    },
  }
</script>