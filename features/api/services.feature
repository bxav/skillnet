Feature: Access to the api

  Background:
    Given there is 1 business like:
      | name |
      | Haircut Master |
    Given the following users:
      | username | plainPassword | roles |
      | user | user | ROLE_API |
    Given assign to "user" authorization roles:
      | Service Manager |
    Given I specified the following request oauth2 credentials:
      | username | user |
      | password | user |

  @reset-schema
  Scenario: post service
    Given I specified the following request body:
    """
    {
        "type":"Brushing",
        "duration":45,
        "description":"lorem",
        "price":20.00,
        "business": 1
    }
    """
    Given I prepare a POST request on "/api/services/"
    When I send the request
    Then print the last response
    Then I should receive a 201 json response

  @reset-schema
  Scenario: patch business
    Given there is 1 services like:
      | business | type | duration |
      | Haircut Master | hair | 45 |
    Given I specified the following request body:
    """
    {
        "type":"brushing",
        "duration":30,
        "price":20.00
    }
    """
    Given I prepare a PATCH request on "/api/services/1"
    When I send the request
    Then print the last response
    Then I should receive a 204 response