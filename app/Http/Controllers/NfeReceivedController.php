<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use NfeXmlHelper;
use App\Nfe;
use Exception;

/**
 * Class NfeReceivedController
 * 
 * This class controls the behavior of the operatios for the received NFEs.
 * 
 */
class NfeReceivedController extends Controller
{
    protected $uri;
    private $apiId;
    private $apiKey;
    private $headers;
    private $valores;

    public function __construct(){
        $this->uri = config('app.uri_nfe_received');
        $this->apiId = config('app.x_api_id');
        $this->apiKey = config('app.x_api_key');
        $this->headers = [
            'Content-Type' => 'application/json',
            'x-api-id' => $this->apiId,
            'x-api-key' => $this->apiKey
        ];
        $this->valores = [];
    }
    
    /**
     * Integrates Arquivei's API into Bolton App
     * It does only once.
     * After it retrieves all received NFE's, it stores the records into
     *      Bolton's App Database. 
     * @api
     * @return json
     */
    public function integrate()
    {
        try{
            $nfes = Nfe::count();
            if($nfes > 0){
                return json_encode([ 
                    'msg' => 'Foram importados previamente '. $nfes . ' registros.'
                ]);
            }
            $client = new Client();
        }catch(Exception $e){
            return json_encode(['error' => $e->getMessage()]);
        }
        $this->retrieveFromArquiveiAPI($client);    
        return $this->store();                
    }

    /**
     * Retrieves all the received NFEs 
     * Extracts the accessKey and total of each NFE
     * @return void
     */
    protected function retrieveFromArquiveiAPI($client){
        try{
            $response = $client->request('GET', $this->uri, ['headers' => $this->headers]);
            $statusCode = $response->getStatusCode();
            if($statusCode <> 200){
                return json_encode(['error' => 
                    'Status code ' . $statusCode . ' on ' . $this->uri . '. Please run again.']);    
            }
            $body = json_decode($response->getBody()->getContents(), true);
            $notas = $body['data'];
            foreach($notas as $key => $nota){
                list($key, $total) = NfeXmlHelper::getIdAndTotal($nota['xml']);
                $this->valores[$key] = $total;
            }
            if($body['count']==50){
                $this->uri = $body['page']['next'];
                $this->retrieveFromArquiveiAPI($client);
            }    
        }catch(Exception $e){
            return json_encode(['error' => $e->getMessage()]);
        }
        
    }
    
    /**
     * Stores the accessKey and total of each NFE into Bolton App Database
     * @return json {msg} 
     */
    protected function store(){
        try{
            $total = 0;
            foreach($this->valores as $access_key => $valor){
                $nfe = new Nfe;
                $nfe->access_key = $access_key;
                $nfe->valor = $valor;
                $nfe->save();
                $total += 1;
            }    
        }catch(Exception $e){
            return json_encode(['error' => $e->getMessage()]);
        }
        return json_encode([ 'msg' => 'Foram importados '. $total . ' registros.']);
    }


    /**
     * Returns the total value of a NFE given an accesKey
     * @api 
     * @param string $accessKey
     * @return json
     */
    protected function show($accessKey){
        return json_encode(['total' => (float)Nfe::findOrFail($accessKey)->valor]);
    }



}
