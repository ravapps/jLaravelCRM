<?php

namespace App\Http\Controllers;

use App\Department;
use App\Designation;
use App\Jbr;
use Illuminate\Http\Request;
use DB;


use Maatwebsite\Excel\Facades\Excel;
use App\Imports\JbrImport;



class ResponsbilitesController extends Controller
{
    public function index()
    {

        if(\Auth::user()->can('Manage Designation'))
        {
          $resp = DB::table("jbrs")->get();

          return view('responsbilites.index', compact('resp'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('Create Designation'))
        {
            $departments = Department::where('created_by', '=', \Auth::user()->creatorId())->get();
            $departments = $departments->pluck('name', 'id');

            return view('responsbilites.create', compact('departments'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {

        if(\Auth::user()->can('Create Designation'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'department_id' => 'required',
                                   'res_name' => 'required|max:50',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $jbr                            = new Jbr();
            $jbr->designation_id            = $request->department_id;
            $jbr->res_name                  = $request->res_name;
            $jbr->created_by                = \Auth::user()->creatorId();

            $jbr->save();

            return redirect()->route('responsbilites.index')->with('success', __('Responsbilites  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Designation $designation)
    {
        return redirect()->route('responsbilites.index');
    }

    public function edit(Jbr $jbr)
    {

                $departments = Department::where('id', $jbr->designation_id)->first();
                $departments = $departments->pluck('name', 'id');

                return view('responsbilites.edit', compact('jbr', 'departments'));


    }

    public function update(Request $request, Jbr $jbr)
    {
        if(\Auth::user()->can('Edit Designation'))
        {

                $validator = \Validator::make(
                    $request->all(), [
                                       'department_id' => 'required',
                                       'res_name' => 'required|max:50',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                $jbr->res_name          = $request->res_name;
                $jbr->designation_id = $request->department_id;
                $jbr->save();

                return redirect()->route('responsbilites.index')->with('success', __('Responsbility  successfully updated.'));

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Jbr $jbr)
    {
        if(\Auth::user()->can('Delete Designation'))
        {
            if($jbr->created_by == \Auth::user()->creatorId())
            {
                $jbr->delete();

                return redirect()->route('responsbilites.index')->with('success', __('Responsbility successfully deleted.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}


/// Excel::import(new UsersImport, $request->file('file')->store('temp'));
