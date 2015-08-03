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

  Scenario: Get customer
    Given there is 1 customer like:
      | username | firstname | lastname |
      | customer | John | Duff |
    Given I prepare a GET request on "/api/customers/customer"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response
    And the properties exist:
    """
    firstname
    lastname
    username
    """


  Scenario: Post customer
    Given I specified the following request body:
    """
    {
        "username":"bob",
        "firstname":"bob",
        "lastname":"duff",
        "email":"janne@example.com"
    }
    """
    Given I prepare a POST request on "/api/customers"
    When I send the request
    Then print the last response
    Then I should receive a 201 json response