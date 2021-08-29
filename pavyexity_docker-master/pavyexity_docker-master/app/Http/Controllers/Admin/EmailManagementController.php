<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\EmailManagement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Auth\User\User;
use Validator;
use Illuminate\Support\Facades\DB;
Use DataTables;

class EmailManagementController extends Controller
{
    //
    public function index(Request $request)
    {
        if($request->ajax()){
            $get_data = EmailManagement::select(['id','email_subject','email_slug','email_body','created_at','updated_at','deleted_at']);
            return Datatables::of($get_data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                    $editMail = url('admin/email_template/'.$row->id.'/');
                    $delMail = url('admin/email_template/'.$row->id.'/delete');
                    $actionBtn = '<a href="'.$editMail.'" class="edit btn btn-success btn-sm" ><i class="fa fa-pencil"></i></a>';
                    // if (!$user_role_id == 1){
                        $actionBtn = $actionBtn.'<a href="'.$delMail.'" class="delete btn btn-danger btn-sm" onclick=\'return check()\'><i class="fa fa-trash"></i></a>';
                    // }
                    return $actionBtn;
            })
            
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('admin.email_template.index');

    }

    public function edit($id)
    {
        $user                  = Auth::user();
        $return_arr            = array();
        $return_arr['user']    = $user;
        $email_template               = EmailManagement::find($id);
        $return_arr['email_template'] = $email_template;
        return view('admin.email_template.edit', $return_arr);
    }

    public function delete($id)
    {
        $t_id = EmailManagement::find($id);
        $t_id->delete();
        //        $company = CompanySetting::find($id)->delete();
        //logs
        $log_data= array(
            'user_id' => auth()->user()->id,
            'logtype' => 'email template',
            'action' => 'Email Template Deleted successfully',
        );
        $logs = \LogActivity::addToLog($log_data);

        return redirect()->route('admin.email_template')->withFlashSuccess('Email Template Deleted Successfully!');
    }

    public function update(request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'email_subject'   => 'required',
            'email_slug'      => 'required|max:255|',
            'email_content'   => 'required',
        ]);
        if ($validator->fails())
            return redirect()->back()->withErrors($validator->errors())->withInput();

        $company_admin         = (($request->filled('company_admin')) ? $request->company_admin : 0);
        $data                  = EmailManagement::find($id);
        $data->email_subject   = $request->email_subject;
        $data->email_slug      = $request->email_slug;
        $data->email_body      = $request->email_content;
        $data->save();

        //logs
        $log_data= array(
            'user_id' => auth()->user()->id,
            'logtype' => 'email template',
            'action' => 'Email Template Updated successfully',
        );
        $logs = \LogActivity::addToLog($log_data);

        return redirect()->route('admin.email_template')->withFlashSuccess('Email Template Updated Successfully!');
    }

    public function add()
    {
        $user               = Auth::user();
        $return_arr         = array();
        $return_arr['user'] = $user;
        return view('admin.email_template.add', $return_arr);
    }

    public function save_email_template(request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_subject'   => 'required',
            'email_slug'      => 'required|max:255|unique:email_templates',
            'email_content'   => 'required',
        ]);
        if ($validator->fails())
            return redirect()->back()->withErrors($validator->errors())->withInput();

        $data                  = new EmailManagement();
        $data->email_subject   = $request->email_subject;
        $data->email_slug      = $request->email_slug;
        $data->email_body      = $request->email_content;
        $data->save();

        //logs
        $log_data= array(
            'user_id' => auth()->user()->id,
            'logtype' => 'email template',
            'action' => 'Email Template Added successfully',
        );
        $logs = \LogActivity::addToLog($log_data);

        return redirect()->route('admin.email_template')->withFlashSuccess('Email Template Added Successfully!');
    }
}
