Feature: Access to the Home page
  In order to access the app
  As an user
  I need to be able to access the frontend

  Scenario: User login
    Given I am on "/helloYou"
    Then I should see "Bootstrap starter template"
     And I should see "helloYou"