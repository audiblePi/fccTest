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
	<div class="panel-wrapper">
		<div class="fcc-panel exam-options-panel">
			<div class="title">
				<?php 
					if ($a['type'] == "simulated") :
						echo "Simulated Exam Options"; 
						else :
							echo "Study Mode Options";
					endif;
				?>
			<div class="section-collapse">collapse <i class="icon-chevron-up"></i></div></div>
			<div class="content">
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
									<div class="twelve columns">
										<input type="checkbox" value="All" class="all" checked>All<br>
										<input type="checkbox" value="A" checked/>Rules & Regulations<br />
										<input type="checkbox" value="B" checked/>Communications Procedures<br />
										<input type="checkbox" value="C" checked/>Equipment Operations<br />
										<input type="checkbox" value="D" checked/>Other Equipment<br />
									</div>
								</div>
								<div class="E3 subtopic">
									<div class="six columns">
										<input class="all" type="checkbox" value="All" checked>All<br>
										<input type="checkbox" value="A" checked>Principles</br>
										<input type="checkbox" value="B" checked>Electrical Math</br>
										<input type="checkbox" value="C" checked>Components</br>
										<input type="checkbox" value="D" checked>Circuits</br>
										<input type="checkbox" value="E" checked>Digital Logic</br>
										<input type="checkbox" value="F" checked>Receivers</br>
										<input type="checkbox" value="G" checked>Transmitters</br>
										<input type="checkbox" value="H" checked>Modulation</br>
									</div>
									<div class="six columns">
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
								</div>
								<div class="E6 subtopic">
									<div class="twelve columns">
										<input class="all" type="checkbox" value="All" checked>All<br>
									</div>
								</div>
								<div class="E7 subtopic">
									<div class="twelve columns">
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
								</div>
								<div class="E7R subtopic">
									<div class="twelve columns">
										<input class="all" type="checkbox" value="All" checked>All<br>
										<input type="checkbox" value="A" checked>General Information and System Overview<br>
										<input type="checkbox" value="B" checked>F.C.C. Rules & Regulations<br>
										<input type="checkbox" value="C" checked>DSC & Alpha-Numeric ID Systems<br>
										<input type="checkbox" value="D" checked>Distress, Urgency & Safety Comms<br>
										<input type="checkbox" value="E" checked>Survival Craft Equip & S.A.R.<br>
										<input type="checkbox" value="F" checked>Maritime Safety Information (M.S.I.)<br>
										<input type="checkbox" value="G" checked>VHF-DSC Equipment & Comms<br>
									</div>
								</div>
								<div class="E8 subtopic">
									<div class="twelve columns">
										<input class="all" type="checkbox" value="All" checked>All<br>
										<input type="checkbox" value="A" checked>RADAR Principles<br>
										<input type="checkbox" value="B" checked>Transmitting Systems<br>
										<input type="checkbox" value="C" checked>Receiving Systems<br>
										<input type="checkbox" value="D" checked>Display & Control Systems<br>
										<input type="checkbox" value="E" checked>Antenna Systems<br>
										<input type="checkbox" value="F" checked>Installation, Maintenance & Repair<br>
									</div>
								</div>
								<div class="E9 subtopic">
									<div class="twelve columns">
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
		</div>
		<div class="shadow"></div>
	</div>
	<div class="panel-wrapper">
		<div class="fcc-panel exam-panel collapsed">
			<div class="title"><span class="the-title">Exam</span><div class="section-collapse">collapse <i class="icon-chevron-down"></i></div></div>
			<div class="content" >
				<div class="pre-loader"></div>
				<div class="exam-container" style="display:none"></div>
			</div>
		</div>
		<div class="shadow"></div>
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
		  	<div class="hidden-id" style="display:none"><?php echo $row['exam_id'] ?></div>
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

