<?php

namespace App\Http\Controllers\Admin;

/**
 * Log Controller Class
 *
 * @author Md Abu Ahsan Basir <maab.career@gmail.com>
 * @package App\Http\Controllers\Admin
 */

use App\Http\Controllers\Controller;
use App\Log;
use Illuminate\Http\Request;
use DataTables;

class LogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd('sdsdsd');
        $auth_user  = \Auth::user();
        $company_id = 0;
        if (!empty($auth_user)) {
            if ($request->ajax()) {
                $logs = Log::get();
                // dd($logs);
                return Datatables::of($logs)
                    ->addIndexColumn()
                    ->addColumn('request_data', function ($log) {
                        return '<button type="button" data-toggle="modal" data-target="#log-request-modal" class="log-request" data-request=\'' . $log->request_data . '\'><i class="fa fa-eye"></i></button>';
                    })
                    ->addColumn('response_data', function ($log) {
                        return '<button type="button" data-toggle="modal" data-target="#log-response-modal" class="log-response" data-response=\'' . $log->response_data . '\'"><i class="fa fa-eye"></i></button>';
                    })
                    ->rawColumns(['request_data', 'response_data'])
                    ->make(true);
            } else {
                $logs = Log::get();
                return view('admin.logs.index', compact('logs'));
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function show(Log $log)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function edit(Log $log)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Log $log)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function destroy(Log $log)
    {
        //
    }
}
