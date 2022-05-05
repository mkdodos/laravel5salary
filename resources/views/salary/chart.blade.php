@extends('app')
@section('content')
<div class="container">


    <div class="row">
        <div class="col-sm">
            <canvas id="myChart"></canvas>

        </div>
        <!-- <div class="col-sm">
            One of three columns
        </div> -->
       
    </div>

</div>

@endsection

@section('footer')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>

<script>
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        // 圖表類型
        type: 'bar',
        data: {
            // 標籤
            labels: ['夏', '秋'],
            // 資料集
            datasets: [

                // 各組資料    
                {
                    data: ['3', '4'],
                    label: '本薪',
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                       
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                       
                    ],
                    borderWidth: 1
                },

            ]
        }
    })
    axios.get('index/data',{params:{
        y:2022,m:8
    }}).then((res)=>{
        // {id: '7869', name: '馬志賢', basic: '35400', y: '2022', m: '8'}
        let data = res.data.map((row)=>row.basic);
        let labels = res.data.map((row)=>row.name);
        myChart.data.labels = labels;
        myChart.data.datasets[0].data = data;
        myChart.update();
        // console.log(rows)
    })
    
</script>
@endsection