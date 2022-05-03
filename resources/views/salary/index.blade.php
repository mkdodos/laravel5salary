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
                <v-btn @click="trans">轉薪資</v-btn>
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
            }
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