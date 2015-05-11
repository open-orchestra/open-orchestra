<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements KernelAwareContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @param $userName
     *
     * @Given /^I am authenticated as "([^"]*)"$/
     */
    public function iAmAuthenticatedAs($userName)
    {
        $this->visit('/logout');
        $this->visit('/login');

        $this->fillField('username', $userName);
        $this->fillField('password', $userName);

        $this->pressButton('_submit');

        $this->assertPageContainsText('Dashboard');
    }

    /**
     * Click on the element with the provided Css Selector
     *
     * @param string $cssSelector
     *
     * @When /^I click on the element with css selector "([^"]*)"$/
     */
    public function iClickOnTheElementWithCssSelector($cssSelector)
    {
        $element = $this->getPage()->find(
            'xpath',
            $this->getSession()->getSelectorsHandler()->selectorToXpath('css', $cssSelector) // just changed xpath to css
        );
        if (null === $element) {
            throw new \InvalidArgumentException(sprintf('Could not evaluate CSS Selector: "%s"', $cssSelector));
        }

        $element->click();
    }

    /**
     * Click on the element with the provided Css query
     *
     * @param string $css
     *
     * @When /^I click on the last element "([^"]*)"$/
     */
    public function iClickOnTheLastElement($css)
    {
        $elements = $this->getPage()->findAll('css', $css);

        $element = end($elements);

        if (null === $element) {
            throw new \InvalidArgumentException(sprintf('Could not evaluate CSS query: "%s"', $css));
        }

        $element->click();
    }

    /**
     * Wait for an element to appear
     *
     * @param string $element
     *
     * @When /^I wait for element "([^"]*)"$/
     */
    public function iWaitForElement($element)
    {
        $this->getSession()->wait(10000, $element);
    }

    /**
     * @param string $text
     *
     * @Then /^I should wait until i see "(?P<text>(?:[^"]|\\")*)"$/
     */
    public function iShouldWaitUntilISee($text)
    {
        $this->iWaitForAjaxToFinish();
        $this->assertPageContainsText($text);
    }

    /**
     * Wait for AJAX to finish.
     *
     * @Given /^I wait for AJAX to finish$/
     */
    public function iWaitForAjaxToFinish()
    {
        $this->iWaitForElement('(typeof(jQuery)=="undefined" || (0 === jQuery.active && 0 === jQuery(\':animated\').length))');
    }

    /**
     * Clicks link with specified id|title|alt|text.
     *
     * @When /^(?:|I )follow last "(?P<link>(?:[^"]|\\")*)"$/
     */
    public function clickLastLink($link)
    {
        $link = $this->fixStepArgument($link);

        $links = $this->getSession()->getPage()->findAll('named', array(
            'link', $this->getSession()->getSelectorsHandler()->xpathLiteral($link),
        ));

        $link = end($links);

        if (null === $link) {
            throw new \InvalidArgumentException(sprintf('Could not found link: "%s"', $link));
        }

        $link->click();
    }

    /**
     * Fills in last form field with specified id|name|label|value.
     *
     * @When /^(?:|I )fill in last "(?P<field>(?:[^"]|\\")*)" with "(?P<value>(?:[^"]|\\")*)"$/
     * @When /^(?:|I )fill in last "(?P<field>(?:[^"]|\\")*)" with:$/
     * @When /^(?:|I )fill in last "(?P<value>(?:[^"]|\\")*)" for "(?P<field>(?:[^"]|\\")*)"$/
     */
    public function fillLastField($field, $value)
    {
        $field = $this->fixStepArgument($field);
        $value = $this->fixStepArgument($value);

        $fields = $this->getSession()->getPage()->findAll('named', array(
            'field', $this->getSession()->getSelectorsHandler()->xpathLiteral($field),
        ));

        $field = end($fields);

        if (null === $field) {
            throw new \InvalidArgumentException(sprintf('Could not found field: "%s"', $field));
        }

        $field->setValue($value);
    }

    /**
     * Presses last button with specified id|name|title|alt|value.
     *
     * @When /^(?:|I )press last "(?P<button>(?:[^"]|\\")*)"$/
     */
    public function pressLastButton($button)
    {
        $button = $this->fixStepArgument($button);

        $buttons = $this->getSession()->getPage()->findAll('named', array(
            'button', $this->getSession()->getSelectorsHandler()->xpathLiteral($button),
        ));

        $button = end($buttons);

        if (null === $button) {
            throw new \InvalidArgumentException(sprintf('Could not found button: "%s"', $button));
        }

        $button->press();
    }

    /**
     * @return \Behat\Mink\Element\DocumentElement
     */
    protected function getPage()
    {
        return $this->getSession()->getPage();
    }

    /**
     * Sets Kernel instance.
     *
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        // TODO: Implement setKernel() method.
    }
}
