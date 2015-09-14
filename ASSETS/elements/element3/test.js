        var questions = [];
        var answer_one = [];
        var answer_two = [];
        var answer_three = [];
        var answer_four = [];
        var correct_answer = [];
        var real_answers = [];

        window.onload = function() {
            var fileInput = document.getElementById('fileInput');

            fileInput.addEventListener('change', function(e) {
                var file = fileInput.files[0];
                var textType = /htm.*/;

                if (file.type.match(textType)) {
                    var reader = new FileReader();
                    console.log(reader);

                    reader.onload = function(e) {
                      var table = $("<table />");
                      var rows = e.target.result.split("\n");
                      for (var i = 0; i < rows.length; i++) {
                          var row = $("<tr />");
                          var cells = rows[i].split("\n");
                          for (var j = 0; j < cells.length; j++) {
                              var cell = $("<td style='border:1px solid black'/>");
                              cell.html(cells[j]);
                              row.append(cell);
                          }
                          table.append(row);
                      }
                      $("#fileDisplayArea").html('');
                      $("#fileDisplayArea").append(table);
                    }
                    reader.readAsText(file);    
                } else {
                    fileDisplayArea.innerText = "File not supported!"
                }

                //analyze();
            });
        }

        function analyze(){
          $( "td" ).each(function( index ) {
            //console.log( index + ":" + $( this ).text() );
            //console.log( $( this ).text().slice(1,3) );
            if ($(this).text().slice(0,2) == '3-' && $(this).text().length > 11){
              questions.push($(this).text());
              //console.log($(this).text().slice(0,7));
            }
            if ($( this ).text().slice(1,2) == 'A'){
              answer_one.push($(this).text());
              //console.log($(this).text());
            }
            if ($( this ).text().slice(1,2) == 'B'){
              answer_two.push($(this).text());
              //console.log($(this).text());
            }
            if ($( this ).text().slice(1,2) == 'C'){
              answer_three.push($(this).text());
              //console.log($(this).text());
            }
            if ($( this ).text().slice(1,2) == 'D'){
              answer_four.push($(this).text());
              //console.log($(this).text());
            }
            if ($( this ).text().slice(0,3) == 'Ans'){
              correct_answer.push($(this).text());
              //console.log($(this).text());
            }

          });

          //console.log(i);
          console.log("Questions: " + questions.length);
          $.each(questions, function( index, value ) {
              //console.log(value);
          });

          console.log("Answer_one: " + answer_one.length);
          $.each(answer_one, function( index, value ) {
              //  console.log(value);
          });

          console.log("Answer_two: " + answer_two.length);
          $.each(answer_two, function( index, value ) {
              //console.log(value);
          });

          console.log("Answer_three: " + answer_three.length);
          $.each(answer_three, function( index, value ) {
              //console.log(value);
          });

          console.log("Answer_four: " + answer_four.length);
          $.each(answer_four, function( index, value ) {
              //console.log(value);
          });

          console.log("Correct_answer: " + correct_answer.length);
          $.each(correct_answer, function( index, value ) {
              //console.log(value);
              //if ($(this).text().slice(11,13) == '3-' && $(this).text().length > 11){
                //questions.push($(this).text());
                console.log(value);
              //}
              if (value.indexOf("A") > 6){
                console.log('yes ' + value.indexOf("A"));
              }
          });

          //createNewTable();

        }

        function createNewTable(){
          $('.old-table').remove();
          $('.controls').css("display", 'none');
          
          var i = 0;
          var table = $("<table />");
          for (i == 0; i < questions.length; i++){
              var row = $("<tr />");
              
              var td = $("<td>"+questions[i]+"</td>"+
                        "<td>"+answer_one[i]+"</td>"+
                        "<td>"+answer_two[i]+"</td>"+
                         "<td>"+answer_three[i]+"</td>"+
                        "<td>"+answer_four[i]+"</td>"+
                        "<td>"+correct_answer[i]+"</td>");
              // if (correct_answer[i]){
              //    td.append($("<td>"+correct_answer[i]+"</td>"));
              // }
              row.append(td);         
              table.append(row);
          }
         $('#fileDisplayArea').append(table);
        }