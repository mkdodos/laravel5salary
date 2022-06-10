@extends('app')
@section('content')
<div id="app" class="container">
  <v-app>
    <v-main>

      <v-row>
        <v-col></v-col>
        <v-col md="5">
          <v-card>
            <v-card-title class="blue-grey white--text mb-3">登入表單</v-card-title>
            <v-card-text>
              <v-select :items="rows" v-model="user" label="使用者" item-text="name" item-value="id" return-object></v-select>

              <v-text-field label="密碼" v-model="pwd" type="password"></v-text-field>
            </v-card-text>

            <v-card-actions>

              <!-- <v-btn text color="teal accent-4">
                登入
              </v-btn>
              <v-btn elevation="2"></v-btn> -->
              
              <v-col v-if="isLogin" class="red--text">
                
                  登入失敗
               
              </v-col>
              
              <v-col class="text-right">
                <v-btn depressed color="primary" @click="login">
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
      workerID: '',
      user: {},
      pwd: '',
      isLogin: false,

    },
    delimiters: ['${', '}'],
    created() {
      // 下拉選單包含姓名和工作人員編號
      // 姓名做為登入後顯示用,工作人員編號做為完工時記錄到排程完工表
      axios.get('worker/data', {}).then((res) => {
        console.log(res.data);
        this.rows = res.data
        // this.$nextTick(function() {
        //     $('#table_id').DataTable();
        // });
      })
    },
    methods: {
      // 姓名,密碼到後端做驗證
      login() {
        axios
          .post("worker/login", {
            name: this.user.name,
            pwd: this.pwd
          })
          .then((response) => {            
            console.log(response.data);
            if(response.data > 0)
            this.isLogin = false
            else
            this.isLogin = true
          })
        // if(this.user.name=='馬志賢' && this.pwd=='0304')
        // console.log('OK')
        // else
        // console.log('Fail')
        // console.log(this.user.id)
        // console.log(this.pwd)
      },
      deleteRow(item) {
        axios
          .post("destory", {
            id: item.id
          })
          .then((response) => {
            this.editedIndex = this.rows.indexOf(item);
            this.rows.splice(this.editedIndex, 1);
            console.log(response.data);
          })
      },

    }
  })
</script>
@endsection