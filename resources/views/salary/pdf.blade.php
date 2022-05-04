  <script src="{{asset('js/jspdf.min.js')}}"></script>
  <script src="{{asset('js/msjhbd-normal.js')}}"></script>
  <script src="{{asset('js/jspdf.plugin.autotable.js')}}"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

  <script>
    // var doc = new jsPDF(orientation, unit);
    var doc = new jsPDF('p', 'mm');
    // 字型       
    doc.addFileToVFS("name-for-addFont-use", font);
    doc.addFont('name-for-addFont-use', 'name-for-setFont-use', 'normal');
    doc.setFont('name-for-setFont-use');
    doc.setFontSize(20);

    // 第一欄標題   
    // doc.text("資產 ", 30, 20);


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
      }
    ];    

    axios.get('index/data', {
      params: {
        y: 2022,
        m: 8
      }
    }).then((res) => {
      let rows = res.data
      console.log(res.data)
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
          doc.text("薪資報表", 20, 20);
        }
      });

      doc.save("a4.pdf");
    })
  </script>