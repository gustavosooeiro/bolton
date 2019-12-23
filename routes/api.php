<?php

use Illuminate\Http\Request;

/*
*--------------------------------------------------------------------------
* API Routes
*--------------------------------------------------------------------------
*
* Here is where you can register API routes for your application. These
* routes are loaded by the RouteServiceProvider within a group which
* is assigned the "api" middleware group. Enjoy building your API!
*
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'v1'], function(){
    /** 
     *------------------------------------------------------------------------------- 
     * Get All NFEs
     *-------------------------------------------------------------------------------
     * URL:            /api/v1/nfes
     * Controller:     NfeReceivedController@index
     * Method:         GET
     * Description:    - Integrates Arquivei's API with the Bonton app
     *                 - Gets received notes from the Arquivei's API:
     *                       https://sandbox-api.arquivei.com.br/v1/nfe/received
     *                 - Stores {access_key, value} into table 'nfes' 
     *
    */
    Route::get('nfes', 'NfeReceivedController@integrate')->name('nfes');
    
    /**
     *-------------------------------------------------------------------------------
     * Get a NFE's value
     *-------------------------------------------------------------------------------
     * URL:            /api/v1/nfe-get-value/{accessKey}
     * Controller:     NfeReceivedController@show
     * Method:         GET
     * Description:    - Given the access_key, gets the NFE's valor field 
     * 
     * @param string accessKey The key that identifies a NFE. ex: NFe35140330290824000104550010003715421390782397
     */
    Route::get('nfe/{accessKey}', 'NfeReceivedController@show')->name('nfe.show');
});
