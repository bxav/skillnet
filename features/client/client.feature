@bellapi_client
Feature:
  In order to propose booking availability
  As a developer
  I need to check the availability and to search for business

  Background:
    Given I have a bellapi account

  Scenario: print businesses
    When I search for "employees"
    Then It should print resources