Feature: Access to the api

  Background:
    Given there is 1 business like:
      | name |
      | Haircut Master |
    Given the following users:
      | username | plainPassword | roles |
      | user | user | ROLE_API |
    Given assign to "user" authorization roles:
      | Business Manager |
      | Employee Manager |
      | Service Manager |
    Given I specified the following request oauth2 credentials:
      | username | user |
      | password | user |

  Scenario: List business
    Given there is 10 business
    Given I prepare a GET request on "/api/businesses"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response

  @reset-schema
  Scenario: List employees
    Given the following users:
      | username | plainPassword | roles |
      | john | john | ROLE_API |
      | bea | bea | ROLE_API |
    Given the following employees:
      | business | user |
      | Haircut Master | john |
      | Haircut Master | bea |
    Given I prepare a GET request on "/api/businesses/1/employees"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response

  Scenario: post business
    Given I specified the following request body:
    """
    {
        "name":"Jean CoifCoif",
        "website":"coif.com",
        "phone":"0669696969",
        "email":"marie-dupond@example.com",
        "description":"lorem",
        "disponibilityTimeSlot":20
    }
    """
    Given I prepare a POST request on "/api/businesses/"
    When I send the request
    Then print the last response
    Then I should receive a 201 json response

  @reset-schema
  Scenario: put business
    Given I specified the following request body:
    """
    {
        "name":"Jean CoifCoif",
        "website":"coif.com",
        "phone":"0669696969",
        "email":"marie-dupond@example.com",
        "description":"lorem",
        "disponibilityTimeSlot":20
    }
    """
    Given I prepare a PUT request on "/api/businesses/1"
    When I send the request
    Then print the last response
    Then I should receive a 204 response

  @reset-schema
  Scenario: get business
    Given there is 1 address like:
      | business | current | name |
      | Haircut Master | true | jean jean |
    Given I prepare a GET request on "/api/businesses/1"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response


  @reset-schema
  Scenario: List services
    Given there is 5 services like:
      | business |
      | Haircut Master |
    Given I prepare a GET request on "/api/businesses/1/services"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response