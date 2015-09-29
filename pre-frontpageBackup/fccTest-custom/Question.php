<?php
if ( ! defined( 'ABSPATH' ) ) exit;
class Question
{
	public $question_id;
	public $question_label;
	public $element_id;
	public $question_text;
	//public $answers = array();
	public $answer_one;
	public $answer_two;
	public $answer_three;
	public $answer_four;
	public $correct_answer;
	public $subtopic;
	
	public function __construct($id, $s, $e)
	{
		
	}

	public function getAnswers()
	{
		// $link = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME );
		// $result = mysqli_query($link , "SELECT * FROM wp_fccTest_custom_questions WHERE wp_fccTest_custom_questions.element_id = '$this->element_id';") OR DIE(mysqli_error($link));
		// $row = mysqli_fetch_array(@$result, MYSQLI_ASSOC);
		// if($row) {
		// 	do {
		// 		if($row["question_text"]) { 
		// 			 $this->questions[] = $row["question_text"];
		// 		}
		// 	} 
		// 	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC));
		// } else { 
		// 	 echo "No Results found..."; 
		// }
	}
	

}//end Class()
?>
