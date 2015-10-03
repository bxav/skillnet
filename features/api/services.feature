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

  @reset-schema
  Scenario: List services
    Given there is 5 services like:
      | business |
      | Haircut Master |
    Given I prepare a GET request on "/api/businesses/1/services"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response
    And scope into the first element
    And the properties exist:
    """
    type
    duration
    description
    price
    """
    
  @reset-schema
  Scenario: post service
    Given I specified the following request body:
    """
    {
        "type":"Brushing",
        "duration":45,
        "description":"lorem",
        "price":20.00
    }
    """
    Given I prepare a POST request on "/api/businesses/1/services"
    When I send the request
    Then print the last response
    Then I should receive a 201 json response

  @reset-schema
  Scenario: put business
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
    Given I prepare a PUT request on "/api/businesses/1/services/1"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response