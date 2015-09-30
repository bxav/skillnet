Feature: Access to the api

  Background:
    Given there is 1 business like:
      | name |
      | Haircut Master |
    Given the following employee:
      | username | plainPassword | roles | enabled | firstname | lastname | business |
      | user | user | ROLE_API | true | marie | dupond | Haircut Master |
    Given I specified the following request http basic credentials:
      | username | user |
      | password | user |

  @reset-schema
  Scenario: Get employee
    Given I prepare a GET request on "/api/employees/1"
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
  Scenario: List employee's services
    Given there is 1 services like:
      | type | business |
      | cut | Haircut Master |
    Given there is 1 services like:
      | type | business |
      | toto | Haircut Master |
    Given "marie" propose:
     | toto | cut |
    Given I prepare a GET request on "/api/employees/1/services"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response
    And scope into the first element
    And the properties exist:
    """
    type
    duration
    description
    price
    """

  @reset-schema
  Scenario: Post employee
    Given I specified the following request body:
    """
    {
        "username":"bob",
        "plain_password":"toto",
        "enabled":true,
        "firstname":"bob",
        "lastname":"duff",
        "business":{"id":1},
        "email":"janne@example.com"
    }
    """
    Given I prepare a POST request on "/api/employees"
    When I send the request
    Then print the last response
    Then I should receive a 201 json response

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
        "lastname":"duff",
        "email":"janne@example.com"
    }
    """
    Given I prepare a PUT request on "/api/employees/1"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response
