<template v-if="gestiones==true">

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
        gestiones_semana:0,
        gestiones_dia:0,
              
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
          this.gestiones_semana = response.data[1];
          this.gestiones_dia = response.data[2];
           console.log(this.gestiones_semana);
           console.log(this.gestiones_dia);
            });
        },
  }
  }
</script>