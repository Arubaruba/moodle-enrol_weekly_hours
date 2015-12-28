<?php

require('../../config.php');

global $DB;
$course = $DB->get_record('course', array('id' => 2), '*', MUST_EXIST);

$plugin = enrol_get_plugin('weekly_hours');
$fields = array(
    'hours_required' => 100
);

echo $plugin->add_instance($course, $fields);