function showProfileStats($atts) {
	$a = shortcode_atts( array('element' => 'something'), $atts );
	$e_id = "E".$a['element'];
	$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	$current_user = wp_get_current_user();
	$current_user_id = $current_user->ID;
	$current_user_display_name = $current_user->display_name;
	$result = $conn->query("SELECT * FROM wp_fccTest_custom_exams 
									WHERE user_id = $current_user_id
									AND element_id = '$e_id'
									ORDER BY date 
									DESC;") 
									OR DIE(mysqli_error($conn));
	$row = $result->fetch_array();
	//var_dump($row);
	//echo $e_id;
	?>
	<div class="panel-wrapper line">
		<div class="fcc-panel exam-history line">
			<div class="title">Exam History<div class="section-collapse">collapse <i class="icon-chevron-up"></i></div></div>
			<div class="content line">
				<div id="element-history" class="<?php echo $current_user_id; ?>"><div class="hidden" style="display:none"><?php echo $e_id; ?></div></div>
				<div class="exam-dashboard">
		            <table>
		                <tr class="row">
		                    <td class="four columns">
		                        <div class="number">
		                            <span class="total_unseen">0</span>
		                        </div>
		                        <div class="text">
		                            Total Unseen
		                        </div>
		                        <div class="percent" style="visibility:hidden">
		                            <span class=""></span>%
		                        </div>
		                    </td>
		                    <td class="four columns">
		                        <div class="number">
		                            <span class="total_correct">0</span> / <span class="total_answered">0</span>
		                        </div>
		                        <div class="text">
		                            Overall Average
		                        </div>
		                        <div class="percent score negative">
		                            <span class="average_score">0</span>%
		                        </div>
		                    </td>
		                    <td class="four columns last">
		                        <div class="number">
		                            <span class="skipped">0</span>
		                        </div>
		                        <div class="text">
		                            Skipped
		                        </div>
		                        <div class="percent" style="visibility:hidden">
		                            <span class="current_score"></span>%
		                        </div>
		                    </td>
		                </tr>
		            </table>
	        	</div>
			</div>
		</div>
		<div class="shadow"></div>
	</div>
	<div class="panel-wrapper">
		<div class="fcc-panel exam-history weak collapsed">
			<div class="title">Weak Areas<div class="section-collapse">collapse <i class="icon-chevron-down"></i></div></div>
			<div class="content" style="display:none">
				<table class="weak-areas">
					<tr class="row table-header">
						<td class="six columns">Topic</td>
						<td class="one columns">Average</td>
						<td class="five columns"></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="shadow"></div>
	</div>
	<div class="panel-wrapper pie six columns">
		<div class="fcc-panel exam-history unseen collapsed">
			<div class="title">Unseen vs Seen<div class="section-collapse">collapse <i class="icon-chevron-down"></i></div></div>
			<div class="content pie" style="display:none">
				<div id="flot-donut1" class="graph"></div>
			</div>
		</div>
		<div class="shadow"></div>
	</div>
	<div class="panel-wrapper pie six columns">
		<div class="fcc-panel exam-history learned collapsed">
			<div class="title">Weak vs Learned<div class="section-collapse">collapse <i class="icon-chevron-down"></i></div></div>
			<div class="content pie" style="display:none">
				<div id="flot-donut2" class="graph"></div>
			</div>
		</div>
		<div class="shadow"></div>
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
		<div class="panel-wrapper">
			<div class="fcc-panel leader-board">
				<div class="title">Element <?php echo substr($e, 1) ?><div class="section-collapse">collapse <i class="icon-chevron-up"></i></div></div>
				<div class="content">
					<table>
						<tr class="row table-header">
							<td class="two columns">User</td>
							<td class="two columns">Score</td>
							<td class="eight columns">Time</td>
						</tr>
						<?php if($row) { ?>
							<?php do { ?>
								<tr class="row">
									<td class="two columns">
										<?php 
											$user_id = $row["user_id"];
											$user = get_user_by( 'id', $user_id);
											echo get_user_meta($user->ID,'nickname',true); 
										?>
									</td>
									<td class="two columns"><?php echo $row["score"] ?>%</td>
									<td class="eight columns"><?php echo $row["total_time"] ?></td>
								</tr>
							<?php } 
							while ($row = $result->fetch_array()); ?>
						<?php 
						} 
						else
							echo "<tr class='row'><td class='twelve columns'>No exams found...</td></tr>";
		echo "</table></div></div><div class='shadow'></div></div>";
	}
}//end showLeaderboard()

function showProfile(){
	$current_user = wp_get_current_user();
	$current_user_id = $current_user->ID;
	?>
	<div class="panel-wrapper">
		<div class="fcc-panel progress_report">
			<div class="title">Progress Report<div class="section-collapse">collapse <i class="icon-chevron-up"></i></div></div>
			<div class="content">
				<div class="row">
					<div id="progress-report" class="<?php echo $current_user_id; ?>"></div>
				</div>
			</div>
		</div>
		<div class="shadow"></div>
	</div>

	<div class="panel-wrapper">
		<div class="fcc-panel collapsed">
			<div class="title">My Profile<div class="section-collapse">collapse <i class="icon-chevron-down"></i></div></div>
			<div class="content" style="display:none">
				<div class="row">
					<?php echo do_shortcode('[pmpro_account]'); ?>
				</div>
			</div>
		</div>
		<div class="shadow"></div>
	</div>

	<div class="panel-wrapper">
		<div class="fcc-panel">
			<div class="title">Forms<div class="section-collapse">collapse <i class="icon-chevron-up"></i></div></div>
			<div class="content">
				<div class="row">
					<p><a href="/wp-content/themes/passFCCExams/assets/pdfs/(GROL) FCC 605 Main Form.pdf" target="_blank">General Radiotelephone Operator License (GROL) FCC 605 Main Form</a></p>
					<p>NOTE: This sample FCC 605 Main Form is for new individual GROL applicant only. If you are filing out another FCC license form, please consult their FCC website, or call the FCC (888) 225-5322, and they will walk you through filling out your forms.</p> 
					<p><a href="/wp-content/themes/passFCCExams/assets/pdfs/Ship Radar Endorsement form FCC 605 Schedule E.pdf" target="_blank">Ship Radar Endorsement form FCC 605 Schedule E</a></p>
				</div>
			</div>
		</div>
		<div class="shadow"></div>
	</div>
	<?php
}
?>