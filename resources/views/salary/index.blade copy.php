@extends('app')
@section('content')
<div id="app" class="container">
    <div v-if="isLoding">載入中...</div>
    <table v-if="!isLoding" class="display" id="table_id">
        <thead>
            <tr>
                <th>年</th>
                <th>月</th>
                <th>姓名</th>
                <th>本薪</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="row in rows" :key="row.id">
                <td>${ row.y }</td>
                <td>${ row.m }</td>
                <td>${ row.name }</td>
                <td>${ row.basic }</td>
                <td><button type="button" class="btn btn-link" @click="edit(row)">${ row.id }</button></td>
            </tr>
        </tbody>
    </table>

    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Launch demo modal
    </button> -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
<script>
    var app = new Vue({
        el: '#app',
        data: {
            rows: [],
            editIndex:-1,
            isLoding: true
        },
        delimiters: ['${', '}'],
        created() {
            axios.get('index/data', {}).then((res) => {
                this.rows = res.data
                console.log(this.rows)
                this.isLoding = false
                this.$nextTick(function() {
                    $('#table_id').DataTable();
                });
            })
        },
        methods: {
            edit(row) {
                this.editIndex = this.rows.indexOf(row);
                console.log(this.editIndex)
                Object.assign(this.rows[this.editIndex],{})
                // $('#exampleModal').modal()
                console.log(this.rows[this.editIndex])
            }
        }
    })
</script>
@endsection