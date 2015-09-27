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

  Scenario: List business
    Given there is 10 business
    Given I prepare a GET request on "/api/test/businesses"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response
    And scope into the first element
    And the properties exist:
    """
    name
    """

  @reset-schema
  Scenario: List employees
    Given there is 10 employees like:
      | business |
      | Haircut Master |
    Given I prepare a GET request on "/api/test/businesses/1/employees"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response
    And scope into the first element
    And the properties exist:
    """
    firstname
    """

  @reset-schema
  Scenario: List services
    Given there is 5 services like:
      | business |
      | Haircut Master |
    Given I prepare a GET request on "/api/test/businesses/1/services"
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

  Scenario: post business
    Given I specified the following request body:
    """
    {
        "name":"Jean CoifCoif",
        "website":"coif.com",
        "phone":"0669696969",
        "email":"marie-dupond@example.com",
        "address":"10 rue les moulins",
        "description":"lorem",
        "disponibility_time_slot":20
    }
    """
    Given I prepare a POST request on "/api/test/businesses"
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
        "address":"10 rue les moulins",
        "description":"lorem",
        "disponibility_time_slot":20
    }
    """
    Given I prepare a PUT request on "/api/test/businesses/1"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response