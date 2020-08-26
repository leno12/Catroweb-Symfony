@api
Feature: Get recommended programs

  To find programs with tags and extensions, which are similar to the tags and extensions of one selected program

  Background:
    Given there are extensions:
      | id | name         | prefix  |
      | 1  | Arduino      | ARDUINO |
      | 2  | Drone        | DRONE   |
      | 3  | Lego         | LEGO    |
      | 4  | Phiro        | PHIRO   |
      | 5  | Raspberry Pi | RASPI   |
    And there are tags:
      | id | en           |
      | 1  | Games        |
      | 2  | Animation    |
      | 3  | Story        |
      | 4  | Music        |
      | 5  | Art          |
      | 6  | Experimental |
    And there are users:
      | name     | id |
      | Catrobat |  1 |
    And there are programs:
      | id | name    | description | owned by | downloads | views | upload time      | version | extensions | tags_id | debug |
      | 1  | Game    | p4          | Catrobat | 5         | 1     | 01.03.2013 12:00 | 0.8.5   |            | 5       | false |
      | 2  | Minions | p1          | Catrobat | 3         | 12    | 01.01.2013 12:00 | 0.8.5   | Lego,Phiro | 1,2,3,4 | false |
      | 3  | Galaxy  | p2          | Catrobat | 10        | 13    | 01.02.2013 12:00 | 0.8.5   | Lego,Drone | 1,2,3   | false |
      | 4  | Alone   | p3          | Catrobat | 5         | 1     | 01.03.2013 12:00 | 0.8.5   |            | 1,2     | false |
      | 5  | Trolol  | p5          | Catrobat | 5         | 1     | 01.03.2013 12:00 | 0.8.5   | Lego       | 5       | true  |


    Scenario: Get similar projects
      Given I have a request header "HTTP_ACCEPT" with value "application/json"
      And I request "GET" "/api/project/2/recommendations/?category=similar"
      Then the response status code should be "200"
      Then the response should have the projects model structure
      Then the response should contain projects in the following order:
        | Name       |
        | Game       |
