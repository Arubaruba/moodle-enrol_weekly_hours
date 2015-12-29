<?php

class enrol_weeklyhours_plugin extends enrol_plugin {

    /**
     * This is called when a course that the user is not enrolled yet is displayed
     * @param stdClass $course
     * @return string HTML displayed on course page
     */
    public function enrol_page_hook(stdClass $course) {
        return '<h3>Weekly hours enrol page hook</h3>';
    }

    /**
     * Returns true on success or a string which is an error message
     * @param stdClass $instance
     * @param bool $checkuserenrolment
     * @return bool|string
     */
    public function can_self_enrol(stdClass $instance, $checkuserenrolment = true) {
        global $DB, $USER;

        if ($checkuserenrolment && isguestuser()) {
            return get_string('guests_cannot_pay', 'enrol_weeklyhours');
        }

        if ($instance->status != ENROL_INSTANCE_ENABLED) {
            return get_string('canntenrol', 'enrol_weeklyhours');
        }

        if ($instance->enrolstartdate != 0 and $instance->enrolstartdate > time()) {
            return get_string('canntenrol', 'enrol_weeklyhours');
        }

        if ($instance->enrolenddate != 0 and $instance->enrolenddate < time()) {
            return get_string('canntenrol', 'enrol_weeklyhours');
        }

        if ($DB->record_exists('user_enrolments', array('userid' => $USER->id, 'enrolid' => $instance->id))) {
            return get_string('already_enrolled', 'enrol_weeklyhours');
        }

        return true;
    }

    public function get_newinstance_link($courseid) {
        $context = context_course::instance($courseid, MUST_EXIST);

        if (!has_capability('moodle/course:enrolconfig', $context) or !has_capability('enrol/weeklyhours:config', $context)) {
            return null;
        }
        // Multiple instances supported - different roles with different password.
        return new moodle_url('/enrol/weeklyhours/edit.php', array('courseid' => $courseid));
    }

    public function get_action_icons(stdClass $instance) {
        global $OUTPUT;

        if ($instance->enrol !== 'weeklyhours') {
            throw new coding_exception('invalid enrol instance!');
        }

        $context = context_course::instance($instance->courseid);

        $icons = array();

        if (has_capability('enrol/weeklyhours:config', $context)) {
            $editlink = new moodle_url("/enrol/weeklyhours/edit.php", array('courseid' => $instance->courseid, 'id' => $instance->id));

            array_push($icons, $OUTPUT->action_icon($editlink, new pix_icon('t/edit', get_string('edit'), 'core',
                array('class' => 'iconsmall'))));
        }

        return $icons;
    }

    public function allow_unenrol(stdClass $instance) {
        return true;
    }

    public function add_course_navigation($instancesnode, stdClass $instance) {
        if ($instance->enrol !== 'weeklyhours') {
            throw new coding_exception('Invalid enrol instance type!');
        }

        $context = context_course::instance($instance->courseid);
        if (has_capability('enrol/weeklyhours:config', $context)) {
            $managelink = new moodle_url('/enrol/weeklyhours/edit.php', array('courseid' => $instance->courseid, 'id' => $instance->id));
            $instancesnode->add($this->get_instance_name($instance), $managelink, navigation_node::TYPE_SETTING);
        }
    }

    /**
     * Is it possible to delete enrol instance via standard UI?
     *
     * @param object $instance
     * @return bool
     */
    public function can_delete_instance($instance) {
        $context = context_course::instance($instance->courseid);
        return has_capability('enrol/weeklyhours:config', $context);
    }

    public function get_instance_defaults() {
        return array();
    }
}
