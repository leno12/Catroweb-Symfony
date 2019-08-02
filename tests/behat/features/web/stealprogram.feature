@homepage
Feature: There should be a steal button on every program page to steal the program

  Background:
    Given there are users:
      | name     | password | token      | email               |
      | Catrobat | 123456   | cccccccccc | dev1@pocketcode.org |
      | User2    | 654321   | cccccccccc | dev2@pocketcode.org |
      | User3    | 654321   | cccccccccc | dev3@pocketcode.org |
    And there are programs:
      | id | name       | description | owned by | downloads | apk_downloads | views | upload time      | version |
      | 1  | oldestProg | p1          | Catrobat | 3         | 2             | 12    | 01.01.2009 12:00 | 0.8.5   |
      | 2  | program 02 |             | Catrobat | 333       | 123           | 9     | 22.04.2014 13:00 | 0.8.5   |
      | 3  | program 03 |             | User2    | 133       | 63            | 33    | 01.01.2012 13:00 | 0.8.5   |
      | 4  | program 04 |             | User2    | 133       | 63            | 33    | 01.01.2012 13:00 | 0.8.5   |
      | 5  | program 05 |             | User2    | 133       | 63            | 33    | 01.01.2012 13:00 | 0.8.5   |
      | 6  | program 06 |             | User2    | 133       | 63            | 33    | 01.01.2012 13:00 | 0.8.5   |
      | 7  | program 07 |             | User2    | 133       | 63            | 33    | 01.01.2012 13:00 | 0.8.5   |
      | 8  | program 08 |             | User2    | 133       | 63            | 33    | 01.01.2012 13:00 | 0.8.5   |
      | 9  | program 09 |             | User2    | 133       | 63            | 33    | 01.01.2012 13:00 | 0.8.5   |

  Scenario: on any program page there should always be a steal button
    Given I log in as "Catrobat" with the password "123456"
    And I am on "/pocketcode/program/4"
    And the element "#steal-program-button" should be visible


  Scenario: User clicks on the steal button
    Given I log in as "User3" with the password "654321"
    And I am on "/pocketcode/program/4"
    When I click "#steal-program-button"
    Then I wait 10 milliseconds
    When I am on "/pocketcode/profile"
    Then I should see 1 "#myprofile-programs .program"
    And I should see "program 04"


  Scenario: Another User clicks on the steal button
    Given I log in as "Catrobat" with the password "123456"
    And I am on "/pocketcode/program/8"
    When I click "#steal-program-button"
    Then I wait 10 milliseconds
    When I am on "/pocketcode/profile"
    Then I should see 3 "#myprofile-programs .program"
    And  I should see "program 08"
