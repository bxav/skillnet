Feature: Access to the api

  Background:
    Given the following user:
      | username | plainPassword | roles | enabled |
      | user | user | ROLE_API | true |
    Given I specified the following request http basic credentials:
      | username | user |
      | password | user |
