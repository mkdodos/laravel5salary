
<div id="app" class="container">
    <table id="myTable" class="display">
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
    </table>
</div>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>
