# This file is part of the Kreta package.
#
# (c) Beñat Espiña <benatespina@gmail.com>
# (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
#
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.

@user
Feature: Manage users vi cli
  In order to manage users cli
  As a console
  I want to be able create a new user

  Scenario: Executing command to create a new user
    Given the following command inputs:
      | email     | kreta@kreta.com |
      | username  | kreta           |
      | firstName | Kreta           |
      | lastName  | User            |
      | password  | 123456          |
    When I run "kreta:user:create" interactive command
    Then I should see the following output:
    """
      A new kreta user has been created
    """
