@extends("app")


@section("content")
<div id="app">
    <v-app>
        <v-main>
            <v-container>
              <v-data-table :items="rows" :headers="headers">
                <template v-slot:item.date="{ item }">
                  ${item.date.slice(0,10)}
                </template>
              </v-data-table>
            </v-container>
        </v-main>
    </v-app>
</div>
@endsection


@section("footer")
<script>
    new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        delimiters:['${','}'],
        data: {
          rows: [],
          headers: [
            {text:'ID',value:'id'},
            {text:'日期',value:'date'},
            {text:'品名',value:'name'}
          ]

        },
        mounted() {
          axios.get('expense/data',{params:{
            name: '頂針'
          }}).then((res)=>{
            console.log(res.data)
            this.rows = res.data
          })
        },        
        methods: {

        },
    })
</script>
@endsection