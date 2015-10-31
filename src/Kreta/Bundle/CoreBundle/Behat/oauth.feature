# This file is part of the Kreta package.
#
# (c) Beñat Espiña <benatespina@gmail.com>
# (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
#
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.

@oauth
Feature: Manage OAuth
  In order to manage OAuth
  As an Oauth server
  I want to be able to manage OAuth

  Scenario: Executing command to create oauth client paasing redirect uri and grant type
    Given the following command options:
      | redirect-uri | http://kreta.io |
      | grant-type   | password        |
    When I run "kreta:oauth-server:client:create" command
    Then I should see the following output:
    """
      A new client with public id %PUBLIC-ID%, secret %SECRET% has been added
    """
