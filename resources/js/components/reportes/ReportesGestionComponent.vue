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
      <!-- Inicio de Mensaje de Alerta   -->
    <v-flex>
      <div>
        <v-alert
          v-model="alert"
          border="top"
          elevation="3"
          close-text="Close Alert"
          :color="colorMen"
          :type="typeAlert"
          :icon="icon"
          colored-border
          dismissible
        >
          <strong>{{ mensajeAlert }}</strong>
        </v-alert>
      </div>
    </v-flex>
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
    <v-flex>
      <div>
        <v-alert
          v-model="alert"
          border="top"
          elevation="3"
          close-text="Close Alert"
          :color="colorMen"
          :type="typeAlert"
          :icon="icon"
          colored-border
          dismissible
        >
          <strong>{{ mensajeAlert }}</strong>
        </v-alert>
      </div>
    </v-flex>
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

      //Encabezados del archivo excel para la descarga de Master_Historico
      json_fields: {
            'Nombre': 'full_name',
            'Tipo_doc': 'tipo_doc',
            'Num_Doc_Persona': 'documento',
            'Telefono_1' : 'telefono_1',
            'Telefono_2': 'telefono_2',
            'Correo_Persona': 'correo_persona',
            'Fecha_agendamiento': 'fecha_agendamiento',
            'Observ_Persona': 'observ_persona',
            'Tipificación': 'tipificacion',
            'Hora_Agendamiento': 'hora_agendamiento', 
            'Direcc_Residencia_Persona': 'direcc_residencia_persona',
            'Barrio_Persona': 'barrio_persona',
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
            'Observ_Persona': 'observ_persona',
            'Tipificación': 'tipificacion',
            'Hora_Agendamiento': 'hora_agendamiento', 
            'Direcc_Residencia_Persona': 'direcc_residencia_persona',
            'Barrio_Persona': 'barrio_persona',
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
            this.typeAlert = "alert"
            this.alert = true
            this.colorMen = "#FF2D00"

            console.log(this.mensaje)
          }else{
            this.json_data = response.data;

            //Mensaje de alerta
              this.alert = true;
              this.typeAlert = "success";
              this.colorMen = "#008000";
              this.mensajeAlert = "Se han encontrado registros en Master_historico ¡De click en exportar Historico! ";

            console.log(this.json_data)
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
            this.typeAlert = "alert"
            this.alert = true
            this.colorMen = "#FF2D00"

            console.log(this.mensaje2)
          }else{
            this.json_data2 = response.data;

            //Mensaje de alerta succes
              this.alert = true;
              this.typeAlert = "success";
              this.colorMen = "#008000";
              this.mensajeAlert = "Se han encontrado registros en Master ¡De click en exportar Gestión!";

            console.log(this.json_data2)
          }
        })
      },
      //Por medio de este codigo se limpian los datos, cada vez que se genere una descarga
      limpiarDatos(){
        //Para Alerta
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