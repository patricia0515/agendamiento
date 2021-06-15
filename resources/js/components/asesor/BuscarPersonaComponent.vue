<template>
  
    <v-container>
      
      <v-flex>
          <!-- Formulario consulta de persona -->
          <v-container>
              <div>
                <v-row>
                  <v-col cols="12" sm="2"></v-col>
                  <v-col
                    cols="12" sm="6" 
                  >
                    <v-text-field
                      v-model="buscarValor"
                      solo outlined  required maxlength="20"
                      label="Número de cédula"
                      clearable
                      @keypress="isNumber($event)"
                      @keyup.enter="buscarCliente()"
                      @paste.prevent
                    ></v-text-field>
                  </v-col>

                  <v-col
                    cols="12" sm="6" md="4"
                  >
                    <!-- aqui va el boton -->
                    <v-btn
                      color="primary"
                      elevation="9"
                      large
                      @click="buscarCliente()"
                      >Buscar</v-btn>
                  </v-col>
                </v-row>
                <v-row>
                  <template>
                  <!-- Inicio de Mensaje de Alerta   -->
                        <v-flex>
                          <div>
                            <v-alert
                              v-model="alert"
                              border="left"
                              close-text="Close Alert"
                              :type = "typeAlert"
                              colored-border
                              dismissible
                            >
                            <strong>{{ mensajeAlert }}</strong>
                            </v-alert>
                          </div>
                        </v-flex>
                  <!-- Fin de Mensaje de Alerta   -->
                  </template>
                </v-row>
              </div>
          </v-container>
      
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
                                <thead><tr><th class="text-left font-weight-black">Tipo de Documento</th><td>{{ tipo_doc_persona }}</td> </tr></thead>
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
                      <v-expansion-panel-content>
                    <!-- Select Tipificación -->
                        <template >
                            <v-select
                            v-model="id_tip"
                            :items="tipificacion"
                            item-text="detalle"
                            item-value="idtipificacion"
                            label="Tipificación"
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
                            max-width="600"
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
                                    <!-- Formulario -->
                                      <form-wizard 
                                      next-button-text="Siguiente"
                                      back-button-text="Anterior"
                                      finish-button-text="Guardar y Procesar"
                                      color='indigo'
                                      shape="circle"
                                      title=""
                                      subtitle=""
                                      >
                
                                           <tab-content 
                                           title="Información Personales">
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
                                                v-model="apellido_persona"
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
                                              <v-text-field
                                                v-model="tipo_doc_persona"
                                                label="Tipo de Documento (*)"
                                                outlined
                                              ></v-text-field>
                                            </v-col>

                                            <v-col
                                              cols="12"
                                              sm="6"
                                            >
                                              <v-text-field
                                                v-model="num_doc_persona"
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
                                                v-model="direcc_residencia_persona"
                                                label="Dirección Residencia (*)"
                                                outlined
                                              ></v-text-field>
                                            </v-col>

                                            <v-col
                                              cols="12"
                                              sm="6"
                                            >
                                              <v-text-field
                                                v-model="barrio_persona"
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
                                              <v-text-field
                                                v-model="ciudad_persona"
                                                label="Municipio (*)"
                                                outlined
                                              ></v-text-field>
                                            </v-col>

                                            <v-col
                                              cols="12"
                                              sm="6"
                                            >
                                              <v-text-field
                                                v-model="telefono1_persona"
                                                label="Teléfono 1 (*)"
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
                                                v-model="telefono2_persona"
                                                label="Teléfono 2 (*)"
                                                outlined
                                              ></v-text-field>
                                            </v-col>

                                            <v-col
                                              cols="12"
                                              sm="6"
                                            >
                                              <v-text-field
                                                v-model="correo_persona"
                                                label="Correo Eléctronico"
                                                outlined
                                              ></v-text-field>
                                            </v-col>
                                          </v-row>
                                          
                                        </tab-content>

                                        <tab-content title="Agendamiento">
                                            Segundo paso
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
        arrayGestion: [],

        //Variables para el formaulario
        idmaster: 0,
        num_doc_persona: '',
        nombre_persona: '',
        apellido_persona: '',
        correo_persona: '',
        ciudad_persona: '',
        tipo_doc_persona:'',
        telefono1_persona:'',
        telefono2_persona:'',
        fecha_agendamiento:'',
        direcc_residencia_persona:'',
        barrio_persona:'',
        

        //Variables para los mensajes de alerta
        alert:false,
        mensajeAlert:'',
        typeAlert:'',

        //Para el panel de expansión
        panel: [0, 1],
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
          this.arrayMensaje=[];
          this.limpiarDatos();
          this.arrayDataPersona = [];
          this.mensajeAlert='';

          if(!this.buscarValor){
          this.mensajeAlert='EL campo Cédula es requerido.';
          this.typeAlert='error';
          this.alert = true;
        }else{
          console.log(this.buscarValor)
          axios.post('consultaPersona',{
            'valor': this.buscarValor,
          }).then(response=>{
            this.arrayDataPersona = response.data;
            
            // dbtm.arrayGestionLog = response.data[3];
            if(response.status==210){
                console.log('LA CONSULTA NO TRAJO RESULTADOS')
              this.mensajeAlert="No se encontro cliente con el numero de cédula "+this.buscarValor+".";
              this.typeAlert='info';
              this.alert = true;
            }else{

                console.log('Tenemos un resultado con la consulta')
                console.log(this.arrayDataPersona)
              this.formulariogestion = 1;
              //Mensaje de alerta
              this.alert=true;
              this.typeAlert="success";
              this.mensajeAlert= '¡Bien hecho! Registro encontrado.';
              
              this.disabled= false,
              this.idmaster = this.arrayDataPersona[0].idmaster;
              this.num_doc_persona = this.arrayDataPersona[0].num_doc_persona;
              this.nombre_persona = this.arrayDataPersona[0].nombre_persona;
              this.apellido_persona = this.arrayDataPersona[0].apellido_persona;
              this.correo_persona = this.arrayDataPersona[0].correo_persona;
              this.ciudad_persona = this.arrayDataPersona[0].ciudad_persona;
              this.tipo_doc_persona  = this.arrayDataPersona[0].tipo_doc_persona;  
              this.telefono1_persona = this.arrayDataPersona[0].telefono1_persona; 
              this.telefono2_persona = this.arrayDataPersona[0].telefono2_persona;
              this.fecha_agendamiento= this.arrayDataPersona[0].fecha_agendamiento;
              this.direcc_residencia_persona= this.arrayDataPersona[0].direcc_residencia_persona;
              this.barrio_persona= this.arrayDataPersona[0].barrio_persona;
              this.listaTipificacion();
            }
          }).catch(error => {
                 console.log("error " + error);
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
     
        ////Limpiar los datos del cliente cuando se realiza una nueva busqueda
      limpiarDatos(){
        // let dbtm = this;
        this.idmaster = 0;
        this.formulariogestion = 0;
        this.arrayDataPersona = [];
        this.arrayGestion = [];
        
        this.tipificacion=[];
        this.sub_tipificacion= [];
        this.id_tip=0;

        //Para Alerta
        this.alert=false;
        this.mensajeAlert='';
        this.typeAlert='';
        //Para el panel de expansión
        this.panel= [0, 1];
        this.disabled = true;
      },
    },
    
    mounted() {

    }, 
        
}

</script>