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
                <td><button type="button" class="btn btn-link" @click="edit(row)">編輯</button></td>
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

                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">姓名</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" v-model="editItem.name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">本薪</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" v-model="editItem.basic">
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default">Sign in</button>
                            </div>
                        </div> -->
                    </form>



                    <!-- ${editItem} -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="save()">Save changes</button>
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
            editIndex: -1,
            editItem: {},
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
                // this.editItem = {};
                this.editIndex = this.rows.indexOf(row);
                this.editItem = Object.assign({}, row);
                // console.log(this.editIndex)
                // Object.assign(this.rows[this.editIndex],{'name':'mark'})
                $('#exampleModal').modal()
                // console.log(this.rows[this.editIndex])
            },
            save() {
                let url = 'update';
                let params = this.editItem
                axios.post(url,params).then((res)=>{
                    console.log(res.data)
                })
                
                
                Object.assign(this.rows[this.editIndex],this.editItem)
                $('#exampleModal').modal('hide')
               
            }
        }
    })
</script>
@endsection