<?php

namespace enrol_weeklyhours;

require('../../config.php');
require_once('registration_form.php');

global $PAGE, $OUTPUT, $DB;

$course_id = required_param('courseid', PARAM_INT);
$course = $DB->get_record('course', array('id' => $course_id));

$PAGE->set_pagelayout('admin');
$PAGE->set_url('/enrol/weeklyhours/registration.php', array('courseid' => $course_id));

$mform = new registration_form();

if ($mform->is_cancelled()) {
    //TODO Handle form cancel operation, if cancel button is present on form
} else if ($data = $mform->get_data()) {
    //TODO In this case you process validated data. $mform->get_data() returns data posted in form.
} else {
    echo $OUTPUT->header();
    echo $OUTPUT->heading($course->fullname);
    $mform->display();
    echo $OUTPUT->footer();
}
