<template>
  
    <v-container>
      <v-card style="width: 175px; height: 30px;">
        <a class="form-group col-md-12 btn btn-primary" href="">Nueva Gestión</a>
      </v-card>
      <br>
      <v-card style="width: 175px; height: 30px;">
        <a class="form-group col-md-12 btn btn-primary" href="">Gestiones</a>
        
      </v-card>
      <v-flex>
          <!-- Formulario consulta de persona -->
         <template>
          <div>
            <v-expansion-panels
              v-model="panel1"
              :readonly="readonly"
              :disabled="disabled"
              multiple
            >
              <v-expansion-panel>
                <v-expansion-panel-header
                class="subheading white--text" color='indigo'
                >
                Gestionar Agendamientos
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                  <div
                  class=" d-flex justify-space-around align-center mb-6 pt-3 mt-4 mr-15 ml-15 "
                  >
                  <v-row 
                  class=" d-flex justify-space-around align-center mb-6 pt-3 mt-4 "
                  >
                  <v-col>
                    <v-text-field
                      v-model="buscarValor"
                      solo outlined  required maxlength="20"
                      label="Número de cédula"
                      clearable
                      @keypress="isNumber($event)"
                      @keyup.enter="buscarCliente()"
                      @paste.prevent
                    >  </v-text-field>
                  </v-col>               
                    <!-- aqui va el boton -->
                    <v-btn
                      class="white--text align-center"
                      color="indigo"
                      elevation="8"
                      large
                      @click="buscarCliente()"
                    >Buscar</v-btn>
                    <!-- fin boton -->
                </v-row>
                </div>
                </v-expansion-panel-content>
              </v-expansion-panel>
            </v-expansion-panels>
          </div>
        </template>
        <!-- Formulario consulta de persona -->
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
                              
                              colored-border
                              dismissible
                            >
                            <strong>{{ mensajeAlert }}</strong>
                            </v-alert>
                          </div>
                        </v-flex>
                  <!-- Fin de Mensaje de Alerta   -->
      
      <!--Fin Formulario consulta de persona -->
      </v-flex>
      

    <!-- Información de la persona -->
        <template v-if="formulariogestion==1">
            <div>
              <v-expansion-panels
                v-model="panel"
                :disabled="disabled"
                multiple
              >
              
                    <v-expansion-panel>
                      <v-expansion-panel-header class="subheading white--text" color='indigo'>
                        Información detallada del Registro
                       <template v-slot:actions>
                          <v-icon color="white">
                            $expand
                          </v-icon>
                        </template> 
                      </v-expansion-panel-header>
                      <v-expansion-panel-content>
                        <!-- Inicio Formulario de Gestión-->
                        <template>
                          <v-simple-table>
                            <template v-slot:default>
                                <thead><tr><th class="text-left font-weight-black">Nombre</th><td>{{ nombre_persona+' '+apellido_persona }}</td> </tr></thead>
                                <thead><tr><th class="text-left font-weight-black">Tipo de Documento</th><td>{{ tipo_doc_persona.detalle }}</td> </tr></thead>
                                <thead><tr><th class="text-left font-weight-black">No. Identificación</th><td>{{ num_doc_persona }}</td> </tr></thead>
                                <thead><tr><th class="text-left font-weight-black">Telefono del Cliente 1</th><td>{{ telefono1_persona }}</td> </tr></thead>
                                <thead><tr><th class="text-left font-weight-black">Telefono del Cliente 2</th><td>{{ telefono2_persona}}</td> </tr></thead>
                                <thead><tr><th class="text-left font-weight-black">Fecha Agendamiento</th><td>{{ fecha_agendamiento }}</td> </tr></thead>
                            </template>
                          </v-simple-table>
                        </template>
                        <!-- Fin Formulario de Gestión-->
                      </v-expansion-panel-content>
                    </v-expansion-panel>
                    

                    <!-- //Gestionar registro -->
                     <v-expansion-panel>
                      <v-expansion-panel-header class="subheading white--text" color='indigo'>
                        Gestionar Registro 
                        <template v-slot:actions>
                          <v-icon color="white">
                            $expand
                          </v-icon>
                        </template>
                        </v-expansion-panel-header>
                      <v-expansion-panel-content class="pa-6">
                    <!-- Select Tipificación -->
                        <template >
                            <v-select
                            v-model="id_tip"
                            :items="tipificacion"
                            item-text="detalle"
                            item-value="idtipificacion"
                            label="Tipificación"
                            outlined
                            @change="listaSubtipificacion()"
                          ></v-select>
                        </template>
                    <!-- Fin Select Tipificación-->

                    <!-- Select SubTipificación -->
                        <template v-if="sub_tipificacion.length > 0">
                            <v-select
                            :items="sub_tipificacion"
                            item-text="detalle"
                            item-value="idsub_tipificacion"
                            label="Subtipificación"
                            outlined
                            @change="dialog = true"
                          ></v-select>
                        </template>
                    <!-- Fin Select SubTipificación-->
         
                    <!-- Información Personal -->
                      <template>
                      <v-row justify="space-around">
                       
                        <v-col cols="auto">
                          <v-dialog
                            v-model="dialog"
                            transition="dialog-top-transition"
                            max-width="900"
                            persistent
                          >
                            <template>
                              <v-card>
                                <v-toolbar
                                  color="indigo"
                                  dark
                                >Información Personal</v-toolbar>
                                <v-card-text>
                                  <div class="text-h6 pa-3">
                                    <p class="font-weight-bold">INFORMACIÓN A RECOPILAR</p>
                                    </div>
                                  <div class="text-h12 pa-0">
                                    <p>
                                      Tenga en cuenta diligenciar o completar todos los campos quen tengan el icono de <span class="red--text">(*)</span>  obligatorio, de lo contrario no se podra almacenar la información.
                                    </p>
                                    </div>

                                    <!-- Inicio de Mensaje de Alerta   -->
                                    <v-snackbar v-for="(mensaje, index) in mensajeAlert " :key="index" v-model="alert" :color="colorMen" right top>
                                      {{mensaje}}
                                      <v-btn color="black" text @click="alert = false" > Cerrar </v-btn>
                                    </v-snackbar>
                                    <!-- Fin de Mensaje de Alerta   -->
                                                                  
                                    <!-- Formulario -->
                                      <form-wizard 
                                      next-button-text="Siguiente"
                                      back-button-text="Anterior"
                                      finish-button-text="Guardar y Procesar"
                                      starr-index= "step1"
                                      @on-complete= "agendarCita"
                                      color='#0000FF'
                                      shape="circle"
                                      title=""
                                      subtitle=""
                                      >
                
                                           <tab-content 
                                           title="Información Personal"
                                           step= "step1"
                                           >
                                          <v-row>
                                            <v-col
                                              cols="12"
                                              sm="6"
                                            >
                                              <v-text-field
                                                v-model="nombre_persona"
                                                label="Nombre"
                                                outlined
                                              ></v-text-field>
                                            </v-col>

                                            <v-col
                                              cols="12"
                                              sm="6"
                                            >
                                              <v-text-field
                                                v-model= "apellido_persona"
                                                label="Apellido"
                                                outlined
                                              ></v-text-field>
                                            </v-col>
                                          </v-row>

                                          <v-row>
                                            <v-col
                                              cols="12"
                                              sm="6"
                                            >
                                              <!-- Select Tipo de Documento -->
                                                  <template>
                                                      <v-select
                                                      v-model= "tipo_doc_persona.idtipo_identificacion"
                                                      :items= "arrayDataTipoId"
                                                      item-text="detalle"
                                                      item-value="idtipo_identificacion"
                                                      label="Tipo de Documento"
                                                      outlined
                                                    ></v-select>
                                                  </template>
                                              <!-- Fin Select Tipo de Documento-->
                                            </v-col>

                                            <v-col
                                              cols="12"
                                              sm="6"
                                            >
                                              <v-text-field
                                                v-model= "num_doc_persona"
                                                label="Número de Documento (*)"
                                                outlined
                                                readonly
                                              ></v-text-field>
                                            </v-col>
                                          </v-row>

                                          <v-row>
                                            <v-col
                                              cols="12"
                                              sm="6"
                                            >
                                              <v-text-field
                                                v-model= "direcc_residencia_persona"
                                                label="Dirección Residencia (*)"
                                                outlined
                                              ></v-text-field>
                                            </v-col>

                                            <v-col
                                              cols="12"
                                              sm="6"
                                            >
                                              <v-text-field
                                                v-model= "barrio_persona"
                                                label="Barrio (*)"
                                                outlined
                                              ></v-text-field>
                                            </v-col>
                                          </v-row>

                                          <v-row>
                                            <v-col
                                              cols="12"
                                              sm="6"
                                            >
                                              <!-- Select Municipio -->
                                                  <template>
                                                      <v-autocomplete
                                                      v-model= "ciudad_persona.id"
                                                      :items= "arrayDataMunicipios"
                                                      item-text="nombre_municipio"
                                                      item-value="id"
                                                      label="Municipio"
                                                      outlined
                                                    ></v-autocomplete>
                                                  </template>
                                              <!-- Fin Select Municipio-->
                                            </v-col>

                                            <v-col
                                              cols="12"
                                              sm="6"
                                            >
                                              <v-text-field
                                                v-model= "telefono1_persona"
                                                label= "Teléfono 1 (*)"
                                                outlined
                                              ></v-text-field>
                                            </v-col>
                                          </v-row>

                                          <v-row>
                                            <v-col
                                              cols="12"
                                              sm="6"
                                            >
                                              <v-text-field
                                                v-model= "telefono2_persona"
                                                label="Teléfono 2 (*)"
                                                outlined
                                              ></v-text-field>
                                            </v-col>

                                            <v-col
                                              cols="12"
                                              sm="6"
                                            >
                                              <v-text-field
                                                v-model= "correo_persona"
                                                label="Correo Eléctronico"
                                                outlined
                                              ></v-text-field>
                                            </v-col>
                                          </v-row>
                                          
                                        </tab-content>

                                        <tab-content 
                                        title="Agendamiento"
                                        class="p-4"
                                        step="step2"
                                        >
                                          <v-row class="justify-center">
                                            <v-card>
                                              <v-date-picker
                                                v-model='date'
                                                label="Fecha Agendamiento (*)"
                                                placeholder="AAAA-MM-DD"
                                                color="indigo"
                                                width="180"
                                                elevation="15"
                                                locale="es-co"
                                                :min='minimo'
                                                :landscape="true"
                                                @change='fecha_agendamiento = date'
                                              ></v-date-picker>
                                            </v-card>
                                          
                                            <v-col
                                              cols="12"
                                              sm="6"
                                              class="pa-3"
                                            >
                                              <v-select
                                                v-model="hora_agendamiento"
                                                :items="items_hora"
                                                full-width
                                                label="Hora Agendamiento (*)"
                                                outlined
                                              ></v-select>
                                              <v-textarea
                                                solo
                                                name="input-7-4"
                                                label="Comentario"
                                              ></v-textarea>
                                            </v-col>
                                            
                                          </v-row>
                                        </tab-content>
                                      </form-wizard>
                                    <!-- Fin Formulario -->
                                </v-card-text>

                                <v-card-actions class="justify-end">
                                  <v-btn
                                    @click="dialog = false"
                                  >Cancelar</v-btn>
                                </v-card-actions>
                                
                              </v-card>
                            </template>
                          </v-dialog>
                        </v-col>
                      </v-row>
                    </template>
                    <!-- Fin Información Personal -->

                      </v-expansion-panel-content>
                    </v-expansion-panel>

              </v-expansion-panels>
            </div>
        </template>
    </v-container>
  
