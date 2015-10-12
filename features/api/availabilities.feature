Feature: Access to the api
  Background:
    Given  there is 1 business like:
      | name | disponibilityTimeSlot |
      | Béa coiffure | 15 |
    And the following employee:
      | username | plainPassword | roles | firstname | lastname | business |
      | user | user | ROLE_API | marie | dupond | Béa coiffure |
    And the following services:
      | business | duration | type |
      | Béa coiffure | 30 | Coiffure |
      | Béa coiffure | 130 | Brushing |
    And there is 1 customer like:
      | username | plainPassword | firstname | lastname |
      | john | john | John | Duff |
    And the following bookings:
      | employee | service | customer | startDateTime | endDateTime |
      | user | Coiffure | john | 2042-01-01 13:35:00.0 | 2042-01-01 17:30:00.0 |
      | user | Brushing | john | 2042-01-01 07:30:00.0 | 2042-01-01 09:15:00.0 |
      | user | Brushing | john | 2042-01-01 14:30:00.0 | 2042-01-01 16:20:00.0 |
    And the business "bea-coiffure" works from "wednesday" to "09:00" at "18:00"
    And I specified the following request http basic credentials:
      | username | user |
      | password | user |

  @reset-schema
  Scenario: List of availabilities
    Given I specified the following request queries:
      | date | 2042-01-01 |
      | service-id | 1 |
    Given I prepare a GET request on "/api/availabilities"
    When I send the request
    Then print the last response
    Then I should receive a 200 json response
    And the properties exist:
    """
    09:30
    10:15
    """