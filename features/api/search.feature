Feature: Access to the api

  Background:
    Given there is 1 business like:
      | name |
      | Haircut Master |
    Given the following users:
      | username | plainPassword | roles |
      | user | user | ROLE_API |
    Given I specified the following request oauth2 credentials:
      | username | user |
      | password | user |

  Scenario: List business
    Given there is 10 business
    Given I prepare a GET request on "/api/search/businesses"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response

  Scenario: List services
    Given there is 5 services like:
      | business |
      | Haircut Master |
    Given I specified the following request queries:
      | location[lat] | 40 |
      | location[lon] | -70 |
      | searchTerm | taxon |
      | searchParam | cleaning |
    Given I prepare a GET request on "/api/search/services"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response