Feature: Access to the api

  Background:
    Given there is 1 business like:
      | name |
      | Haircut Master |
    Given the following users:
      | username | plainPassword | roles |
      | user | user | ROLE_API |
      | marie | marie | ROLE_API |
    Given assign to "user" authorization roles:
      | Customer Manager |
      | Personalized Service Manager |
    Given I specified the following request oauth2 credentials:
      | username | user |
      | password | user |

  @reset-schema
  Scenario: Get customer
    Given there is 1 customer like:
      | user | firstname | lastname |
      | user | John | Duff |
    Given I prepare a GET request on "/api/customers/1"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response
    And the properties exist:
    """
    first_name
    last_name
    """

  @reset-schema
  Scenario: Post customer
    Given I specified the following request body:
    """
    {
        "firstName":"bob",
        "lastName":"duff",
        "user": 1
    }
    """
    Given I prepare a POST request on "/api/customers/"
    When I send the request
    Then print the last response
    Then I should receive a 201 json response

  @reset-schema
  Scenario: put customer
    Given there is 1 customer like:
      | user | firstname | lastname |
      | user | John | Duff |
    Given I specified the following request body:
    """
    {
        "firstName":"bob",
        "lastName":"duff"
    }
    """
    Given I prepare a PUT request on "/api/customers/1"
    When I send the request
    Then print the last response
    Then I should receive a 204 response

  @reset-schema
  Scenario: Get personalized services by service
    Given there is 1 customer like:
      | user | firstname | lastname |
      | user | John | Duff |
    And the following services:
      | business | duration | type |
      | Haircut Master | 30 | Coiffure |
    And the following personalizedServices:
      | duration | customer | service |
      | 30 | John | Coiffure |
    Given I specified the following request queries:
      | service | 1 |
    Given I prepare a GET request on "/api/customers/1/personalized-services"
    When I send the request
    Then print the last response

  @reset-schema
  Scenario: Get personalized services by id
    Given there is 1 customer like:
      | user | firstname | lastname |
      | user | John | Duff |
    And the following services:
      | business | duration | type |
      | Haircut Master | 30 | Coiffure |
    And the following personalizedServices:
      | duration | customer | service |
      | 30 | John | Coiffure |
    Given I prepare a GET request on "/api/customers/1/personalized-services/1"
    When I send the request
    Then print the last response

  @reset-schema
  Scenario: Post personalized service
    Given there is 1 customer like:
      | user | firstname | lastname |
      | user | John | Duff |
    And the following services:
    | business | duration | type |
    | Haircut Master | 30 | Coiffure |
    And I specified the following request body:
    """
    {
        "duration": 25,
        "price": 10.00,
        "service": 1,
        "customer": 1
    }
    """
    Given I prepare a POST request on "/api/customers/1/personalized-services"
    When I send the request
    Then print the last response
    Then I should receive a 201 json response

  @reset-schema
  Scenario: Patch personalized service
    Given there is 1 customer like:
      | user | firstname | lastname |
      | user | John | Duff |
    And the following services:
      | business | duration | type |
      | Haircut Master | 30 | Coiffure |
    And there is 1 PersonalizedService like:
      | customer | service | price | duration |
      | John | Coiffure | 10 | 10 |
    And I specified the following request body:
    """
    {
        "duration": 25,
        "price": 30.00
    }
    """
    Given I prepare a Patch request on "/api/customers/1/personalized-services/1"
    When I send the request
    Then print the last response
    Then I should receive a 204 response