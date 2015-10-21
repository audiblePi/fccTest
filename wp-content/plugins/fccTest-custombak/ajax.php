<?php

include("Exam.php");

if (isset($_POST['myAction']))
{    
    $action = $_POST['myAction'];
    switch($action) {
        case 'start'            : start();break;
        case 'init'             : mySave(0);break;
        case 'update'           : mySave(1);break;
        case 'getArray'         : getArray();break;
        case 'dontResume'       : dontResume();break;
        case 'getProgressReport': getProgressReport(); break;
        case 'getElementHistory': getElementHistory(); break;
        case 'getWeakAreas'     : getWeakAreas(); break;
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
    $quick50 = $_POST['quick50'];

    $newExam = new Exam($user_id, $element_id, $subtopics, $simulated, $weak_areas, $missed_retake, $resume, $quick50);

    ?>
   	 	<div class="row exam-details">
            <div class="row" style="display:none">
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
                            case '8-45F4'   : echo $image."8f12".$img_end;break;
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
                <div class="new-high-score"></div>
               <!--  <button class="try-again">Try Again?</button> -->
                <button class="retake">Missed Retake</button>
            </div> 
        </div>
        <div class="exam-controls">
            <div>
                <a href="my-account/study-reports/element-<?php echo substr($newExam->element_id, 1) ?>"><button class="exit-exam">Exit</button></a>
                <!-- <span class="mobile-logo"><img src="/wp-content/themes/passFCCExams/assets/images/logo.png"></span> -->
                <button class="next-question">Next</button>
            </div>
        </div>
        <div class="exam-dashboard">
            <table>
                <tr class="row">
                    <td class="four columns">
                        <div class="number">
                            <span class="current_question"><?php echo $newExam->current_question ?></span> / <span class="total_questions"><?php echo $newExam->exam_size ?></span>
                        </div>
                        <div class="text">
                            Questions Viewed
                        </div>
                        <div class="percent positive">
                            <span class="percent-progress">0</span>%
                        </div>
                    </td>
                    <td class="four columns">
                        <div class="number">
                            <span class="correct"><?php echo $newExam->correct ?></span> / <span class="num-answered"></span>
                        </div>
                        <div class="text">
                            Current Score
                        </div>
                        <div class="percent score negative">
                            <span class="current_score"><?php echo $newExam->score ?></span>%
                        </div>
                    </td>
                    <td class="four columns last">
                        <?php if ($newExam->simulated == 1) : ?>
                           <div class="number">
                                <span class="score-to-beat"><?php echo $newExam->scoreToBeat ?></span><span>%</span>
                            </div>
                            <div class="text">
                                Best Score
                            </div>
                        <?php else : ?>
                            <div class="number">
                                <span class="skipped"><?php echo $newExam->skipped ?></span>
                            </div>
                            <div class="text">
                                Skipped
                            </div>
                        <?php endif; ?>
                        <div class="percent" style="visibility:hidden">
                            <span class="current_score"><?php echo $newExam->score ?></span>%
                        </div>
                    </td>
                </tr>
            </table>
        <div>
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
                                        DESC LIMIT 1;") 
                                        OR DIE(mysqli_error($conn));
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

function dontResume(){
    $exam_id = $_POST['exam_id'];
    $conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    $sql = "UPDATE wp_fccTest_custom_exams
                            SET status = 1
                            WHERE exam_id = $exam_id";
    if($conn->query($sql))
        echo "Exam ".$exam_id." updated";
    else
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    mysqli_close($conn);
    exit();
}

function getArray(){
    $current_exam = $_POST['exam_id'];
    $conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    $result = $conn->query("SELECT questions 
                            FROM wp_fccTest_custom_exams 
                            WHERE exam_id = $current_exam;")
                            OR DIE(mysqli_error($conn));
    $row = $result->fetch_array();
    $questionArray = $row['questions'];
    $sArray = unserialize($questionArray);
    $jsonArray = json_encode($sArray);
    echo $jsonArray;
    exit();
}

function getProgressReport() {
    $current_user = $_POST['user_id'];
    $conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    $elements =  array("E1", "E3", "E6", "E7", "E7R", "E8", "E9");
    $scores = array();
    foreach ($elements as $e){
        $result = $conn->query("SELECT score
                                FROM wp_fccTest_custom_exams 
                                WHERE user_id = $current_user
                                AND element_id = '$e'
                                AND simulated = 1
                                AND missed_retake = 0
                                AND status = 1
                                ORDER BY date 
                                DESC LIMIT 2;")
                                OR DIE(mysqli_error($conn));
        $row = $result->fetch_array();
        $i = 0;
        $data =array();
        do {
            $data[$i] = array (
                'score'.$i => $row['score'],
            );
            $i++;
        }
        while ($row = $result->fetch_array());
        $scores[] = $data;
    }
    echo json_encode($scores);
    exit();
}

function getElementHistory() {
    $current_user = $_POST['user_id'];
    $element_id = $_POST['element_id'];
    $conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    $scores = array();
    $dates = array();
    $result = $conn->query("SELECT score, correct, incorrect, skipped, date
                            FROM wp_fccTest_custom_exams 
                            WHERE user_id = $current_user
                            AND element_id = '$element_id'
                            AND incorrect + correct > 5
                            ORDER BY date 
                            ASC")
                            OR DIE(mysqli_error($conn));
    $row = $result->fetch_array();
    if($row) {
        do {
            $data = array (
                'score' => $row['score'],
                'correct' => $row['correct'],
                'incorrect' => $row['incorrect'],
                'skipped' => $row['skipped'],
                'date' => $row['date']
            );
            $scores[] = $data;
        }
        while ($row = $result->fetch_array());
    }
    echo json_encode($scores);
    exit();
}

function getWeakAreas(){
    $current_user = $_POST['user_id'];
    $element_id = $_POST['element_id'];
    $seenQuestions = array();
    $weakAreas = array();
    $temp = array();
    $num_subtopics;
    $pool_size;
    $subtopic_array = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q');
    switch($element_id) {
        case 'E1' : $pool_size = 144;$num_subtopics = 4;break;
        case 'E3' : $pool_size = 600;$num_subtopics = 17;break;
        case 'E6' : $pool_size = 616;$num_subtopics = 1;break;
        case 'E7' : $pool_size = 600;$num_subtopics = 10;break;
        case 'E7R': $pool_size = 300;$num_subtopics = 7;break;
        case 'E8' : $pool_size = 300;$num_subtopics = 6;break;
        case 'E9' : $pool_size = 300;$num_subtopics = 7;break;                      
    }
    $conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    
    $result = $conn->query("SELECT * FROM wp_fccTest_custom_exams 
                            WHERE wp_fccTest_custom_exams.user_id = '$current_user' 
                            AND wp_fccTest_custom_exams.element_id = '$element_id'
                            ORDER BY date 
                            DESC") 
                            OR DIE(mysqli_error($conn));
    $row = $result->fetch_array();

    if($row) {
        do $temp[] = $row['questions'];
        while ($row = $result->fetch_array());

        foreach ($temp as $v){
            $t = unserialize($v);
            foreach ($t as $s){
                //var_dump($s);
                if( $s['grade'] != -777){
                    $key = array_search($s['question_number'], array_column($seenQuestions, 'question_number'));

                    $i = 0;//incorrect
                    $c = 0;//correct
                    $sk = 0;//skipped
                    $sc = 0;//score
                    $topic = "0";
                    if ($key === false) {
                        switch($s['grade']){
                            case '0' : $i = 1;break;
                            case '1' : $c = 1;break;
                            case '-1': $sk = 1;break;
                        }
                        if ($c == 1)
                            $sc = 100;
                        $data = array (
                            'question_number' => $s['question_number'],
                            'correct' => $c,
                            'incorrect' => $i,
                            'skipped' => $sk,
                            'score' => $sc,
                            'seen' => 1
                        );
                        $seenQuestions[] = $data ;
                    }
                    else if ($key >= 0){
                        if($seenQuestions[$key]['seen'] < 3){
                            switch($s['grade']){
                                case '0' : $seenQuestions[$key]['incorrect']++;break;
                                case '1' : $seenQuestions[$key]['correct']++;break;
                                case '-1': $seenQuestions[$key]['skipped']++;break;
                            }
                            $total_answered = $seenQuestions[$key]['correct'] + $seenQuestions[$key]['incorrect'] + $seenQuestions[$key]['skipped'];
                            if ($total_answered)
                                $sc = number_format(($seenQuestions[$key]['correct']/$total_answered)*100);
                            $seenQuestions[$key]['score'] = $sc;
                            $seenQuestions[$key]['seen']++;
                        }
                    }
                }
            }
        }
        foreach ($seenQuestions as $f){
            if ($f['score'] < 70)
                $weakAreas[] = $f;
        }
    }

    $data = array (
        'totalSeen' => count($seenQuestions),
        'totalWeak' => count($weakAreas),
        'poolSize'  => $pool_size
    );

    $subtopics = array();
    for  ($i=0; $i<$num_subtopics; $i++){
        $subtopic_id = $subtopic_array[$i];
        $correct = 0;
        $answered = 0;
        foreach ($seenQuestions as $wa){
            if (substr($wa['question_number'], -2, -1) === $subtopic_id ){
                $answered += $wa['seen'];
                $correct += $wa['correct'];
            }
        }
        if($answered > 1)
            $score = number_format(($correct/$answered)*100);
        else $score = 0;
        $temp = array (
            'topic' => $subtopic_id,
            'correct' => $correct,
            'answered' => $answered,
            'score' => $score
        );
        $subtopics[] = $temp;
    }
    $data[] = $subtopics;
    //var_dump($seenQuestions);
    echo json_encode($data);
    exit();
}
