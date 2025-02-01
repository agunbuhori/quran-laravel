<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Faker\Factory as Faker;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_bahwa_endpoint_mengembalikan_data_token(): void
    {
        $this->get('/api/ambil-data')
            ->assertOk()
            ->assertJsonStructure([
                'token'
            ]);
    }

     /**
     * A basic test example.
     */
    public function test_bahwa_user_tidak_bisa_login_karena_kredensial_salah(): void
    {
        $this->post('/api/login', ["email" => "ngacak", "password" => "ngacak"])
            ->assertUnauthorized();
    }
    
     /**
     * A basic test example.
     */
    public function test_bahwa_user_bisa_login_karena_kredensial_benar(): void
    {
        $faker = Faker::create();

        $user = \App\Models\User::factory()->create([
            "email" => $faker->email,
            "password" => bcrypt("rahasia")
        ]);

        // bahwa route harus ada
        // bahwa data harus terkirim
        // bahwa kredensial harus benar
        // bahwa route/endpoint harus mengembalikan token

        $this->post('/api/login', ["email" => $user->email, "password" => "rahasia"])
            ->assertOk()
            ->assertJsonStructure([
                'token'
            ])
            ->assertJson([
                'message' => 'Login sukses'
            ]);
    }


    public function test_bahwa_user_bisa_logout()
    {
        $faker = Faker::create();

        $user = \App\Models\User::factory()->create([
            "email" => $faker->email,
            "password" => bcrypt("rahasia")
        ]);

    
        $this->withHeaders(['Authorization' => "Bearer {$user->createToken('Token Name')->accessToken}"]);
        
        $this->post('/api/logout')
        ->assertOk();
    }

}
