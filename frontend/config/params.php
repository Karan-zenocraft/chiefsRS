<?php
return [
    'adminEmail' => 'testingforproject0@gmail.com',
    'upload_path'         => dirname(__FILE__) . DIRECTORY_SEPARATOR . '../../frontend/web/uploads/projectdocs',
    'project_status'=>array('1'=>'In-process','2'=>'On-Hold','3'=>'Require-Client-Input','4'=>'Completed'),
    'milestone_status'=>array('1'=>'In-process','2'=>'On-Hold','3'=>'Require-Client-Input','4'=>'Completed','5'=>'QA-Pending','6'=>'QA-Approved'),
    'task_status'=>array('1'=>'In-process','2'=>'On-Hold','3'=>'Require-Client-Input','4'=>'Completed'),
    'milestone_update_status'=>array('0'=>'New','1'=>'In-process','2'=>'On-Hold','3'=>'Require-Client-Input','4'=>'Completed'),
    'milestone_status_array'=>['In-process'=> '1','On-Hold'=>'2','Require-Client-Input'=>'3','Completed'=>'4','QA-Pending'=>'5','QA-Approved'=>'6'],
     'qa_pending_task_type' => array(
        '3' => 'Bug',
        '4' => 'Feedback',
        '5' => 'Suggestions',
        '6' => 'Support',
        '7' => 'R&D',
        '8' => 'Knowledge Transfer',
        '9' => 'Estimation',
        '10' => 'Client Call',
        '11' => 'Others',
    ),

];
