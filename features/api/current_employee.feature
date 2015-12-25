Feature: Access to the api

  Background:
    Given there is 1 business like:
      | name |
      | Haircut Master |
    Given the following users:
      | username | plainPassword | roles |
      | user | user | ROLE_API |
      | marie | marie | ROLE_API |
    Given the following employee:
      | user | firstName | lastName | business |
      | marie | marie | dupond | Haircut Master |
    Given I specified the following request oauth2 credentials:
      | username | marie |
      | password | marie |

  Scenario: Get employee
    Given I prepare a GET request on "/api/employee"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response
    And the properties exist:
    """
    id
    first_name
    last_name
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
    Given I prepare a GET request on "/api/employee/services/"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response


  Scenario: Get current employee
    Given I prepare a GET request on "/api/employee/business"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response
    And the properties exist:
    """
    id
    name
    """


  @reset-schema
  Scenario: get current employee bookings
    Given there is 10 bookings like:
      | employee |
      | marie     |
    Given I prepare a GET request on "/api/employee/bookings/"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response

