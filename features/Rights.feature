Feature: Rights

  Scenario: Edit Group change rights and check
    Given I am authenticated as "admin"
    When I click on the element with css selector ".fa-desktop"
    Then I should wait until i see "Content type"
    And I click on the element with css selector "#nav-group"
    Then I should wait until i see "First group"
    When I click on the last element ".btn-warning"
    Then I should wait until i see "ROLE_ACCESS_CONTENT_TYPE"
    And I press "group_submit"
    Then I should wait until i see "The group has been updated"
    When I click on the element with css selector ".back-to-list"
    Then I should wait until i see "First group"
    And I should not see "Theme"
