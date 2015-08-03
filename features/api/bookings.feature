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

  Scenario: List employee's bookings
    Given there is 1 customer like:
      | username | firstname | lastname |
      | customer | John | Duff |
    Given there is 5 bookings like:
      | employee | service | customer |
      | marie | haircut | customer |
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

  Scenario: post booking
    Given there is 1 customer like:
      | username | firstname | lastname |
      | customer | John | Duff |
    Given there is 10 bookings
    Given I specified the following request body:
    """
    {
        "start_datetime":"2015-08-03T08:43:29+0200",
        "end_datetime":"2015-08-03T08:43:29+0200",
        "customer_username":"customer",
        "employee_slug":"marie-dupond",
        "service_id":20
    }
    """
    Given I prepare a POST request on "/api/bookings"
    When I send the request
    Then print the last response
    Then I should receive a 201 json response