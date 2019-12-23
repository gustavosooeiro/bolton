Feature: Search NFEs
    Scenario: I want to get a list of NFEs
        Given I have the id and key of the API
        Given I have the content-type setup
        When I search for NFEs
        Then I get a result