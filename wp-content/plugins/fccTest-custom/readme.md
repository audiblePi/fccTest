Plugin Name: FCC Test Plugin
Plugin URI: http://www.pippindesign.com
Description: Custom Plugin for FCC Test Elements
Version: BETA
Author: Pippin Design
Author URI: http://www.pippindesign.com


== Program Design Overiew ==
This plugin works with two database tables.  
'fccTest_custom_questions' contains the exam questions, 'fccTest_custom_exam' contains each exam session.  
User input starts from fccmain.js which makes an ajax request to ajax.php that creates an Exam object from Exam.php which returns an array of processed questions.
Progression through the exam is tracked via an ajax call to save/update the exam after every question.  
Each exam contains a question array of the exam questions id's and answer status.
Each question in the question array is initiated as -777 (unseen).
As the user progresses, we track each question as skipped (-1), answered correctly (1) or incorrectly (0).
Each exam also tracks the input variables for its creation so we can recreate that exam if needed.


== Exam Overview ==
Simluated Exams are created based on a preset length, with a preset percentage of questions from each subtopic.
Study Mode Exams are customizable and can be resumed.
If the user enter 'Study Mode', they will prompted whether or not they want to resume their last study session.
If the user declines, they will no longer be prompted, until their next unfinished study session.
'Missed retake' and 'Weak areas' exams retrieve the question array and cross reference each question id with its row in the question table.
'Missed retake' finds the last exam by the user and creates a new exam from the missed questions.
'Weak areas' are calculated as questions within an element that have been missed at least once out of the last three attempts.
For a question to no longer be considered a weak area, the user must answer it correctly three times consectuively.
'Quick 50' creates an Exam with 50 questions, similar to the simulated exam


== Account Dashoboard Overview ==
'Study Reports' contains data from simulated exams and study sessions, but filters out exams with less than 5 attempted questions.
'Study Reports -> Weak Areas' chart is based on the total number of correct answers out of the total number of answered questions in each element.
	NOTE: This means the last three attempts of the same question will be accounted for.  This only refers to questions that have been seen.
'Study Reports -> Weak vs Learned' shows the percentage of seen questions that have been tagged as weak areas.
	ASSUMPTION: If the user has not seen a question it is not considered weak or learned.
'Leader Board' only refers to smulated exams, showing the top five scores of completed from all registered users.
	NOTE: The leaderboard uses 'Nickname' profile value for each user.
A note about grading: In study mode, the user is allowed to skip questions. Skipped questions are counted as missed questions.
	NOTE: This does not apply to the weak areas algorithm.  Weak areas applies to questions that have been answered.