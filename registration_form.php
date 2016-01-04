<?php

namespace enrol_weeklyhours;


//moodleform is defined in formslib.php
use moodleform;

require_once("$CFG->libdir/formslib.php");

class registration_form extends moodleform {
    static $tutor_support_levels = array(33, 66, 100);

    //Add elements to form
    public function definition() {
        $mform = $this->_form; // Don't forget the underscore!

        // Header
        $mform->addElement('header', 'registration-options', get_string('registration_options', 'enrol_weeklyhours'));

        // Group Registration
        $mform->addElement('selectyesno', 'group_registration', get_string('group_registration', 'enrol_weeklyhours'));
        $mform->addHelpButton('group_registration', 'group_registration', 'enrol_weeklyhours');

        // Third Party
        $mform->addElement('selectyesno', 'third_party', get_string('third_party', 'enrol_weeklyhours'));
        $mform->addHelpButton('third_party', 'third_party', 'enrol_weeklyhours');

        // Level of Tutor Support
        $tutor_support_levels = array();
        foreach (registration_form::$tutor_support_levels as $hours_of_tutoring) {
            $tutor_support_levels[] =& $mform->createElement('radio', 'tutor_support_level', '',
               $hours_of_tutoring . ' ' . get_string('hours', 'enrol_weeklyhours'));
        }
        $mform->addGroup($tutor_support_levels, 'tutor_support_levels', get_string('level_of_tutor_support', 'enrol_weeklyhours'), array('<br>'), false);
        $mform->addHelpButton('tutor_support_levels', 'level_of_tutor_support', 'enrol_weeklyhours');
    }

    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}

