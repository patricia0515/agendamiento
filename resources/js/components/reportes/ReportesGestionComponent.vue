<template>
    <v-container>
        <v-card style="width: 175px; height: 30px;">
            <label for="reportes" class="form-group col-md-12 btn btn-primary ">Descarga de Reportes</label>
        </v-card>
        <hr>
        <div class="card">
                        <div class="card-header text-center bg bg-primary"><font color="white">Reporte Gestion</font></div>

                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="row">
                                    <div class="col-md-5">
                                        <input type="date" name="fecha_inicial" id="datepickerInicio" class="form-control" required="">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="date" name="fecha_final"  id="datepickerFin" class="form-control" required="">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="hidden" value="reporteGestion" name="opcionReporte">
                                        <input type="submit" id="btnfiltrar" class="btn btn-primary" value="Descargar">
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <hr>
                    <div class="card">
                        <div class="card-header text-center bg bg-primary"><font color="white">Histórico Agendamiento</font></div>

                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="row">
                                    <div class="col-md-5">
                                        <input type="date" name="fechaInicial" class="form-control" required="">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="date" name="fechaFinal" class="form-control" required="">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="hidden" value="reporteGestion" name="opcionReporte">
                                        <input type="submit" class="btn btn-primary" value="Descargar">
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
    </v-container>
</template>

<script>
  export default {
    data: () => ({
        nombreadmin: '',


        fechaInicial: new Date().toISOString().substr(0, 10),
        fechaFinal: new Date().toISOString().substr(0, 10),

       
        //Para la alerta
        banMensaje: false,
        arrayMensaje: [],
        colorMensaje: '',

        //Variable auxiliar
        exporRep: false,
        
    }),

    

    methods: {

      //Exportar a excel
      exportarExcel: function (event) {
        
        let dbtm = this;
        dbtm.arrayMensaje = [];
        dbtm.exporRep = true;

        if(dbtm.fechaInicial && dbtm.fechaFinal) {
          
          if(dbtm.fechaInicial > dbtm.fechaFinal) {
            dbtm.arrayMensaje.push("El campo Fecha Inicial debe ser menor o igual al campo Fecha Final.");
            dbtm.banMensaje = true;
            dbtm.colorMensaje = 'error';
            dbtm.exporRep = false;
            
          }else{
            
            axios({
                  url: 'reporteriaExcel',
                  method: "POST",
                  data: {
                    idReporte : dbtm.selectTipoReporte,
                    idTipificacion : dbtm.selectTipificacion,
                    idSubTipificacion : dbtm.selectSubTipificacion,
                    fechaInicial : dbtm.fechaInicial,
                    fechaFinal : dbtm.fechaFinal,
                  },
                  responseType: 'blob',
              })
              .then(response => {

                if(response.status == 200){
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'reporte.xlsx'); //or any other extension
                    document.body.appendChild(link);
                    link.click();
                }else if(response.status == 210){
                  dbtm.arrayMensaje.push("No existen registros para el reporte.");
                  dbtm.banMensaje = true;
                  dbtm.colorMensaje = 'info';
                }

                this.exporRep = false;
              })
              .catch(error => {
                  // console.log("error " + error);
              });

            dbtm.exporRep = false;

          }

        }else{
          dbtm.arrayMensaje.push("Los campos Fecha Inicial y Fecha Final, son obligatorios.");
          dbtm.banMensaje = true;
          dbtm.colorMensaje = 'error';
          dbtm.exporRep = false;
        }
        
      },

    },



    mounted() {
    },

  }
</script>
