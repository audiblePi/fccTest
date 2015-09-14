<?php

include("Exam.php");

if (isset($_POST['myAction']))
{    
    $action = $_POST['myAction'];
    switch($action) {
        case 'start'    : start();break;//weak areas //missed retake //previous
        case 'init'     : mySave(0);break;
        case 'update'   : mySave(1);break;
        case 'getArray' : getArray();break;
    }
}

function start(){
    $test = "123";
 	$user_id = $_POST['user_id'];
    $element_id  = $_POST['element_id'];
    $subtopics = $_POST['subtopics'];
    $simulated = $_POST['simulated'];
    $weak_areas = $_POST['weak_areas'];
    $missed_retake = $_POST['missed_retake'];
    $resume = $_POST['resume'];

    $newExam = new Exam($user_id, $element_id, $subtopics, $simulated, $weak_areas, $missed_retake, $resume);


    ?>
   	 	<div class="row exam-details">
            <div class="row">
                <div class="two columns">Element <?php echo substr($newExam->element_id, 1) ?><span class="element-id"><?php echo $newExam->element_id ?></span></div>
                <div class="two columns">Subtopics: <span class="subtopics"><?php foreach ($newExam->subtopics as $s) echo $s." ";?></span></div>
                <div class="three columns">Progress: <span class="current_question"><?php echo $newExam->current_question + 1 ?></span>/<span class="total_questions"><?php echo $newExam->exam_size ?></span></div>
                <div class="three columns">Current Score: <span class="current_score"><?php echo $newExam->score ?></span>%</div>
                <div class="two columns">Seen: <span class="seen"><?php echo $newExam->seen ?></span>/<span class="total_questions"><?php echo $newExam->exam_size ?></span></div>
            </div>
            <div class="row" style="display:none">
                <div class="three columns">Exam Id: <span class="exam-id"><?php if ($newExam->exam_id) echo $newExam->exam_id ?></span></div>                
                <div class="three columns">User Id: <?php echo $newExam->user_id ?></div>
                <div class="three columns">Simulated: <span class="simulated"><?php echo $newExam->simulated ?></span></div>
                <div class="three columns">Missed Retake: <span class="missed-retake"><?php echo $newExam->missed_retake ?></span></div>
                <div class="three columns">Resume: <span class="resume"><?php echo $newExam->resume ?></span></div>
                <div class="three columns">Show Numbers: <span class="show_numbers"><?php echo $newExam->show_numbers ?></span></div>
                <div class="three columns">Show Answers: <span class="show_answers"><?php echo $newExam->show_answers ?></span></div>
                <div class="three columns">Weak Areas: <span class="weak-areas"><?php echo $newExam->weak_areas ?></span></div>
                <div class="three columns">Correct: <span class="correct"><?php echo $newExam->correct ?></span></div>
                <div class="three columns">Incorrect: <span class="incorrect"><?php echo $newExam->incorrect ?></span></div>
                <div class="three columns">Date: <span class="date"><?php echo date("m/d/Y H:i:s") ?></span></div>
                <div class="three columns">Start Time: <span class="start_time"><?php echo date("H:i:s") ?></span></div>
                <div class="three columns">Prev Time: <span class="prev_time"><?php echo $newExam->prev_time ?></span></div>
                <div class="three columns">Skipped: <span class="skipped"><?php echo $newExam->skipped ?></span></div>
                <div class="three columns">Status: <span class="status"><?php echo $newExam->status ?></span></div>
		</div>
        <div class="question-container">
            <?php
                $quizIndex = 0; //for keeping quiz order
                foreach ($newExam->questions as $v){
                    $correct_answer;
                    $answer_array = array();
                    $answer_array[] = $v["answer_one"];
                    $answer_array[] = $v["answer_two"];
                    $answer_array[] = $v["answer_three"];
                    $answer_array[] = $v["answer_four"];
                    switch($v["correct_answer"]) {
                        case 'A' : $correct_answer = $answer_array[0];break;
                        case 'B' : $correct_answer = $answer_array[1];break;
                        case 'C' : $correct_answer = $answer_array[2];break;
                        case 'D' : $correct_answer = $answer_array[3];break;
                    }
                    shuffle($answer_array);
            ?>
                <div class="question <?php echo $quizIndex; ?>">
                    <div class="row">
                        <div class="index" style="display:none"><?php echo $quizIndex + 1; ?></div>
                        <div class="question-id" style="display:none">Id:<?php echo $v["id"] ?></div>
                        <div class="question-number"><?php echo $v["question_label"] ?></div>
                        <div class="question-text"><?php echo $v["question_text"] ?></div>
                    </div>
                    <form>
                        <div class="answer-box" <?php if ($answer_array[0] == $correct_answer) echo "id='correct'" ?>><span class="check-marks"><i class="icon-ok"></i><i class="icon-remove"></i></span><span class="answer"><input type="radio" name="answer" value="<?php echo $answer_array[0] ?>"><?php echo $answer_array[0] ?></span></div>
                        <div class="answer-box" <?php if ($answer_array[1] == $correct_answer) echo "id='correct'" ?>><span class="check-marks"><i class="icon-ok"></i><i class="icon-remove"></i></span><span class="answer"><input type="radio" name="answer" value="<?php echo $answer_array[1] ?>"><?php echo $answer_array[1] ?></span></div>
                        <div class="answer-box" <?php if ($answer_array[2] == $correct_answer) echo "id='correct'" ?>><span class="check-marks"><i class="icon-ok"></i><i class="icon-remove"></i></span><span class="answer"><input type="radio" name="answer" value="<?php echo $answer_array[2] ?>"><?php echo $answer_array[2] ?></span></div>
                        <div class="answer-box" <?php if ($answer_array[3] == $correct_answer) echo "id='correct'" ?>><span class="check-marks"><i class="icon-ok"></i><i class="icon-remove"></i></span><span class="answer"><input type="radio" name="answer" value="<?php echo $answer_array[3] ?>"><?php echo $answer_array[3] ?></span></div>
                    </form>
                    <div class="correct-answer"><?php echo $correct_answer ?></div>
                    <div class="image-container">
                        <?php 
                        $image = "<img src='/wp-content/plugins/fccTest-custom/images/fig-";
                        $img_end = ".png'>";
                        switch($v["question_label"]) {
                            case '8-7A1'    :
                            case '8-7A6'    :
                            case '8-20C5'   :
                            case '8-21C3'   :
                            case '8-24C6'   : echo $image."8a1".$img_end; break;
                            case '8-9A2'    :
                            case '8-9A4'    :
                            case '8-10A5'   : echo $image."8a2".$img_end;break;
                            case '8-9A5'    : echo $image."8a3".$img_end;break;
                            case '8-10A1'   : echo $image."8a4".$img_end;break;
                            case '8-10A2'   : echo $image."8a5".$img_end;break;
                            case '8-10A3'   : echo $image."8a6".$img_end;break;
                            case '8-10A4'   : echo $image."8a7".$img_end;break;
                            case '8-10A6'   : echo $image."8a8".$img_end;break;
                            case '8-20C1'   : echo $image."8c9".$img_end;break;
                            case '8-26C3'   : echo $image."8c10".$img_end;break;
                            case '8-26C4'   :
                            case '8-26C6'   : echo $image."8c11".$img_end;break;
                            case '8-45F1'   :
                            case '8-45f4'   : echo $image."8f12".$img_end;break;
                        }
                        ?>
                    </div>
                </div>    
            <?php
                $quizIndex++;
                }
            ?>
            <div class="question exam-ended">
                <div>Exam Ended</div>
                <button class="retake">Missed Retake</button> 
            </div> 
        </div>
        <div class="exam-controls">
            <a href="profile"><button class="exit-start">Exit</button></a>
            <button class="next-question">Next</button>
        </div>
    <?php
    exit();
}

