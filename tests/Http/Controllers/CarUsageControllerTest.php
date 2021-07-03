<?php

namespace Http\Controllers;

use App\Http\Controllers\CarUsageController;
use App\Models\Car;
use App\Models\CarUsage;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use TestCase;

class CarUsageControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $users = User::factory()->count(2)->create();
        $cars = Car::factory()->count(2)->create();

        CarUsage::create(
            ['car_id' => 1, 'user_id' => 1, 'time_from' => '2020-01-01 12:30', 'time_to' => '2020-01-01 13:00']
        );
    }

    /**
     * Проверяет, что запрос на создание не проходит, в случаях, когда предоставлены неверные данные
     * @dataProvider createProvider
     */
    public function testCreateFailures($car_id, $user_id, $timeFrom, $timeTo, $failureKeys)
    {

        $data = [
            'car_id' => $car_id,
            'user_id' => $user_id,
            'time_from' => $timeFrom,
            'time_to' => $timeTo
        ];
        $response = $this->json(
            'POST',
            '/api/usage',
            $data
        );

        $response->assertResponseStatus(422);

        if (strtotime($timeFrom) === false) {
            unset($data['time_from']);
        }

        if (strtotime($timeTo) === false) {
            unset($data['time_to']);
        }

        $response->notSeeInDatabase('car_usage', $data);
        $response->seeJson($failureKeys);
    }

    public function testSuccessfullCreate()
    {
        $data = ['car_id' => 2, 'user_id' => 2, 'time_from' => '2020-01-01 12:30', 'time_to' => '2020-01-01 13:00'];
        $response = $this->json('post', '/api/usage', $data);
        $response->assertResponseOk();
        $response->seeJson($data);
        $this->seeInDatabase('car_usage', $data);
    }


    public function createProvider()
    {
        return [
            [1, 2, '2020-01-01 12:30', '2020-01-01 13:00', ['car_id' => ["The car id should be free in specified period"]]],
            [1, 2, '2020-01-01 12:29', '2020-01-01 12:59', ['car_id' => ["The car id should be free in specified period"]]],
            [1, 2, '2020-01-01 12:29', '2020-01-01 13:01', ['car_id' => ["The car id should be free in specified period"]]],
            [1, 2, '2020-01-01 12:31', '2020-01-01 12:59', ['car_id' => ["The car id should be free in specified period"]]],
            [1, 2, '2020-01-01 12:31', '2020-01-01 13:01', ['car_id' => ["The car id should be free in specified period"]]],
            [2, 1, '2020-01-01 12:30', '2020-01-01 13:00', ['user_id' => ["The user id should be free in specified period"]]],
            [2, 1, '2020-01-01 12:29', '2020-01-01 12:59', ['user_id' => ["The user id should be free in specified period"]]],
            [2, 1, '2020-01-01 12:29', '2020-01-01 13:01', ['user_id' => ["The user id should be free in specified period"]]],
            [2, 1, '2020-01-01 12:31', '2020-01-01 12:59', ['user_id' => ["The user id should be free in specified period"]]],
            [2, 1, '2020-01-01 12:31', '2020-01-01 13:01', ['user_id' => ["The user id should be free in specified period"]]],
            [3, 2, '2020-01-01 12:31', '2020-01-01 13:01', ['car_id' => ["The selected car id is invalid."]]],
            [2, 3, '2020-01-01 12:31', '2020-01-01 13:01', ['user_id' => ["The selected user id is invalid."]]],
            [2, 2, '2020-01-01 12:31', '2020-01-01 12:30', ['time_to' => ["The time to must be a date after time from."]]],
            [2, 2, '00', '2020-01-01 13:01', ['time_from' => ["The time from is not a valid date."]]],
            [2, 2, '2020-01-01 13:01', '00', ['time_to'  => ["The time to is not a valid date.","The time to must be a date after time from."]]]
        ];
    }
}
