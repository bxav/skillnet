Feature: Access to the api

  Background:
    Given the following user:
      | username | plainPassword | roles |
      | user | user | ROLE_API |
    Given I specified the following request oauth2 credentials:
      | username | user |
      | password | user |

  @reset-schema
  Scenario: Get user
    Given I prepare a GET request on "/api/users/1"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response
    And the properties exist:
    """
    id
    """

  Scenario: List users
    Given there is 10 users
    Given I prepare a GET request on "/api/users"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response

  Scenario: Post user
    Given I specified the following request body:
    """
    {
        "username":"bob",
        "plainPassword":"toto"
    }
    """
    Given I prepare a POST request on "/api/users/"
    When I send the request
    Then print the last response
    Then I should receive a 201 json response

  @reset-schema
  Scenario: Put user
    Given I specified the following request body:
    """
    {
        "username":"bob",
        "plainPassword":"tototo"
    }
    """
    Given I prepare a PUT request on "/api/users/1"
    When I send the request
    Then print the last response
    Then I should receive a 204 response