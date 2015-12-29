<?php

require('../../config.php');

require_once('edit_form.php');

// Get params
$courseid = required_param('courseid', PARAM_INT);
$instanceid = optional_param('id', 0, PARAM_INT);

// Load course info and context
global $DB, $PAGE, $OUTPUT;
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$context = context_course::instance($course->id, MUST_EXIST);

// Make sure user is authorized
require_login($course);
require_capability('enrol/weeklyhours:config', $context);

// Setup the page
$PAGE->set_url('/enrol/weeklyhours/edit.php', array('courseid' => $course->id, 'id' => $instanceid));
$PAGE->set_pagelayout('admin');

// Set the return url and if the plugin is disabled (globally for moodle, not the course) go to this url immediately
$return = new moodle_url('/enrol/instances.php', array('id' => $course->id));
if (!enrol_is_enabled('weeklyhours')) redirect($return);

$plugin = enrol_get_plugin('weeklyhours');

// Retrieve plugin instance data
if ($instanceid) {
// If this plugin was already added to the course (has an instance id) we simply get it's info from the database
    $instance = $DB->get_record('enrol', array('courseid' => $course->id, 'enrol' => 'weeklyhours', 'id' => $instanceid), '*', MUST_EXIST);
} else {
// If not, we create a new instance
    require_capability('moodle/course:enrolconfig', $context);
    // No instance yet, we have to add new instance.
    navigation_node::override_active_url(new moodle_url('/enrol/instances.php', array('id' => $course->id)));

    $instance = (object)$plugin->get_instance_defaults();
    $instance->id = null;
    $instance->courseid = $course->id;
    $instance->status = ENROL_INSTANCE_ENABLED; // Do not use default for automatically created instances here.
}

// Deal with form submissions
$form = new enrol_weeklyhours_edit_form(null, array($instance, $plugin, $context));

if ($form->is_cancelled()) {
    redirect($return);
} else if ($data = $form->get_data()) {
    if ($instance->id) {

        $instance->hours_required = $data->hours_required;
        $instance->timemodified = time();

        $DB->update_record('enrol', $instance);
    } else {
        $fields = array(
            'hours_required' => $data->hours_required,
        );
        $plugin->add_instance($course, $fields);
    }
    redirect($return);
}

$PAGE->set_heading($course->fullname);
$PAGE->set_title(get_string('pluginname', 'enrol_weeklyhours'));

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pluginname', 'enrol_weeklyhours'));
$form->display();
echo $OUTPUT->footer();
