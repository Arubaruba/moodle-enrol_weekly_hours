<?php

defined('MOODLE_INTERNAL') || die();

$capabilities = array(
  /* Add, edit or remove weeklyhours enrol instance from course */
  'enrol/weeklyhours:config' => array(
    'captype' => 'write',
    'contextlevel' => CONTEXT_COURSE,
    'archetypes' => array(
      'manager' => CAP_ALLOW
    )
  ),

  'enrol/weeklyhours:manage' => array(

    'captype' => 'write',
    'contextlevel' => CONTEXT_COURSE,
    'archetypes' => array(
      'editingteacher' => CAP_ALLOW,
      'manager' => CAP_ALLOW,
    )
  ),

//  /* Voluntarily unenrol self from course - watch out for data loss. */
//  'enrol/weeklyhours:unenrolself' => array(
//    'captype' => 'write',
//    'contextlevel' => CONTEXT_COURSE,
//    'archetypes' => array(
//      'student' => CAP_ALLOW,
//    )
//  ),

  /* Unenrol anybody from course (including self) -  watch out for data loss. */
  'enrol/weeklyhours:unenrol' => array(
    'captype' => 'write',
    'contextlevel' => CONTEXT_COURSE,
    'archetypes' => array(
      'editingteacher' => CAP_ALLOW,
      'manager' => CAP_ALLOW,
    )
  ),
);
