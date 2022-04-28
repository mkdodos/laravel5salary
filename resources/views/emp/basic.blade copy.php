@extends('app')

@section('content')
<div id="app" class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">員工基本資料</div>

                <div class="panel-body">

                    <h1>datatable介紹</h1>
                    <table class="table" id="table_id">
                        <thead>
                            <tr>
                                <th>name</th>
                                <th>basic</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                                <td>兆豐銀行</td>
                                <td>$300 產品（限量8萬名）<br>最高5千抽獎</td>
                                <td>期限綁定台灣Pay/信用卡，可享一次抽獎，最高獎金5千元(110/12/31前)</td>
                            </tr>
                            <!-- <tr v-for="row in rows">
                                <td>${ row.name }</td>
                                <td>${ row.basic }</td>
                            </tr> -->
                        </tbody>
                    </table>

                    <!-- <table id="table_id" class="display">
                        <thead>
                            <tr>
                                <th>信用卡公司</th>
                                <th>回饋 / 名額</th>
                                <th>五倍券優惠活動</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>兆豐銀行</td>
                                <td>$300 產品（限量8萬名）<br>最高5千抽獎</td>
                                <td>期限綁定台灣Pay/信用卡，可享一次抽獎，最高獎金5千元(110/12/31前)</td>
                            </tr>
                           
                            
                        </tbody>
                    </table> -->


                   
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
<script>

$(document).ready( function () {
    // $('#table_id').DataTable(); 
} );


     $('#table_id').DataTable();
    var app = new Vue({
        el: '#app',
        data: {
            rows: []
        },
        delimiters: ['${', '}'],
        mounted() {

            axios.get('basic/data', {}).then((res) => {
                console.log(res.data);
                this.rows = res.data
               

            })


        },
        created() {

        }
    })
</script>
@endsection