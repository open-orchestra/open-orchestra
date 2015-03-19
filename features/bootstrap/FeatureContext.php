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
        $session = $this->getSession();
        $element = $session->getPage()->find(
            'xpath',
            $session->getSelectorsHandler()->selectorToXpath('css', $cssSelector) // just changed xpath to css
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
        $session = $this->getSession();

        $elements = $session->getPage()->findAll('css', $css);

        $element = end($elements);

        if (null === $element) {
            throw new \InvalidArgumentException(sprintf('Could not evaluate CSS query: "%s"', $css));
        }

        $element->click();
    }

    /**
     * Wait some second
     *
     * @param $time
     *
     * @When /^I wait some second "(\d+)"$/
     */
    public function iWaitSomeSecond($time)
    {
        sleep($time);
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
