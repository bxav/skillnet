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

  Scenario: Get employee
    Given there is 10 employees
    Given there is 1 employees like:
      | business | firstname | lastname |
      | Haircut Master | marie | dupond |
    Given I prepare a GET request on "/api/employees/marie-dupond"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response
    And the properties exist:
    """
    id
    firstname
    lastname
    """

  Scenario: List employee's services
    Given there is 1 services like:
      | type | business |
      | cut | Haircut Master |
    Given there is 1 services like:
      | type | business |
      | toto | Haircut Master |
    Given there is 1 employees like:
      | business | firstname | lastname |
      | Haircut Master | marie | dupond |
    Given "marie" propose:
     | toto | cut |
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
