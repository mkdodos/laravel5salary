  <script src="{{asset('js/jspdf.min.js')}}"></script>
  <script src="{{asset('js/msjhbd-normal.js')}}"></script>
  <script src="{{asset('js/jspdf.plugin.autotable.js')}}"></script>

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


    // var columns = [
    //         { title: "ID", dataKey: "no" },
    //         { title: "Name", dataKey: "title" },
    //         { title: "Country", dataKey: "amt" },
    //     ];

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
        dataKey: "country"
      },

    ];


    var rows = [{
        "id": 1,
        "name": "馬克",
        "country": "Tanzania"
      },
      {
        "id": 2,
        "name": "Nelson",
        "country": "Kazakhstan"
      },
      {
        "id": 3,
        "name": "Garcia",
        "country": "Madagascar"
      },

    ];


    // doc.autoTable(columns, table_data, {
    //   styles: {
    //     fillColor: [255, 255, 255],
    //     font: "name-for-setFont-use",
    //     cellPadding: 3
    //   },
    //   startY: table_y + 10,
    //   margin: {
    //     left: 25
    //   },
    //   tableWidth: 200,
    //   createdCell: function(cell, data) {
    //     if (data.column.dataKey === 'amt') {
    //       cell.styles.halign = 'right';
    //     }
    //   },
    // });


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
  </script>