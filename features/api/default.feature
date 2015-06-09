Feature: Access to the api

  Scenario: Get response
    When I request "GET /api/"
    Then I get a "200" response
     And the "say" property exists
     And the "say" property contains 2 items