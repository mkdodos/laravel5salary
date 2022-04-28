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