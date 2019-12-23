<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use GuzzleHttp\Client;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    protected $response = null;
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct() {
        $this->uri = 'https://sandbox-api.arquivei.com.br/v1/nfe/received';
        $this->apiId = 'f96ae22f7c5d74fa4d78e764563d52811570588e';
        $this->apiKey = 'cc79ee9464257c9e1901703e04ac9f86b0f387c2';
        $this->headers = [
            'Content-Type' => 'application/json',
            'x-api-id' => $this->apiId,
            'x-api-key' => $this->apiKey
        ];
        $this->headersBolton = [
            'Content-Type' => 'text/plain',
            //'User-Agent' => ''
        ];

        /** 
         * A porta 8000 permite teste localmente. Se o teste for executado dentro da
         * instância do Docker, utilizar a porta 9000
         * 
         * */ 
        $this->baseURL = 'http://localhost:9000';
        $this->getValorNfeUri = $this->baseURL . '/api/v1/nfe/';
        $this->client = new Client();
    }

    /**
     * @Given I have the content-type setup
     */
    public function iHaveTheContentTypeSetup()
    {
        if($this->headers['Content-Type'] != 'application/json'){
            throw new Exception("You need to setup the header Content-Type. Now you have " . $this->headers['Content-Type']);
        }
        return true;
    }


    /**
     * @Given I have the id and key of the API
     */
    public function iHaveTheIdAndKeyOfTheApi()
    {
        if($this->headers['x-api-id'] != 'f96ae22f7c5d74fa4d78e764563d52811570588e' &&
            $this->headers['x-api-key'] != 'cc79ee9464257c9e1901703e04ac9f86b0f387c2' ){
                throw new Exception("You need to setup the API Key and Id in the header");
            }

    }

    /**
     * @When I search for NFEs
     */
    public function iSearchForNfes()
    {
        $this->response = $this->client->request('GET', $this->uri, ['headers'=>$this->headers]);
    }



    /**
     * @Then I get a result
     */
    public function iGetAResult()
    {
        $response_code = $this->response->getStatusCode();
        if($response_code <> 200){
            throw new Exception("Expected 200 response code, but got a " . $response_code);
        }
    }
}
