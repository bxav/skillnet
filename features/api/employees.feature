Feature: Access to the api

  Background:
    Given the following user:
      | username | plainPassword | roles | enabled |
      | user | user | ROLE_API | true |
    Given I specified the following request http basic credentials:
      | username | user |
      | password | user |
    Given there is 1 business like:
      | name |
      | Haircut Master |

  Scenario: List employee's services
    Given there is 1 employees like:
      | business | firstname | lastname |
      | Haircut Master | marie | dupond |
    Given there is 5 services like:
      | employee |
      | marie |
    Given I prepare a GET request on "/api/employees/marie-dupond/services"
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