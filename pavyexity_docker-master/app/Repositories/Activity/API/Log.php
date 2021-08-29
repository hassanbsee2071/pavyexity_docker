<?php namespace App\Repositories\Activity\API;

/**
 * Class Log
 *
 * @author Md Abu Ahsan Basir <maab.career@gmail.com>
 */

use App\Log as LogModel;
use App\Repositories\LogRepository;

class Log extends LogRepository
{
    /**
     * Model
     *
     * @var object
     */
    protected $model;

    public function __construct()
    {
        $this->model = new LogModel;
    }
}
