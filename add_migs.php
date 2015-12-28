<?php

require('../../config.php');

global $DB;
$course = $DB->get_record('course', array('id' => 2), '*', MUST_EXIST);

$plugin = enrol_get_plugin('migs');
$fields = array(
    'cost' => 0,
    'enrolstartdate' => 0,
    'enrolenddate' => 0,
);

echo $plugin->add_instance($course, $fields);
