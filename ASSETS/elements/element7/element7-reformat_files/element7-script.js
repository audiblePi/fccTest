        var questions = [];
        var answer_one = [];
        var answer_two = [];
        var answer_three = [];
        var answer_four = [];
        var correct_answer = [];
        var real_answer = [];

        // $(document).ready(function(){
        //   console.log('removing <span>\'s');
        //   $('span').remove();
        // });

        function analyze(){
          $( "td" ).each(function( index ) {
            //console.log( index + ":" + $( this ).text() );
            //console.log( $( this ).text().slice(1,3) );
            if (($(this).text().slice(1,2) == 'A'
              || $(this).text().slice(1,2) == 'B'
              || $(this).text().slice(2,3) == 'B' 
              || $(this).text().slice(2,3) == 'C' 
              || $(this).text().slice(2,3) == 'D' 
              || $(this).text().slice(2,3) == 'E' 
              || $(this).text().slice(2,3) == 'F' 
              || $(this).text().slice(2,3) == 'G'
              || $(this).text().slice(2,3) == 'H'
              || $(this).text().slice(2,3) == 'I'
              || $(this).text().slice(2,3) == 'J'
              || $(this).text().slice(2,4) == '0J') && ($(this).text().length > 10)){
              questions.push("7-"+$(this).text());
              //console.log($(this).text().length);
              //console.log(">>>>>>>>>" + $(this).text().slice(0,7));
            }
            if ($( this ).text().slice(0,2) == 'A.'){
              answer_one.push($(this).text());
              //console.log(">>>>>>>>>" + $(this).text().slice(0,2));
            }
            if ($( this ).text().slice(0,2) == 'B.'){
              answer_two.push($(this).text());
              //console.log($(this).text().slice(0,2));
            }
            if ($( this ).text().slice(0,2) == 'C.'){
              answer_three.push($(this).text());
              //console.log($(this).text());
            }
            if ($( this ).text().slice(0,2) == 'D.'){
              answer_four.push($(this).text());
              //console.log($(this).text().slice(0,2));
            }
            if ($( this ).text().indexOf("Answers:") >= 0){
              correct_answer.push($(this).text());
              $.each($(this).nextAll(), function( index, value ) {
                if($(this).text()){
                  //console.log($(this).text());
                  real_answer.push($(this).text());
                }
              });
            }
          });

          console.log("Questions: " + questions.length);
          $.each(questions, function( index, value ) {
              //console.log(value.slice(0,7));
          });

          console.log("Answer_one: " + answer_one.length);
          $.each(answer_one, function( index, value ) {
                //console.log(value);
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

          console.log("Real_answer: " + real_answer.length);
          $.each(real_answer, function( index, value ) {
              //console.log(index + ": " + value);
          });
          createNewTable();
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
                        "<td>"+real_answer[i]+"</td>");
              row.append(td);         
              table.append(row);
          }
         $('#fileDisplayArea').append(table);
        }