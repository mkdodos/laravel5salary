@extends('app')
@section('content')
<div id="app" class="container">
    <table class="display" id="table_id">
        <thead>
            <tr>
                <th>name</th>
                <th>basic</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="row in rows">
                <td>${ row.name }</td>
                <td>${ row.basic }</td>
            </tr>
        </tbody>
    </table>



</div>
@endsection
@section('footer')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>

<script>
    var app = new Vue({
        el: '#app',
        data: {
            rows: []
        },
        delimiters: ['${', '}'],
        created() {
            axios.get('basic/data', {}).then((res) => {
                console.log(res.data);
                this.rows = res.data
                this.$nextTick(function() {
                    $('#table_id').DataTable();
                });


            })
        }
    })
</script>
@endsection