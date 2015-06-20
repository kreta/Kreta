<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CreateUserCommand.
 *
 * @package Kreta\Bundle\UserBundle\Command
 */
class CreateUserCommand extends ContainerAwareCommand
{
    /**
     * The input.
     *
     * @var \Symfony\Component\Console\Input\InputInterface
     */
    private $input;

    /**
     * The output.
     *
     * @var \Symfony\Component\Console\Output\OutputInterface
     */
    private $output;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('kreta:user:create')
            ->setDescription('Creates a new user')
            ->addArgument(
                'email',
                InputArgument::REQUIRED,
                'The email'
            )
            ->addArgument(
                'username',
                InputArgument::REQUIRED,
                'The username'
            )
            ->addArgument(
                'firstName',
                InputArgument::REQUIRED,
                'The first name'
            )
            ->addArgument(
                'lastName',
                InputArgument::REQUIRED,
                'The last name'
            )
            ->addArgument(
                'password',
                InputArgument::REQUIRED,
                'The password'
            )
            ->setHelp(<<<EOT
The <info>%command.name%</info> command creates a new user.
<info>php %command.full_name% [--redirect-uri=...] [--grant-type=...] name</info>
EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $user = $container->get('kreta_user.factory.user')->create(
            $input->getArgument('email'),
            $input->getArgument('username'),
            $input->getArgument('firstName'),
            $input->getArgument('lastName'),
            true
        );
        $user->setPlainPassword($input->getArgument('password'));
        $manager = $container->get('fos_user.user_manager');
        $manager->updatePassword($user);
        $manager->updateUser($user);

        $output->writeln(sprintf('A new <info>%s</info> user has been created', $user->getUsername()));
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $this
            ->addField('email')
            ->addField('username')
            ->addField('firstName')
            ->addField('lastName')
            ->addField('password', 'askHiddenResponseAndValidate');
    }

    /**
     * Adds form console fields customizing the field name and its validation method.
     *
     * @param string $name   The field name
     * @param string $method The method that be executed
     *
     * @return $this self
     */
    private function addField($name, $method = 'askAndValidate')
    {
        if (!$this->input->getArgument($name)) {
            $field = $this->getHelper('dialog')->$method(
                $this->output,
                sprintf('Please choose a/an %s:', $name),
                function ($field) {
                    if (empty($field)) {
                        throw new \Exception('This field can not be empty');
                    }

                    return $field;
                }
            );
            $this->input->setArgument($name, $field);
        }

        return $this;
    }
}
