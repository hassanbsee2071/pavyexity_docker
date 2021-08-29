<?php namespace App\Repositories;

/**
 * Abstract Class LogRepository
 *
 * @author Md Abu Ahsan Basir <maab.career@gmail.com>
 * @package App\Repositories
 */

use Carbon\Carbon;
use Exception;

Abstract class LogRepository
{
    /**
     * Store a newly created log in storage.
     *
     * @param  array  $data
     * @return boolean
     */
    public function add($data)
    {
        try {
            $requestData = (object) $data['request'];
            $responseData = (object) $data['response'];

            $this->model->create([
                'customer_name' => $data['customer_name'],
                'api_name' => $data['api_name'],
                'request_data' => json_encode($requestData),
                'response_data' => json_encode($responseData),
                'request_at' => now()
            ]);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }
}

