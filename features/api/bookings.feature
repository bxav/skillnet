Feature: Access to the api
  Background:
    Given there is 1 business like:
      | name |
      | Haircut Master |
    Given the following users:
      | username | plainPassword | roles |
      | user | user | ROLE_API |
      | marie | marie | ROLE_API |
      | john | john | ROLE_API |
    Given the following employee:
      | user | firstname | lastname | business |
      | marie | marie | dupond | Haircut Master |
    Given assign to "user" authorization roles:
      | Booking Manager |
    Given I specified the following request oauth2 credentials:
      | username | user |
      | password | user |
    Given there is 1 service like:
      | business | duration | type | id |
      | Haircut Master | 20 | haircut | id |


  @reset-schema
  Scenario: List employee's bookings
    Given there is 1 customer like:
      | user | firstname | lastname |
      | john | john | duff |
    Given there is 5 bookings like:
      | employee | service | customer |
      | marie | haircut | john |
    Given I specified the following request queries:
      | criteria[employee] | 1 |
    Given I prepare a GET request on "/api/bookings/"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response

  @reset-schema
  Scenario: post booking
    Given there is 1 customer like:
      | user | firstname | lastname |
      | john | john | duff |
    Given there is 10 bookings
    Given I specified the following request body:
    """
    {
        "startDatetime":"2015-11-06T09:51:36+0100",
        "endDatetime":"2015-11-06T10:51:36+0100",
        "employee": 1,
        "customer": 1,
        "service": 1
    }
    """
    Given I prepare a POST request on "/api/bookings/"
    When I send the request
    Then print the last response
    Then I should receive a 201 json response

  @reset-schema
  Scenario: patch booking
    Given the following customers:
      | user | firstname | lastname |
      | john | john | duff |
    Given the following bookings:
      | employee | service | customer | startDateTime | endDateTime |
      | marie | haircut | john | 2042-01-01 13:35:00.0 | 2042-01-01 17:30:00.0 |
    Given I specified the following request body:
    """
    {
        "endDatetime":"2015-11-06T09:51:36+0100",
        "employee": 1,
        "customer": 1,
        "service": 1
    }
    """
    Given I prepare a PATCH request on "/api/bookings/1"
    When I send the request
    Then print the last response
    Then I should receive a 204 response