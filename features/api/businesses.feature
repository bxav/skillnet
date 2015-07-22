Feature: Access to the api

  Background:
    Given the following user:
      | username | plainPassword | roles | enabled |
      | user | user | ROLE_API | true |
    Given I specified the following request http basic credentials:
      | username | user |
      | password | user |

  Scenario: List business
    Given there is 10 business
    Given I prepare a GET request on "/api/businesses"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response
    And scope into the first element
    And the properties exist:
    """
    name
    """