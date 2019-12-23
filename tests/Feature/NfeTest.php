<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Nfe;

class NfeTest extends TestCase
{

    use RefreshDatabase;

    protected function &getAccessKey()
    {
        static $value = 'Nfe02938493828183958694837173880493847583940';
        return $value;
    }
    
    protected function &getValor()
    {
        static $value = 35.44;
        return $value;
    }

    /**
     * Tests insertions on Nfe's table.
     *
     * @return void
     */
    public function testNfeCreation()
    {
        $accessKey = &$this->getAccessKey();
        $valor = &$this->getValor();
        
        factory(Nfe::class)->create([
            'access_key' => $accessKey,
            'valor' => $valor,
        ]);
 
        $this->assertDatabaseHas('nfes', [
            'access_key' => $accessKey,
            'valor' => $valor,
        ]);
    }

    public function testCanShowNfe() {
        
        $accessKey = &$this->getAccessKey();
        $valor = &$this->getValor();

        factory(Nfe::class)->create([
            'access_key' => $accessKey,
            'valor' => $valor,
        ]);

        $this->get(route('nfe.show', $accessKey))
            ->assertStatus(200);
    }
}
