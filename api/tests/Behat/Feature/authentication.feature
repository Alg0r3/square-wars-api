Feature: JWT Authentication

  Scenario: Successful user authentication
    Given a user with valid credentials
    When the user attempts to authenticate in the API
    Then the response status code should be 200
    And a JWT token should be successfully returned

  Scenario: Failed user authentication
    Given a user with invalid credentials
    When the user attempts to authenticate in the API
    Then the response status code should be 401
