jQuery(function($){
	var user_id;
    var exam_id = 0;
    var element_id;
    var subtopics;
    var current_question_index = 0;
    var exam_length = 0;
    var correct = 0;
    var incorrect = 0;
    var skipped = 0;
    var num_answered = 0;
    var current_score = 0;
    var show_numbers;
    var show_answers;
    var simulated;
    var weak_areas;
    var date;
    var start_time;
    var questions = [];
    var status = -1;
    var missed_retake = 0;
    var resume = 0;
    var prev_time = 0;
    var seen;
    var percent_progress = num_answered / exam_length;

    $( "#dialog" ).dialog({ modal: true, show: { effect: "fadeIn", duration: 200 }, autoOpen:false });
    $('.ui-dialog-titlebar').css('display', 'none');

    $('.simulated').change(function(){ 
        var value = $(this).val();
        if (value == '1'){
            $('.study-mode-options').css('display', 'none');
            
            //reset defaults for simulated mode
            $('.settings-option .subtopic').val('All');
            $('.settings-option .show-numbers').val('0');
            $('.settings-option .show-answers').val('0');
            $('.settings-option .weak-areas').val('0');
        }
        if (value == '0'){
            $('.study-mode-options').css('display', 'block');
            $('.subtopic').css('display', 'none');
            $('.E1.subtopic').css('display', 'block');
            $('.settings-option .element-id').val('E1');
        }
    });

    $('.quick-50').change(function(){ 
        var value = $(this).val();
        if (value == '1'){
            //turn subtopics off
            $('.subtopic input').attr('disabled', true);
            $('.subtopics-wrapper').css('opacity', '.5');
        }
        if (value == '0'){
            //turn subtopics on
            $('.subtopic input').attr('disabled', false);
            $('.subtopics-wrapper').css('opacity', '1');
        }
    });

    $('.element-id').change(function(){ 
        var value = $(this).val();
        switch(value){
            case "E1":
                $('.E1.subtopic').css('display', 'block');
                $('.E3.subtopic').css('display', 'none');
                $('.E6.subtopic').css('display', 'none');
                $('.E7.subtopic').css('display', 'none');
                $('.E7R.subtopic').css('display', 'none');
                $('.E8.subtopic').css('display', 'none');
                $('.E9.subtopic').css('display', 'none');
                break;
            case "E3":
                $('.E1.subtopic').css('display', 'none');
                $('.E3.subtopic').css('display', 'block');
                $('.E6.subtopic').css('display', 'none');
                $('.E7.subtopic').css('display', 'none');
                $('.E7R.subtopic').css('display', 'none');
                $('.E8.subtopic').css('display', 'none');
                $('.E9.subtopic').css('display', 'none');                
                break;
            case "E6":
                $('.E1.subtopic').css('display', 'none');
                $('.E3.subtopic').css('display', 'none');
                $('.E6.subtopic').css('display', 'block');
                $('.E7.subtopic').css('display', 'none');
                $('.E7R.subtopic').css('display', 'none');
                $('.E8.subtopic').css('display', 'none');
                $('.E9.subtopic').css('display', 'none');                
                break;
            case "E7":
                $('.E1.subtopic').css('display', 'none');
                $('.E3.subtopic').css('display', 'none');
                $('.E6.subtopic').css('display', 'none');
                $('.E7.subtopic').css('display', 'block');
                $('.E7R.subtopic').css('display', 'none');
                $('.E8.subtopic').css('display', 'none');
                $('.E9.subtopic').css('display', 'none');                
                break;
            case "E7R":
                $('.E1.subtopic').css('display', 'none');
                $('.E3.subtopic').css('display', 'none');
                $('.E6.subtopic').css('display', 'none');
                $('.E7.subtopic').css('display', 'none');
                $('.E7R.subtopic').css('display', 'block');
                $('.E8.subtopic').css('display', 'none');
                $('.E9.subtopic').css('display', 'none');                
                break;
            case "E8":
                $('.E1.subtopic').css('display', 'none');
                $('.E3.subtopic').css('display', 'none');
                $('.E6.subtopic').css('display', 'none');
                $('.E7.subtopic').css('display', 'none');
                $('.E7R.subtopic').css('display', 'none');
                $('.E8.subtopic').css('display', 'block');
                $('.E9.subtopic').css('display', 'none');                
                break;    
            case "E9":
                $('.E1.subtopic').css('display', 'none');
                $('.E3.subtopic').css('display', 'none');
                $('.E6.subtopic').css('display', 'none');
                $('.E7.subtopic').css('display', 'none');
                $('.E7R.subtopic').css('display', 'none');
                $('.E8.subtopic').css('display', 'none');
                $('.E9.subtopic').css('display', 'block');                
                break; 
            default: 
                $('.E1.subtopic').css('display', 'block');
                $('.E3.subtopic').css('display', 'none');
                $('.E6.subtopic').css('display', 'none');
                $('.E7.subtopic').css('display', 'none');
                $('.E7R.subtopic').css('display', 'none');
                $('.E8.subtopic').css('display', 'none');
                $('.E9.subtopic').css('display', 'none');
        }
    });
    
    $(document).on("change",".subtopic .all",function(e){
        e.preventDefault();
        $('.subtopics-wrapper').css('border', '2px solid white');
        if(!this.checked)
            $(this).parent().parent().find(':checkbox').each(function () { $(this).prop('checked', false); });
        else
            $(this).parent().parent().find(':checkbox').each(function () { $(this).prop('checked', true); });
    });

    $(document).on("change",".subtopic input",function(e){
        e.preventDefault();
        $('.subtopics-wrapper').css('border', '2px solid white');
        if(!$(this).hasClass('all')){
            if($(this).parent().parent().find('.all').is(':checked') ){
                $(this).parent().parent().find(':checkbox').each(function () { $(this).prop('checked', false); });
                $(this).prop('checked', true);
            }
            else if ($(this).is(':checked'))
                 $(this).prop('checked', true);
            else if (!$(this).is(':checked'))
                 $(this).prop('checked', false);
            $(this).parent().parent().find('.all').prop('checked', false);
        }
    });

    $(document).on("click",".exam-start",function(e){
        e.preventDefault();	
        resetData();
        $('.exam-container').css('display', 'none');
        $('.exam-container').empty();
        if (validates())
            startExam();
        else
            $('.subtopics-wrapper').css('border', '2px solid red');
    });

    $(document).on("click",".resume-no",function(e){
        e.preventDefault();
        $('#dialog').dialog('close');
        dontResume($('#dialog .hidden-id').html());
    });

    $(document).on("click",".resume-exam",function(e){
        e.preventDefault();
        $('#dialog').dialog('close');
        resume = 1;
        $('.exam-container').css('display', 'none');
        $('.exam-container').empty();
        startExam();
    });

    $(document).on("click",".retake",function(e){
        e.preventDefault(); 
        resetData();
        missed_retake = 1;
        $('.exam-container').css('display', 'none');
        $('.exam-container').empty();
        startExam();
    });

    $(document).on("click",".question-container .question .answer-box",function(e){
        $(this).children().children('input').prop('checked', true);
        if(show_answers == "1"){
            showAnswer($(this));
            $('.exam-controls .next-question').attr('disabled', false);
            $('.question-container .question.' + current_question_index).css('pointer-events', 'none');
        }
        else{
            if(checkAnswer()==1)
                updateScore('right');  
            else if (checkAnswer() == 0)
                updateScore('wrong');
            else
                updateScore('skipped');
            proceed();
        }
    });

    $(document).on("click",".exam-container .next-question",function(e){
        if(checkAnswer()==1)
            updateScore('right');  
        else if (checkAnswer() == 0)
            updateScore('wrong');
        else
            updateScore('skipped');
        proceed();
    });

    function startExam(){
        // console.log('startExam()');
        openExam();
        var quick_50 = $('.quick-50').val();
        user_id = $('.hidden-id').html();
        simulated = $('.simulated').val();
        element_id = $('.element-id').val();
        subtopics = $('.study-mode-options .settings-option .' + element_id + ' input[type=checkbox]:checked').map(function(_, el) {
            return $(el).val();
        }).get();
        show_numbers = $('.show-numbers').val();
        if (simulated == 1)
            show_answers = 0;
        else
            show_answers = $('.show-answers').val();
        weak_areas = $('.weak-areas').val();
        
        post_data = {
            'myAction'      : 'start',
            'user_id'       : user_id,
            'element_id'    : element_id,
            'subtopics'     : subtopics,
            'simulated'     : simulated,
            'weak_areas'    : weak_areas,
            'missed_retake' : missed_retake,
            'resume'        : resume,
            'quick50'       : quick_50          
        };

        $.ajax({
           type: 'post',
           url: 'ajax.php',
           data: post_data,
           dataType: "text",
           success: function (text) {
                $('.pre-loader').css('display', 'none');
                printExam(text);
                if(resume==0){
                    $('.exam-panel .title .the-title').html($('.element-id option:selected').text());
                    saveExam(0); //0 = init
                }
                else{
                    exam_id = $('.exam-id').html();
                    getQuestionsArray();
                    resumeExam();
                    var temp = $(".element-id option[value='"+element_id+"']").text()
                    $('.exam-panel .title .the-title').html(temp);
                }
           }
        });
        $('.pre-loader').css('display', 'block');
        $('.exam-details .current_question').html(current_question_index);
    }

    function saveExam(i){
        // console.log('saveExam(' + i + ')');
        var action;
        if (i==0)
            action = "init";
        else
            action = "update";

        date = $('.date').html();
        start_time = $('.start_time').html();
        post_data = {
            'myAction'          : action,
            'exam_id'           : exam_id,
            'user_id'           : user_id,
            'current_score'     : current_score,
            'element_id'        : element_id,
            'subtopics'         : subtopics,
            'incorrect'         : incorrect,
            'correct'           : correct,
            'skipped'           : skipped,
            'current_question'  : current_question_index,
            'exam_length'       : exam_length,          
            'simulated'         : simulated,
            'show_numbers'      : show_numbers,
            'show_answers'      : show_answers,
            'weak_areas'        : weak_areas,
            'missed_retake'     : missed_retake,
            'resume'            : resume,
            'date'              : date,
            'prev_time'         : prev_time,
            'start_time'        : start_time,
            'status'            : status, 
            'questions'         : questions
        };

        if (i==0){
            $.ajax({
                type: 'post',
                url: 'ajax.php',
                data: post_data,
                dataType: "text",
                success: function (data) {
                    exam_id = parseInt(data);
                    updateHTML();
                    //console.log(data);
                }
            });
        }
        else{
            $.ajax({
                type: 'post',
                url: 'ajax.php',
                data: post_data,
                dataType: "text",
                success: function (data) {
                    //console.log(data);
                }
            });
        }
    }

    function dontResume(id){
        //console.log('dontResume(' + id + ')');
        var action = "dontResume";
      
        post_data = {
            'myAction'          : action,
            'exam_id'           : id,
        };

        $.ajax({
            type: 'post',
            url: 'ajax.php',
            data: post_data,
            dataType: "text",
            success: function (data) {
                //console.log(data);
            }
        });
    }

    function printExam(data){
        // console.log('printExam()');
        $('.exam-container').html(data).fadeIn();
        if (show_answers == "0"){
            $('.exam-controls .next-question').css('display', 'none');
        }
        if (resume == 0){
            exam_length = $('.question-container .question').length - 1;
            $('.exam-details .total_questions').html(exam_length);
            updateHTML();
        }
        if( show_numbers == '0')
            $('.question-container .question-number').css('display', 'none');
        if (simulated == 1){
            $('.exam-controls .next-question').attr('disabled', true);
            $('.question.exam-ended .retake').css('display', 'none');
            $('.exam-controls .exit-exam').css('display', 'none');
        }
        seen = $('.seen').text();
        createQuestionsArray();
    }

    function updateHTML(){
        // console.log('updateHTML()');
        $('.exam-details .exam-id').html(exam_id);
        $('.exam-details .simulated').html(simulated);
        $('.exam-details .show_numbers').html(show_numbers);
        $('.exam-details .show_answers').html(show_answers);
        $('.exam-details .current_question').html(current_question_index);
        $('.exam-details .correct').html(correct);
        $('.exam-details .incorrect').html(incorrect);
        $('.exam-details .current_score').html(current_score);
        $('.exam-details .skipped').html(skipped);
        $('.exam-details .status').html(status);
        $('.exam-details .missed-retake').html(missed_retake);
        $('.exam-details .weak-areas').html(weak_areas);
        $('.exam-details .resume').html(resume);
        $('.exam-details .num-answered').html(num_answered);
        percent_progress = (num_answered/exam_length*100).toFixed(0);
        if (percent_progress > 0)
            $('.exam-details .percent-progress').html(percent_progress);
    }

    function checkAnswer(){
        //console.log('checkAnswer()');
        var temp = $('.question-container .question.' + current_question_index + " input[name=answer]:checked").val();
        var correct_answer = $('.question-container .question.' + current_question_index + ' .correct-answer').text();
        if (temp == correct_answer)
            return 1;        
        else if(temp)
            return 0;
        else
            return -1;
    }

    function updateScore($s){
        //console.log('updateScore()' + $s);
        if ($s == 'right'){
            questions[current_question_index].grade = 1;
            correct++;
            $('.exam-details .correct').html(correct);
        }
        else if ($s == 'wrong'){
            questions[current_question_index].grade = 0;
            incorrect++;
            $('.exam-details .incorrect').html(incorrect);
        }
        else if ($s == 'skipped'){
            questions[current_question_index].grade = -1;
            skipped++;
            $('.exam-details .skipped').html(skipped);
        }
        num_answered++;
        current_score = (correct/num_answered*100).toFixed(0);
        $('.exam-details .current_score').html(current_score);
    }

    function proceed(){
        // console.log('proceed()');
        if(current_question_index < exam_length - 1){
            $('.question-container .question.' + current_question_index).fadeOut(100);
            current_question_index++;
            $('.question-container .question.' + current_question_index).delay(200).fadeIn(100);
            updateHTML();
            if (simulated == 1)
                $('.exam-controls .next-question').attr('disabled', true);
            saveExam(1);
        }
        else if(current_question_index < exam_length){
            //last question has been answered
            $('.question-container .question.' + current_question_index).fadeOut(100);
            $('.question-container .exam-ended').delay(200).fadeIn(100);
            $('.exam-controls .next-question').attr('disabled', true);
            $('.exam-controls .stop-exam').attr('disabled', true);
            current_question_index++;
            status = 1;
            saveExam(1);
            updateHTML();
            if (simulated == 1)
                checkHighScore();
        }
        if(seen < exam_length){
            seen++;
            $('.seen').html(seen);
        }
        if (current_score >= 75){
            $('.exam-dashboard .percent.score').removeClass('negative');
            $('.exam-dashboard .percent.score').addClass('positive');
        }
            else{
                $('.exam-dashboard .percent.score').removeClass('positive');
                $('.exam-dashboard .percent.score').addClass('negative');
            }
    }

    function showAnswer(o){
        // console.log('showAnswer()');
        if(o.is('#correct'))
            o.children().children('.icon-ok').fadeIn(100).css("display","inline-block");
        else{
            //$(".question-container .question." + current_question_index + " form div#correct.answer-box .answer").css('border-color', 'green');
            o.children().children('.icon-remove').fadeIn(100).css("display","inline-block");
            $(".question-container .question." + current_question_index + " form div#correct.answer-box .icon-ok ").fadeIn(100).css("display","inline-block");
        }
    }

    function createQuestionsArray(){
        // console.log('createQuestionsArray()');
        questions = [];
        $(".exam-container .exam-details .question-container .question .question-number").each(function(){
            var data = {};
            data.question_number = $(this).text();
            data.grade = -777;
            questions.push(data);
        });
        //console.log(questions);
    }

    function resetData(){
        // console.log('resetData()');
        correct = 0;
        incorrect = 0;
        skipped = 0;
        num_answered = 0;
        current_score = 0;
        status = -1;
        missed_retake = 0;
        resume = 0;
        prev_time = 0;
        seen = 0;
        current_question_index = 0;
    }

    function getQuestionsArray(){
        // console.log('getQuestionsArray()');        
        post_data = {
            'myAction'  : 'getArray',
            'exam_id'   : exam_id
        };

        $.ajax({
           type: 'post',
           url: 'ajax.php',
           data: post_data,
           dataType: "json",
           success: function (data) {
                questions = data;
                //console.log(questions);
           }
        });
    }

    function resumeExam(){
        element_id = $('.exam-details .element-id').html();
        simulated = $('.exam-details .simulated').html();
        weak_areas = $('.exam-details .weak-areas').html();
        subtopics = $('.exam-details .subtopics').html();
        show_numbers = $('.exam-details .show_numbers').html();
        show_answers = $('.exam-details .show_answers').html();
        correct = $('.exam-details .correct').html();
        incorrect = $('.exam-details .incorrect').html();
        exam_length = $('.exam-details .total_questions').html();
        skipped = $('.exam-details .skipped').html();
        num_answered = parseInt(correct) + parseInt(incorrect);
        $('.exam-details .num-answered').html(num_answered);
        current_score = $('.exam-details .current_score').html();
        current_question_index = $('.exam-details .current_question').html() - 1;
        status = $('.exam-details .status').html();
        missed_retake = $('.exam-details .missed-retake').html();
        prev_time = $('.exam-details .prev_time').html();
        percent_progress = (num_answered/exam_length*100).toFixed(0);
        $('.exam-details .percent-progress').html(percent_progress);

        // console.log(
        //     "user_id: " + user_id
        //     + " exam_id: " + exam_id
        //     + " element_id: " + element_id
        //     + " subtopics: " + subtopics
        //     + " current_question_index: " + current_question_index
        //     + " exam_length: " + exam_length
        //     + " correct: " + correct
        //     + " incorrect: " + incorrect
        //     + " skipped: " + skipped
        //     + " num_answered: " + num_answered
        //     + " current_score: " + current_score
        //     + " show_numbers: " + show_numbers
        //     + " show_answers: " + show_answers
        //     + " simulated: " + simulated
        //     + " weak_areas: " + weak_areas
        //     //+ "date: " + date
        //     //+ "start_time: " + start_time
        //     //+ " questions: " + questions
        //     + " status: " + status
        //     + " missed_retake: " + missed_retake
        //     + " resume: " + resume
        //     + " prev_time: " + prev_time
        // );

        $('.question-container .question.0').css('display', 'none');
        $('.question-container .question.' + current_question_index).fadeIn(100);
        if (show_answers == 1)
            $('.exam-controls .next-question').css('display', 'inline-block');
    }

    function validates(){
        validation = false;
        this_element_id = $('.element-id').val();
        $('.study-mode-options .settings-option .' + this_element_id ).find(':checkbox').each(function () { 
            if ($(this).is(':checked'))
                validation = true;
        });
        return validation;
    }

    function checkHighScore(){
        score_to_beat = $('.score-to-beat').html();
        if (current_score > score_to_beat){
            $('.new-high-score').html("<br>You have achieved a new high score!");
            $('.score-to-beat').html(current_score);
            $('.score-to-beat').parent().css('color', '#74AC12');
        }
    }
});