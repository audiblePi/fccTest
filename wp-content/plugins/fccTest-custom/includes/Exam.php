<?php
/**
 * The Exam class creates exams.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

include(fccTest_PATH . "lib/array_column.php");

class Exam
{
	public $exam_id = "-1";
	public $user_id;
	public $simulated;
	public $element_id;
	public $subtopics = array();
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
	public $seenQuestions = array();
	public $weakAreas = array();
	public $seen = 0;
	public $scoreToBeat =0;
	public $quick50; 


	/**
	 * Object constructor
	 *
	 * Sets input parameters, get exam questions, sets start date for this exam
	 *
	 * @param int $id 	Wordpress user id
	 * @param string $e Element id E1, E7R etc
	 * @param array $s 	Array of subtopics by letter
	 * @param int $sim 	Simulated exam flag
	 * @param int $wa 	Weak areas flag
	 * @param int $mr 	Missed retake flag
	 * @param int $r 	Resume exam flag
	 * @param int $q 	Quick 50 flag
	 *
	 * @return void
	 */
	public function __construct($id, $e, $s, $sim, $wa, $mr, $r, $q){
		$this->user_id = $id;
		$this->element_id = $e;
		$this->subtopics = $s;
		$this->simulated = $sim;
		$this->weak_areas = $wa;
		$this->missed_retake = $mr;
		$this->resume = $r;
		$this->quick50 = $q;
		$this->getQuestions($e);
		$this->date = date("Y/m/d");
	}//end __contruct()

	public function getQuestions($e){
		if($this->missed_retake==1)
			$this->missedRetake();
		else if ($this->simulated==1)
			$this->createSimulatedExam();
		else if($this->weak_areas==1)
			$this->focusOnWeakAreas();
		else if ($this->quick50==1)
			$this->createSimulatedExam();
		else if($this->resume==1)
			$this->resumeExam();
		else
			$this->createStudyExam(0);
	}//end getQuestions()


	/**
	 * Study Exams pull all the questions from an element, with the option to choose specific subtopics
	 * 
	 * @param int $flag 1 means we are creating a study exam from the determined weak areas 
	 */
	public function createStudyExam($flag){
		$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		if ($this->subtopics[0] == "All"){
			$result = $conn->query("SELECT * FROM wp_fccTest_custom_questions 
									WHERE wp_fccTest_custom_questions.element_id = '$this->element_id';") 
									OR DIE(mysqli_error($conn));
			$row = $result->fetch_array();
			if($row) {
				do {
					if ($flag == 1){
	            		if(array_search($row['question_label'], array_column($this->weakAreas, 'question_number')) !== false )
		            		$this->questions[] = $row;
					}
					else
						$this->questions[] = $row;
				}
				while ($row = $result->fetch_array());
			} else
				 echo "No questions found..."; 
		}
		else{
			foreach ($this->subtopics as $s){
				$result2 = $conn->query("SELECT * FROM wp_fccTest_custom_questions 
										WHERE wp_fccTest_custom_questions.element_id = '$this->element_id' 
										AND wp_fccTest_custom_questions.subelement_id = '$s'") 
										OR DIE(mysqli_error($conn));
				$row2 = $result2->fetch_array();
				if($row2) {
					do {
						if ($flag == 1){
		            		if(array_search($row2['question_label'], array_column($this->weakAreas, 'question_number')) !== false )
			            		$this->questions[] = $row2;
						}
						else
							$this->questions[] = $row2;
					}
					while ($row2 = $result2->fetch_array());
				} else
					 echo "No questions found..."; 
			}
		}
		$this->orderQuestions();
		$this->determineSeenQuestions();
		$this->sortQuestionsArray();
	}//end createStudyExam()


	/**
	 * Missed Retaked grabs the users last exam question array, creates new exam from the missed questions
	 */
	public function missedRetake(){
		$temp = array();
		$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		$result = $conn->query("SELECT * FROM wp_fccTest_custom_exams 
								WHERE wp_fccTest_custom_exams.user_id = '$this->user_id' 
								ORDER BY date 
								DESC LIMIT 1;") 
								OR DIE(mysqli_error($conn));
		$row = $result->fetch_array();

		if($row) {
			do {
				$temp[] = $row['questions'];
				foreach ($temp as $v){
		            $t = unserialize($v);
		            foreach ($t as $s){
		            	if( $s['grade'] == -1 || $s['grade'] == 0){
			            	$missed_or_skipped = $s['question_number'];
			            	$result2 = $conn->query("SELECT * FROM wp_fccTest_custom_questions 
			            							WHERE wp_fccTest_custom_questions.question_label = '$missed_or_skipped';") 
			            							OR DIE(mysqli_error($conn));
							$row2 = $result2->fetch_array();
							if($row2) {
								do $this->questions[] = $row2;
						 		while ($row2 = $result2->fetch_array());
							}
							else{
						 		echo "No Missed Questions to Retake!!"; 
						 		exit();
							}
		            	}
		            }
		        }
			}
			while ($row = $result->fetch_array());
		} 
		else
			 echo "No previous exam found";
		$this->determineSeenQuestions();
	}//end missedRetake()


	/**
	 * Resume exam retrieves the question array from the users last unfisnished STUDY exam, 
	 * then retrieves each question with answers from the question table
	 * then send that question array to loadExam()
	 */
	public function resumeExam(){
		$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		$result = $conn->query("SELECT * FROM wp_fccTest_custom_exams 
								WHERE user_id = $this->user_id
								AND simulated = 0
								ORDER BY date 
								DESC LIMIT 1;")
								OR DIE(mysqli_error($conn));
		$row = $result->fetch_array();
		$this->exam_id = $row['exam_id'];

		if ($row){
			if ($row['status'] == -1){
				$temp[] = $row['questions'];
				$t = unserialize($temp[0]);
				foreach ($t as $q){
					$v = $q['question_number'];
					$result2 = $conn->query("SELECT * FROM wp_fccTest_custom_questions 
											WHERE wp_fccTest_custom_questions.question_label = '$v'");
					$row2 = $result2->fetch_array();
					$this->questions[] = $row2;
				}
			}
			$this->loadExam($row);
		}
		else
			echo 'No previous exam found...';
		$this->determineSeenQuestions();
	}//end resumeExam()


	/**
	 * Simulated Exams have a predifined length and predfined number of questions from each subtopic
	 * This function determines how many questions are required for wach sub topics based on the user input element
	 * Grabs random questions from each sub topic, shuffles, and finds scoreToBeat
	 *
	 * NOTE: *quick50 same as simulated exam, with exam_size == 50
	 * can be updated to reflect the % of each sub topic
	 */
	public function createSimulatedExam(){
		$num_subtopics;
		switch($this->element_id) {
	        case 'E1' : $this->exam_size = 24;$num_subtopics = 4;break;
	        case 'E3' : $this->exam_size = 76;$num_subtopics = 17;break;
	        case 'E6' : $this->exam_size = 100;$num_subtopics = 1;break;
	        case 'E7' : $this->exam_size = 100;$num_subtopics = 10;break;
	        case 'E7R': $this->exam_size = 50;$num_subtopics = 7;break;
	        case 'E8' : $this->exam_size = 50;$num_subtopics = 6;break;
	        case 'E9' : $this->exam_size = 50;$num_subtopics = 7;break;                      
	    }
	    if ($this->quick50 ==1 )
	    	$this->exam_size = 50;
	    $questions_per_element = floor($this->exam_size/$num_subtopics);
	    $subtopic_array = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q');
		$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		for  ($i=0; $i<$num_subtopics; $i++){
			if ( $i == ($num_subtopics - 1)){
				if ( ($this->exam_size - count($this->questions) - $questions_per_element) != 0)
					$questions_per_element = $this->exam_size - count($this->questions);
			}
			$subtopic_id = $subtopic_array[$i];
			$result = $conn->query("SELECT * FROM wp_fccTest_custom_questions 
									WHERE wp_fccTest_custom_questions.subelement_id = '$subtopic_id' 
									AND wp_fccTest_custom_questions.element_id = '$this->element_id'
									ORDER BY rand() 
									LIMIT $questions_per_element;")
									OR DIE(mysqli_error($conn));
			$row = $result->fetch_array();
			do $this->questions[] = $row;
			while ($row = $result->fetch_array());
		}
		$this->orderQuestions();
		$this->getScoreToBeat();
	}//end createSimulatedExam()


	/**
	 * Sets variables for the retrieved resumed exam
	 */
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
	}//end loadExam()


	public function orderQuestions(){
		shuffle($this->questions);
	}//end orderQuestions()


	public function sortQuestionsArray(){
		if(!$this->seenQuestions)
			$this->determineSeenQuestions();

  		usort($this->questions, array($this, 'sortBySeen'));
	}//end sortQuestionArray()


	/**
	 *	Pulls unseen questions to the front on study exams
	 */
	public function sortBySeen($a, $b){
    	return strnatcmp($a['seen'], $b['seen']);
  	}//end sortBySeen()


	public function setCurrentQuestion($i){
		$current_question = $i;
	}//end setcurrentQuestion()


	/**
	 * A weak area is a question that has been in answered incorrect 2 out of 3 three attempts
	 * Technically < %67
	 * This function populates the weak areas from questions that have been seen
	 */
	public function determineWeakAreas(){
		foreach ($this->seenQuestions as $f){
			if ($f['score'] < 70)
				$this->weakAreas[] = $f;
		}
		if (count($this->weakAreas) > 0)
			$this->createStudyExam(1);
		// else 
		// 	echo "We do not have enough data to determine your weak areas.  Please practice some more questions.";
	}//end determineWeakAreas()


	/**
	 * This function helps us determine what questions have not been seen, 
	 * We will push unseen questions to the front of every study exam until all the questions have been seen
	 * We will track the users grade for each seen questions to help up determine what questions are 'weak areas'
	 * seenQuestions array [(question_number, correct, incorrect, skipped, score, seen)]
	 */
	public function determineSeenQuestions(){
		$temp = array();
		$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		$result = $conn->query("SELECT * FROM wp_fccTest_custom_exams 
								WHERE wp_fccTest_custom_exams.user_id = '$this->user_id' 
								AND wp_fccTest_custom_exams.element_id = '$this->element_id'
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
	            	//var_dump($s['grade']);
	            	if( $s['grade'] != -777){
		            	$key = array_search($s['question_number'], array_column($this->seenQuestions, 'question_number'));

						$i = 0;
		            	$c = 0;
		            	$sk = 0;
		            	$sc = 0;
		            	if ($key === false) {
		            		switch($s['grade']){
			            		case '0' : $i = 1;break;
		                        case '1' : $c = 1;break;
		                        case '-1': $sk = 1;break;
		                    }
		                    if ($c == 1)
                            	$sc = 100; //otherwise score will not calculated until second attempt
		            		$data = array (
		            			'question_number' => $s['question_number'],
		            			'correct' => $c,
		            			'incorrect' => $i,
		            			'skipped' => $sk,
		            			'score' => $sc,
		            			'seen' => 1
		            		);
		            		$this->seenQuestions[] = $data;
		            	}
		            	else if ($key >= 0){
		            		/**
		            		 * NOTE: *once the question has been seen, we will only calculate a score based on the last three attempts
		            		 */
		            		if($this->seenQuestions[$key]['seen'] < 3){
								switch($s['grade']){
				            		case '0' : $this->seenQuestions[$key]['incorrect']++;break;
			                        case '1' : $this->seenQuestions[$key]['correct']++;break;
			                        case '-1': $this->seenQuestions[$key]['skipped']++;break;
			                    }
			                    $total_answered = $this->seenQuestions[$key]['correct'] + $this->seenQuestions[$key]['incorrect'];
			                    if ($total_answered)
			            			$sc = number_format(($this->seenQuestions[$key]['correct']/$total_answered)*100);
			            		$this->seenQuestions[$key]['score'] = $sc;
			            		$this->seenQuestions[$key]['seen']++;
			            	}
		            	}
	            	}
	            }
	        }
	        /*counts the number of seen questions for selected element*/
	        foreach ($this->seenQuestions as $sn){
			    $key = array_search($sn['question_number'], array_column($this->questions, 'question_label'));
			    if($key !== false){
			    	$this->questions[$key]['seen'] = 1;
			    	$this->seen++;
			    }
			}
		}
		//else
		//	 echo "determineSeenQuestions() -> No previous exams found";
	}//end determineSeenQuestions()


	public function focusOnWeakAreas(){
		$this->determineSeenQuestions();
		$this->determineWeakAreas();
	}//end focusOnWeakAreas()


	/**
	 * Score to beat only applies to simulated exams.
	 * It is the highest score on a completed simulated exam
	 */
	public function getScoreToBeat(){
		$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		$result = $conn->query("SELECT * FROM wp_fccTest_custom_exams 
								WHERE user_id = $this->user_id 
								AND element_id = '$this->element_id'
								AND simulated = 1
								AND missed_retake = 0
								AND status = 1
								ORDER BY score 
								DESC;") 
								OR DIE(mysqli_error($conn));
		$row = $result->fetch_array();
		if($row)
			$this->scoreToBeat = $row['score'];
	}//end getScoreToBeat()
}//end Class()
?>
