<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewLandingPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function landing_page_loads_correctly()
    {
        //Arrange

        //Act
        $response = $this->get('/');

        //Assert
        $response->assertStatus(200);
        $response->assertSee('MAGZ-Ecommerce');
        $response->assertSee('Includes multiple products');
    }





}