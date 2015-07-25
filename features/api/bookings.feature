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
    Given there is 1 employees like:
      | business | firstname |
      | Haircut Master | marie |
    Given there is 1 service like:
      | employee | duration | type |
      | marie | 20 | haircut |

  Scenario: List employee's services
    Given there is 5 bookings like:
      | service | clientName |
      | haircut | John |
    Given I prepare a GET request on "/api/bookings?employee=marie"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response
    And scope into the first element
    And the properties exist:
    """
    start_datetime
    end_datetime
    """