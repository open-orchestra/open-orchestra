Feature: Login

  Scenario: Failed login
    Given I am on "/login"
    When I fill in "username" with "zezze15"
    And I fill in "password" with "azeopfjaop"
    And I press "_submit"
    Then I should see "Bienvenue sur PHP Orchestra"

  Scenario: Login success
    Given I am on "/login"
    When I fill in "_username" with "nicolas"
    And I fill in "_password" with "nicolas"
    And I press "_submit"
    Then I should see "Dashboard"
    And I click on the element with css selector "#refresh"
    And I wait some second "2"
    Then I should see "Clear Local Storage"
    And I press "bot2-Msg1"
    And I wait some second "3"
    Then I should see "Dashboard"
