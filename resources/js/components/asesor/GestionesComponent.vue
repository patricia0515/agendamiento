<template>

  <v-data-table
    :headers="headers"
    :items="desserts"
    :items-per-page="10"
    class="elevation-1"
  >

  </v-data-table>
  
</template>

<script>
  export default {
    data: () => ({
        agendamiento_semana:0,
        agendamiento_dia:0,
        lunes:"",
        domingo:"",
              
        headers: [
            {
                text: 'Historico',
                align: 'start',
                sortable: false,
                value: 'id',
            },

                { text: 'Identificación', value: 'documento' },
                { text: 'Nombre', value: 'full_name' },
                { text: 'Tipificación', value: 'tip' },
                { text: 'Telefono', value: 'telefono' },
                { text: 'Fecha Gestionado', value: 'fecha_gestionado'},
                
            ],
        desserts: [],
      
    }),
    created () {
        this.getItems();
    },
    methods: {
        getItems() {
        axios.get("gestiones").then(response => {
          this.desserts = response.data[0];
          this.agendamiento_semana = response.data[1];
          this.agendamiento_dia = response.data[2];
          this.lunes=response.data[3];
          this.domingo=response.data[4];

           console.log(this.agendamiento_semana);
           console.log(this.agendamiento_dia);
           console.log('RANGO DE SEMANA')
           console.log(this.lunes)
           console.log(this.domingo)
            });
        },
  }
  }
</script>