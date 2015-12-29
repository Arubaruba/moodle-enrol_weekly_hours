<?php

defined('MOODLE_INTERNAL') || die();

require_once('../../lib/formslib.php');

class enrol_weeklyhours_edit_form extends moodleform {

    protected function definition() {

        list($instance, $plugin, $context) = $this->_customdata;

        $form = $this->_form;

        // Approximate number of hours required to complete course
        $form->addElement('text', 'hours_required', get_string('hours_required_label', 'enrol_weeklyhours'));

        // Hidden parameters
        $form->addElement('hidden', 'id');
        $form->setType('id', PARAM_INT);
        $form->addElement('hidden', 'courseid');
        $form->setType('courseid', PARAM_INT);

        $this->add_action_buttons(true, ($instance->id ? null : get_string('addinstance', 'enrol')));

        $this->set_data($instance);
    }

    function validation($data, $files) {
        $errors = parent::validation($data, $files);
        if (!$data['hours_required']) {
            $errors['hours_required'] = get_string('required');
        } else if (!is_numeric($data['hours_required'])) {
            $errors['hours_required'] = get_string('must_be_number', 'enrol_weeklyhours');
        }

        return $errors;
    }
}
