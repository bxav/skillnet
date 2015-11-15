Feature: Access to the api
  Background:
    Given  there is 1 business like:
      | name | disponibilityTimeSlot |
      | Béa coiffure | 15 |
    Given the following users:
      | username | plainPassword | roles |
      | user | user | ROLE_API |
      | john | john | ROLE_API |
    And the following employee:
      | user | firstname | lastname | business |
      | user | marie | dupond | Béa coiffure |
    And the following services:
      | business | duration | type |
      | Béa coiffure | 30 | Coiffure |
      | Béa coiffure | 130 | Brushing |
    And there is 1 customer like:
      | user | firstname | lastname |
      | john | John | Duff |
    And the following bookings:
      | employee | service | customer | startDateTime | endDateTime |
      | marie | Coiffure | john | 2042-01-01 13:35:00.0 | 2042-01-01 17:30:00.0 |
      | marie | Brushing | john | 2042-01-01 07:30:00.0 | 2042-01-01 09:15:00.0 |
      | marie | Brushing | john | 2042-01-01 14:30:00.0 | 2042-01-01 16:20:00.0 |
    And the business "bea-coiffure" works from "wednesday" to "09:00" at "18:00"
    And I specified the following request oauth2 credentials:
      | username | user |
      | password | user |

  @reset-schema
  Scenario: List of availabilities
    Given I specified the following request queries:
      | date | 2042-01-01 |
      | service | 1 |
    Given I prepare a GET request on "/api/availabilities/"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response