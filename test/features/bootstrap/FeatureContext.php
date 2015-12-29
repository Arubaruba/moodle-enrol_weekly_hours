<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

/**
 * Features context.
 */
class FeatureContext extends BehatContext {
    private $output = "";

    function __construct() {}

    /**
     * @Given /^I am in a directory "([^"]*)"$/
     * @param $dir
     */
    public function iAmInADirectory($dir) {
        if (!file_exists($dir)) {
            mkdir($dir);
        }
        chdir($dir);
    }

    /**
     * @Given /^I have a file named "([^"]*)"$/
     * @param $file
     */
    public function iHaveAFileNamed($file) {
        touch($file);
    }

    /**
     * @Given /^I run :command
     * @param $command
     */
    public function iRun($command) {
        exec($command, $output);
        $this->output = trim(implode("\n", $output));
    }

    /**
     * @Given /^I should get:$/
     * @param PyStringNode $string
     * @throws Exception
     */
    public function iShouldGet(PyStringNode $string) {
        if ($string != $this->output) {
            throw new Exception(
                "Actual output:\n" . $this->output
            );
        }
    }
}
