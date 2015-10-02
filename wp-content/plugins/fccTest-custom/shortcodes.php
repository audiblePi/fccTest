<?php

add_shortcode('fccTest_show_profile_stats', 'showProfileStats');
add_shortcode('fccTest', 'showInterface');
add_shortcode('fccTest_show_leaderboard', 'showLeaderBoard');
add_shortcode('fccTest_show_profile', 'showProfile');

function showInterface($atts){
	$a = shortcode_atts( array('type' => 'something'), $atts );
	$current_user = wp_get_current_user();
	$current_user_id = $current_user->ID;

    if ($a['type'] == "study")
		checkForPendingExam($current_user_id);
?>	
	<div class="fcc-panel exam-options-panel">
		<div class="title">Exam Options<div class="section-collapse">collapse <i class="icon-chevron-up"></i></div></div>
		<div class="exam-options">
			<div class="row" style="display:none">
				<div class="hidden-id"><?php echo $current_user_id; ?></div>
				<div class="settings-title three columns">Simulated Exam</div>
				<div class="settings-option nine columns">
					<select class="simulated">
						<?php if ($a['type'] == "simulated") { ?>
							<option value="1" selected="selected">On</option>
							<option value="0" >Off</option>
						<?php } else { ?>
							<option value="1" >On</option>
							<option value="0" selected="selected">Off</option>
						<?php } ?>
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
			<div class="study-mode-options" <?php if ($a['type'] == "simulated") echo "style='display:none'"; ?>>
				<div class="row" style="">
					<div class="settings-title three columns">Quick 50</div>
					<div class="settings-option nine columns">
						<select class="quick-50">
							<option value="1">On</option>
							<option value="0" selected="selected">Off</option>
						</select>
					</div>
				</div>
				<div class="row subtopics-wrapper">
					<div class="settings-title three columns">Choose Study Topics</div>
					<div class="settings-option nine columns">
						<div class="E1 subtopic">
							<input type="checkbox" value="All" class="all" checked>All<br>
							<input type="checkbox" value="A" checked/>Rules & Regulations<br />
							<input type="checkbox" value="B" checked/>Communications Procedures<br />
							<input type="checkbox" value="C" checked/>Equipment Operations<br />
							<input type="checkbox" value="D" checked/>Other Equipment<br />
						</div>
						<div class="E3 subtopic">
								<input class="all" type="checkbox" value="All" checked>All<br>
								<input type="checkbox" value="A" checked>Principles</br>
								<input type="checkbox" value="B" checked>Electrical Math</br>
								<input type="checkbox" value="C" checked>Components</br>
								<input type="checkbox" value="D" checked>Circuits</br>
								<input type="checkbox" value="E" checked>Digital Logic</br>
								<input type="checkbox" value="F" checked>Receivers</br>
								<input type="checkbox" value="G" checked>Transmitters</br>
								<input type="checkbox" value="H" checked>Modulation</br>
								<input type="checkbox" value="I" checked>Power Sources</br>
								<input type="checkbox" value="J" checked>Antennas</br>
								<input type="checkbox" value="K" checked>Aircraft</br>
								<input type="checkbox" value="L" checked>Installation, Maintenance & Repair</br>
								<input type="checkbox" value="M" checked>Communications Technology</br>
								<input type="checkbox" value="N" checked>Marine</br>
								<input type="checkbox" value="O" checked>RADAR</br>
								<input type="checkbox" value="P" checked>Satellite</br>
								<input type="checkbox" value="Q" checked>Safety</br>
						</div>
						<div class="E6 subtopic">
							<input class="all" type="checkbox" value="All" checked>All<br>
						</div>
						<div class="E7 subtopic">
							<input class="all" type="checkbox" value="All" checked>All<br>
							<input type="checkbox" value="A" checked>General Information and System Overview<br>
							<input type="checkbox" value="B" checked>Principles of Communications<br>
							<input type="checkbox" value="C" checked>F.C.C. Rules & Regulations<br>
							<input type="checkbox" value="D" checked>DSC & Alpha-Numeric ID<br>
							<input type="checkbox" value="E" checked>Distress, Urgency & Safety Communications<br>
							<input type="checkbox" value="F" checked>Survival Craft Equip & S.A.R.<br>
							<input type="checkbox" value="G" checked>VHF-DSC Equipment & Communications<br>
							<input type="checkbox" value="H" checked>Maritime Safety Information (M.S.I.)<br>
							<input type="checkbox" value="I" checked>Inmarsat Equip. & Comms<br>
							<input type="checkbox" value="J" checked>MF-HF Equip. and Comms<br>
						</div>
						<div class="E7R subtopic">
							<input class="all" type="checkbox" value="All" checked>All<br>
							<input type="checkbox" value="A" checked>General Information and System Overview<br>
							<input type="checkbox" value="B" checked>F.C.C. Rules & Regulations<br>
							<input type="checkbox" value="C" checked>DSC & Alpha-Numeric ID Systems<br>
							<input type="checkbox" value="D" checked>Distress, Urgency & Safety Comms<br>
							<input type="checkbox" value="E" checked>Survival Craft Equip & S.A.R.<br>
							<input type="checkbox" value="F" checked>Maritime Safety Information (M.S.I.)<br>
							<input type="checkbox" value="G" checked>VHF-DSC Equipment & Comms<br>
						</div>
						<div class="E8 subtopic">
							<input class="all" type="checkbox" value="All" checked>All<br>
							<input type="checkbox" value="A" checked>RADAR Principles<br>
							<input type="checkbox" value="B" checked>Transmitting Systems<br>
							<input type="checkbox" value="C" checked>Receiving Systems<br>
							<input type="checkbox" value="D" checked>Display & Control Systems<br>
							<input type="checkbox" value="E" checked>Antenna Systems<br>
							<input type="checkbox" value="F" checked>Installation, Maintenance & Repair<br>
						</div>
						<div class="E9 subtopic">
							<input class="all" type="checkbox" value="All" checked>All<br>
							<input type="checkbox" value="A" checked>VHF-DSC Equipment & Operation<br>
							<input type="checkbox" value="B" checked>MF-HF-DSC-SITOR (NBDP) Equip. & Ops<br>
							<input type="checkbox" value="C" checked>Satellite Systems<br>
							<input type="checkbox" value="D" checked>Other GMDSS Equipment<br>
							<input type="checkbox" value="E" checked>Power Sources<br>
							<input type="checkbox" value="F" checked>Other Equipment and Networks<br>
							<input type="checkbox" value="G" checked>Inspections, Installations and Instruments<br>
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
							<option value="1" selected="selected">On</option>
							<option value="0" >Off</option>
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
	</div>
	<div class="fcc-panel exam-panel collapsed" style="height:52px">
		<div class="title"><span class="the-title">Exam</span><div class="section-collapse" id="500">collapse <i class="icon-chevron-down"></i></div></div>
		<div class="pre-loader"></div>
		<div class="exam-container" style="display:none"></div>
	</div>
<?php
}//end main()

