  <script src="{{asset('js/jspdf.min.js')}}"></script>
  <script src="{{asset('js/msjhbd-normal.js')}}"></script>

  <script>
      var doc = new jsPDF('p', 'pt');
      // 字型       
      doc.addFileToVFS("name-for-addFont-use", font);
      doc.addFont('name-for-addFont-use', 'name-for-setFont-use', 'normal');
      doc.setFont('name-for-setFont-use');
      doc.setFontSize(20);

      // 第一欄標題
      // doc.text("文字", x, y);
      doc.text("資產 ", 100, 200);
      doc.save("a4.pdf");
  </script>