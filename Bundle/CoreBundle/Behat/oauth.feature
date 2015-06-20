# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

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
