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
        $this->getSession()->wait(5000, $element);
    }

    /**
     * @param string $text
     *
     * @Then /^I should wait until i see "(?P<text>(?:[^"]|\\")*)"$/
     */
    public function iShouldWaitUntilISee($text)
    {
        $result = $this->waitForText($text);

        if (false == $result) {
            throw new \InvalidArgumentException(sprintf('Could not found text: "%s"', $text));
        }
    }

    /**
     * @param string $text
     * @param int    $wait
     *
     * @return boolean
     */
    protected function waitForText($text, $wait = 5)
    {
        for ($i = 0; $i < $wait; $i++) {
            try {
                $this->assertPageContainsText($text);
                return true;
            } catch (Exception $e) {
            }
            sleep(1);
        }

        return false;
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
