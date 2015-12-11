Feature: Access to the api

  Background:
    Given there is 1 business like:
      | name |
      | Haircut Master |

  Scenario: Search business
    Given there is 10 business
    Given I prepare a GET request on "/api/search/businesses"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response

  Scenario: Search services
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

  @reset-schema
  Scenario: Search services by business

    Given there is 1 business like:
      | name |
      | Beuaty |
    Given there is 5 services like:
      | business |
      | Haircut Master |
    Given there is 2 services like:
      | business |
      | Beuaty |
    Given I specified the following request queries:
      | location[lat] | 40 |
      | location[lon] | -70 |
      | searchTerm | taxon |
      | searchParam | cleaning |
      | criteria[business] | 2 |
    Given I prepare a GET request on "/api/search/services"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response