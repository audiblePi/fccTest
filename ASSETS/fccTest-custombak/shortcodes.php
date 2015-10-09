<?php

add_shortcode('fccTest_show_profile_stats', 'showProfileStats');
add_shortcode('fccTest', 'showInterface');
add_shortcode('fccTest_show_leaderboard', 'showLeaderBoard');

function showInterface($atts){
	$current_user = wp_get_current_user();
	$current_user_id = $current_user->ID;
	checkForPendingExam($current_user_id);

?>
	<div class="pre-loader"></div>
	<div class="exam-options">
		<div class="row">
			<div class="hidden-id"><?php echo $current_user_id; ?></div>
			<div class="settings-title three columns">Simulated Exam</div>
			<div class="settings-option nine columns">
				<select class="simulated">
					<option value="1" >On</option>
					<option value="0" selected="selected">Off</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="settings-title three columns">Choose Element</div>
			<div class="settings-option nine columns">
				<select class="element-id">
					<option value="E1">Element 1 : Basic Radio Law and Operating Practice</option>
					<option value="E3">Element 3 : General Radiotelephone</option>
					<option value="E6">Element 6 : Advanced Radiotelegraph</option>
					<option value="E7">Element 7 : GMDSS Radio Operating Practices</option>
					<option value="E7R">Element 7R : Restricted GMDSS Radio Operating Practices</option>
					<option value="E8">Element 8 : Ship Radar Techniques</option>
					<option value="E9">Element 9 : GMDSS Radio Maintenance Practices and Procedures</option>
				</select>
			</div>
		</div>
		<div class="study-mode-options">
			<div class="row">
				<div class="settings-title three columns">Choose Study Topics</div>
				<div class="settings-option nine columns">
					<div>
						<select class="E1 subtopic" multiple="multiple">
							<option value="All" selected="selected">All</option>
							<option value="A">Rules & Regulations</option>
							<option value="B">Communications Procedures</option>
							<option value="C">Equipment Operations</option>
							<option value="D">Other Equipment</option>
						</select>
					</div>
					<div>
						<select class="E3 subtopic" multiple="multiple">
							<option value="All" selected="selected">All</option>
							<option value="A">Principles</option>
							<option value="B">Electrical Math</option>
							<option value="C">Components</option>
							<option value="D">Circuits</option>
							<option value="E">Digital Logic</option>
							<option value="F">Receivers</option>
							<option value="G">Transmitters</option>
							<option value="H">Modulation</option>
							<option value="I">Power Sources</option>
							<option value="J">Antennas</option>
							<option value="K">Aircraft</option>
							<option value="L">Installation, Maintenance & Repair</option>
							<option value="M">Communications Technology</option>
							<option value="N">Marine</option>
							<option value="O">RADAR</option>
							<option value="P">Satellite</option>
							<option value="Q">Safety</option>
						</select>
					</div>
					<div>
						<select class="E6 subtopic" multiple="multiple">
							<option value="All" selected="selected">All</option>
						</select>
					</div>
					<div>
						<select class="E7 subtopic" multiple="multiple">
							<option value="All" selected="selected">All</option>
							<option value="A">General Information and System Overview</option>
							<option value="B">Principles of Communications</option>
							<option value="C">F.C.C. Rules & Regulations</option>
							<option value="D">DSC & Alpha-Numeric ID</option>
							<option value="E">Distress, Urgency & Safety Communications</option>
							<option value="F">Survival Craft Equip & S.A.R.</option>
							<option value="G">VHF-DSC Equipment & Communications</option>
							<option value="H">Maritime Safety Information (M.S.I.)</option>
							<option value="I">Inmarsat Equip. & Comms</option>
							<option value="J">MF-HF Equip. and Comms</option>
						</select>
					</div>
					<div>
						<select class="E7R subtopic" multiple="multiple">
							<option value="All" selected="selected">All</option>
							<option value="A">General Information and System Overview</option>
							<option value="B">F.C.C. Rules & Regulations</option>
							<option value="C">DSC & Alpha-Numeric ID Systems</option>
							<option value="D">Distress, Urgency & Safety Comms</option>
							<option value="E">Survival Craft Equip & S.A.R.</option>
							<option value="F">Maritime Safety Information (M.S.I.)</option>
							<option value="G">VHF-DSC Equipment & Comms</option>
						</select>
					</div>
					<div>
						<select class="E8 subtopic" multiple="multiple">
							<option value="All" selected="selected">All</option>
							<option value="A">RADAR Principles</option>
							<option value="B">Transmitting Systems</option>
							<option value="C">Receiving Systems</option>
							<option value="D">Display & Control Systems</option>
							<option value="E">Antenna Systems</option>
							<option value="F">Installation, Maintenance & Repair</option>
						</select>
					</div>
					<div>
						<select class="E9 subtopic" multiple="multiple">
							<option value="All" selected="selected">All</option>
							<option value="A">VHF-DSC Equipment & Operation</option>
							<option value="B">MF-HF-DSC-SITOR (NBDP) Equip. & Ops</option>
							<option value="C">Satellite Systems</option>
							<option value="D">Other GMDSS Equipment</option>
							<option value="E">Power Sources</option>
							<option value="F">Other Equipment and Networks</option>
							<option value="G">Inspections, Installations and Instruments</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="settings-title three columns">Show Question Numbers</div>
				<div class="settings-option nine columns">
					<select class="show-numbers">
						<option value="1">On</option>
						<option value="0" selected="selected">Off</option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="settings-title three columns">Show Answers</div>
				<div class="settings-option nine columns">
					<select class="show-answers">
						<option value="1" >On</option>
						<option value="0" selected="selected">Off</option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="settings-title three columns">Focus on Weak Areas</div>
				<div class="settings-option nine columns">
					<select class="weak-areas">
						<option value="1">On</option>
						<option value="0" selected="selected">Off</option>
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<button class="exam-start">Start Exam</button>
		</div>
	</div>
	<div class="exam-container" style="display:none"></div>
<?php
}//end main()

