@extends('app')
@section('content')
<div id="app">
    <v-app>
        <v-container>
            <!-- 查詢項 -->
            <v-row class="mb-6">
                <v-col class="text-right">
                    <v-autocomplete label="姓名" v-model="searchEmp" :items="empData" return-object item-text="name" item-value="name">
                    </v-autocomplete>
                </v-col>
                <v-col class="text-right">
                    <v-text-field label="年" v-model="transData.y" type="number"></v-text-field>
                </v-col>
                <v-col class="text-right">
                    <v-text-field label="月" v-model="transData.m" type="number"></v-text-field>
                </v-col>
                <v-col>
                    <v-btn class="success" @click="filterRow">查詢</v-btn>
                </v-col>
                <v-col>
                    <v-btn outlined color="indigo" @click="pdf">
                        PDF
                        <!-- <a href="{{ url('/salary/pdf') }}">PDF</a> -->
                    </v-btn>
                </v-col>
                <v-col>
                    <v-btn dark @click="trans">轉薪資</v-btn>
                </v-col>
            </v-row>

            <!-- 資料表格 -->
            <v-row>
                <v-col>
                    <v-data-table :headers="headers" :items="rows" :items-per-page="10" class="elevation-1">
                        <template v-slot:item.del={item}>
                            <v-btn @click="deleteRow(item)">${item.id}</v-btn>
                        </template>
                        <template v-slot:item.edit={item}>
                            <v-btn @click="editRow(item)">編輯</v-btn>
                        </template>
                    </v-data-table>
                </v-col>
            </v-row>

            <!-- 編輯項 -->
            <v-dialog v-model="dialog" width="500">
                <v-card>
                    <v-card-title class="text-h5">編輯</v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col>
                                <v-text-field label="本薪" v-model="editItem.basic"></v-text-field>
                            </v-col>
                            <v-col>
                                <v-text-field label="職務加給" v-model="editItem.job"></v-text-field>
                            </v-col>
                            <v-col>
                                <v-text-field label="技術加給" v-model="editItem.tech"></v-text-field>
                            </v-col>
                        </v-row>
                        <v-btn class="primary" @click="save">儲存</v-btn>
                    </v-card-text>
                </v-card>
            </v-dialog>

        </v-container>
    </v-app>

</div>
@endsection

@section('footer')
<script src="{{asset('js/jspdf.min.js')}}"></script>
<script src="{{asset('js/msjhbd-normal.js')}}"></script>
<script src="{{asset('js/jspdf.plugin.autotable.js')}}"></script>
<script>
    new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        delimiters: ['${', '}'],
        created() {
            axios.get('../emp/basic/data').then((res) => {
                this.empData = res.data;
                console.log(res.data)
            })
            this.filterRow()
        },
        methods: {
            save() {
                this.dialog = false;
                let url = 'update';
                let params = this.editItem
                axios.post(url, params).then((res) => {
                    Object.assign(this.rows[this.editIndex], this.editItem)
                })
            },
            editRow(item) {
                this.editIndex = this.rows.indexOf(item);
                this.editItem = Object.assign({}, item);
                this.dialog = true;
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
            trans() {
                let url = 'trans';
                let params = this.transData;
                axios.post(url, params).then((res) => {
                    this.filterRow()
                })
            },
            filterRow() {
                let url = 'index/data';
                let row = {};
                // 有輸入值才傳到後端處理               
                if (this.transData.y) row.y = this.transData.y;
                if (this.transData.m) row.m = this.transData.m;
                if (this.searchEmp !== null && this.searchEmp !== '') {
                    row.name = this.searchEmp.name
                };

                axios.get(url, {
                    params: row
                }).then(res => {
                    console.log(res)
                    //避免沒資料時出錯,沒資料時給空陣列
                    if (res.data) this.rows = res.data;
                    else this.rows = [];
                });
            },
            pdf() {
                var doc = new jsPDF('p', 'mm');
                // 字型       
                doc.addFileToVFS("name-for-addFont-use", font);
                doc.addFont('name-for-addFont-use', 'name-for-setFont-use', 'normal');
                doc.setFont('name-for-setFont-use');
                doc.setFontSize(20);

                doc.text(this.transData.y+'/'+this.transData.m+' 薪資報表', 30, 20);

                let rows = this.rows
                // {id: '7869', name: '馬志賢', basic: '35400'}
                // dataKey 對應 json 資料的 key
                var columns = [{
                        title: "ID",
                        dataKey: "id"
                    },
                    {
                        title: "姓名",
                        dataKey: "name"
                    },
                    {
                        title: "本薪",
                        dataKey: "basic"
                    },
                    {
                        title: "",
                        dataKey: "job"
                    },
                    {
                        title: "",
                        dataKey: "tech"
                    }
                ];
                doc.autoTable(columns, rows, {
                    styles: {
                        // 標題列有中文的話會亂碼,設定白色讓標題列看不見
                        fillColor: [255, 255, 255],
                        font: "name-for-setFont-use"
                    },
                    columnStyles: {
                        id: {
                            fillColor: 255
                        }
                    },
                    startY: 30,
                    margin: {
                        // top: 30
                    },
                    addPageContent: function(data) {
                        // doc.text("薪資報表", 20, 20);
                    }
                });

                doc.save("a4.pdf");
            }
        },
        data() {
            return {
                empData: [],
                searchEmp: '',
                editItem: {},
                dialog: false,
                transData: {
                    y: new Date().getFullYear(),
                    m: new Date().getMonth()
                },
                rows: [],
                headers: [{
                        text: '',
                        value: 'del'
                    },
                    {
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
                    {
                        text: '職務加給',
                        value: 'job'
                    },
                    {
                        text: '技術加給',
                        value: 'tech'
                    },
                    {
                        text: '',
                        value: 'edit'
                    },
                ],

            }
        },
    })
</script>
@endsection