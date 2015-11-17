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
    Given assign to "marie" authorization roles:
      | Employee Manager |
      | Service Manager |
      | Booking Manager |
    Given I specified the following request oauth2 credentials:
      | username | marie |
      | password | marie |

  Scenario: Get employees
    Given I prepare a GET request on "/api/employees/"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response



  @reset-schema
  Scenario: post booking
    Given there is 1 service like:
      | business | duration | type | id |
      | Haircut Master | 20 | haircut | id |
    Given there is 1 customer like:
      | user | firstname | lastname |
      | john | john | duff |
    Given there is 10 bookings
    Given I specified the following request body:
    """
    {
        "startDatetime":"2015-11-06T09:51:36+0100",
        "endDatetime":"2015-11-06T10:51:36+0100",
        "customer": 1,
        "service": 1
    }
    """
    Given I prepare a POST request on "/api/employees/1/bookings"
    When I send the request
    Then print the last response
    Then I should receive a 201 json response

  @reset-schema
  Scenario: Get employee
    Given I prepare a GET request on "/api/employees/1"
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
    Given I prepare a GET request on "/api/employees/1/services"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response

  @reset-schema
  Scenario: Post employee
    Given I specified the following request body:
    """
    {
        "firstName":"bob",
        "lastName":"duff",
        "business": 1,
        "user": 1
    }
    """
    Given I prepare a POST request on "/api/employees/"
    When I send the request
    Then print the last response
    Then I should receive a 201 json response

  @reset-schema
  Scenario: patch employee
    Given there is 1 employee like:
      | user | firstname | lastname |
      | user | John | Duff |
    Given I specified the following request body:
    """
    {
        "firstName":"bob",
        "lastName":"duff"
    }
    """
    Given I prepare a PATCH request on "/api/employees/1"
    When I send the request
    Then print the last response
    Then I should receive a 204 response


  Scenario: Get current employee
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
