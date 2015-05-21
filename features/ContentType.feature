Feature: ContentType

  Scenario: Add content type
    Given I am authenticated as "admin"
    When I follow "Administration"
    And I follow "Content type"
    And I wait for AJAX to finish
    And I follow "Add"
    Then I should wait until i see "Content type id"
    When I reload the page
    Then I should wait until i see "Content type id"
    And I should be on "/admin/#content_types/add"
    When I fill in "Content type id" with "test content"
    And I press "Add field"
    Then I should see "Field id"
    When I press "Delete field"
    Then I should not see "Field id"
    When I press "Add field"
    When I fill in "Field id" with "first field id"
    And I select "Integer" from "Type"
    Then I should wait until i see "Rounding mode"
    And I should see "Format"
    When I fill in "Format" with "2"
    Then the "Format" field should contain "2"
    When I press "Add field"
    And I fill in last "Field id" with "second field id"
    And I press "Save"
    Then I should wait until i see "The content type has been created"
    When I follow "Back to list"
    And I wait for AJAX to finish
    And I should be on "/admin/#content_types/list"
    Then I should see "test content"

  Scenario: Edit content type and delete it
    Given I am authenticated as "admin"
    When I follow "Administration"
    And I follow "Content type"
    And I wait for AJAX to finish
    When I follow last "Edit"
    And I wait for AJAX to finish
    Then the "Content type id" field should contain "test content"
    And the "Format" field should contain "2"
    And I should see "Max length"
    When I press last "Delete field"
    Then I should not see "Max length"
    When I press "Save"
    Then I should wait until i see "The content type has been modified"
    And I should see "format"
    But I should not see "Max length"
    When I select "Money" from "Type"
    Then I should wait until i see "Precision"
    When I fill in "Precision" with "10"
    And I press "Save"
    Then I should wait until i see "The content type has been modified"
    And the "Precision" field should contain "10"
    When I follow "Back to list"
    And I wait for AJAX to finish
    And I follow last "Edit"
    And I wait for AJAX to finish
    Then I should wait until i see "Precision"
    And the "Precision" field should contain "10"
    When I follow "Back to list"
    And I wait for AJAX to finish
    And I should be on "/admin/#content_types/list"
    And I follow last "Delete"
    Then I should wait until i see "Delete this element"
    When I press "Yes"
    Then I should not see "test content"
    When I reload the page
    Then I should not see "test content"
