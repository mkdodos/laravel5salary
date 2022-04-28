@extends('app')
@section('content')
<div id="app" class="container">
    <table class="display" id="table_id">
        <thead>
            <tr>
            <th>年</th>
            <th>月</th>
            <th>姓名</th>
                <th>本薪</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="row in rows">
            <td>${ row.y }</td>
            <td>${ row.m }</td>    
            <td>${ row.name }</td>
                <td>${ row.basic }</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
@section('footer')
<script>
    var app = new Vue({
        el: '#app',
        data: {
            rows: []
        },
        delimiters: ['${', '}'],
        created() {
            axios.get('index/data', {}).then((res) => {               
                this.rows = res.data
                this.$nextTick(function() {
                    $('#table_id').DataTable();
                });


            })
        }
    })
</script>
@endsection