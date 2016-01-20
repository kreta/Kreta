Feature: Test app verification
  In order to test the extension easily
  As a WebApi feature tester
  I want to be able to find features automatically

  Background:
    Given a file named "behat.yml" with:
      """
      default:
          formatters:
              progress: ~
          extensions:
              Behat\WebApiExtension:
                  base_url: http://localhost:8080/

          suites:
              default:
                  contexts: ['Behat\WebApiExtension\Context\WebApiContext']
      """

  Scenario: Sending form data
    Given a file named "features/send_form.feature" with:
      """
      Feature: Exercise WebApiContext data sending
        In order to validate the send request step
        As a context developer
        I need to be able to send a request with values in a scenario

        Scenario:
          When I send a POST request to "echo" with form data:
          '''
          name=name&pass=pass
          '''
          Then the response should contain "POST"
          And the response should contain json:
          '''
          {
          "name" : "name",
          "pass": "pass"
          }
          '''
      """
    When I run "behat features/send_form.feature"
    Then it should pass with:
      """
      ...

      1 scenario (1 passed)
      """

  Scenario: Sending raw data
    Given a file named "features/send_raw.feature" with:
      """
      Feature: Exercise WebApiContext data sending
        In order to validate the send request step
        As a context developer
        I need to be able to send a request with values in a scenario

        Scenario:
          Given I set header "content-type" with value "application/json"
          When I send a POST request to "echo" with body:
          '''
          {
          "name" : "name",
          "pass": "pass"
          }
          '''
          Then the response should contain "POST"
          And the response should contain json:
          '''
          {
          "name" : "name",
          "pass": "pass"
          }
          '''
      """
    When I run "behat features/send_raw.feature"
    Then it should pass with:
      """
      ....

      1 scenario (1 passed)
      """

  Scenario: Sending HEAD requests
    Given a file named "features/send_request.feature" with:
      """
      Feature: Exercise WebApiContext method choice
        In order to validate the send request step
        As a context developer
        I need to be able to use any HTTP1/1 method in a scenario

        Scenario: HEAD should not return a body.
          When I send a HEAD request to "echo"
          Then the response should not contain "HEAD"
      """
    When I run "behat features/send_request.feature"
    Then it should pass with:
      """
      ..

      1 scenario (1 passed)
      """

  Scenario Outline: Sending requests
    Given a file named "features/send_request.feature" with:
      """
      Feature: Exercise WebApiContext method choice
        In order to validate the send request step
        As a context developer
        I need to be able to use any HTTP1/1 method in a scenario

        Scenario: The HTTP methods should be echoed in the output.
          When I send a <method> request to "echo"
          Then the response should contain "<method>"
          And the response code should be 200
      """
    When I run "behat features/send_request.feature"
    Then it should pass with:
      """
      ...

      1 scenario (1 passed)
      """

    Examples:
      | method  |
      | GET     |
      | POST    |
      | PUT     |
      | DELETE  |
      | OPTIONS |
      | PATCH   |

  Scenario: Sending values
    Given a file named "features/send_values.feature" with:
      """
      Feature: Exercise WebApiContext data sending
        In order to validate the send request step
        As a context developer
        I need to be able to send a request with values in a scenario

        Scenario:
          When I send a POST request to "echo" with values:
          | name | name |
          | pass | pass |
          Then the response should contain "POST"
          And the response should contain json:
          '''
          {
          "name" : "name",
          "pass": "pass"
          }
          '''
      """
    When I run "behat features/send_values.feature"
    Then it should pass with:
      """
      ...

      1 scenario (1 passed)
      """

  Scenario: Error responses should work
    Given a file named "features/error_handling.feature" with:
      """
      Feature: Accessing an invalid url
        In order to known about my mistakes
        As an API client
        I should receive an error response

      Scenario:
        When I send a GET request to "/404"
        Then the response code should be 404
      """
    When I run "behat features/error_handling.feature"
    Then it should pass with:
      """
      ..

      1 scenario (1 passed)
      """

  Scenario: Setting header
    Given a file named "features/headers.feature" with:
      """
      Feature: Exercise WebApiContext Set Header
        In order to validate the set_header step
        As a context developer
        I need to be able to add headers in a scenario before sending a request

      Scenario:
        Given I set header "foobar" with value "bazquux"
        When I send a GET request to "echo"
        Then the response should contain "headers"
        And the response should contain "foobar"
        And the response should contain "bazquux"
      """
    When I run "behat features/headers.feature"
    Then it should pass with:
      """
      .....

      1 scenario (1 passed)
      """

  Scenario: Authentication
    Given a file named "features/authentication.feature" with:
      """
      Feature: Exercise WebApiContext Basic authentication
        In order to validate the authentication step
        As a context developer
        I need to be able to use authentication in a scenario

      Scenario:
        Given I am authenticating as "user" with "pass" password
        When I send a GET request to "echo"
        Then the response should contain "headers"
        And the response should contain "authorization"
        # "dXNlcjpwYXNz" === base64_encode('user', 'pass')
        And the response should contain "Basic dXNlcjpwYXNz"
      """
    When I run "behat features/authentication.feature"
    Then it should pass with:
      """
      .....

      1 scenario (1 passed)
      """
