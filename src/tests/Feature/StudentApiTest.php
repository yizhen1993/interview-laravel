<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StudentApiTest extends TestCase
{
    /** @test for admin login to receive sanctum token */
    public function get_bearer_token_after_login()
    {
        $adminData = [
            'email' => 'admin@example.com',
            'password' => 'admin',
        ];

        $response = $this->postJson('/api/tokens/create', $adminData);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'content' => [
                    'token',
                    'user'
                ]
            ]);
        return $response;
    }

    /** @test for admin to use the sanctum token to retrieve student list */
    public function use_bearer_token_to_get_student_list()
    {
        $res = $this->get_bearer_token_after_login();
        $token = $res->original['content']['token'];

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token,
        ];

        $response = $this->withHeaders($headers)
                         ->get('/api/student');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'content' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'courses' => [
                            '*' => [
                                'id',
                                'name'
                            ]
                        ],
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
    }

    /** @test for admin to use the sanctum token to retrieve student by email */
    public function use_bearer_token_to_get_student_by_email()
    {
        $res = $this->get_bearer_token_after_login();
        $token = $res->original['content']['token'];

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token,
        ];

        $param = [
            'email' => 'ambrose83@example.org'
        ];

        $response = $this->withHeaders($headers)
                         ->get('/api/student', $param);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'content' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'courses' => [
                            '*' => [
                                'id',
                                'name'
                            ]
                        ],
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
    }
}