</template>

<script>
export default {
    data: () => ({
        nombreAsesor: '',
        formulariogestion: 0,
        buscarValor: '',
        arrayDataPersona: [],
        arrayDataTipoId: [],
        arrayDataMunicipios: [],
        arrayGestion: [],

        //Variables para el formaulario
        idmaster: 0,
        num_doc_persona: '',
        nombre_persona: '',
        apellido_persona: '',
        correo_persona: '',
        ciudad_persona: {
          id:'',
          nombre_municipio:''
        },
        tipo_doc_persona: {
          idtipo_identificacion:'',
          detalle:''
        },
        
        telefono1_persona:'',
        telefono2_persona:'',
        fecha_agendamiento:'',
        direcc_residencia_persona:'',
        barrio_persona:'',

        //para la fecha y hora de agendamiento
        fecha_agendamiento:'',
        hora_agendamiento:'',
        items_hora: [
          '08:00-10:00',
          '09:00-11:00',
          '10:00-12:00',
          '13:00-15:00',
          '14:00-16:00',
          '15:00-17:00'],

        /* Dejo la fecha minima tomando en cuenta el día calendario del equipo (Pilas no cuenta el dia actual) */
        minimo:new Date().toISOString().substr(0,10),
        date: new Date().toISOString().substr(0,10),
                  
        //Variables para los mensajes de alerta
        alert:false,
        mensajeAlert:[],
        typeAlert:'',
        colorMen:'',

        //Para el panel de expansión
        panel: [0, 1],
        panel1: [0, 0],
        disabled: true,
        readonly: true,

        //para el select
        select: null,
        tipificacion: [],
        sub_tipificacion: [],
        id_tip:0,
        //Para el formulario flotante
        dialog: false,
        
    }),
    methods:{
        ////Validaciones solo Números
      isNumber: function (evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
            evt.preventDefault();;
        } else {
            return true;
        }
      },
      //Metodo para buscar cliente
      buscarCliente(){
          console.log('Hola, desde la consola')
          this.limpiarDatos();
          this.arrayDataPersona = [];
          this.arrayDataTipoId = [];
          this.arrayDataMunicipios = [];
          this.mensajeAlert = [];

          if(!this.buscarValor){
          this.mensajeAlert='EL campo Cédula es requerido.';
          this.typeAlert='error';
          this.alert = true;
          this.colorMen = '#FF0033';
        }else{
          console.log(this.buscarValor)
          axios.post('consultaPersona',{
            'valor': this.buscarValor,
          }).then(response=>{
            this.arrayDataPersona = response.data[0];
            this.arrayDataMunicipios = response.data[1];
            this.arrayDataTipoId = response.data[2];
            // dbtm.arrayGestionLog = response.data[3];
            if(response.status==210){
                console.log('LA CONSULTA NO TRAJO RESULTADOS')
              this.mensajeAlert="No se encontro cliente con el numero de cédula "+this.buscarValor+".";
              this.typeAlert='info';
              this.alert = true;
              this.colorMen = '#FFC30F';
            }else{ 
              this.formulariogestion = 1;
              this.y=this.arrayDataMunicipios.length;
              //Mensaje de alerta
              this.alert=true;
              this.typeAlert='success';
              this.colorMen = '#008000';
              this.mensajeAlert= '¡Bien hecho! Registro encontrado.';
              
              this.disabled= false,
              this.idmaster = this.arrayDataPersona[0].idmaster;
              this.num_doc_persona = this.arrayDataPersona[0].num_doc_persona;
              this.nombre_persona = this.arrayDataPersona[0].nombre_persona;
              this.apellido_persona = this.arrayDataPersona[0].apellido_persona;
              this.correo_persona = this.arrayDataPersona[0].correo_persona;
              
              this.ciudad_persona.id = this.arrayDataPersona[0].ciudad_persona;
              console.log('ESTE ES EL ID CIUDAD QUE ME LLEGA DE LA CONSULTA')
              console.log(this.ciudad_persona.id)
              
                for (let x = 0; x < (this.arrayDataMunicipios.length); x++) {
                    if(this.ciudad_persona.id == this.arrayDataMunicipios[x].id){
                      this.ciudad_persona.nombre_municipio = this.arrayDataMunicipios[x].nombre_municipio
                    }
                }
              console.log('ESTE ES EL OBJETO CIUDAD QUE SALE DEL FOR')
              console.log(this.ciudad_persona)
              
              this.tipo_doc_persona.idtipo_identificacion = this.arrayDataPersona[0].tipo_doc_persona;
              console.log('ESTE ES EL ID DOCUMENTO QUE ME LLEGA DE LA CONSULTA')
              console.log(this.tipo_doc_persona.idtipo_identificacion)

                for (let x = 0; x < (this.arrayDataTipoId.length); x++) {
                  if(this.tipo_doc_persona.idtipo_identificacion == this.arrayDataTipoId[x].idtipo_identificacion){
                    this.tipo_doc_persona.detalle = this.arrayDataTipoId[x].detalle
                  }
              }
              console.log('ESTE ES EL OBJETO DOCUMENTO QUE SALE DEL FOR')
              console.log(this.tipo_doc_persona)

              this.telefono1_persona = this.arrayDataPersona[0].telefono1_persona; 
              this.telefono2_persona = this.arrayDataPersona[0].telefono2_persona;
              this.fecha_agendamiento= this.arrayDataPersona[0].fecha_agendamiento;
              this.direcc_residencia_persona= this.arrayDataPersona[0].direcc_residencia_persona;
              this.barrio_persona= this.arrayDataPersona[0].barrio_persona;
              this.listaTipificacion();
            }
          }).catch(error => {
                 console.log("error , parece que es la consulta " + error);
              });
          }
        },
      
      //Listar tipificaciones
      listaTipificacion(){
          this.tipificacion=[];
          axios.post('listar-tipificaciones',{
          'estado': 1,
        }).then(response=>{
          this.tipificacion = response.data;
          console.log('RESULTADO DE LA CONSULTA TIPIFICACIONES')
          console.log(this.tipificacion)  
        }).catch(error => {
                 console.log("error " + error);
              });
      },
      //Listar Subtipificaciones
      listaSubtipificacion(){
          this.sub_tipificacion=[];
          axios.post('listar-subtipificaciones',{
          'id': this.id_tip,
        }).then(response=>{
          this.sub_tipificacion = response.data;
          console.log('RESULTADO DE LA CONSULTA SUBTIPIFICACIONES')
          console.log(this.sub_tipificacion)  
        }).catch(error => {
                 console.log("error " + error);
              });
      },
      agendarCita(){
        this.validarForm();
  
        if(this.mensajeAlert.length > 0){
          

          this.colorMen = '#FF0033';
          this.alert = true;
          console.log('FALTA LLENAR CAMPOS')
        }else{
          console.log('Todo en orden para guardar la agenda.')
          this.dialog = false;
        }
        
        console.log('TERMINO EL FORM PASO A PASO')
      },
      validarForm(){
        this.mensajeAlert=[];

        if(this.tipo_doc_persona==''){
          this.mensajeAlert.push("Debe seleccionar el tipo de documento.");
        }
        if(this.nombre_persona==''){
          this.mensajeAlert.push("Digite el nombre.");
        }
        if(this.apellido_persona==''){
          this.mensajeAlert.push("Digite el apellido.");
        }
        if(this.hora_agendamiento==''){
          this.mensajeAlert.push("Seleccione hora de agendamiento.");
        }
      },
     
        ////Limpiar los datos del cliente cuando se realiza una nueva busqueda
      limpiarDatos(){
        // let dbtm = this;
        this.idmaster = 0;
        this.formulariogestion = 0;
        this.arrayDataPersona = [];
        this.arrayDataTipoId= [];
        this.arrayDataMunicipios= [];
        this.arrayGestion = [];
        
        this.tipificacion=[];
        this.sub_tipificacion= [];
        this.id_tip = 0;

        //Para Alerta
        this.alert=false;
        this.mensajeAlert=[];
        this.typeAlert='';
        this.colorMen = '';

        //Para el panel de expansión
        this.panel= [0, 1];
        this.disabled = true;
        
        //gestión hor fecha agendamiento
        this.fecha_agendamiento ='';
        this.date = new Date().toISOString().substr(0,10);
        this.hora_agendamiento ='';
        
      },
    },
    
    mounted() {

    }, 
        
}

</script>