@extends("app")


@section("content")
<div id="app">
  <v-app>
    <v-main>
      <v-container>
        <v-text-field v-model="search"></v-text-field>
        <v-btn @click="query">查詢</v-btn>
        <v-data-table :items="rows" :headers="headers" :loading="loading">
          <template v-slot:item.price="{item}">
            ${trimZero(item.price)}
          </template>
          <template v-slot:item.date="{ item }">
            ${item.date.slice(0,10)}
          </template>
          <template v-slot:item.amt="{ item }">
            ${Math.round(item.price*item.qty)}
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
          value: 'price'
        },
        {
          text: '數量',
          value: 'qty'
        },
        {
          text: '小計',
          value: 'amt'
        },
        // {
        //   text: 'test',
        //   value: 'test'
        // }
      ]

    },
    mounted() {
      this.loading = true
      axios.get('expense/data').then((res) => {
        this.rows = res.data
        this.loading = false
      })
    },
    methods: {
      // 價格 xxx.0 去掉 .0
      trimZero(price) {
        let zeroAt = price.lastIndexOf("0");
        let len = price.length;
        if (zeroAt == len - 1)
          return price.slice(0, len - 2)
        else
          return price

      },
      query() {
        this.loading = true
        axios.get('expense/data', {
          params: {
            name: this.search
          }
        }).then((res) => {
          this.rows = res.data
          this.loading = false
        })
      }
    },
  })
</script>
@endsection