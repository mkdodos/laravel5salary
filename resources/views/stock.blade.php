<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<div id="app" class="container">





<!-- https://ithelp.ithome.com.tw/articles/10198927 -->
<!-- <select  v-model="no">
    <option :value="option.id" v-for="option in options">
        ${ option.text }
    </option>
</select> -->


    <!-- <input type="text" v-model="no"></input>
    <input type="date" v-model="dnum"></input> -->
    
<!-- ${ dnum.replace(/-/g, "") } -->


<div class="card" style="width: 18rem;">
<v-select v-model="selected"
          :options="books" 
          label="text"
        ></v-select>


        <v-select v-model="selected"
          :options="books" 
          label="id"
        ></v-select>
        <div class="card-body">
        <button v-on:click="send">send</button>
        </div>
    </div>




    <div class="card" style="width: 18rem;">
        <canvas id="myChart" width="40" height="40"></canvas>
        <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
    </div>

    

</div>




<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>


<script src="https://unpkg.com/vue-select@3.0.0"></script>
<link rel="stylesheet" href="https://unpkg.com/vue-select@3.0.0/dist/vue-select.css">  

  



<script>
  
  Vue.component("v-select", VueSelect.VueSelect);

    var today = new Date();
    today = today.toISOString().substring(0, 10);
    // console.log(today)


    function addData(chart, label, data, title) {
        // chart.data.labels.push(label);
        chart.data.labels = label;
        // chart.data.datasets.forEach((dataset) => {
        //     dataset.data.push(data);
        // });
        console.log(chart.data.datasets[0].data)
        chart.data.datasets[0].data = data;

        chart.data.datasets[0].label = title;
        // console.log(data);
        chart.update();
    }

    function removeData(chart) {
        chart.data.labels.pop();
        chart.data.datasets.forEach((dataset) => {
            dataset.data.pop();
        });
        chart.update();
    }

    var app = new Vue({
        el: '#app',
        data: {
            no:2330,
            dnum: today,
            qdate: '',
            options: [],
            selectName : '',
            selected: '',
            books: [
                { id: 1, text:"Old Man's War" },
                { id: 2330,  text:"台積電" },
                { id: 2412, text:"中華電" }
            ],
        },
        delimiters: ['${', '}'],
        mounted(){
            axios.get('stock', {

            }).then((res) => {
                this.options = res.data
                this.books = res.data
                console.log(res.data);
               
            })

           
        },
        methods: {
            getstock() {
                alert('dd');
            },
            send() {
                let rows=[]
                let labels = [];
                qdate=this.dnum.replace(/-/g, "")
                axios.get('guz', {
                //    傳股票代碼和日期到後端取資料
                        params: {
                            // no: this.no,
                            no: this.selected.id,
                            qdate: qdate
                        }
                    })
                    //設定 chart.js 的資料
                    .then(function(response) {
                       
                        let d = response.data.data;
                        // console.log(d);
                        for (i = 0; i < d.length; i++) {
                            rows.push(d[i][6] * 1);                            
                            labels.push(i);
                            
                        }

                        console.log(labels)
                        addData(myChart, labels, rows, response.data.title)
                        // console.log(rows);
                    })
                    .catch(function(error) {
                        console.log(error);
                    })
                    .then(function() {
                        // always executed
                    });
                const data2 = [90, 10, 5, 2, 20, 30, 15];
               
                // removeData(myChart, labels, data)
            }
        }
    })

    
   
    const data = {
        labels: [],
        datasets: [{
            label: 'My First dataset',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            // data: [0, 10, 5, 2, 20, 30, 45],
            data: [],
        }]
    };

    const config = {
        type: 'line',
        data: data,
        options: {}
    };


    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>