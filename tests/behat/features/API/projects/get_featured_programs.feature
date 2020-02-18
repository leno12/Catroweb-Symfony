@project-api
Feature: Get featured programs

  Background:
    Given the server name is "pocketcode.org"
    And I use a secure connection
    Given there are users:
      | name     | password | token      | id |
      | Catrobat | 12345    | cccccccccc |  1 |
      | User1    | vwxyz    | aaaaaaaaaa |  2 |

    And there are programs:
      | id | name      | description             | owned by | views | upload time       |  FileSize  | version     |language version |
      | 1  | project 1 | project 1 description   | catrobat | 10    | 01.08.2014 12:00  |  1048576   |    0.8.5    |  0.993          |
      | 2  | project 2 | project 2 description   | User1    | 50    | 01.08.2014 12:00  |  1048576   |    0.8.5    |  0.234          |
      | 3  | project 3 | project 3 description   | User1    | 40    | 01.08.2014 12:00  |  1048576   |    0.8.5    |  0.122          |
    And following programs are featured:
      | name         | active | priority | ios_only |
      | project 3    | yes    | 1        | no       |
      | project 1    | yes    | 3        | yes      |
      | project 2    | yes    | 2        | no       |



  Scenario: show featured programs with limit 1 and offset 1
    Given I have a parameter "limit" with value "1"
    And I have a parameter "offset" with value "0"
    When I GET "/api/projects/featured" with these parameters
    Then I should get the json object:
    """
      [
        {
            "id": "3",
            "name":"project 3",
            "author":"User1",
            "featured_image": "resources_test/featured/featured_1.jpg"

        }
      ]
      """


#  Scenario: show featured programs with limit 10 and no offset
#    Given I have a parameter "limit" with value "10"
#    And I have a parameter "offset" with value "0"
#    When I GET "/app/api/projects/featured.json" with these parameters
#    Then I should get the json object:
#      """
#      {
#        "CatrobatProjects":
#          [
#            {
#              "ProjectId": "(.*?)",
#              "ProjectName":"A new world",
#              "Author":"User1",
#              "FeaturedImage":"resources_test/featured/featured_2.jpg"
#            },
#            {
#              "ProjectId": "(.*?)",
#              "ProjectName":"Soon to be",
#              "Author":"User1",
#              "FeaturedImage": "resources_test/featured/featured_3.jpg"
#            },
#            {
#              "ProjectId": "(.*?)",
#              "ProjectName": "Invaders",
#              "Author": "Catrobat",
#              "FeaturedImage": "resources_test/featured/featured_1.jpg"
#            }
#          ],
#         "preHeaderMessages":"",
#         "CatrobatInformation":
#          {
#            "BaseUrl":"http://pocketcode.org/",
#            "TotalProjects":"3",
#            "ProjectsExtension":".catrobat"
#          }
#      }
#      """
#
#  Scenario: show featured programs with limit and offset
#    Given I have a parameter "limit" with value "2"
#    And I have a parameter "offset" with value "0"
#    When I GET "/app/api/projects/featured.json" with these parameters
#    Then I should get the json object:
#      """
#      {
#        "CatrobatProjects":
#          [
#            {
#              "ProjectId": "(.*?)",
#              "ProjectName":"A new world",
#              "Author":"User1",
#              "FeaturedImage":"resources_test/featured/featured_2.jpg"
#             },
#             {
#              "ProjectId": "(.*?)",
#              "ProjectName":"Soon to be",
#              "Author":"User1",
#              "FeaturedImage": "resources_test/featured/featured_3.jpg"
#             }
#          ],
#         "preHeaderMessages":"",
#         "CatrobatInformation":
#          {
#            "BaseUrl":"http://pocketcode.org/",
#            "TotalProjects":"3",
#            "ProjectsExtension":".catrobat"
#          }
#      }
#      """
#
#  Scenario: show featured programs without limit and offset
#    When I GET "/app/api/projects/featured.json" with these parameters
#    Then I should get the json object:
#      """
#      {
#        "CatrobatProjects":
#          [
#            {
#              "ProjectId": "(.*?)",
#              "ProjectName":"A new world",
#              "Author":"User1",
#              "FeaturedImage":"resources_test/featured/featured_2.jpg"
#             },
#             {
#              "ProjectId": "(.*?)",
#              "ProjectName":"Soon to be",
#              "Author":"User1",
#              "FeaturedImage": "resources_test/featured/featured_3.jpg"
#             },
#             {
#              "ProjectId": "(.*?)",
#              "ProjectName":"Invaders",
#              "Author":"Catrobat",
#              "FeaturedImage": "resources_test/featured/featured_1.jpg"
#             }
#          ],
#         "preHeaderMessages":"",
#         "CatrobatInformation":
#          {
#            "BaseUrl":"http://pocketcode.org/",
#            "TotalProjects":"3",
#            "ProjectsExtension":".catrobat"
#          }
#      }
#      """
#
#  Scenario: show featured programs without limit and offset
#    When I GET "/app/api/projects/ios-featured.json" with these parameters
#    Then I should get the json object:
#      """
#      {
#        "CatrobatProjects":
#          [
#            {
#              "ProjectId": "(.*?)",
#              "ProjectName":"IOS test",
#              "Author":"User1",
#              "FeaturedImage":"resources_test/featured/featured_5.jpg"
#             }
#          ],
#        "preHeaderMessages":"",
#        "CatrobatInformation":
#        {
#          "BaseUrl":"http://pocketcode.org/",
#          "TotalProjects":"1",
#          "ProjectsExtension":".catrobat"
#        }
#      }
#      """
