@extends("app")


@section("content")
<div id="app">
  <v-app>
    <v-main>
      <v-container>
        <v-text-field v-model="search"></v-text-field>
        <v-data-table :items="rows" :headers="headers" :search="search" :loading="loading">
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
    delimiters: ['${', '}'],
    data: {
      search: '',
      loading: false,
      rows: [],
      headers: [{
          text: 'ID',
          value: 'id'
        },
        {
          text: '日期',
          value: 'date'
        },
        {
          text: '品名',
          value: 'name'
        },
        {
          text: '金額',
          value: 'amt'
        },
        {
          text: '數量',
          value: 'qty'
        }
      ]

    },
    mounted() {
      this.loading = true
      axios.get('expense/data', {
        // params: {
        //   name: '頂針'
        // }
      }).then((res) => {
        // json 字串用""括起,如果內容有"符號,會出問題
        // 要加 \ 跳脫
        let text = "鋼質傘型頂針 5\"*MT4";

        let position = text.search("Blue");
        // console.log(position)
        console.log(res.data)
        this.rows = res.data
        this.loading = false
      })
    },
    methods: {

    },
  })
</script>
@endsection