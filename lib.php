<?php

class enrol_weekly_hours_plugin extends enrol_plugin {

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
            return get_string('guests_cannot_pay', 'enrol_weekly_hours');
        }

        if ($instance->status != ENROL_INSTANCE_ENABLED) {
            return get_string('canntenrol', 'enrol_weekly_hours');
        }

        if ($instance->enrolstartdate != 0 and $instance->enrolstartdate > time()) {
            return get_string('canntenrol', 'enrol_weekly_hours');
        }

        if ($instance->enrolenddate != 0 and $instance->enrolenddate < time()) {
            return get_string('canntenrol', 'enrol_weekly_hours');
        }

        if ($DB->record_exists('user_enrolments', array('userid' => $USER->id, 'enrolid' => $instance->id))) {
            return get_string('already_enrolled', 'enrol_weekly_hours');
        }

        return true;
    }

    public function get_newinstance_link($courseid) {
        $context = context_course::instance($courseid, MUST_EXIST);

        if (!has_capability('moodle/course:enrolconfig', $context) or !has_capability('enrol/weekly_hours:config', $context)) {
            return null;
        }
        // Multiple instances supported - different roles with different password.
        return new moodle_url('/enrol/weekly_hours/edit.php', array('courseid' => $courseid));
    }

    public function get_user_enrolment_actions(course_enrolment_manager $manager, $ue) {
        $actions = array();
        $context = $manager->get_context();
        $instance = $ue->enrolmentinstance;
        $params = $manager->get_moodlepage()->url->params();
        $params['ue'] = $ue->id;
        if ($this->allow_unenrol($instance) && has_capability("enrol/weekly_hours:unenrol", $context)) {
            $url = new moodle_url('/enrol/unenroluser.php', $params);
            $actions[] = new user_enrolment_action(new pix_icon('t/delete', ''), get_string('unenrol', 'enrol'), $url, array('class'=>'unenrollink', 'rel'=>$ue->id));
        }
        if ($this->allow_manage($instance) && has_capability("enrol/weekly_hours:manage", $context)) {
            $url = new moodle_url('/enrol/editenrolment.php', $params);
            $actions[] = new user_enrolment_action(new pix_icon('t/edit', ''), get_string('edit'), $url, array('class'=>'editenrollink', 'rel'=>$ue->id));
        }
        return $actions;
    }

    public function allow_unenrol(stdClass $instance) {
        return true;
    }

    public function add_course_navigation($instancesnode, stdClass $instance) {
        if ($instance->enrol !== 'weekly_hours') {
            throw new coding_exception('Invalid enrol instance type!');
        }

        $context = context_course::instance($instance->courseid);
        if (has_capability('enrol/weekly_hours:config', $context)) {
            $managelink = new moodle_url('/enrol/weekly_hours/edit.php', array('courseid' => $instance->courseid, 'id' => $instance->id));
            $instancesnode->add($this->get_instance_name($instance), $managelink, navigation_node::TYPE_SETTING);
        }
    }

    public function get_action_icons(stdClass $instance) {
        global $OUTPUT;

        if ($instance->enrol !== 'weekly_hours') {
            throw new coding_exception('invalid enrol instance!');
        }
        $context = context_course::instance($instance->courseid);

        $icons = array();

        if (has_capability('enrol/weekly_hours:config', $context)) {
            $deletelink = new moodle_url("/enrol/instances.php", array(
                'sesskey' => sesskey(),
                'id' => $instance->courseid,
                'action' => 'delete',
                'instance' => $instance->id,
            ));
            array_push($icons, $OUTPUT->action_icon($deletelink, new pix_icon('t/delete', get_string('delete'), 'core',
                array('class' => 'iconsmall'))));


            $editlink  = new moodle_url("/enrol/weekly_hours/edit.php", array('courseid' => $instance->courseid, 'id' => $instance->id));

            array_push($icons, $OUTPUT->action_icon($editlink, new pix_icon('t/edit', get_string('edit'), 'core',
                array('class' => 'iconsmall'))));
        }

        return $icons;
    }
    /**
     * Is it possible to delete enrol instance via standard UI?
     *
     * @param object $instance
     * @return bool
     */
    public function can_delete_instance($instance) {
        $context = context_course::instance($instance->courseid);
        return has_capability('enrol/weekly_hours:config', $context);
    }

    public function get_instance_defaults() {
        return array();
    }
}
