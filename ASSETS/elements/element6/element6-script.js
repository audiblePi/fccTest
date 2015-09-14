        var question_id = [];
        var questions = [];
        var answer_one = [];
        var answer_two = [];
        var answer_three = [];
        var answer_four = [];
        var correct_answer = [];
        var real_answers = [];
        $(document).ready(function(){
          window.alert('remove');
          $('span').remove();
        });
        function analyze(){
          
          //$('td').css('white-space', 'nowrap');
          $( "td" ).each(function( index ) {
            //console.log( index + ":" + $( this ).text() );
            //console.log( $( this ).text().slice(1,3) );
            if ($(this).text().slice(0,1) == '6' ){
              question_id.push($(this).text());
              //console.log(">>>>>"+$(this).text());
              //console.log($(this).parent().next().next().first().text());
              questions.push($(this).parent().next().next().first().text());
              correct_answer.push($(this).parent().next().first().text());
            }
            if ($(this).text().slice(0,2) == '3-'){
              questions.push($(this).text());
              //console.log($(this).text().slice(0,7));
            }
            if ($( this ).text().slice(0,2) == 'A.'){
              answer_one.push($(this).text());
              //console.log($(this).text());
            }
            if ($( this ).text().slice(0,2) == 'B.'){
              answer_two.push($(this).text());
              //console.log($(this).text());
            }
            if ($( this ).text().slice(0,2) == 'C.'){
              answer_three.push($(this).text());
              //console.log($(this).text());
            }
            if ($( this ).text().slice(0,2) == 'D.'){
              answer_four.push($(this).text());
              //console.log($(this).text());
            }
            if ($( this ).text() == ('A' || 'B' || 'C' || 'D')){
              //correct_answer.push($(this).text());
              //console.log($(this).text());
            }

          });

          console.log("Question ID's: " + question_id.length);
          $.each(question_id, function( index, value ) {
              //index++;
              //console.log(index + ": " + value);
          });

          console.log("Questions: " + questions.length);
          $.each(questions, function( index, value ) {
              console.log(value);
          });

          console.log("Answer_one: " + answer_one.length);
          $.each(answer_one, function( index, value ) {
            //index++;
                //console.log(index + ": " + value);
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
                //console.log(value);
              //}
              // if (value.indexOf("A") > 6){
              //   console.log('yes ' + value.indexOf("A"));
              // }
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
              
              var td = $("<td>"+question_id[i]+"</td>"+
                        "<td>"+questions[i]+"</td>"+
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