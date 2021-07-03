<?php

namespace Http\Controllers;

use App\Http\Controllers\HealthCheckController;
use TestCase;

class HealthCheckControllerTest extends TestCase
{
    public function testHealthcheck()
    {
        $response = $this->get('/api/healthcheck');
        $response->seeJson(['status' => true, 'message' => 'ok']);
    }
}
