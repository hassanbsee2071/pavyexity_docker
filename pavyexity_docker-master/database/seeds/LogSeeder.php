<?php

/**
 * Log Seeder Class
 *
 * @author Md Abu Ahsan Basir <maab.career@gmail.com>
 */

use Illuminate\Database\Seeder;
use App\Log;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $requestData1 = [
            'first_name' => 'Test',
            'last_name' => 'Alam',
            'address' => '1400 Walnut street',
            'businessName' => 'Blackbox Lab',
            'ssn' => '123456789',
            'phone' => '3121654789'
        ];

        makeApiLog([
            'customer_name' => 'Kawser Alam',
            'api_name' => 'EIN',
            'request' => $requestData1,
            'response' => ['message' => 'EIN request completed successfully.'],
        ]);

        // $log = new Log;
        // $log->customer_name = 'Kawser Alam';
        // $log->api_name = 'EIN';
        // $log->request_data = json_encode($requestData1);
        // $log->response_data = json_encode((object) ['message' => 'EIN request completed successfully.']);
        // $log->request_at = now();
        // $log->save();

        $requestData2 = [
            'first_name' => 'Kabir',
            'last_name' => 'Hossain',
            'address' => '52/6 Walnut street',
            'businessName' => 'Blackbox Lab',
            'ssn' => '1234584569',
            'phone' => '31654754789'
        ];

        makeApiLog([
            'customer_name' => 'Test Man',
            'api_name' => 'EIN',
            'request' => $requestData2,
            'response' => ['message' => 'EIN request completed successfully.'],
        ]);

        // $log = new Log;
        // $log->customer_name = 'Test Man';
        // $log->api_name = 'EIN';
        // $log->request_data = json_encode($requestData2);
        // $log->response_data = json_encode((object) ['message' => 'EIN request completed successfully.']);
        // $log->request_at = now();
        // $log->save();

        $requestData3 = [
            'first_name' => 'Nurat',
            'last_name' => 'Bushra',
            'address' => '3100 Walnut street',
            'businessName' => 'Blackbox Lab',
            'ssn' => '123852789',
            'phone' => '3126544789'
        ];

        makeApiLog([
            'customer_name' => 'Md Abu Ahsan Basir',
            'api_name' => 'Passport (ds11)',
            'request' => $requestData3,
            'response' => ['message' => 'Passport request completed successfully.'],
        ]);

        // $log = new Log;
        // $log->customer_name = 'Md Abu Ahsan Basir';
        // $log->api_name = 'Passport (ds11)';
        // $log->request_data = json_encode($requestData3);
        // $log->response_data = json_encode((object) ['message' => 'Passport request completed successfully.']);
        // $log->request_at = now();
        // $log->save();
    }
}
