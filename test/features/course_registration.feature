@core
Feature: Course Registration
  A student registers for a new course by:
  selecting a teacher
  selecting the desired tutoring hours
  paying for the course tutoring hours

  Scenario: A teacher is not teaching a course
    Given the following "users" exist:
      | username | firstname | lastname | email |
      | student1 | Student | 1 | student1@example.com |
      | student2 | Student | 2 | student2@example.com |
      | student3 | Student | 3 | student3@example.com |
#    Given A user "Teacher1" exists
#    And A course "Course1" exists
#    Then The available teachers for "Course1" should be:
#    """
#    """
#
#  Scenario: A teacher is teaching a course
#    Given A user "Teacher1" exists
#    And A course "Course1" exists
#    And "Teacher1" teaches "Course1"
#    Then The available teachers for "Course1" should be:
#    """
#    Teacher1
#    """
#
#  Scenario: A student is not enrolled in a course:
#    Given A user "Student1" exists
#    And A course "Course1" exists
#    When The user "Student1" goes on the course page of "Course1"
#    Then I should see "Available Teachers:"
