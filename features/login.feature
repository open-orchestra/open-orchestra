Feature: Login

  Scenario: Failed login
    Given I am on "/login"
    When I fill in "username" with "zezze15"
    And I fill in "password" with "azeopfjaop"
    And I press "_submit"
    Then I should see "Bienvenue sur PHP Orchestra"

  Scenario: Login success
    Given I am on "/login"
    When I fill in "_username" with "admin"
    And I fill in "_password" with "admin"
    And I press "_submit"
    Then I should see "Dashboard"
    When I click on the element with css selector "#refresh"
    Then I should wait until i see "Clear Local Storage"
    When I press "bot2-Msg1"
    Then I should wait until i see "Dashboard"