function mySave($i){
    $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME );
    $current_exam;
    $user_id = $_POST['user_id'];
    $current_score = $_POST['current_score'];
    $element_id = $_POST['element_id'];
    $subtopics = $_POST['subtopics'];
    $incorrect = $_POST['incorrect'];
    $correct = $_POST['correct'];
    $skipped = $_POST['skipped'];
    $current_question = $_POST['current_question'];
    $exam_length = $_POST['exam_length'];
    $simulated = $_POST['simulated'];
    $show_numbers = $_POST['show_numbers'];
    $show_answers = $_POST['show_answers'];
    $weak_areas = $_POST['weak_areas'];
    $missed_retake = $_POST['missed_retake'];
    $resume = $_POST['resume'];
    $date = $_POST['date'];
    $prev_time = $_POST['prev_time'];
    $start_time = $_POST['start_time'];
    $end_time = date("H:i:s");
    $total_time = strtotime($end_time) - strtotime($start_time);
    $status = $_POST['status'];
    $questions = $_POST['questions'];    
    $tdate = date("H:i:s", $total_time);
    $squestions = serialize($questions);
    $ssubtopics = serialize($subtopics);
    
    if($prev_time){
        $tdate = strtotime($tdate) + strtotime($prev_time);
        $tdate = date("H:i:s", $tdate);
    }
    
    if ($i == 1){
        $current_exam = $_POST['exam_id'];
        $sql = "UPDATE wp_fccTest_custom_exams
                SET score = $current_score,
                    incorrect = $incorrect,
                    correct = $correct,
                    skipped = $skipped,
                    current_question = $current_question,
                    questions = '$squestions',
                    end_time = '$end_time',
                    total_time = '$tdate',
                    status = $status
                WHERE exam_id = $current_exam;";
    }
    else {
        if ($exam_length > 0){
            $sql = "INSERT INTO wp_fccTest_custom_exams (user_id, score, element_id, subtopics, incorrect, correct, skipped, current_question, exam_length, simulated, show_numbers, show_answers, weak_areas, missed_retake, resume, date, start_time, end_time, total_time, questions, status)
            VALUES ($user_id, $current_score, '$element_id', '$ssubtopics', $incorrect, $correct, $skipped, $current_question, $exam_length, $simulated, $show_numbers, $show_answers, $weak_areas, $missed_retake, $resume, '$date', '$start_time', '$end_time', '$tdate', '$squestions', $status)";
        }
        else
            echo "No Exam to save";
    }

    if (mysqli_query($conn, $sql)){
        if ($i == 1)
            echo "Exam ".$current_exam." updated";
    }
    else
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);

    if ($i == 0){
        $result = mysqli_query($conn , "SELECT exam_id 
                                        FROM wp_fccTest_custom_exams 
                                        WHERE wp_fccTest_custom_exams.user_id = '$user_id' 
                                        ORDER BY exam_id 
                                        DESC LIMIT 1;") OR DIE(mysqli_error($conn));
        $row = mysqli_fetch_array(@$result, MYSQLI_ASSOC);
        if($row) {
            do
                $current_exam = $row['exam_id'];
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC));
        } else { 
             echo "No Results found...4"; 
        }
        echo $current_exam;
    }
    
    mysqli_close($conn);
    exit();
}

function getArray(){
    $current_exam = $_POST['exam_id'];
    $conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    $result = $conn->query("SELECT questions 
                            FROM wp_fccTest_custom_exams 
                            WHERE exam_id = $current_exam;");
    $row = $result->fetch_array();
    $questionArray = $row['questions'];
    $sArray = unserialize($questionArray);
    $jsonArray = json_encode($sArray);
    echo $jsonArray;
    exit();
}