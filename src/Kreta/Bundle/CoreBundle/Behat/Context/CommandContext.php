<?php

/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kreta\Bundle\CoreBundle\Behat\Context;

use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Kreta\Bundle\CoreBundle\Command\CreateClientCommand;
use Kreta\Bundle\UserBundle\Command\CreateUserCommand;
use PHPUnit_Framework_Assert as Assertions;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class CommandContext.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class CommandContext extends DefaultContext
{
    /**
     * The application.
     *
     * @var \Symfony\Bundle\FrameworkBundle\Console\Application
     */
    protected $application;

    /**
     * The command tester.
     *
     * @var \Symfony\Component\Console\Tester\CommandTester
     */
    protected $tester;

    /**
     * Array which contains the command input arguments.
     *
     * @var array
     */
    private $inputs = [];

    /**
     * Array which contains the command option arguments.
     *
     * @var array
     */
    private $options = [];

    /**
     * Method that loads all the commands of the Kreta.
     */
    protected function loadCommands()
    {
        $this->application = new Application($this->getKernel());

        $this->application->add(new CreateClientCommand());
        $this->application->add(new CreateUserCommand());
    }

    /**
     * Runs the given command.
     *
     * @param string $command The command name
     *
     *
     * @When /^I run "([^"]*)" command$/
     */
    public function iRunCommand($command)
    {
        $this->loadCommands();

        $command = $this->application->find($command);
        $this->tester = new CommandTester($command);

        $this->inputs['command'] = $command->getName();
        $this->tester->execute($this->inputs, $this->options);

        $this->initialize();
    }

    /**
     * Runs the given interactive command.
     *
     * @param string $command The command name
     *
     *
     * @When /^I run "([^"]*)" interactive command$/
     */
    public function iRunInteractiveCommand($command)
    {
        $this->loadCommands();

        $command = $this->application->find($command);
        $this->tester = new CommandTester($command);

        $helper = $command->getHelper('question');
        $helper->setInputStream($this->getInputStream('Test\\n'));

        $this->inputs['command'] = $command->getName();
        $this->tester->execute($this->inputs, $this->options);

        $this->initialize();
    }

    /**
     * Overrides the inputs class array with given values.
     *
     * @param \Behat\Gherkin\Node\TableNode $inputs Table of inputs value
     *
     *
     * @Given /^the following command inputs:$/
     */
    public function theFollowingCommandInputs(TableNode $inputs)
    {
        $this->inputs = $this->parse($inputs);
    }

    /**
     * Overrides the options class array with given values.
     *
     * @param \Behat\Gherkin\Node\TableNode $options Table of options value
     *
     *
     * @Given /^the following command options:$/
     */
    public function theFollowingCommandOptions(TableNode $options)
    {
        $this->options = $this->parse($options);
    }

    /**
     * I should see. Checks the actual result with the expected.
     *
     * @param \Behat\Gherkin\Node\PyStringNode $output The output
     *
     *
     * @Then /^I should see the following output:$/
     */
    public function iShouldSee(PyStringNode $output)
    {
        $raw = preg_split('/\%[^)]+\%/', $output->getRaw());
        foreach ($raw as $substring) {
            Assertions::assertContains(trim($substring), $this->tester->getDisplay());
        }
    }

    /**
     * Initializes the inputs and options array.
     */
    private function initialize()
    {
        $this->inputs = [];
        $this->options = [];
    }

    /**
     * Parses and normalizes the tableNode given format becoming to an associative array.
     *
     * @param \Behat\Gherkin\Node\TableNode $arguments The arguments in tableNode format
     *
     * @return array
     */
    private function parse(TableNode $arguments)
    {
        $fields = [];
        foreach ($arguments->getRowsHash() as $key => $value) {
            if (array_key_exists($key, $fields)) {
                if (is_array($fields[$key])) {
                    $fields[$key][] = $value;
                } else {
                    $fieldValue = $fields[$key];
                    $fields[$key][] = $fieldValue;
                    $fields[$key][] = $value;
                }
            } else {
                $fields[$key] = $value;
            }
        }

        return $fields;
    }

    /**
     * Gets the input stream, method required to mock the interaction with console.
     *
     * @param string $input The input
     *
     * @return resource
     */
    private function getInputStream($input)
    {
        $stream = fopen('php://memory', 'r+', false);
        fputs($stream, $input);
        rewind($stream);

        return $stream;
    }
}
