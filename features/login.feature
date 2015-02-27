Feature: Login

#  @javascript
  Scenario: Failed login
    Given I am on "/login"
    When I fill in "username" with "test"
    And I fill in "password" with "test"
    And I press "_submit"
    Then I should see "Bienvenue sur PHP Orchestra"

#  @javascript
  Scenario: Login success
    Given I am on "/login"
    When I fill in "_username" with "nicolas"
    And I fill in "_password" with "nicolas"
    And I press "_submit"
    Then I should see "Dashboard"