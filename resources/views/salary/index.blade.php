@extends('app')

@section('content')
<div id="app">
    <v-app>

        <v-container>

            <v-row class="mb-6">
                <v-col class="text-right">
                    <v-text-field label="年" v-model="transData.y"></v-text-field>
                </v-col>
                <v-col class="text-right">
                    <v-text-field label="月" v-model="transData.m" type="number"></v-text-field>
                </v-col>
                <v-col>
                    <v-btn dark @click="trans">轉薪資</v-btn>
                </v-col>
                <v-col>
                    <v-btn class="success" @click="filterRow">查詢</v-btn>
                </v-col>
            </v-row>



            <v-row>
                <v-col>
                    <v-data-table :headers="headers" :items="rows" :items-per-page="10" class="elevation-1"></v-data-table>

                </v-col>

            </v-row>


        </v-container>

    </v-app>

</div>
@endsection

@section('footer')
<script>
    new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        delimiters: ['${', '}'],
        created() {

            axios.get('index/data', {}).then((res) => {
                this.rows = res.data
            })
        },
        methods: {
            trans() {
                let url = 'trans';
                let params = this.transData;
                axios.post(url, params).then((res) => {
                    axios.get('index/data', {}).then((res) => {
                        this.rows = res.data
                    })
                })
            },
            filterRow() {
                let url = 'index/data';
                let row = {};
                // 有輸入值才傳到後端處理
                if (this.transData.m) row.m = this.transData.m;
               
                axios.get(url, {
                    params: row
                }).then(res => {
                    //避免沒資料時出錯,沒資料時給空陣列
                    if (res.data) this.rows = res.data;
                    else this.rows = [];
                });
            },
        },
        data() {
            return {
                transData: {
                    y: '2022',
                    m: '6'
                },
                rows: [],
                headers: [{
                        text: '年',
                        value: 'y'
                    },
                    {
                        text: '月',
                        value: 'm'
                    },
                    {
                        text: '姓名',
                        align: 'start',
                        sortable: false,
                        value: 'name',
                    },
                    {
                        text: '本薪',
                        value: 'basic'
                    },
                ],

            }
        },
    })
</script>
@endsection