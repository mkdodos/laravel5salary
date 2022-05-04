  <script src="{{asset('js/jspdf.min.js')}}"></script>
  <script src="{{asset('js/msjhbd-normal.js')}}"></script>

  <script>

// {
//  orientation: 'p',
//  unit: 'mm',
//  format: 'a4',
//  putOnlyUsedFonts:true
// }


// var doc = new jsPDF(orientation, unit);
      var doc = new jsPDF('p', 'mm');
      // 字型       
      doc.addFileToVFS("name-for-addFont-use", font);
      doc.addFont('name-for-addFont-use', 'name-for-setFont-use', 'normal');
      doc.setFont('name-for-setFont-use');
      doc.setFontSize(20);

      // 第一欄標題
      // doc.text("文字", x, y);
      doc.text("資產 ", 100, 200);


      
    //   doc.setDrawColor(0);
// 白色
      doc.setFillColor(255, 255, 255);
    //   rect(x, y, w, h, style)
    //   doc.rect(25, 10, 161, 246, 'FD'); //Fill and Border
    //   doc.setFontSize(8);
    //   doc.setFontType('normal');
    //   doc.text('hello', 42, 51);

      doc.save("a4.pdf");
  </script>