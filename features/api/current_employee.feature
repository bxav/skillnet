Feature: Access to the api

  Background:
    Given there is 1 business like:
      | name |
      | Haircut Master |
    Given the following employee:
      | username | plainPassword | roles | firstname | lastname | business |
      | user | user | ROLE_API | marie | dupond | Haircut Master |
    Given I specified the following request http basic credentials:
      | username | user |
      | password | user |

  @reset-schema
  Scenario: Get employee
    Given I prepare a GET request on "/api/current/employee"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response
    And the properties exist:
    """
    id
    firstname
    lastname
    """

  @reset-schema
  Scenario: put employee
    Given there is 1 employee like:
      | username | firstname | lastname |
      | customer | John | Duff |
    Given I specified the following request body:
    """
    {
        "username":"bob",
        "firstname":"bob",
        "lastname":"duff"
    }
    """
    Given I prepare a PUT request on "/api/current/employee"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response
