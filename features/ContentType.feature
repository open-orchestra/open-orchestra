Feature: ContentType

  Scenario: Add content type and delete it
    Given I am authenticated as "admin"
    When I click on the element with css selector ".fa-desktop"
    And I click on the element with css selector "#nav-content_types"
    And I wait for element "$('.bh-button-add').length > 0"
    And I click on the element with css selector ".bh-button-add"
    Then I should wait until i see "Content type id"
    When I reload the page
    Then I should wait until i see "Content type id"
    And I should be on "/admin/#content_types/add"
    When I fill in "content_type_names_0_value" with "test content type"
    And I click on the element with css selector ".prototype-add"
    Then I should wait until i see "Field id"
    When I fill in "content_type_fields_0_fieldId" with "first field id"
    And I fill in "content_type_fields_0_labels_0_value" with "first field label"
    And I press "content_type_submit"
    Then I should wait until i see "The content type has been created"
    When I click on the element with css selector ".back-to-list"
    Then I should wait until i see "test_content_type"
    And I should be on "/admin/#content_types/list"
    When I click on the last element ".btn-danger"
    Then I should wait until i see "Delete this element"
    When I press "bot2-Msg1"
    Then I should not see "test_content_type"
    When I reload the page
    Then I should not see "test_content_type"
