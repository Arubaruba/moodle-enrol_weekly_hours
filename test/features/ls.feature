Feature: ls
  In order to see the directory structure
  As a unix user
  I need to be able to list the current directory's structure

  Scenario: List 2 files in a directory
    Given I am in a directory "/tmp/weeklyhours"
    And I have a file named "foo"
    And I have a file named "bar"
    When I run "ls"
    Then I should get:
    """
    bar
    foo
    """