<?php

require('../../config.php');

$courseid = 2;
$fields = array(
    'required_hours' => 200,
    'enrolstartdate' => 0,
    'enrolenddate' => 0,
);

global $DB;
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
echo enrol_get_plugin('weeklyhours')->add_instance($course, $fields);