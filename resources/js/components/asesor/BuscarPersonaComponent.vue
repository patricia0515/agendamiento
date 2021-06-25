<template>
  <v-container>
    <v-card style="width: 175px; height: 30px">
      <a class="form-group col-md-12 btn" href="">Nueva Gestión</a>
    </v-card>
    <br />
    <v-card style="width: 175px; height: 30px">
      <a class="form-group col-md-12 btn" href="">Gestiones</a>
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
                      >Buscar</v-btn
                    >
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
    <template v-if="formulariogestion == 1">
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
                  v-model="id_tip"
                  :items="tipificacion"
                  item-text="detalle"
                  item-value="idtipificacion"
                  label="Tipificación"
                  outlined
                  @change="(dialog = true), (alert = false)"
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
                                        return-object
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
                                      solo
                                      name="input-7-4"
                                      label="Comentario"
                                    ></v-textarea>
                                  </v-col>
                                </v-row>
                              </v-form>
                                
                              </tab-content>
                              
                              <tab-content
                              title ="Verificación"
                              @on-validate="agendarCita"
                              >
                                <div>
                                      <p class="font-weight-black text-subtitle-2 text-center error--text text--darken-2" >
                                        {{ mens }}
                                      </p>
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
  </v-container>
</template>

<script>
export default {
  data: () => ({
    nombreAsesor: "",
    formulariogestion: 0,
    infoPersona: 0,
    buscarValor: "",
    arrayDataPersona: [],
    arrayDataTipoId: [],
    arrayDataMunicipios: [],
    arrayGestion: [],

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
  methods: {
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
              this.fecha_agendamiento = this.arrayDataPersona[0].fecha_agendamiento;
              this.direcc_residencia_persona = this.arrayDataPersona[0].direcc_residencia_persona;
              this.barrio_persona = this.arrayDataPersona[0].barrio_persona;

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

    agendarCita() {

      if(this.fecha_agendamiento1==null){
        this.mens='Seleccione una fecha en el calendario.'
      }else{
      
        this.formulariogestion = 0;
        this.dialog = false;

        //Mensaje de confirmación
        this.alert = true;
        this.colorMen = "#008000";
        console.log('Datos del agendamiento.')
        console.log(this.fecha_agendamiento)
        console.log(this.hora_agendamiento)
        console.log(this.nombre_persona +' '+this.apellido_persona)
        if (this.id_tip == 1) {
          this.mensajeAlert =
            "¡Cita Agendada con exito! Cliente: " + this.buscarValor;
        } else if (this.id_tip == 2) {
          this.mensajeAlert =
            "¡Cita Cancelada con exito! Cliente: " + this.buscarValor;
        }
      }
      },
      /* axios.post("actualizar-master", {
            'idmaster': this.idmaster,
            'num_doc_persona': this.num_doc_persona,
            'nombre_persona': this.nombre_persona,
            'apellido_persona': this.apellido_persona,
            'correo_persona': this.correo_persona,
            'ciudad_persona': this.ciudad_persona,
            'tipo_doc_persona': this.tipo_doc_persona,
            'telefono1_persona': this.telefono1_persona,
            'telefono2_persona': this.telefono2_persona,
            'fecha_agendamiento': this.fecha_agendamiento,
            'direcc_residencia_persona': this.direcc_residencia_persona,
            'barrio_persona': this.barrio_persona,
            'fecha_agendamiento': this.fecha_agendamiento,
            'hora_agendamiento': this.hora_agendamiento,
            'tipificacion': this.tipificacion,
            'sub_tipificacion': this.sub_tipificacion,
            'observ_persona': this.observ_persona,
          })
          .then(function (response) {
            if (response.status == 210) {
              this.arrayMensaje.push(
                "No hay información para guardar, si no desea continuar haga click sobre el botón Cancelar."
              );

              this.banMensaje = true;
              this.colorMensaje = "error";
            } else {
              this.formulariogestion = 0;
              this.mensajeAlert =
                "Datos actualizados satisfactoriamente. Cliente: " +
                this.buscarValor;
              this.colorMen = "#008000";
              this.alert = true;

              this.buscarValor = "";
            }
          })
          .catch(function (error) {});
      } */

      
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

      //gestión hora y fecha agendamiento
      this.fecha_agendamiento = "";
      this.fecha_agendamiento1 = null;
      this.hora_agendamiento = "";
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
      this.barrio_persona= "";
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

  mounted() {},
};
</script>
<style>