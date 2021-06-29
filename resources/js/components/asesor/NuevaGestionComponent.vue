<template>
  <v-container>
      <v-bottom-navigation
            :value="value"
            color="indigo"
            grow
            
        >
            <v-btn
            @click="gestionesOk"
            >
            <span>Gestiones</span>
            
            <v-icon>mdi-briefcase-edit</v-icon>
            </v-btn>

            <v-btn
            @click="nueva_gestion"
            >
            <span>Nueva Gestión</span>

            <v-icon>mdi-newspaper-plus</v-icon>
            </v-btn>
        </v-bottom-navigation>

      <div class="pa-6">
        <v-row
        class="pa-2 justify-center align-center">

        <h5>Record de Agendamientos en la semana entre el <strong class="green--text"> lunes {{ lunes }} </strong>al <strong class="green--text"> domingo  {{ domingo }}</strong>:</h5>
        </v-row>
        <v-row
        class="pa-3 justify-center align-center">
        <h3><strong>  {{ agendamiento_semana }}</strong></h3>
            </v-row>
            <div class="progress">
                <div 
                class="progress-bar " 
                role="progressbar" 
                
                :style="{'width': agendamiento_semana+'%'}"
                aria-valuenow="20" 
                aria-valuemin="0" 
                aria-valuemax="80"
                :class="color"
                >{{ agendamiento_semana }}%</div>
              </div>
        
      </div>
            
   
    <v-flex>
      
      <!-- Formulario consulta de persona -->
      <template v-if="nuevaGestion==true && menu==2">
        <div>
          <v-expansion-panels
            v-model="panel1"
            :readonly="readonly"
            :disabled="disabled"
            multiple
          >
            <v-expansion-panel>
              <v-expansion-panel-header
                class="subheading white--text"
                color="indigo"
              >
                Gestionar Agendamientos
              </v-expansion-panel-header>
              <v-expansion-panel-content>
                <div
                  class="
                    d-flex
                    justify-space-around
                    align-center
                    mb-6
                    pt-3
                    mt-4
                    mr-15
                    ml-15
                  "
                >
                  <v-row
                    class="
                      d-flex
                      justify-space-around
                      align-center
                      mb-6
                      pt-3
                      mt-4
                    "
                  >
                    <v-col>
                      <v-text-field
                        v-model="buscarValor"
                        solo
                        outlined
                        required
                        maxlength="20"
                        label="Número de cédula"
                        clearable
                        @keypress="isNumber($event)"
                        @keyup.enter="buscarCliente()"
                        @paste.prevent
                      >
                      
                      </v-text-field>
                    </v-col>
                    <!-- aqui va el boton -->
                    <v-btn
                      class="white--text align-center"
                      color="indigo"
                      elevation="8"
                      large
                      @click="buscarCliente()"
                      >
                      <v-icon>mdi-file-search-outline</v-icon>
                      Buscar</v-btn>
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
    <template v-if="formulariogestion == 1 && menu==2">
      <div>
        <v-expansion-panels v-model="panel" :disabled="disabled" multiple>
          <v-expansion-panel>
            <v-expansion-panel-header
              class="subheading white--text"
              color="indigo"
            >
              Información detallada del Registro
              <template v-slot:actions>
                <v-icon color="white"> $expand </v-icon>
              </template>
            </v-expansion-panel-header>
            <v-expansion-panel-content>
              <!-- Inicio Data de Gestión-->
              <template v-if="infoPersona == 1">
                <v-simple-table>
                  <template v-slot:default>
                    <thead>
                      <tr>
                        <th class="text-left font-weight-black">Nombre</th>
                        <td>{{ nombre_persona + " " + apellido_persona }}</td>
                      </tr>
                    </thead>
                    <thead>
                      <tr>
                        <th class="text-left font-weight-black">
                          Tipo de Documento
                        </th>
                        <td>{{ tip_doc }}</td>
                      </tr>
                    </thead>
                    <thead>
                      <tr>
                        <th class="text-left font-weight-black">
                          No. Identificación
                        </th>
                        <td>{{ num_doc_persona }}</td>
                      </tr>
                    </thead>
                    <thead>
                      <tr>
                        <th class="text-left font-weight-black">
                          Telefono del Cliente 1
                        </th>
                        <td>{{ telefono1_persona }}</td>
                      </tr>
                    </thead>
                    <thead>
                      <tr>
                        <th class="text-left font-weight-black">
                          Telefono del Cliente 2
                        </th>
                        <td>{{ telefono2_persona }}</td>
                      </tr>
                    </thead>
                    <thead>
                      <tr>
                        <th class="text-left font-weight-black">
                          Fecha Agendamiento
                        </th>
                        <td>{{ fecha_agendamiento }}</td>
                      </tr>
                    </thead>
                  </template>
                </v-simple-table>
              </template>
              <!-- Fin Formulario de Gestión-->
            </v-expansion-panel-content>
          </v-expansion-panel>

          <!-- //Gestionar registro -->
          <v-expansion-panel>
            <v-expansion-panel-header
              class="subheading white--text"
              color="indigo"
            >
              Gestionar Registro
              <template v-slot:actions>
                <v-icon color="white"> $expand </v-icon>
              </template>
            </v-expansion-panel-header>
            <v-expansion-panel-content class="pa-6">
              <!-- Select Tipificación -->
              <template>
                <v-select
                  v-model.number="id_tip"
                  :items="tipificacion"
                  item-text="detalle"
                  item-value="idtipificacion"
                  label="Tipificación"
                  outlined
                  @change="validFecha"
                ></v-select>
              </template>
              <!-- Fin Select Tipificación-->

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
                          <v-toolbar color="indigo" dark
                            >Información Personal</v-toolbar
                          >
                          <v-card-text>
                            <div class="text-h6 pa-3">
                              <p class="font-weight-bold">
                                INFORMACIÓN A RECOPILAR
                              </p>
                            </div>
                            <div class="text-h12 pa-0">
                              <p>
                                Tenga en cuenta diligenciar o completar todos
                                los campos quen tengan el icono de
                                <span class="red--text">(*)</span> obligatorio,
                                de lo contrario no se podra almacenar la
                                información.
                              </p>
                            </div>

                            <!-- Inicio de Mensaje de Alerta   -->
                            <v-snackbar
                              v-for="(mensaje, index) in mensajeAlert"
                              :key="index"
                              v-model="alert"
                              :color="colorMen"
                              right
                              top
                            >
                              {{ mensaje }}
                              <v-btn color="black" text @click="alert = false">
                                Cerrar
                              </v-btn>
                            </v-snackbar>
                            <!-- Fin de Mensaje de Alerta   -->

                            <!-- Formulario -->
                            <form-wizard
                              next-button-text="Siguiente"
                              back-button-text="Anterior"
                              finish-button-text="Guardar y Procesar"
                              @on-complete="agendarCita"
                              color="#0000FF"
                              error-color="#ff4949"
                              shape="circle"
                              title=""
                              subtitle=""
                              
                            >
                              <tab-content
                                title="Información Personal"
                              
                                :before-change="() => validateAsync('form')"
                                
                              >
                                <v-form
                                  ref="form"
                                  v-model="valid"
                                  lazy-validation
                                >
                                  <v-row>
                                    <v-col cols="12" sm="6">
                                      <v-text-field
                                        v-model.trim= "nombre_persona"
                                        label="Nombre"
                                        outlined
                                        :counter="20"
                                        :rules= "nombre_personaRules"
                                      ></v-text-field>
                                    </v-col>

                                    <v-col cols="12" sm="6">
                                      <v-text-field
                                        v-model.trim="apellido_persona"
                                        label="Apellido"
                                        outlined
                                        :counter="20"
                                        :rules= "apellido_personaRules"
                                      ></v-text-field>
                                    </v-col>
                                  </v-row>

                                  <v-row>
                                    <v-col cols="12" sm="6">
                                      <!-- Select Tipo de Documento -->
                                      <template>
                                        <v-select
                                          v-model.number="tipo_doc_persona"
                                          :items="arrayDataTipoId"
                                          item-text="detalle"
                                          item-value="idtipo_identificacion"
                                          label="Tipo de Documento"
                                          outlined
                                          :rules="tipo_doc_personaRules"
                                        ></v-select>
                                      </template>
                                      <!-- Fin Select Tipo de Documento-->
                                    </v-col>

                                    <v-col cols="12" sm="6">
                                      <v-text-field
                                        v-model.trim="num_doc_persona"
                                        label="Número de Documento (*)"
                                        outlined
                                        readonly
                                      ></v-text-field>
                                    </v-col>
                                  </v-row>

                                  <v-row>
                                    <v-col cols="12" sm="6">
                                      <v-text-field
                                        v-model="direcc_residencia_persona"
                                        label="Dirección Residencia (*)"
                                        outlined
                                        :counter="50"
                                        :rules="direcc_residencia_personaRules"
                                      ></v-text-field>
                                    </v-col>

                                    <v-col cols="12" sm="6">
                                      <v-text-field
                                        v-model.trim="barrio_persona"
                                        label="Barrio (*)"
                                        outlined
                                        :counter="30"
                                        :rules="barrio_personaRules"
                                      ></v-text-field>
                                    </v-col>
                                  </v-row>

                                  <v-row>
                                    <v-col cols="12" sm="6">
                                      <!-- Select Municipio -->
                                      <template>
                                        <v-autocomplete
                                          v-model.number="ciudad_persona"
                                          :items="arrayDataMunicipios"
                                          item-text="nombre_municipio"
                                          item-value="id"
                                          label="Municipio"
                                          outlined
                                          :rules="ciudad_personaRules"
                                        ></v-autocomplete>
                                      </template>
                                      <!-- Fin Select Municipio-->
                                    </v-col>

                                    <v-col cols="12" sm="6">
                                      <v-text-field
                                        v-model.trim="telefono1_persona"
                                        label="Teléfono 1 (*)"
                                        outlined
                                        :counter="10"
                                        :rules="telefono1_personaRules"
                                      ></v-text-field>
                                    </v-col>
                                  </v-row>

                                  <v-row>
                                    <v-col cols="12" sm="6">
                                      <v-text-field
                                        v-model.trim="telefono2_persona"
                                        label="Teléfono 2 (*)"
                                        outlined
                                        :counter="10"
                                        :rules="telefono2_personaRules"
                                      ></v-text-field>
                                    </v-col>

                                    <v-col cols="12" sm="6">
                                      <v-text-field
                                        v-model.trim="correo_persona"
                                        label="Correo Eléctronico"
                                        outlined
                                        :rules="correo_personaRules"
                                      ></v-text-field>
                                    </v-col>
                                  </v-row>
                                </v-form>
                              </tab-content>
                              <template v-if="id_tip == 1">
                                <tab-content
                                  title="Agendamiento"
                                  class="p-4"
                                  :before-change="() => validateAsync('form2')"
                                >
                                  
                                  <v-form
                                    ref="form2"
                                    v-model="valid2"
                                    lazy-validation
                                  >
                                    <v-row class="justify-center">
                                      <v-card>
                                        
                                        <v-date-picker
                                          v-model="fecha_agendamiento1"
                                          label="Fecha Agendamiento (*)"
                                          placeholder="AAAA-MM-DD"
                                          color="indigo"
                                          width="180"
                                          elevation="15"
                                          locale="es-co"
                                          :min="minimo"
                                          :landscape="true"
                                          :rules="fecha_agendamientoRules"
                                          @change="fecha_agendamiento = fecha_agendamiento1"
                                        ></v-date-picker>
                                      </v-card>

                                      <v-col cols="12" sm="6" class="pa-3">
                                        <v-select
                                          v-model="hora_agendamiento"
                                          :items="items_hora"
                                          full-width
                                          label="Hora Agendamiento (*)"
                                          outlined
                                          :rules="hora_agendamientoRules"
                                        ></v-select>
                                        <v-textarea
                                          v-model="observ_persona"
                                          solo
                                          name="input-7-4"
                                          label="Comentario"
                                        ></v-textarea>
                                      </v-col>
                                    </v-row>
                                  </v-form>
                                
                                </tab-content>
                              </template>
                              <template v-if="id_tip == 2">
                                <tab-content
                                  title="Cancelar Cita"
                                  class="p-4"
                                >
                                <div
                                class="ma-3 text-center justify-center">
                                  <h4 class="justify-center"> Esta seguro que desea cancelar la cita asignada para la fecha:</h4><span><h1>{{fecha_agendamiento}}</h1></span><br>
                                  <h4 class="justify-center"> Hora: </h4><span><h2>{{ hora_agendamiento1 }}</h2></span><br>
                                  <v-textarea
                                          v-model="observ_persona"
                                          solo
                                          name="input-7-4"
                                          label="Comentario"
                                        ></v-textarea>
                                </div>
                                

                                </tab-content>

                              </template> 
                              
                              <tab-content
                              title ="Verificación"
                              @on-validate="agendarCita"
                              >
                                <div>
                                  <div>
                                      <p class="font-weight-black text-subtitle-2 text-center error--text text--darken-2" >
                                        {{ mens }}
                                      </p>
                                  </div>
                                      <template v-if="advertencia==false">
                                        <v-row
                                        class="pa-2 justify-center align-center">
                                          <img class="justify-center align-center" src="img/check.png" alt="check" width="140" >
                                        </v-row>
                                      </template>
                                    
                                      
                                    </div>
                              </tab-content>
                            </form-wizard>
                            <!-- Fin Formulario -->
                          </v-card-text>

                          <v-card-actions class="justify-end">
                            <v-btn @click="limpiarDatos">Cancelar</v-btn>
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
    <template v-if="menu==1">
      <gestiones-component></gestiones-component>
    </template>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    gestiones:false,
    nuevaGestion:true,
    agendamiento_dia:0,
    agendamiento_semana:0,
    lunes:"",
    domingo:"",

    value:0,
    menu:0,
    advertencia:false,
    

    nombreAsesor: "",
    formulariogestion: 0,
    infoPersona: 0,
    buscarValor: "",
    arrayDataPersona: [],
    arrayDataTipoId: [],
    arrayDataMunicipios: [],
    arrayGestiones: [],

    //Variables para el formaulario
    idmaster: 0,
    num_doc_persona: "",
    nombre_persona: "",
    apellido_persona: "",
    correo_persona: "",
    ciudad_persona: 0,
    municipio: "",
    tipo_doc_persona: 0,
    tip_doc: "",
    telefono1_persona: "",
    telefono2_persona: "",
    direcc_residencia_persona: "",
    barrio_persona: "",

    //para la fecha y hora de agendamiento
    fecha_agendamiento: "",
    fecha_agendamiento1:null,
    hora_agendamiento: "",
    hora_agendamiento1: "",
    items_hora: [
      "08:00-10:00",
      "09:00-11:00",
      "10:00-12:00",
      "13:00-15:00",
      "14:00-16:00",
      "15:00-17:00",
    ],

    /* Dejo la fecha minima tomando en cuenta el día calendario del equipo (Pilas no cuenta el dia actual) */
    minimo: new Date().toISOString().substr(0, 10),

    //Variables para los mensajes de alerta
    alert: false,
    mensajeAlert: [],
    typeAlert: "",
    colorMen: "",

    //Para el panel de expansión
    panel: [0, 1],
    panel1: [0, 0],
    disabled: true,
    readonly: true,

    //para el select
    select: null,
    tipificacion: [],
    sub_tipificacion: [],
    observ_persona: "",

    //Para el formulario modal
    dialog: false,

    //Vamos a validar el formulario agendar 
    valid: true,
    valid2: true,
    
    mens:"",

    nombre_personaRules: [
        v => !!v || 'Nombre requerido',
        v => (v && v.length <= 20) || 'El nombre no debe exceder mas de 20 caracteres',
      ],
    apellido_personaRules: [
        v => !!v || 'Apellido requerido',
        v => (v && v.length <= 20) || 'El apellido no debe exceder mas de 20 caracteres',
      ],
    tipo_doc_personaRules: [
        v => !!v || 'Seleccione el tipo de documento',
      ],
    direcc_residencia_personaRules: [
        v => !!v || 'Dirección requerida',
        v => (v && v.length <= 50) || 'La dirección no debe exceder mas de 50 caracteres',
      ],
    barrio_personaRules: [
        v => !!v || 'Nombre barrio requerido',
        v => (v && v.length <= 30) || 'El nombre del barrio no debe exceder mas de 30 caracteres',
      ],
    ciudad_personaRules: [
        v => !!v || 'Seleccione el municipio',
      ],
    telefono1_personaRules: [
        v => !!v || 'El telefono 1 es requerido',
        v => (v && v.length <= 10) || 'El telefono no debe exceder mas de 10 digitos',
      ],
    telefono2_personaRules: [
        v => !!v || 'El telefono 2 es requerido',
        v => (v && v.length <= 10) || 'El telefono no debe exceder mas de 10 digitos',
      ],
    correo_personaRules: [
        v => /.+@.+\..+/.test(v) || 'Formato no valido',
      ],
    hora_agendamientoRules:[
      v => !!v || 'Seleccione una hora',
    ],
    fecha_agendamientoRules:[
      v => !!v || 'Seleccione una fecha',
    ],

  }),
  created () {
        this.getCount();
    },
  
  methods: {
    getCount() {
        axios.get("gestiones").then(response => {
          
          this.agendamiento_dia = response.data[2];
          this.agendamiento_semana = response.data[1];
          this.lunes=response.data[3];
          this.domingo=response.data[4];

            });
        },

    gestionesOk(){
      this.menu=1;
      this.alert=false;
    },
    nueva_gestion(){
      this.limpiarDatos()
      this.menu=2;
    },

    ////Validaciones solo Números
    isNumber: function (evt) {
      evt = evt ? evt : window.event;
      var charCode = evt.which ? evt.which : evt.keyCode;
      if (
        charCode > 31 &&
        (charCode < 48 || charCode > 57) &&
        charCode !== 46
      ) {
        evt.preventDefault();
      } else {
        return true;
      }
    },
    //Metodo para buscar cliente
    buscarCliente() {
      this.limpiarDatos();
      this.arrayDataPersona = [];
      this.arrayDataTipoId = [];
      this.arrayDataMunicipios = [];
      this.mensajeAlert = [];

      if (!this.buscarValor) {
        this.mensajeAlert = "EL campo Cédula es requerido.";
        this.typeAlert = "error";
        this.alert = true;
        this.colorMen = "#FF0033";
      } else {
        axios
          .post("consultaPersona", {
            valor: this.buscarValor,
          })
          .then((response) => {
            if (response.status == 210) {
              
              this.arrayDataMunicipios = response.data[0];
              this.arrayDataTipoId = response.data[1];
              this.formulariogestion = 1;
              this.mensajeAlert =
                "No se encontro cliente con el numero de cédula " +
                this.buscarValor +
                ".";
              this.typeAlert = "info";
              this.alert = true;
              this.colorMen = "#FFC30F";
              this.num_doc_persona=this.buscarValor

              this.listaTipificacion();
            } else {
              this.arrayDataPersona = response.data[0];
              this.arrayDataMunicipios = response.data[1];
              this.arrayDataTipoId = response.data[2];
              this.formulariogestion = 1;
              this.infoPersona = 1;

              //Mensaje de alerta
              this.alert = true;
              this.typeAlert = "success";
              this.colorMen = "#008000";
              this.mensajeAlert = "¡Bien hecho! Registro encontrado.";

              this.disabled = false,
              this.idmaster = this.arrayDataPersona[0].idmaster;
              this.num_doc_persona = this.arrayDataPersona[0].num_doc_persona;
              this.nombre_persona = this.arrayDataPersona[0].nombre_persona;
              this.apellido_persona = this.arrayDataPersona[0].apellido_persona;
              this.correo_persona = this.arrayDataPersona[0].correo_persona;
              this.ciudad_persona = this.arrayDataPersona[0].ciudad_persona;
              this.municipio = this.arrayDataPersona[0].municipio;
              this.tipo_doc_persona = this.arrayDataPersona[0].tipo_doc_persona;
              this.tip_doc = this.arrayDataPersona[0].tip_doc;
              this.telefono1_persona = this.arrayDataPersona[0].telefono1_persona;
              this.telefono2_persona = this.arrayDataPersona[0].telefono2_persona;
              this.tipificacion = this.arrayDataPersona[0].tipificacion;
              this.fecha_agendamiento = this.arrayDataPersona[0].fecha_agendamiento;
              if(this.fecha_agendamiento < this.minimo || this.tipificacion ==2){
                this.fecha_agendamiento = ""
              }
              this.direcc_residencia_persona = this.arrayDataPersona[0].direcc_residencia_persona;
              this.barrio_persona = this.arrayDataPersona[0].barrio_persona;
              this.hora_agendamiento1 = this.arrayDataPersona[0].hora_agendamiento;
              
              this.listaTipificacion();
            }
          })
          .catch((error) => {
            console.log("error , parece que es la consulta " + error);
          });
      }
    },

    //Listar tipificaciones
    listaTipificacion() {
      this.tipificacion = [];
      axios
        .post("listar-tipificaciones", {
          estado: 1,
        })
        .then((response) => {
          this.tipificacion = response.data;
        })
        .catch((error) => {
          console.log("error " + error);
        });
    },
    validFecha(){
      this.alert=false;
      if (this.id_tip==1 && this.fecha_agendamiento > this.minimo){
        this.mensajeAlert = "Ya existe una cita asignada y vigente.";
        this.typeAlert = "error";
        this.alert = true;
        this.colorMen = "#FF0033";
        console.log('Ya existe una cita asignada y vigente.')

      }else if (this.id_tip==2 && this.fecha_agendamiento==""){
        this.mensajeAlert = "No hay citas asignadas para el cliente. "+this.num_doc_persona;
        this.typeAlert = "error";
        this.alert = true;
        this.colorMen = "#FF0033";
        console.log('No hay citas asigandas.')
      }else{
        this.dialog = true
      }

    },
    agendarCita() {
          if (this.id_tip==2){
            this.fecha_agendamiento1=this.fecha_agendamiento
            
          }
          if(this.fecha_agendamiento1==null){
            this.mens='Seleccione una fecha en el calendario.'
            this.advertencia=true;
        }else{
          this.formulariogestion = 0;
          /* this.dialog = false; */

          //Mensaje de confirmación
          this.alert = true;
          this.colorMen = "#008000";
          
        //Petición para guardar los el registro en la base de datos
        axios.post('actualizar-master',{

              idmaster: this.idmaster,
              num_doc_persona: this.num_doc_persona,
              nombre_persona: this.nombre_persona,
              apellido_persona: this.apellido_persona,
              correo_persona: this.correo_persona,
              ciudad_persona: this.ciudad_persona,
              tipo_doc_persona: this.tipo_doc_persona,
              telefono1_persona: this.telefono1_persona,
              telefono2_persona: this.telefono2_persona,
              direcc_residencia_persona: this.direcc_residencia_persona,
              barrio_persona: this.barrio_persona,
              fecha_agendamiento: this.fecha_agendamiento,
              hora_agendamiento: this.hora_agendamiento,
              tipificacion: this.id_tip,
              observ_persona: this.observ_persona,

        }).then((response)=>{
        
              if (this.id_tip == 1) {
                this.mensajeAlert =
                  "¡Cita Agendada con exito! Cliente: " + this.buscarValor;
              } else if (this.id_tip == 2) {
                this.mensajeAlert =
                  "¡Cita Cancelada con exito! Cliente: " + this.buscarValor;
              }
        })
        //Fin Pettición para guardar el registro en la base de datos

        }
      },
     
      
    //Limpiar los datos del cliente cuando se realiza una nueva busqueda
    limpiarDatos() {
      
      this.formulariogestion = 0;
      this.infoPersona = 0,
      this.arrayDataPersona = [];
      this.arrayDataTipoId = [];
      this.arrayDataMunicipios = [];
      this.arrayGestion = [];

      this.tipificacion = [];
      this.sub_tipificacion = [];
      this.id_tip = 0;

      //Para Alerta
      this.alert = false;
      this.mensajeAlert = [];
      this.typeAlert = "";
      this.colorMen = "";

      //Para el panel de expansión
      this.panel = [0, 1];
      this.disabled = true;
      this.advertencia=false;

      //gestión hora y fecha agendamiento
      this.fecha_agendamiento = "";
      this.fecha_agendamiento1 = null;
      this.hora_agendamiento = "";
      this.hora_agendamiento1 = "";
      this.dialog=false,
      this.mens="",

      //Variables para el formaulario
      this.idmaster= 0;
      this.num_doc_persona= "";
      this.nombre_persona= "";
      this.apellido_persona= "";
      this.correo_persona= "";
      this.ciudad_persona= 0;
      this.municipio= "";
      this.tipo_doc_persona= 0,
      this.tip_doc= "";
      this.telefono1_persona= "";
      this.telefono2_persona= "";
      this.direcc_residencia_persona= "";
      this.barrio_persona = "";
      this.observ_persona = "";
    },

    //Validador del formulario agendamiento
    validateAsync:function(ref) {
      return new Promise((resolve, reject) => {
          if(!this.$refs[ref].validate()){ 
            reject(this.mens)
          }else{
            resolve(true)
          }
      })
      },

  },
  computed:{
    
    color(){
      return{
        'bg-danger' : this.agendamiento_semana <= 10,
        'bg-warning' : this.agendamiento_semana > 10 && this.agendamiento_semana < 20,
        'bg-success' : this.agendamiento_semana >= 20
      }
    },
    
  },

  mounted() {},
};
</script>
