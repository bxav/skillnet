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
  Scenario: Get customer
    Given there is 1 customer like:
      | username | firstname | lastname |
      | customer | John | Duff |
    Given I prepare a GET request on "/api/customers/2"
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
        "plain_password":"toto",
        "enabled":true,
        "firstname":"bob",
        "lastname":"duff",
        "email":"janne@example.com"
    }
    """
    Given I prepare a POST request on "/api/customers"
    When I send the request
    Then print the last response
    Then I should receive a 201 json response

  @reset-schema
  Scenario: put customer
    Given there is 1 customer like:
      | username | firstname | lastname |
      | customer | John | Duff |
    Given I specified the following request body:
    """
    {
        "username":"bob",
        "firstname":"bob",
        "lastname":"duff",
        "email":"janne@example.com"
    }
    """
    Given I prepare a PUT request on "/api/customers/2"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response


  @reset-schema
  Scenario: Post personalized service
    Given there is 1 customer like:
      | username | firstname | lastname |
      | customer | John | Duff |
    And the following services:
    | business | duration | type |
    | Haircut Master | 30 | Coiffure |
    And I specified the following request body:
    """
    {
        "duration": 25,
        "price": 10.00,
        "service":{"id":1}
    }
    """
    Given I prepare a POST request on "/api/customers/2/personalizations/services"
    When I send the request
    Then print the last response
    Then I should receive a 201 json response

  @reset-schema
  Scenario: Put personalized service
    Given there is 1 customer like:
      | username | firstname | lastname |
      | customer | John | Duff |
    And the following services:
      | business | duration | type |
      | Haircut Master | 30 | Coiffure |
    And there is 1 PersonalizedService like:
      | customer | service | price | duration |
      | customer | Coiffure | 10 | 10 |
    And I specified the following request body:
    """
    {
        "duration": 25,
        "price": 30.00
    }
    """
    Given I prepare a Put request on "/api/customers/2/personalizations/services/1"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response