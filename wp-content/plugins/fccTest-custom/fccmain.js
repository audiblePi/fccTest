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
    var data_threshold = 0;
    var E1 = { A: "Rules & Regulations", B: "Communications Procedures", C: "Equipment Operations", D: "Other Equipment"};
    var E3 = { A: "Principles", B: "Electrical Math", C: "Components", D: "Circuits", E: "Digital Logic", F: "Receivers", G: "Transmitters", H: "Modulation", I: "Power Sources", J: "Antennas", K: "Aircraft", L: "Installation, Maintenance & Repair", M: "Communications Technology", N: "Marine", O: "RADAR", P: "Satellite", Q: "Safety"};
    var E7 = { A: "General Information and System Overview", B: "Principles of Communications", C: "F.C.C. Rules & Regulations", D: "DSC & Alpha-Numeric ID", E: "Distress, Urgency & Safety Communications", F: "Survival Craft Equip & S.A.R.", G: "VHF-DSC Equipment & Communications", H: "Maritime Safety Information (M.S.I.)", I: "Inmarsat Equip. & Comms", J: "MF-HF Equip. and Comms"};
    var E7R = { A: "General Information and System Overview", B: "F.C.C. Rules & Regulations", C: "DSC & Alpha-Numeric ID Systems", D: "Distress, Urgency & Safety Comms", E: "Survival Craft Equip & S.A.R.", F: "Maritime Safety Information (M.S.I.)", G: "VHF-DSC Equipment & Comms"};
    var E8 = { A: "RADAR Principles", B: "Transmitting Systems", C: "Receiving Systems", D: "Display & Control Systems", E: "Antenna Systems", F: "Installation, Maintenance & Repair"};
    var E9 = { A: "VHF-DSC Equipment & Operation", B: "MF-HF-DSC-SITOR (NBDP) Equip. & Ops", C: "Satellite Systems", D: "Other GMDSS Equipment", E: "Power Sources", F: "Other Equipment and Networks", G: "Inspections, Installations and Instruments"};

    if($('#progress-report').length)
        showProgressReport();
    if($('#element-history').length){
        showElementHistory();
    }

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
                if (exam_length == 0){
                    if (missed_retake == 1)
                        $('.question.exam-ended').html("<div>No missed questions to retake!</div>");
                    else if (weak_areas == 1)
                        $('.question.exam-ended').html("<div>No weak areas to review!</div>");
                        else 
                            $('.question.exam-ended').html("<div>No questions found..</div>");
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

    function showProgressReport(){
        var data = [
            { y: 'Element 1',   prev: "0", last: "0"},
            { y: 'Element 3',   prev: "0", last: "0"},
            { y: 'Element 6',   prev: "0", last: "0"},
            { y: 'Element 7',   prev: "0", last: "0"},
            { y: 'Element 7R',  prev: "0", last: "0"},
            { y: 'Element 8',   prev: "0", last: "0"},
            { y: 'Element 9',   prev: "0", last: "0"}
        ];
        var jsonScores = [];
        var cu = $('#progress-report').attr('class');
        
        post_data = {'myAction' : 'getProgressReport','user_id' : cu};

        $.ajax({
           type: 'post',
           url: 'ajax.php',
           data: post_data,
           dataType: "json",
           success: function (a) {
                for (i = 0; i < data.length; i++){
                    data[i].last = a[i][0]['score0'];
                    if(a[i].length > 1)
                        data[i].prev = a[i][1]['score1'];
                }
                //console.log(data);
                open($('.fcc-panel.progress_report'));
                Morris.Bar({
                    element: 'progress-report',
                    data: data,
                    ymax: 100,
                    xkey: 'y',
                    ykeys: ['prev', 'last'],
                    labels: ['Prev Score', 'Last Score'],
                    goals: [80],
                    goalStrokeWidth: 2,
                    goalLineColors: ['green'],
                    gridDashed: '--',
                    barColors: ['#6B9DD0', '#27558A']
                });
           }
        });
    }

    function showElementHistory(){
        var data = [];
        var cu = $('#element-history').attr('class');
        var ei = $('#element-history .hidden').html();
        var jsonScores = [];
        var totalAnswered = 0;
        var totalCorrect = 0;
        var totalSkipped = 0;
        var averageScore = 0;

        post_data = {
            'myAction'  : 'getElementHistory',
            'user_id'   : cu,
            'element_id': ei
        };

        $.ajax({
           type: 'post',
           url: 'ajax.php',
           data: post_data,
           dataType: "json",
           success: function (a) {
                //console.log(a);
                if(a.length > 0){
                    data_threshold = 1;
                    for (i = 0; i < a.length; i++){
                        var temp = {};
                        var tempDate = new Date(a[i].date.substring(0,10)).toDateString();
                        
                        temp.i = i+1;
                        temp.date = tempDate;
                        temp.correct = a[i].correct;
                        temp.total = parseInt(a[i].correct) + parseInt(a[i].incorrect) + parseInt(a[i].skipped);
                        temp.score = a[i].score;
                        data.push(temp);
                        totalAnswered += parseInt(temp.total);
                        totalCorrect += parseInt(temp.correct);
                        totalSkipped += parseInt(a[i].skipped);
                    }
                    if (a.length < 10){
                        var temp2 = {};
                        var pad = 10 - a.length;
                        for (z = 0; z < pad; z++){
                            temp2.i = i+z+1;
                            temp2.date = null;
                            temp2.correct = null;
                            temp2.total = null;
                            temp2.score = null;
                            data.push(temp2);
                        }
                    }
                    averageScore = (totalCorrect / totalAnswered * 100).toFixed(0);
                    if (averageScore > 70 ){
                        $('.exam-history .exam-dashboard .percent.score').removeClass('negative');
                        $('.exam-history .exam-dashboard .percent.score').addClass('positive');
                    }
                    $('.exam-history .exam-dashboard .total_correct').html(totalCorrect);
                    $('.exam-history .exam-dashboard .total_answered').html(totalAnswered);
                    $('.exam-history .exam-dashboard .average_score').html(averageScore);
                    $('.exam-history .exam-dashboard .skipped').html(totalSkipped);
                    
                    $('.panel-wrapper.line').animate({ marginBottom: '80px' }, 1000);
                    open($('.fcc-panel.exam-history.line'));
                    Morris.Line({
                        element: 'element-history',
                        data: data,
                        ymax: 100,
                        xkey: 'i',
                        ykeys: ['score'],
                        labels: ['Score'],
                        lineColors: ['#f86638'],
                        goals: [80],
                        goalStrokeWidth: 2,
                        goalLineColors: ['green'],
                        gridDashed: '--',
                        hoverCallback: function (index, options, content, row) {
                            var string = "";
                            var comment ="";
                            if(data[index].date != null){
                                if (data[index].score > 80 )
                                    comment += "<div class='morris-hover-row-label comment'>Great Job!!</div>";
                                string += comment + 
                                    "<div class='morris-hover-row-label'>" + data[index].date.substring(0,10) + "</div>" +
                                    "<div class='morris-hover-point'>Score: " + data[index].score + "</div>" +
                                    "<div class='morris-hover-point'>" + data[index].correct + " / " + data[index].total + "</div>";
                            }
                            return string;
                        },
                        resize: true
                    });

                }
                else{
                    $('.panel-wrapper.line').animate({ marginBottom: '80px' }, 1000);
                    open($('.fcc-panel.exam-history.line'));
                    $('.exam-history #element-history').append("<div class='row error-msg'><div class='twelve columns'>No exams found...</div></div>");
                }
                showWeakAreas();
           }
        });
    }

    function showWeakAreas(){
        var cu = $('#element-history').attr('class');
        var ei = $('#element-history .hidden').html();
        var useArray = [];
        switch(ei){
            case "E1": useArray = E1; break;
            case "E3": useArray = E3; break;
            case "E7": useArray = E7; break;
            case "E7R": useArray = E7R; break;
            case "E8": useArray = E8; break;
            case "E9": useArray = E9; break;
            default: $('.panel-wrapper.weak').css('display', 'none'); break;
        }

        post_data = {
            'myAction'  : 'getWeakAreas',
            'user_id'   : cu,
            'element_id': ei
        };

        $.ajax({
           type: 'post',
           url: 'ajax.php',
           data: post_data,
           dataType: "json",
           success: function (a) {
                console.log(a);
                var totalUnseen;
                if (a.totalSeen > a.poolSize)
                    totalUnseen = 0;
                else
                    totalUnseen = a.poolSize - a.totalSeen;
                var totalStrong = a.totalSeen - a.totalWeak;
                if (data_threshold > 0){
                    $.each(a[0], function(index, value) {
                        if (this.score < 70) var status = 'negative';
                            else var status = 'positive'; 
                        $('.exam-history .weak-areas').append('<tr class="row" id="'+this.topic+'"><td class="six columns">'+this.topic+': '+useArray[this.topic]+'</td> <td class="score '+status+' one columns">'+this.score+'%</td> <td class="graph five columns"><div id="progressBar"><div></div></div></td></tr>');
                        var div = "#" + this.topic + " #progressBar";
                        progress(this.score, $(div));
                    });
                    $('.exam-history .exam-dashboard .total_unseen').html(totalUnseen);
                    showPieCharts(totalUnseen, a.totalSeen, a.totalWeak, totalStrong);
                }
                else{
                    $.each(useArray, function(index, value) {
                        $('.exam-history .weak-areas').append('<tr class="row" id="'+index+'"><td class="six columns">'+index+': '+value+'</td> <td class="score negative one columns">0%</td> <td class="graph five columns"><div id="progressBar"><div></div></div></td></tr>');
                    });
                    $('.exam-history .content.pie .graph').append("<div class='row error-msg'><div class='twelve columns'>No exams found...</div></div>");
                    open($('.exam-history.unseen'));
                    open($('.exam-history.learned'));
                }
                open($('.exam-history.weak'));
           }
        });
    }

    function showPieCharts(unseen, seen, weak, strong){
        var data = [ { label: "Unseen", data: unseen},{ label: "Seen", data: seen} ];
        var data2 = [ { label: "Weak", data: weak},{ label: "Learned", data: strong} ];
        
        open($('.exam-history.unseen'));
        open($('.exam-history.learned'));
        jQuery.plot($("#flot-donut1"), data, {
            series: {
                pie: { 
                    innerRadius: 0.3,
                    show: true, 
                    label: { show: true }
                }
            },
            legend: { show:false },
            colors: [ '#6B9DD0', '#27558A']
        });
        jQuery.plot($("#flot-donut2"), data2, {
            series: {
                pie: { 
                    innerRadius: 0.3,
                    show: true,
                    label: { show: true }
                }
            },
            legend: { show:false },
            colors: [ '#6B9DD0', '#27558A']
        });
    }

    function progress(percent, $element) {
        var progressBarWidth = percent * $element.width() / 100;
        $element.find('div').delay(2000).animate({ width: progressBarWidth }, 1000);
    }

    function open(div){
        div.children('.content').slideToggle("slow");
        div.removeClass('collapsed');
        div.find('i').removeClass('icon-chevron-down');
        div.find('i').addClass('icon-chevron-up');
    }
});