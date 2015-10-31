# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

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
