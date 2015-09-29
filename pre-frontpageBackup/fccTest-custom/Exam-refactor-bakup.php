<?php
if ( ! defined( 'ABSPATH' ) ) exit;

require_once ('Question.php');

class Exam
{
	public $exam_id = "-1";
	public $user_id;
	public $simulated;
	public $element_id; //E1, E3, E6, E7, E7R, , E8, E9
	public $subtopics = array(); //study focus areas
	public $show_numbers;
	public $show_answers;
	public $exam_size;
	public $weak_areas;
	public $missed_retake = 0;
	public $resume = 0;
	public $score;
	public $correct;
	public $incorrect;
	public $questions = array();
	public $missed_or_skipped = array();
	public $current_question;
	public $date;
	public $skipped;
	public $status;
	public $prev_time;
	//private $start_time;
	//private $end_time;
	//private $total_time;
	
	public function __construct($id, $e, $s, $sim, $wa, $mr, $r){
		$this->user_id = $id;
		$this->element_id = $e;
		$this->subtopics = $s;
		$this->simulated = $sim;
		$this->weak_area = $wa;
		$this->missed_retake = $mr;
		$this->resume = $r;
		$this->getQuestions($e);
		$this->date = date("Y/m/d");
	}

	public function getQuestions($e){
		if($this->missed_retake==1)
			$this->missedRetake();
		else if ($this->simulated==1)
			$this->createSimulatedExam();
		else if($this->weak_areas==1)
			$this->focusOnWeakAreas();
		else if($this->resume==1)
			$this->resumeExam();
		else
			$this->createStudyExam();
	}

	public function createStudyExam(){
		$link = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME );
		if ($this->subtopics[0] == "All")
			$result = mysqli_query($link , "SELECT * FROM wp_fccTest_custom_questions WHERE wp_fccTest_custom_questions.element_id = '$this->element_id';") OR DIE(mysqli_error($link));
		else{
			$temp = "SELECT * FROM wp_fccTest_custom_questions WHERE wp_fccTest_custom_questions.element_id = '$this->element_id' AND";
			$count = count($this->subtopics);
			$index = 0;
			foreach ($this->subtopics as $s){
				$string = " wp_fccTest_custom_questions.subelement_id = '$s'";
				$temp .=$string;
				if ($index < $count -1)
					$temp .= " OR";
				$index++;
			}
			$temp .=";";
			$result = mysqli_query($link , $temp) OR DIE(mysqli_error($link));
		}
		$row = mysqli_fetch_array(@$result, MYSQLI_ASSOC);
		if($row) {
			do $this->questions[] = $row;
			while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC));
		} else { 
			 echo "No Results found..."; 
		}
		$this->orderQuestions();
	}

	public function missedRetake(){
		$temp = array();
		$link = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME );
		$result = mysqli_query($link , "SELECT * FROM wp_fccTest_custom_exams WHERE wp_fccTest_custom_exams.user_id = '$this->user_id' ORDER BY date DESC LIMIT 1;") OR DIE(mysqli_error($link));
		$row = mysqli_fetch_array(@$result, MYSQLI_ASSOC);

		if($row) {
			do {
				$temp[] = $row['questions'];
				foreach ($temp as $v){
		            $t = unserialize($v);
		            foreach ($t as $s){
		            	if( $s['grade'] == -1 || $s['grade'] == 0)
			            	$this->missed_or_skipped[] = $s['question_number'];
		            }
		        }
			}
			while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC));
		} else { 
			 echo "No Results found..."; 
		}

		$temp2 = "SELECT * FROM wp_fccTest_custom_questions WHERE";
		$count = count($this->missed_or_skipped);

		if ($count > 0){
			$index = 0;
			foreach ($this->missed_or_skipped as $s){
				$string = "  wp_fccTest_custom_questions.question_label = '$s'";
				$temp2 .=$string;
				if ($index < $count -1)
					$temp2 .= " OR";
				$index++;
			}
			$temp2 .=";";
			$result2 = mysqli_query($link , $temp2) OR DIE(mysqli_error($link));

			$row2 = mysqli_fetch_array(@$result2, MYSQLI_ASSOC);
			if($row2) {
				do $this->questions[] = $row2;
				while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC));
			} else 
				 echo "No Results found..."; 
		} else{
			echo "No Missed Questions to Retake!!"; 
			exit();
		}
	}

	public function resumeExam(){
		$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		$result = $conn->query("SELECT * FROM wp_fccTest_custom_exams WHERE user_id = $this->user_id ORDER BY date DESC LIMIT 1;");
		$row = $result->fetch_array();
		$this->exam_id = $row['exam_id'];

		if ($row){
			if ($row['status'] == -1){
				$temp[] = $row['questions'];
				$t = unserialize($temp[0]);
				foreach ($t as $q){
					$v = $q['question_number'];
					$result2 = $conn->query("SELECT * FROM wp_fccTest_custom_questions WHERE wp_fccTest_custom_questions.question_label = '$v'");
					$row2 = $result2->fetch_array();
					$this->questions[] = $row2;
				}
			}
			$this->loadExam($row);
		}
		else
			echo 'No previous exam found...';
	}

	public function createSimulatedExam(){
		/**
		update this for uneven $questions_per_element
		**/
		$num_subtopics;
		switch($this->element_id) {
	        case 'E1' : $this->exam_size = 24;$num_subtopics = 4;break;
	        case 'E3' : $this->exam_size = 76;$num_subtopics = 17;break;
	        case 'E6' : $this->exam_size = 100;$num_subtopics = 1;break;
	        case 'E7' : $this->exam_size = 100;$num_subtopics = 7;break;
	        case 'E7R': $this->exam_size = 50;$num_subtopics = 7;break;
	        case 'E8' : $this->exam_size = 50;$num_subtopics = 6;break;
	        case 'E9' : $this->exam_size = 50;$num_subtopics = 7;break;                      
	    }
	    $questions_per_element = $this->exam_size/$num_subtopics;
	    $subtopic_array = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', '3-K', '3-L', '3-M', '3-N', '3O', '3P', '3Q');
		$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		for  ($i=0; $i<$num_subtopics; $i++){
			$subtopic_id = $subtopic_array[$i];
			$result = $conn->query("SELECT * FROM wp_fccTest_custom_questions WHERE wp_fccTest_custom_questions.subelement_id = '$subtopic_id' ORDER BY rand() LIMIT $questions_per_element;");
			$row = $result->fetch_array();
			do $this->questions[] = $row;
			while ($row = $result->fetch_array());
		}
		$this->orderQuestions();
	}

	public function loadExam($r){
		$this->element_id = $r['element_id'];
		$this->missed_retake = $r['missed_retake'];
		$this->simulated = $r['simulated'];
		$this->subtopics = unserialize($r['subtopics']);
		$this->show_numbers = $r['show_numbers'];
		$this->show_answers = $r['show_answers'];
		$this->current_question = $r['current_question'];
		$this->exam_size = $r['exam_length'];
		$this->correct = $r['correct'];
		$this->incorrect = $r['incorrect'];
		$this->score = $r['score'];
		$this->skipped = $r['skipped'];
		$this->status = $r['status'];
		$this->weak_areas = $r['weak_areas'];
		$this->prev_time = $r['total_time'];
	}

	public function orderQuestions(){
		//logic to bring unseen questions first
		shuffle($this->questions);
	}

	public function setCurrentQuestion($i){
		$current_question = $i;
	}

	public function determineWeakAreas(){

	}

	public function determinUnseenQuestions(){

	}

	public function focusOnWeakAreas(){

	}
}//end Class()
?>
