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
    Given there is 1 service like:
      | business | duration | type |
      | Haircut Master | 20 | haircut |

  Scenario: List employee's services
    Given there is 5 bookings like:
      | employee | service | clientName |
      | marie | haircut | John |
    Given I specified the following request queries:
      | employee | marie |
    Given I prepare a GET request on "/api/bookings"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response
    And scope into the first element
    And the properties exist:
    """
    start_datetime
    end_datetime
    """