function checkForPendingExam($id){
	$link = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME );
	$result = mysqli_query($link , "SELECT * FROM wp_fccTest_custom_exams 
									WHERE user_id = $id 
									ORDER BY date 
									DESC LIMIT 1;") 
									OR DIE(mysqli_error());
	$row = mysqli_fetch_array(@$result, MYSQLI_ASSOC);
	if ($row){
		if ($row['status'] == -1){
		?>
		<div id="dialog" title="Resume" style="display:none">
		  	<p>Would you like to resume Element <?php echo substr($row['element_id'], 1) ?>?</p>
			<button class="resume-no" style="margin-right:10px;">No</button><button class="resume-exam">Yes</button>
		</div>
		<script>
			jQuery(function($){
				setTimeout(function(){$( "#dialog" ).dialog( "open" )}, 500 );
    		});
		</script>
		<?php }
	}
}//end checkForPendingExam()

function showProfileStats() {
	$link = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME );
	$current_user = wp_get_current_user();
	$current_user_id = $current_user->ID;
	$current_user_display_name = $current_user->display_name;
	$result = mysqli_query($link , "SELECT * FROM wp_fccTest_custom_exams 
									WHERE user_id = $current_user_id 
									AND simulated = 1
									AND missed_retake = 0
									ORDER BY date 
									DESC;") 
									OR DIE(mysqli_error());
	$row = mysqli_fetch_array(@$result, MYSQLI_ASSOC);

	//echo '<div>'.$current_user_display_name.'<br><br></div>';

	if($row) {
		?>
			<div class="row">
				<div class="twelve columns"><h4>Exam History</h4></div>
			</div>
			<div class="row" style="display:none">
				<!--<div class="one columns">Exam Id</div>-->
				<div class="two columns">Element</div>
				<!--<div class="two columns">Subtopics</div>-->
				<div class="two columns">Score</div>
				<!--<div class="one columns">Correct</div>-->
				<!--<div class="one columns">Incorrect</div>-->
				<!--<div class="one columns">Skipped</div>-->
				<!--<div class="one columns">Current Question</div>-->
				<!--<div class="one columns">Exam Length</div>-->
				<!--<div class="one columns">Simulated</div>-->
				<!--<div class="one columns">Show Answers</div>-->
				<!--<div class="one columns">Weak Areas</div>-->
				<!--<div class="one columns">Missed Retake</div>-->
				<!--<div class="one columns">Resume</div>-->
				<div class="three columns">Date</div>
				<!--<div class="one columns">Start Time</div>-->
				<!--<div class="one columns">End Time</div>-->
				<!--<div class="one columns">Total Time</div>-->
				<!--<div class="one columns">Questions</div>-->
				<!--<div class="one columns">Status</div>-->
			</div>
		<?php
		do { ?>
			<div class="row">
				<!--<div class="one columns"><?php echo $row["exam_id"] ?></div>-->
				<div class="two columns"><?php echo "Element ".substr($row["element_id"], 1) ?></div>
				<!--<div class="two columns">
					<?php 
						//$t = unserialize($row["subtopics"]);
						//foreach ($t as $s) 
						//	echo $s." "; 
					?>
				</div>-->
				<div class="two columns"><?php echo $row["score"] ?>%</div>
				<!--<div class="one columns"><?php echo $row["correct"] ?></div>-->
				<!--<div class="one columns"><?php echo $row["incorrect"] ?></div>-->
				<!--<div class="one columns"><?php echo $row["skipped"] ?></div>-->
				<!--<div class="one columns"><?php echo $row["current_question"] ?></div>-->
				<!--<div class="one columns"><?php echo $row["exam_length"] ?></div>-->
				<!--<div class="one columns"><?php echo $row["simulated"] ?></div>-->
				<!--<div class="one columns"><?php echo $row["show_answers"] ?></div>-->
				<!--<div class="one columns"><?php echo $row["weak_areas"] ?></div>-->
				<!--<div class="one columns"><?php echo $row["missed_retake"] ?></div>-->
				<!--<div class="one columns"><?php echo $row["resume"] ?></div>-->
				<div class="three columns"><?php echo $row["date"] ?></div>
				<!--<div class="one columns"><?php echo $row["start_time"] ?></div>-->
				<!--<div class="one columns"><?php echo $row["end_time"] ?></div>-->
				<!--<div class="one columns"><?php echo $row["total_time"] ?></div>-->
				<!--<div class="one columns"><?php echo count($row["questions"]) ?></div>-->
				<!--<div class="one columns"><?php echo $row["status"] ?></div>-->
			</div>
			<?php
		} 
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC));
	} else
		 echo "No Results found..."; 
}//end showProfileStats()

