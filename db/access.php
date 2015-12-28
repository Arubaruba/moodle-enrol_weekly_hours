<?php

defined('MOODLE_INTERNAL') || die();

$capabilities = array(
  /* Add, edit or remove weekly_hours enrol instance from course */
  'enrol/weekly_hours:config' => array(
    'captype' => 'write',
    'contextlevel' => CONTEXT_COURSE,
    'archetypes' => array(
      'manager' => CAP_ALLOW
    )
  ),

  'enrol/weekly_hours:manage' => array(

    'captype' => 'write',
    'contextlevel' => CONTEXT_COURSE,
    'archetypes' => array(
      'editingteacher' => CAP_ALLOW,
      'manager' => CAP_ALLOW,
    )
  ),

//  /* Voluntarily unenrol self from course - watch out for data loss. */
//  'enrol/weekly_hours:unenrolself' => array(
//    'captype' => 'write',
//    'contextlevel' => CONTEXT_COURSE,
//    'archetypes' => array(
//      'student' => CAP_ALLOW,
//    )
//  ),

  /* Unenrol anybody from course (including self) -  watch out for data loss. */
  'enrol/weekly_hours:unenrol' => array(
    'captype' => 'write',
    'contextlevel' => CONTEXT_COURSE,
    'archetypes' => array(
      'editingteacher' => CAP_ALLOW,
      'manager' => CAP_ALLOW,
    )
  ),
);
