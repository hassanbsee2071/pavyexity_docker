<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Auth\User\User;
use Illuminate\Http\Request;
use App\SmtpSettingModel;
use Validator;

class SmtpSettingController extends Controller
{
    public function update(Request $request) {
        if ($request->isMethod('post')) {
           
                $validator = Validator::make($request->all(), [
                    'host'   => 'required',
                    'user_name'=> 'required',
                    'password' => 'required',
                    'port'    => 'required',
                    'smtp_id'    => 'required'
                ]);
            if ($validator->fails()){
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            $id = $request->smtp_id;
            $data = SmtpSettingModel::find($id);
            $data->user_name           = $request->user_name;
            $data->host           = $request->host;
            $data->password    = $request->password;
            $data->port      = $request->port;
            $data->driver      = $request->driver;
            $data->encryption      = $request->encryption;
            $data->from_address      = $request->from_address;
            $data->from_name      = $request->from_name;
            $data->save();
            return redirect()->route('admin.smtp')->withFlashSuccess('SMTP Setting Updated Successfully!');
        }
        $settingData = SmtpSettingModel::first();
        // dd($settingData);
        $return_arr['smtp_data'] = $settingData;
        return view('admin.smtp.edit', $return_arr);
    }
}