function showLeaderBoard() {
	$link = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME );
	$elements =  array("E1", "E3", "E6", "E6", "E7", "E7R", "E8", "E9");
	foreach ($elements as $e){
		$result = mysqli_query($link , "SELECT * FROM wp_fccTest_custom_exams 
										WHERE simulated = 1
										AND missed_retake = 0
										AND element_id = '$e'
										ORDER BY score 
										DESC") 
										OR DIE(mysqli_error());
		$row = mysqli_fetch_array(@$result, MYSQLI_ASSOC);

		if($row) { ?>
			<div class="row">
				<div class="twelve columns"><h4>Element <?php echo substr($e, 1) ?></h4></div>
			</div>
			<div class="row" style="display:none">
				<div class="two columns">User</div>
				<!--<div class="one columns">Exam ID</div>-->
				<!--<div class="two columns">Element</div>-->
				<div class="two columns">Score</div>
				<div class="two columns">Time</div>
			</div>
			<?php do { ?>
				<div class="row">
					<div class="two columns">
						<?php 
							$user_id = $row["user_id"];
							$user = get_user_by( 'id', $user_id);
							echo get_user_meta($user->ID,'nickname',true); 
						?>
					</div>
					<!--<div class="one columns"><?php echo $row["exam_id"] ?></div>-->
					<!--<div class="two columns"><?php echo $row["element_id"] ?></div>-->
					<div class="two columns"><?php echo $row["score"] ?>%</div>
					<div class="two columns"><?php echo $row["total_time"] ?></div>
				</div>
				<?php
			} 
			while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC));
			echo "<br>";
		} 
		// else
		// 	 echo "No Results found...";
	}
}//end showLeaderboard()
?>