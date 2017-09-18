@organization
Feature: Creating an organization
  In order to create an organization
  As a organization creator
  I want to be able to create an organization

  Background:
    Given "user-id" as organization creator id to create the organization

  Scenario: Creating an organization with "Organization 01" name
# Lanzar el command de crear organization
    Given a "Organization 01" name an organization was created
# Checkear que la organization esta insertada correctamente en el repository de memory con un query handler
    When I create a organization with the given "Organization 01" name
# Checkear que el usuario utilizado para crear la org es un owner de a misma
#    Then I become automatically an organization owner
