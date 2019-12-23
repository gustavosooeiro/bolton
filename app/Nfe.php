<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * Class Nfe
 * 
 * The Nfe model has two fields: access_key(string), valor(float).
 * 
 */
class Nfe extends Model
{
     /**
     * The name of the table.
     *
     * @var string
     */
    protected $table = 'nfes';

     /**
     * The primary key associated with the table nfes.
     *
     * @var string
     */
    protected $primaryKey = 'access_key';


    protected $fillable = ['access_key', 'valor'];
}
