Feature: Access to the api

  Background:
    Given the following user:
      | username | plainPassword | roles |
      | user | user | ROLE_API |
    Given I specified the following request oauth2 credentials:
      | username | user |
      | password | user |

  Scenario: Get user
    Given I prepare a GET request on "/api/users"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response
