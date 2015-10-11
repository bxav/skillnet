Feature: Access to the api
  Background:
    Given there is 1 business like:
      | name |
      | Haircut Master |
    Given the following employee:
      | username | plainPassword | roles | firstname | lastname | business |
      | user | user | ROLE_API | marie | dupond | Haircut Master |
    Given I specified the following request http basic credentials:
      | username | user |
      | password | user |
    Given there is 1 service like:
      | business | duration | type | id |
      | Haircut Master | 20 | haircut | id |


  @reset-schema
  Scenario: List employee's bookings
    Given there is 1 customer like:
      | username | firstname | lastname |
      | customer | John | Duff |
    Given there is 5 bookings like:
      | employee | service | customer |
      | marie | haircut | customer |
    Given I specified the following request queries:
      | employee | 1 |
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

  @reset-schema
  Scenario: post booking
    Given there is 1 customer like:
      | username | firstname | lastname |
      | customer | John | Duff |
    Given there is 10 bookings
    Given I specified the following request body:
    """
    {
        "start_datetime":"2015-09-26T11:55:20.000000+0200",
        "end_datetime":"2015-09-26T11:75:20.000000+0200",
        "employee":{"id":1},
        "customer":{"id":1},
        "service":{"id":1}
    }
    """
    Given I prepare a POST request on "/api/bookings"
    When I send the request
    Then print the last response
    Then I should receive a 201 json response

  @reset-schema
  Scenario: put booking
    Given the following customers:
      | username | firstname | lastname |
      | customer | John | Duff |
      | joe | Joe | Duff |
    Given the following bookings:
      | employee | service | customer | startDateTime | endDateTime |
      | user | haircut | customer | 2042-01-01 13:35:00.0 | 2042-01-01 17:30:00.0 |
    Given I specified the following request body:
    """
    {
        "end_datetime":"2015-09-26T11:75:20.000000+0200",
        "employee":{"id":1},
        "customer":{"id":2},
        "service":{"id":1}
    }
    """
    Given I prepare a Put request on "/api/bookings/1"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response