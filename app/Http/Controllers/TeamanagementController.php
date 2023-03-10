<?php


namespace App\Http\Controllers;
use App\Department;
use App\Designation;
use App\Employee;
use App\Teams;
use App\TeamsWorkers;

use DB;
use Closure;
use Illuminate\Support\Facades\Log;



use Illuminate\Http\Request;

class TeamanagementController extends Controller
{







  public function show()
  {
  }







  public function index(){
    $usr = \Auth::user();
    if(1) //if($usr->can('Manage Team'))
    {
        $get_teams=Teams::all();
        return view('team_management.index',compact('get_teams'));
    }
    else
    {
        return redirect()->back()->with('error', __('Permission denied.'));
    }
  }














  public function create() {

    if(1)   //if(\Auth::user()->can('Create Team'))
    {
        $employees_superviors  = Employee::where('created_by', '=', \Auth::user()->creatorId())->where('designation_id', '=', Employee::supervisor_desig_id())->get();
        $employees_workers  = Employee::where('created_by', '=', \Auth::user()->creatorId())->where('designation_id', '=', Employee::worker_desig_id())->get();
        $team_id = Teams::team_id();
        $displaytype = 'create';
        return view('team_management.create', compact('displaytype','employees_superviors','team_id','employees_workers'));
    }
    else
    {
        return response()->json(['error' => __('Permission denied.')], 401);
    }

  }








  public function edit($id) {

    $team = Teams::find($id);
    if(1)   //if(\Auth::user()->can('Manage Team'))
    {
        if(1)   //if($team->created_by == \Auth::user()->creatorId())
        {
            $employees_superviors  = Employee::where('created_by', '=', \Auth::user()->creatorId())->where('designation_id', '=', Employee::supervisor_desig_id())->get();
            $employees_workers  = Employee::where('created_by', '=', \Auth::user()->creatorId())->where('designation_id', '=', Employee::worker_desig_id())->get();
            $team_id = $team->id;
            $displaytype = 'edit';
            return view('team_management.create', compact('team','displaytype','employees_superviors','team_id','employees_workers'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }
    else
    {
        return response()->json(['error' => __('Permission denied.')], 401);
    }
  }







      public function store(Request $request)
      {
          if(1) //if(\Auth::user()->can('Create Team'))
          {
              $vrules = [
                                 'supervisor_emp_id' => 'required|unique:teams,supervisor_emp_id',
                                 'team_name' => 'required|unique:teams,team_name',
                             ];
              $validator = \Validator::make(
                  $request->all(), $vrules
              );
         if($validator->fails())
              {
                  $messages = $validator->getMessageBag();
                  return redirect()->back()->with('error', $messages->first());
              }

              DB::beginTransaction();
                  try {
                    $team              = new Teams();
                    $team->team_name = $request->team_name;
                    $team->supervisor_emp_id = $request->supervisor_emp_id;
                    $team->created_by  = \Auth::user()->creatorId();



                    $team->save();
                    $new_team_id = $team->id;
                    if($request->worker_emp_id[0] =="all" ){
                      $employees_workers  = Employee::where('created_by', '=', \Auth::user()->creatorId())->where('designation_id', '=', Employee::worker_desig_id())->get();
                      foreach($employees_workers as $wk)
                      {
                        $teamworker              = new TeamsWorkers();
                        $teamworker->team_id = $new_team_id;
                        $teamworker->worker_emp_id = $wk->id;
                        $teamworker->created_by  = \Auth::user()->creatorId();
                        $teamworker->save();
                        unset($teamworker);
                      }
                    } else {
                      foreach($request->worker_emp_id as $wk) {
                        $teamworker              = new TeamsWorkers();
                        $teamworker->team_id = $new_team_id;
                        $teamworker->worker_emp_id = $wk;
                        $teamworker->created_by  = \Auth::user()->creatorId();
                        $teamworker->save();
                        unset($teamworker);
                      }
                    }

                   DB::commit();

                  } catch (\Exception $e) {

                      DB::rollback();
                      Log::info(json_encode($e));
                     return redirect()->back()->with('error',"Database related error.");
                }
              return redirect()->route('team_management.index')->with('success', 'Team  successfully created.');
          }
          else
          {
              return redirect()->back()->with('error', __('Permission denied.'));
          }
    }











                 public function update(Request $request, Teams $team)
                 {
                  if(1) //if(\Auth::user()->can('Manage Team'))
                     {
                         if(1) //if($team->created_by == \Auth::user()->creatorId())
                         {
                           $vrules = [
                                              'team_name' => 'required',
                                          ];
                           $validator = \Validator::make(
                               $request->all(), $vrules
                           );
                      if($validator->fails())
                           {
                               $messages = $validator->getMessageBag();
                               return redirect()->back()->with('error', $messages->first());
                           }

                          // DB::beginTransaction();
                               try {

                                 Teams::where("id",$request->id)->update([
                                   'team_name' => $request->team_name,
                                   'created_by' =>  \Auth::user()->creatorId(),
                                 ]);


                                 TeamsWorkers::where('team_id',$request->id)->delete();
                                 $new_team_id = $request->id;
                                 if($request->worker_emp_id[0] =="all" ){
                                               $employees_workers  = Employee::where('created_by', '=', \Auth::user()->creatorId())->where('designation_id', '=', Employee::worker_desig_id())->get();
                                               foreach($employees_workers as $wk)
                                               {
                                                 $teamworker              = new TeamsWorkers();
                                                 $teamworker->team_id = $new_team_id;
                                                 $teamworker->worker_emp_id = $wk->id;
                                                 $teamworker->created_by  = \Auth::user()->creatorId();
                                                 $teamworker->save();
                                                 unset($teamworker);
                                               }
                                              // echo "herere"; exit();
                                 } else {
                                   foreach($request->worker_emp_id as $wk) {
                                     $teamworker              = new TeamsWorkers();
                                     $teamworker->team_id = $new_team_id;
                                     $teamworker->worker_emp_id = $wk;
                                     $teamworker->created_by  = \Auth::user()->creatorId();
                                     $teamworker->save();
                                     unset($teamworker);
                                   }
                                 }
//exit();
                              //  DB::commit();

                               } catch (\Exception $e) {

                                  // DB::rollback();
                                   Log::info(json_encode($e));
                                  return redirect()->back()->with('error',"Database related error.");
                             }
                           return redirect()->route('team_management.index')->with('success', 'Team  successfully updated.');

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








                 public function destroy($id)
                 {

                   if(1) //if(\Auth::user()->can('Manage Team'))
                     {
                         if(1) //if($team->created_by == \Auth::user()->creatorId())
                         {

                             TeamsWorkers::where('team_id',$id)->delete();
                             Teams::where('id',$id)->delete();
                             // leave them here only for the time + transaction
                             // The validations to check if team is being used or not
                             return redirect()->back()->with('success', __('Team successfully deleted.'));
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
