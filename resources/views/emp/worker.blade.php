@extends('app')
@section('content')
<div id="app" class="container">
  <v-app>
    <v-main>

      <v-row>
        <v-col></v-col>
        <v-col>
          <v-card>
            <v-card-title>登入表單</v-card-title>
            <v-card-text>
              <v-select :items="rows" label="使用者" item-text="name" item-value="id" return-object></v-select>

              <v-text-field label="密碼" type="password"></v-text-field>
            </v-card-text>

            <v-card-actions>
              <!-- <v-btn text color="teal accent-4">
                登入
              </v-btn>
              <v-btn elevation="2"></v-btn> -->
              <v-col class="text-right">
              <v-btn depressed color="primary">
                登入
              </v-btn>
              </v-col>
            </v-card-actions>


          </v-card>

        </v-col>
        <v-col></v-col>

      </v-row>


      <!-- <v-simple-table>
        <template v-slot:default>
          <thead>
            <tr>
              <th class="text-left">
                Name
              </th>
              <th class="text-left">
                Calories
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in rows" :key="item.id">
              <td>${ item.id }</td>
              <td>${ item.name }</td>
            </tr>
          </tbody>
        </template>
      </v-simple-table> -->
    </v-main>
  </v-app>
</div>
@endsection
@section('footer')
<script>
  var app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    data: {
      rows: [],
      workerID: ''
    },
    delimiters: ['${', '}'],
    created() {
      axios.get('worker/data', {}).then((res) => {
        console.log(res.data);
        this.rows = res.data
        // this.$nextTick(function() {
        //     $('#table_id').DataTable();
        // });
      })
    }
  })
</script>
@endsection