@project-api
Feature: Get the random programs


  Background:
    Given there are users:
      | name     | password | token      | email               | id |
      | catrobat | 123456   | cccccccccc | dev1@pocketcode.org | 1  |
      | User1    | 123456   | cccccccccc | dev2@pocketcode.org | 2  |

    And there are programs:
      | id | name      | description             | owned by | views | upload time       |  FileSize  | version     |language version |
      | 1  | project 1 | project 1 description   | catrobat | 10    | 01.08.2014 12:00  |  1048576   |    0.8.5    |  0.993          |
      | 2  | project 2 | project 2 description   | User1    | 50    | 01.08.2014 12:00  |  1048576   |    0.8.5    |  0.234          |
      | 3  | project 3 | project 3 description   | User1    | 40    | 01.08.2014 12:00  |  1048576   |    0.8.5    |  0.122          |

  Scenario: show random programs
    Given I have a parameter "limit" with value "3"
    And I have a parameter "offset" with value "0"
    When I GET "/api/projects/randomPrograms" with these parameters
    Then I should get 3 programs in random order:
      """
      [
        {
            "id": "2",
            "name":"project 2",
            "author":"User1",
            "description":"project 2 description",
            "version":"0.8.5",
            "views": 50,
            "download": 1,
            "private":false,
            "flavor": {},
            "uploaded": 1406887200,
            "uploaded_string":"more than one year ago",
            "screenshot_large": "images/default/screenshot.png",
            "screenshot_small": "images/default/thumbnail.png",
            "projectUrl": "app/project/2",
            "downloadUrl": "app/download/2.catrobat",
            "filesize": 1
        },

        {
            "id": "1",
            "name":"project 1",
            "author":"catrobat",
            "description":"project 1 description",
            "version":"0.8.5",
            "views": 10,
            "download": 1,
            "private":false,
            "flavor": {},
            "uploaded": 1406887200,
            "uploaded_string":"more than one year ago",
            "screenshot_large": "images/default/screenshot.png",
            "screenshot_small": "images/default/thumbnail.png",
            "projectUrl": "app/project/1",
            "downloadUrl": "app/download/1.catrobat",
            "filesize": 1
        },
          {
            "id": "3",
            "name":"project 3",
            "author":"User1",
            "description":"project 3 description",
            "version":"0.8.5",
            "views": 40,
            "download": 1,
            "private":false,
            "flavor": {},
            "uploaded": 1406887200,
            "uploaded_string":"more than one year ago",
            "screenshot_large": "images/default/screenshot.png",
            "screenshot_small": "images/default/thumbnail.png",
            "projectUrl": "app/project/3",
            "downloadUrl": "app/download/3.catrobat",
            "filesize": 1
        }
      ]
      """

  Scenario: show random program with offset
    Given I have a parameter "limit" with value "1"
    And I have a parameter "offset" with value "0"
    When I GET "/api/projects/randomPrograms" with these parameters
    Then I should get 1 programs in random order:
     """
      [
        {
            "id": "2",
            "name":"project 2",
            "author":"User1",
            "description":"project 2 description",
            "version":"0.8.5",
            "views": 50,
            "download": 1,
            "private":false,
            "flavor": {},
            "uploaded": 1406887200,
            "uploaded_string":"more than one year ago",
            "screenshot_large": "images/default/screenshot.png",
            "screenshot_small": "images/default/thumbnail.png",
            "projectUrl": "app/project/2",
            "downloadUrl": "app/download/2.catrobat",
            "filesize": 1
        },

        {
            "id": "1",
            "name":"project 1",
            "author":"catrobat",
            "description":"project 1 description",
            "version":"0.8.5",
            "views": 10,
            "download": 1,
            "private":false,
            "flavor": {},
            "uploaded": 1406887200,
            "uploaded_string":"more than one year ago",
            "screenshot_large": "images/default/screenshot.png",
            "screenshot_small": "images/default/thumbnail.png",
            "projectUrl": "app/project/1",
            "downloadUrl": "app/download/1.catrobat",
            "filesize": 1
        },
          {
            "id": "3",
            "name":"project 3",
            "author":"User1",
            "description":"project 3 description",
            "version":"0.8.5",
            "views": 40,
            "download": 1,
            "private":false,
            "flavor": {},
            "uploaded": 1406887200,
            "uploaded_string":"more than one year ago",
            "screenshot_large": "images/default/screenshot.png",
            "screenshot_small": "images/default/thumbnail.png",
            "projectUrl": "app/project/3",
            "downloadUrl": "app/download/3.catrobat",
            "filesize": 1
        }
      ]
      """


  Scenario: show random program ids
    Given I have a parameter "limit" with value "2"
    And I have a parameter "offset" with value "0"
    When I GET "/api/projects/randomPrograms" with these parameters
    Then I should get 2 programs in random order:
     """
      [
        {
            "id": "2",
            "name":"project 2",
            "author":"User1",
            "description":"project 2 description",
            "version":"0.8.5",
            "views": 50,
            "download": 1,
            "private":false,
            "flavor": {},
            "uploaded": 1406887200,
            "uploaded_string":"more than one year ago",
            "screenshot_large": "images/default/screenshot.png",
            "screenshot_small": "images/default/thumbnail.png",
            "projectUrl": "app/project/2",
            "downloadUrl": "app/download/2.catrobat",
            "filesize": 1
        },

        {
            "id": "1",
            "name":"project 1",
            "author":"catrobat",
            "description":"project 1 description",
            "version":"0.8.5",
            "views": 10,
            "download": 1,
            "private":false,
            "flavor": {},
            "uploaded": 1406887200,
            "uploaded_string":"more than one year ago",
            "screenshot_large": "images/default/screenshot.png",
            "screenshot_small": "images/default/thumbnail.png",
            "projectUrl": "app/project/1",
            "downloadUrl": "app/download/1.catrobat",
            "filesize": 1
        },
          {
            "id": "3",
            "name":"project 3",
            "author":"User1",
            "description":"project 3 description",
            "version":"0.8.5",
            "views": 40,
            "download": 1,
            "private":false,
            "flavor": {},
            "uploaded": 1406887200,
            "uploaded_string":"more than one year ago",
            "screenshot_large": "images/default/screenshot.png",
            "screenshot_small": "images/default/thumbnail.png",
            "projectUrl": "app/project/3",
            "downloadUrl": "app/download/3.catrobat",
            "filesize": 1
        }
      ]
      """

    And I have a parameter "offset" with value "1"
    When I GET "/api/projects/randomPrograms" with these parameters
    Then I should get 2 programs in random order:
         """
      [
        {
            "id": "2",
            "name":"project 2",
            "author":"User1",
            "description":"project 2 description",
            "version":"0.8.5",
            "views": 50,
            "download": 1,
            "private":false,
            "flavor": {},
            "uploaded": 1406887200,
            "uploaded_string":"more than one year ago",
            "screenshot_large": "images/default/screenshot.png",
            "screenshot_small": "images/default/thumbnail.png",
            "projectUrl": "app/project/2",
            "downloadUrl": "app/download/2.catrobat",
            "filesize": 1
        },

        {
            "id": "1",
            "name":"project 1",
            "author":"catrobat",
            "description":"project 1 description",
            "version":"0.8.5",
            "views": 10,
            "download": 1,
            "private":false,
            "flavor": {},
            "uploaded": 1406887200,
            "uploaded_string":"more than one year ago",
            "screenshot_large": "images/default/screenshot.png",
            "screenshot_small": "images/default/thumbnail.png",
            "projectUrl": "app/project/1",
            "downloadUrl": "app/download/1.catrobat",
            "filesize": 1
        },
          {
            "id": "3",
            "name":"project 3",
            "author":"User1",
            "description":"project 3 description",
            "version":"0.8.5",
            "views": 40,
            "download": 1,
            "private":false,
            "flavor": {},
            "uploaded": 1406887200,
            "uploaded_string":"more than one year ago",
            "screenshot_large": "images/default/screenshot.png",
            "screenshot_small": "images/default/thumbnail.png",
            "projectUrl": "app/project/3",
            "downloadUrl": "app/download/3.catrobat",
            "filesize": 1
        }
      ]
      """

    And I have a parameter "offset" with value "3"
    When I GET "/api/projects/randomPrograms" with these parameters
    Then I should get 0 programs in random order:
          """
      [
        {
            "id": "2",
            "name":"project 2",
            "author":"User1",
            "description":"project 2 description",
            "version":"0.8.5",
            "views": 50,
            "download": 1,
            "private":false,
            "flavor": {},
            "uploaded": 1406887200,
            "uploaded_string":"more than one year ago",
            "screenshot_large": "images/default/screenshot.png",
            "screenshot_small": "images/default/thumbnail.png",
            "projectUrl": "app/project/2",
            "downloadUrl": "app/download/2.catrobat",
            "filesize": 1
        },

        {
            "id": "1",
            "name":"project 1",
            "author":"catrobat",
            "description":"project 1 description",
            "version":"0.8.5",
            "views": 10,
            "download": 1,
            "private":false,
            "flavor": {},
            "uploaded": 1406887200,
            "uploaded_string":"more than one year ago",
            "screenshot_large": "images/default/screenshot.png",
            "screenshot_small": "images/default/thumbnail.png",
            "projectUrl": "app/project/1",
            "downloadUrl": "app/download/1.catrobat",
            "filesize": 1
        },
          {
            "id": "3",
            "name":"project 3",
            "author":"User1",
            "description":"project 3 description",
            "version":"0.8.5",
            "views": 40,
            "download": 1,
            "private":false,
            "flavor": {},
            "uploaded": 1406887200,
            "uploaded_string":"more than one year ago",
            "screenshot_large": "images/default/screenshot.png",
            "screenshot_small": "images/default/thumbnail.png",
            "projectUrl": "app/project/3",
            "downloadUrl": "app/download/3.catrobat",
            "filesize": 1
        }
      ]
      """

   Scenario: Call API random programs with max version parameter
     Given I have a parameter "limit" with value "3"
     And I have a parameter "offset" with value "0"
     And I have a parameter "max_version" with value "0.433"
     When I GET "/api/projects/randomPrograms" with these parameters
     Then I should get 2 programs in random order:
      """
      [
      {
            "id": "2",
            "name":"project 2",
            "author":"User1",
            "description":"project 2 description",
            "version":"0.8.5",
            "views": 50,
            "download": 1,
            "private":false,
            "flavor": {},
            "uploaded": 1406887200,
            "uploaded_string":"more than one year ago",
            "screenshot_large": "images/default/screenshot.png",
            "screenshot_small": "images/default/thumbnail.png",
            "projectUrl": "app/project/2",
            "downloadUrl": "app/download/2.catrobat",
            "filesize": 1
        },

        {
            "id": "3",
            "name":"project 3",
            "author":"User1",
            "description":"project 3 description",
            "version":"0.8.5",
            "views": 40,
            "download": 1,
            "private":false,
            "flavor": {},
            "uploaded": 1406887200,
            "uploaded_string":"more than one year ago",
            "screenshot_large": "images/default/screenshot.png",
            "screenshot_small": "images/default/thumbnail.png",
            "projectUrl": "app/project/3",
            "downloadUrl": "app/download/3.catrobat",
            "filesize": 1
        }
      ]
      """

  Scenario: Calling random programs API with wrong max version
    Given I have a parameter "limit" with value "2"
    And I have a parameter "maxVersion" with value "0"
    When I GET "/api/projects/randomPrograms" with these parameters
    Then The status code of the response should be "400"


  Scenario: Calling random programs API without accept header
    Given I have a parameter "limit" with value "2"
    When I GET "/api/projects/randomPrograms" without the accept json header
    Then The status code of the response should be "406"