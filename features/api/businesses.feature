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

  Scenario: List employees
    Given there is 10 employees like:
      | business |
      | Haircut Master |
    Given I prepare a GET request on "/api/businesses/haircut-master/employees"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response
    And scope into the first element
    And the properties exist:
    """
    firstname
    """

  Scenario: List services
    Given there is 5 services like:
      | business |
      | Haircut Master |
    Given I prepare a GET request on "/api/businesses/haircut-master/services"
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