function checkForPendingExam($id){
	$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	$result = $conn->query("SELECT * FROM wp_fccTest_custom_exams 
									WHERE user_id = $id
									AND simulated = 0
									ORDER BY date 
									DESC LIMIT 1;") 
									OR DIE(mysqli_error($conn));
	$row = $result->fetch_array();
	if ($row){
		if ($row['status'] == -1){
		?>
		<div id="dialog" title="Resume" style="display:none">
		  	<p>Would you like to resume Element <?php echo substr($row['element_id'], 1) ?>?</p>
			<button class="resume-no">No</button><button class="resume-exam">Yes</button>
		</div>
		<script>
			jQuery(function($){
				setTimeout(function(){$( "#dialog" ).dialog( "open" )}, 1000 );
    		});
		</script>
		<?php }
	}
}//end checkForPendingExam()

function showProfileStats() {
	$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	$current_user = wp_get_current_user();
	$current_user_id = $current_user->ID;
	$current_user_display_name = $current_user->display_name;
	$result = $conn->query("SELECT * FROM wp_fccTest_custom_exams 
									WHERE user_id = $current_user_id 
									AND simulated = 1
									AND missed_retake = 0
									AND status = 1
									ORDER BY date 
									DESC;") 
									OR DIE(mysqli_error($conn));
	$row = $result->fetch_array();

	//echo '<div>'.$current_user_display_name.'<br><br></div>';
	?>
	<div class="fcc-panel exam-history">
		<div class="title">Exam History<div class="section-collapse">collapse <i class="icon-chevron-up"></i></div></div>
		<?php
			if($row) {
				?>
					<div class="row table-header">
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
						<div class="eight columns">Date</div>
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
						<div class="eight columns"><?php echo $row["date"] ?></div>
						<!--<div class="one columns"><?php echo $row["start_time"] ?></div>-->
						<!--<div class="one columns"><?php echo $row["end_time"] ?></div>-->
						<!--<div class="one columns"><?php echo $row["total_time"] ?></div>-->
						<!--<div class="one columns"><?php echo count($row["questions"]) ?></div>-->
						<!--<div class="one columns"><?php echo $row["status"] ?></div>-->
					</div>
					<?php
				} 
				while ($row = $result->fetch_array());
			} else
				 echo "<div class='row'><div class='twelve columns'>No simulated exams found...</div></div>";
		?>
	</div>
	<?php
}//end showProfileStats()

function showLeaderBoard() {
	$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	$elements =  array("E1", "E3", "E6", "E7", "E7R", "E8", "E9");
	foreach ($elements as $e){
		$result = $conn->query("SELECT * FROM wp_fccTest_custom_exams 
										WHERE simulated = 1
										AND missed_retake = 0
										AND element_id = '$e'
										ORDER BY score 
										DESC LIMIT 5") 
										OR DIE(mysqli_error($conn));
		$row = $result->fetch_array(); ?>
		<div class="fcc-panel leader-board">
			<div class="title">Element <?php echo substr($e, 1) ?><div class="section-collapse">collapse <i class="icon-chevron-up"></i></div></div>
			<div class="row table-header">
				<div class="two columns">User</div>
				<!--<div class="one columns">Exam ID</div>-->
				<!--<div class="two columns">Element</div>-->
				<div class="two columns">Score</div>
				<div class="eight columns">Time</div>
			</div>
			<?php if($row) { ?>
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
						<div class="eight columns"><?php echo $row["total_time"] ?></div>
					</div>
				<?php } 
				while ($row = $result->fetch_array()); ?>
		<?php 
		} 
		else
			echo "<div class='row'><div class='twelve columns'>No exams found...</div></div>";
		echo "</div>";
	}
}//end showLeaderboard()

function showProfile(){
	?>
	<div class="fcc-panel collapsed">
		<div class="title">My Profile<div class="section-collapse">collapse <i class="icon-chevron-down"></i></div></div>
	</div>

	<div class="fcc-panel collapsed">
		<div class="title">Progress Report<div class="section-collapse">collapse <i class="icon-chevron-down"></i></div></div>
	</div>
	<?php
}
?>