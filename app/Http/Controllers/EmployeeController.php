<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Department;
use App\Designation;
use App\Jbr;
use Closure;
use Illuminate\Support\Facades\Log;


use App\Teams;
use App\TeamsWorkers;

use App\Document;
use App\Employee;
use App\EmployeeDocument;
use App\EmpPaygrades;
use App\Mail\UserCreate;
use App\Plan;
use App\DeductionOption;
use App\User;
use App\Utility;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use DB;
use Spatie\Permission\Models\Role;
use Session;
//use Faker\Provider\File;

class EmployeeController extends Controller
{



  public function store(Request $request)
  {




//var_dump($_REQUEST);
// exit();


      if(\Auth::user()->can('Create Employee'))
      {

          $created_date_time=date("Y-m-d h:i:s");
          /* $validator = \Validator::make(
              $request->all(), [
                              //    'name' => 'required',
                                 'first_name' => 'required',
                                 'last_name' => 'required',
                                 'username' => 'required',
                                 'passport_no' => 'required',
                                 'passport_expire' => 'required',
                                 'nationality' => 'required',
                                 'religion' => 'required',
                                 'marital_status' => 'required',
                                 'emr_name2' => 'required',
                                 'emr_name1' => 'required',
                              //     'dob' => 'required',
                              //    'gender' => 'required',
                                 'phone' => 'required',
                                 'branch_id' => 'required',
                              'address' => 'required',
                              'username' => 'required|min:4|unique:users,username',
                                 'email' => 'required|unique:users',
                                 'password' => 'min:6|required_with:confirm_password|same:confirm_password|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$@#%]).*$/',
                                 'department_id' => 'required',
                                 'designation_id' => 'required',
                                 'des_id1' => 'required',
                                // 'account_holder_name' => 'required',
                                // 'account_number' => 'required |numeric',
                                // 'bank_name' => 'required',
                                // 'branch_location' => 'required',
                                // 'bank_identifier_code' => 'required',
                                 //'document.*' => 'image|mimes:jpeg,png,jpg,gif,svg,pdf,doc|max:20480',
                             ]
          );
          if($validator->fails())
          {
              $messages = $validator->getMessageBag();

              return redirect()->back()->with('error', $messages->first())->withinput();
          }   */

//var_dump($request);

          //  PLAN BEING SELECTED HERE
          $objUser        = \Auth::user();
          $total_employee = $objUser->countEmployees();
          $plan           = Plan::find($objUser->plan);

         // OLD CODE if($total_employee < $plan->max_employees || $plan->max_employees == -1)// {

                 // FILE UPLOADING LOGICS AT TOP BEFORE DB UPDATE SO LESS ROLLBACKS IF ERROR
                 if($request->hasFile('profile_images'))
                 {

                     $file = $request->file('profile_images');
                     $filenameWithExt = $request->file('profile_images')->getClientOriginalName();
                     $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                     $extension       = $request->file('profile_images')->getClientOriginalExtension();
                     $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                     $dir             = storage_path('uploads/document/');
                     $image_path      = $dir . $filenameWithExt;
                     $file->move(public_path().'/uploads/document/', $fileNameToStore);
                 }
                 else
                 {
                     $fileNameToStore='';
                 }

                 DB::beginTransaction();

                 try {

              //transaction starts here
              // FROM  Basic Information  SECTION OF FORM
              $user = User::create(
                  [
                      'name' => $request->first_name." ".$request->last_name,
                      'username' => $request->username,
                      'email' => $request['email'],
                      'password' => Hash::make($request['password']),
                      'type' => $request->user_type,
                      'lang' => 'en',
                      'created_by' => \Auth::user()->creatorId(),
                  ]
              );
              $user->save();

              /// TO CLARIFY
              $user->assignRole('hr');



            //  OLD CODE  FROMHRM$user->assignRole('Employee');// }// else// {//return redirect()->back()->with('error', __('Your employee limit is over, Please upgrade plan.'));//  }// if(!empty($request->document) && !is_null($request->document))// {//     $document_implode = implode(',', array_keys($request->document));// }// else// {//     $document_implode = null;// }


            // FROM  Basic Information  SECTION OF FORM
            // FROM Employment Information SECTION OF FORM
            // FROM Department Information  SECTION OF FORM
            // FROM  Personal Information  SECTION OF FORM
            // FORM Basic Salary Information SECTION OF FORM
            // FROM Working Hours SECTION OF FORM
            $employee = Employee::create(
              [
                  'user_id' => $user->id,
                  'name' => $request->first_name." ".$request->last_name,
                  'first_name' => $request->first_name,
                  'last_name' => $request->last_name,
                  'email' => $request->email,
                  'username' => $request->username,
                  'dob' => date('Y-m-d', strtotime($request['dob'])),
                  'phone' => $request->phone,
                  'documents' => $fileNameToStore,

                  'pass_type' => $request->pass_type,
                  'year_type' => $request->year_type,
                  'company_doj' => date("Y-m-d",strtotime($request->company_doj)),
                  'other_emp' => $request->other_emp,
                  'emp_type' => $request->emp_type,
                  'company' => $request->company,
                  'donation_type' => $request['donation_type'],


                  'branch_id' => $request['branch_id'],
                  'department_id' => $request['department_id'],
                  'designation_id' => $request['designation_id'],
                  'uniform' => $request->uniform,
                  'uniform_size' => $request->uniform_size,
                  'contract_period' => $request->contract_period,
                  'other_contract' => $request->other_contract1,
                  'probation_period' => $request->probation_period,
                  'emp_other_prob' => $request->other_prob,
                  'notice_period' => $request->notice_period,
                  'other_notice' => $request->other_notice,
                  'worker_id' => $request->worker_id,
                  'reporting_id' => $request->report_id,


                  'identifications_no' =>$request['identifications_no'],
                  'race' => $request->race,
                  'own_bike' => $request['own_bike'],
                  'own_sg_car' => $request['own_sg_car'],
                  'iunumber_b' => $request['IU_number'],
                  'iunumber_c' => $request['IU_number_c'],
                  'regis_no_b' => $request['Registration_number'],
                  'regis_no_c' => $request['Registration_number_c'],

                  'pay_grade' =>  $request->pay_grade,

                  'shift_type' => $request->shift_type,

                  'employee_id' => $this->employeeNumber(),

                  'created_by' => \Auth::user()->creatorId(),
              ]
          );


          // FROM Other Documents  SECTION OF FORM
          if($request->hasFile('document_upload'))
          {
              $file = $request->file('document_upload');
              foreach($file as $key => $document1)
                  {
                      $filenameWithExt = $request->file('document_upload')[$key]->getClientOriginalName();
                      $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                      $extension       = $request->file('document_upload')[$key]->getClientOriginalExtension();
                      $fileNameToStore11 = $filename . '_' . time() . '.' . $extension;
                      $dir             = storage_path('uploads/document/');
                      $image_path      = $dir . $filenameWithExt;
                      $document1->move(public_path().'/uploads/document/', $fileNameToStore11);
                      $inputqua=array('employee_id' => $employee->id,
                      'document_value' => $fileNameToStore11,
                      'created_at' => $created_date_time,
                      'created_by'=>\Auth::user()->creatorId());
                       DB::table('employee_documents')->insert($inputqua);
                  }
          }


          /*
          FROM  Personal Information  SECTION OF FORM
          FROM  Basic Information  SECTION OF FORM
          */
          $input=array('user_id' => $user->id,
          'passport_no' => $request->passport_no,
          'passport_expire' => date("Y-m-d",strtotime($request->passport_expire)),
          'tel' => $request->tel,
          'nationality' => $request->nationality,
          'religion' => $request->religion,
          'marital_status' => $request->marital_status,
          'marital_status1' => $request->marital_status1,
          'spouse' => $request->spouse,
          'no_of_child' => $request->no_of_child,
          'created_at' => $created_date_time);
          DB::table('emp_personal_info')->insert($input);


          // FROM Emergency Contact  SECTION OF FORM
          if(!empty($request->emr_name1)){
            $input=array('user_id' => $user->id,
            'emr_name1' => $request->emr_name1,
            'emr_phone1' => $request->emr_phone1,
            'emr_relation1' => $request->emr_relation1,
            'emr_phone12' => $request->emr_phone12,
            'created_at' => $created_date_time);
            DB::table('emp_primary_details')->insert($input);
          }
          if(!empty($request->emr_name2)){
             $input1=array('user_id' => $user->id,
             'emr_name2' => $request->emr_name2,
             'emr_phone2' => $request->emr_phone2,
             'emr_relation2' => $request->emr_relation2,
             'emr_phone22' => $request->emr_phone22,
             'created_at' => $created_date_time);
             DB::table('emp_secondry_details')->insert($input1);
          }

          //FROM Family Informations SECTION OF FOMR
          for($i=0;$i<count($request->emr_family_name2);$i++) {
            if(!empty($request->emr_family_name2[$i])){
                 ///employee family details//
                 $input1=array('user_id' => $user->id,
                 'emr_family_name2' => $request->emr_family_name2[$i],
                 'emr_family_relation2' => $request->emr_family_relation2[$i],
                 'emr_dob' => $request->emr_dob[$i],
                 'emr_family_phone' => $request->emr_family_phone[$i],
                 'created_at' => $created_date_time);
                 DB::table('emp_family_info')->insert($input1);
            }
          }

          //FROM Experience Informations SECTION OF FOMR
          for($i=0;$i<count($request->exp_name);$i++) {
            if(!empty($request->exp_name[$i])){
               ///employee experience details//
               $input123=array('user_id' => $user->id,
               'exp_name' => $request->exp_name[$i],
               'exp_location' => $request->exp_location[$i],
               'exp_job_position' => $request->exp_job_position[$i],
               'exp_from' => $request->exp_from[$i],
               'exp_to' => $request->exp_to[$i],
               'created_at' => $created_date_time);
               DB::table('emp_experience_info')->insert($input123);
            }
          }

          //FROM License Informations SECTION OF FORM
          for($i=0;$i<count($request->emp_license);$i++) {
            if(!empty($request->emp_license[$i])){
               ///employee license details//
               $input123=array('user_id' => $user->id,
               'emp_license' => $request->emp_license[$i],
               'other_text' => $request->other_text[$i],
               'lic_expire_Date' => $request->lic_expire_Date[$i],
               'created_at' => $created_date_time);
               DB::table('emp_licenses')->insert($input123);
            }
          }

          //FROM Deduction Informations SECTION OF FORM
          for($i=0;$i<count($request->deduction_id);$i++) {
            if(!empty($request->deduction_amount[$i])){
               ///employee license details//
               $input123=array('user_id' => $user->id,
               'deduction_id' => $request->deduction_id[$i],
               'deduction_amount' => $request->deduction_amount[$i],
               'other_text_d' => $request->other_text_d[$i],
               'other_amount' => $request->other_amount[$i],
               'created_at' => $created_date_time);
               DB::table('emp_deductions')->insert($input123);
            }
          }


          // FROM Bank information SECTION IOF FORM
          ///employee bank details//
               $input12=array('user_id' => $user->id,
               'bank_name' => $request->bank_name,
               'bank_account_no' => $request->bank_account_no,
               'bank_branch_code' => $request->bank_branch_code,
               'bank_pay_now' => $request->bank_pay_now,
               'unique_no' => $request->unique_no,
               'created_at' => $created_date_time);
               DB::table('emp_bank_info')->insert($input12);


               // FROM CPF  information SECTION IOF FORM
               ///employee CPF  details//
               $input12=array('user_id' => $user->id,
               'cpf_contribution' => $request->cpf_contribution,
               'cpf_no' => $request->cpf_no,
               'emp_cpf_contribution' => $request->emp_cpf_contribution,
               'additional_rate' => $request->additional_rate,
               'total_rate' => $request->total_rate,
               'created_at' => $created_date_time);
               DB::table('emp_cpf_info')->insert($input12);


               // FORM Basic Salary Information SECTION OF FORM
                 if($request->payment_type == 'Other') {
                   $mypayment_type = $request->other_payment;
                 } else {
                   $mypayment_type = $request->payment_type;
                 }

               $input12=array('user_id' => $user->id,
               'salary_type' => $request->salary_type,
               'salary_amount' => $request->salary_amount,
               'payment_type' => $mypayment_type,
               'created_at' => $created_date_time);
               DB::table('emp_slary_info')->insert($input12);


               // FORM Education Qualification SECTION OF FORM
               ///employee qualification details//
               if(!empty($request->emp_qualification))
               {
                   foreach($request->emp_qualification as $key=>$val)
                   {
                       if($val=='Others')
                       {
                         $inputqua=array('user_id' => $user->id,
                         'title' => $val,
                         'emp_qual_text' => $request->emp_qual_text,
                         'created_at' => $created_date_time);
                         DB::table('emp_qualification')->insert($inputqua);
                       }
                       else
                       {
                         $inputqua=array('user_id' => $user->id,
                         'title' => $val,
                         'emp_qual_text' => "",
                         'created_at' => $created_date_time);
                         DB::table('emp_qualification')->insert($inputqua);
                       }
                   }
               }
                ///end employee qualification details//

                // FORM Employee Address SECTION OF FORM
                if(!empty($request->ca_postalcode))
                {
                  $input123=array('user_id' => $user->id,
                  'postalcode' => $request->ca_postalcode,
                  'street' => $request->ca_street,
                  'building' => $request->ca_build,
                  'unitfrm' => $request->ca_unitfrm,
                  'address_type' => 'C',
                  'unitto' => $request->ca_unitto,
                  'created_at' => $created_date_time);
                  DB::table('emp_addresses')->insert($input123);
                }
                if(!empty($request->pa_postalcode))
                {
                  $input123=array('user_id' => $user->id,
                  'postalcode' => $request->pa_postalcode,
                  'street' => $request->pa_street,
                  'building' => $request->pa_build,
                  'unitfrm' => $request->pa_unitfrm,
                  'address_type' => 'P',
                  'unitto' => $request->pa_unitto,
                  'created_at' => $created_date_time);
                  DB::table('emp_addresses')->insert($input123);
                }

                // FROM Department Information  SECTION OF FORM
                if(!empty($request->team_id))
                {
                    foreach($request->team_id as $key=>$val)
                    {
                      $input12=array('worker_emp_id' => $user->id,
                      'team_id' => $val,
                      'created_at' => $created_date_time);
                      DB::table('teams_workers')->insert($input12);
                    }
                }


                // FROM Department Information  SECTION OF FORM
                if(!empty($request->responsibilties_id))
                {
                    foreach($request->responsibilties_id as $key=>$val)
                    {
                      $input12=array('employee_id' => $user->id,
                      'jbr_id' => $val,
                      'created_at' => $created_date_time);
                      DB::table('employee_jbrs')->insert($input12);
                    }
                }

                // FROM Department Information  SECTION OF FORM
                if(!empty($request->client_location))
                {
                    foreach($request->client_location as $key=>$val)
                    {
                      $input12=array('worker_emp_id' => $user->id,
                      'location_id' => $val,
                      'created_at' => $created_date_time);
                      DB::table('employee_jbrs')->insert($input12);
                    }
                }






// $setings = Utility::settings();// if($setings['employee_create'] == 1)// {//     $user->type     = 'Employee';//     $user->password = $request['password'];//     try//     {//         Mail::to($user->email)->send(new UserCreate($user));//     }//     catch(\Exception $e)//     {//         $smtp_error = __('E-Mail has been not sent due to SMTP configuration');//     }//     return redirect()->route('employee.index')->with('success', __('Employee successfully created.') . (isset($smtp_error) ? $smtp_error : ''));// }// $endpoint = "http://localhost/masters/public/";// $client = new \GuzzleHttp\Client();// $id = 5;// $value = "ABC";// $response = $client->request('GET', $endpoint, ['query' => [//     'name' => $request->first_name." ".$request->last_name,//     'username' => $request->username,//     'email' => $request['email'],//     'password' => Hash::make($request['password']),//     'type' => $request->user_type,// ]]);// // url will be: http://my.domain.com/test.php?key1=5&key2=ABC;// $statusCode = $response->getStatusCode();// $content = $response->getBody();// dd($statusCode,$content);



DB::commit();

} catch (\Exception $e) {
//var_dump($e);
Log::info(json_encode($e));
DB::rollback();
//return redirect()->back()->with('error', 'Error saving - Incorrect data entered.');

}

//exit();
          return redirect()->route('employee.index')->with('success', __('Employee  successfully created.'));






      }
      else
      {
          return redirect()->back()->with('error', __('Permission denied.'));
      }
  }































    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $permissions = \Auth::user()->getAllPermissions();

//print_r($permissions);exit;
        if(\Auth::user()->can('Manage Employee'))
        {


            if(!empty(Session::get('my_own_access')) && Session::get('my_own_access')=='self')
            {
                $employees = Employee::where('user_id', '=', Auth::user()->id)->orderBy("id","DESC");
            }
            else
            {
                $employees = Employee::orderBy("id","DESC");
            }





               // $employees = Employee::where('created_by', \Auth::user()->creatorId());
               // $employees = Employee::orderBy("id","DESC");
                if(!empty($request->department_id))
                {

                    $employees->where('department_id', $request->department_id);
                }

                if(!empty($request->designation_id))
                {

                    $employees->where('designation_id', $request->designation_id);
                }
                if(!empty($request->emp_name))
                {

                    $employees->where('name','like', '%'.$request->emp_name.'%');
                }



            if(empty($request->department_id) && empty($request->emp_name) && empty($request->designation_id))
            {
                //$employees = Employee::where('created_by', \Auth::user()->creatorId())->paginate(10);
                $employees = Employee::orderBy("id","DESC")->paginate(10);

                if(!empty(Session::get('my_own_access')) && Session::get('my_own_access')=='self')
                {
                    $employees = Employee::where('user_id', '=', Auth::user()->id)->orderBy("id","DESC")->get();
                }
                else
                {
                    $employees = Employee::orderBy("id","DESC")->paginate(10);
                }
            }
            else
            {
                $employees = $employees->paginate(10);
            }

            $departments      = Department::get();
            $designations     = Designation::get();
            //$responsbilites     = Responsbilites::get();
            $emp_set_date = DB::table('emp_set_date')->first();
            return view('employee.index', compact('employees','emp_set_date','departments','designations'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {

        if(\Auth::user()->can('Create Employee'))
        {

            $company_settings = Utility::settings();
            $documents        = Document::where('created_by', \Auth::user()->creatorId())->get();
            $branches         = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $departments      = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $designations     = Designation::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');


            $teams_dropdown     = Teams::get()->pluck('team_name', 'id' );
            $employees        = User::where('created_by', \Auth::user()->creatorId())->get();
            $employeesId      = \Auth::user()->employeeIdFormat($this->employeeNumber());
            $nationalities    = DB::table("nationality")->get();
            $deductions       = DeductionOption::get()->pluck('name', 'id');
            $shift_types    = DB::table("shift_types")->get();

            return view('employee.create', compact('shift_types','teams_dropdown','employees', 'employeesId', 'departments', 'designations', 'documents', 'branches', 'company_settings','nationalities','deductions'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function edit($id)
    {

        $id = Crypt::decrypt($id);
        if(\Auth::user()->can('Edit Employee'))
        {
            // $documents    = Document::where('created_by', \Auth::user()->creatorId())->get();
            // $branches     = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            // $departments  = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            // $designations = Designation::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $documents    = Document::get();
            $branches     = Branch::get()->pluck('name', 'id');
            $departments  = Department::get()->pluck('name', 'id');
            $designations = Designation::get()->pluck('name', 'id');
            $employee     = Employee::find($id);
            $employee_personal    = DB::table("emp_personal_info")->where("user_id",$employee->user_id)->first();
            $employeesId  = \Auth::user()->employeeIdFormat($employee->employee_id);
            $employee_primary    = DB::table("emp_primary_details")->where("user_id",$employee->user_id)->first();
            $employee_secondry    = DB::table("emp_secondry_details")->where("user_id",$employee->user_id)->first();
            $employee_family    = DB::table("emp_family_info")->where("user_id",$employee->user_id)->first();
            $employee_experience    = DB::table("emp_experience_info")->where("user_id",$employee->user_id)->first();
            $employee_bank    = DB::table("emp_bank_info")->where("user_id",$employee->user_id)->first();
            $employee_slary    = DB::table("emp_slary_info")->where("user_id",$employee->user_id)->first();
            $employee_cpf    = DB::table("emp_cpf_info")->where("user_id",$employee->user_id)->first();

            $employee_qalification    = DB::table("emp_qualification")->where("user_id",$employee->user_id)->get();
            $employee_license   = DB::table("emp_license")->where("user_id",$employee->user_id)->get();
            $employee_deduction   = DB::table("emp_deduction_amount")->where("employee_id",$employee->id)->get();
            $deductions   = DeductionOption::all();
            $employee_it   = DB::table("emp_it")->where("user_id",$employee->user_id)->get();
            $employee_certificates   = DB::table("emp_certificates")->where("user_id",$employee->user_id)->get();
            $employee_skills   = DB::table("emp_skills")->where("user_id",$employee->user_id)->get();

            $employee_qalification_t  = DB::table("emp_qualification")->where("title","Others")->where("user_id",$employee->user_id)->first();
            $employee_license_t   = DB::table("emp_license")->where("title","Others")->where("user_id",$employee->user_id)->first();
            $employee_it_t   = DB::table("emp_it")->where("title","Others")->where("user_id",$employee->user_id)->first();
            $employee_certificates_t   = DB::table("emp_certificates")->where("title","Others")->where("user_id",$employee->user_id)->first();
            $employee_skills_t   = DB::table("emp_skills")->where("title","Others")->where("user_id",$employee->user_id)->first();
            $employee_all_grade     = EmpPaygrades::where("grade_type",$employee_slary->salary_type)->get();
            $employee_qalification1=$employee_license1=$employee_it1=$employee_certificates1=$employee_skills1=$extra_text=array();
            $emp_qual_text=$emp_licence_text=$technical_other_text=$emp_ertificates_text=$extra_text=$emp_skills_text='';
            $nationalities    = DB::table("nationality")->get();
            if(!empty($employee_qalification_t)) $emp_qual_text          = $employee_qalification_t->emp_qual_text;
            if(!empty($employee_license_t))      $emp_licence_text       = $employee_license_t->emp_licence_text;
            if(!empty($employee_it_t))           $technical_other_text   = $employee_it_t->technical_other_text;
            if(!empty($employee_certificates_t)) $emp_ertificates_text   = $employee_certificates_t->emp_ertificates_text;
            if(!empty($employee_skills_t))       $emp_skills_text        = $employee_skills_t->emp_skills_text;

            $extra_text=array("emp_qual_text"=>$emp_qual_text,"emp_licence_text"=>$emp_licence_text,"technical_other_text"=>$technical_other_text,"emp_ertificates_text"=>$emp_ertificates_text, "emp_skills_text"=>$emp_skills_text);

            if(!empty($employee_qalification))
            {
                foreach($employee_qalification as $val)
                {
                    $employee_qalification1[]= $val->title;
                }
            }

            if(!empty($employee_license))
            {
                foreach($employee_license as $val)
                {
                    $employee_license1[]= $val->title;
                }
            }

            if(!empty($employee_it))
            {
                foreach($employee_it as $val)
                {
                    $employee_it1[]= $val->title;
                }
            }

            if(!empty($employee_certificates))
            {
                foreach($employee_certificates as $val)
                {
                    $employee_certificates1[]= $val->title;
                }
            }

            if(!empty($employee_skills))
            {
                foreach($employee_skills as $val)
                {
                    $employee_skills1[]= $val->title;
                }
            }


            return view('employee.edit', compact('deductions','employee_deduction','nationalities','employee_all_grade','employee', 'employeesId', 'branches', 'departments', 'designations', 'documents','employee_personal','employee_primary','employee_secondry','employee_family','employee_experience','employee_bank','employee_slary','employee_cpf','employee_qalification1','employee_license1','employee_it1','employee_certificates1','employee_skills1','extra_text','employee_license'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(Request $request, $id)
    {

        if(\Auth::user()->can('Edit Employee'))
        {
            $validator = \Validator::make(
                // $request->all(), [
                //                    'name' => 'required',
                //                    'dob' => 'required',
                //                    'gender' => 'required',
                //                    'phone' => 'required|numeric',
                //                    'address' => 'required',
                //                    'department_id' => 'required',
                //                    'designation_id' => 'required',
                //                    'account_holder_name' => 'required',
                //                    'account_number' => 'required |numeric',
                //                    'bank_name' => 'required',
                //                    'branch_location' => 'required',
                //                    'bank_identifier_code' => 'required',
                //                    'document.*' => 'image|mimes:jpeg,png,jpg,gif,svg,pdf,doc|max:20480',
                //                ]

                $request->all(), [
                    //    'name' => 'required',
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'username' => 'required',
                    'passport_no' => 'required',
                    'passport_expire' => 'required',
                    'nationality' => 'required',
                    //'religion' => 'required',
                    'marital_status' => 'required',
                    //'emr_name2' => 'required',
                    //'emr_name1' => 'required',
                    'phone' => 'required',
                    'branch_id' => 'required',
                     'username' => 'required|min:4',
                    'address' => 'required',
                   // 'password' => 'min:6|required_with:confirm_password|same:confirm_password|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$@#%]).*$/',
                    'department_id' => 'required',
                    'designation_id' => 'required',

                 ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

           // $employee = Employee::findOrFail($id);

            // if($request->document)
            // {

            //     foreach($request->document as $key => $document)
            //     {
            //         if(!empty($document))
            //         {
            //             $filenameWithExt = $request->file('document')[$key]->getClientOriginalName();
            //             $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //             $extension       = $request->file('document')[$key]->getClientOriginalExtension();
            //             $fileNameToStore = $filename . '_' . time() . '.' . $extension;

            //             $dir        = storage_path('uploads/document/');
            //             $image_path = $dir . $filenameWithExt;

            //             if(File::exists($image_path))
            //             {
            //                 File::delete($image_path);
            //             }
            //             if(!file_exists($dir))
            //             {
            //                 mkdir($dir, 0777, true);
            //             }
            //             $path = $request->file('document')[$key]->storeAs('uploads/document/', $fileNameToStore);


            //             $employee_document = EmployeeDocument::where('employee_id', $employee->employee_id)->where('document_id', $key)->first();

            //             if(!empty($employee_document))
            //             {
            //                 $employee_document->document_value = $fileNameToStore;
            //                 $employee_document->save();
            //             }
            //             else
            //             {
            //                 $employee_document                 = new EmployeeDocument();
            //                 $employee_document->employee_id    = $employee->employee_id;
            //                 $employee_document->document_id    = $key;
            //                 $employee_document->document_value = $fileNameToStore;
            //                 $employee_document->save();
            //             }

            //         }
            //     }
            // }

            $employee = Employee::findOrFail($id);//dd($employee);
            //$input    = $request->all();
            $res=$request->designation_id1;
            if(empty($res))
            {
            $res=0;
            }
            else{

              $res=implode(",",$request['designation_id1']);

            }

            if($request->hasFile('profile_images'))
            {

                $file = $request->file('profile_images');
                    $filenameWithExt = $request->file('profile_images')->getClientOriginalName();
                    $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension       = $request->file('profile_images')->getClientOriginalExtension();
                    $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                    $dir             = storage_path('uploads/document/');
                    $image_path      = $dir . $filenameWithExt;

                    $file->move(public_path().'/uploads/document/', $fileNameToStore);


            }
            else
            {
                $fileNameToStore=$employee->documents;
            }

            $input=array('name' => $request->first_name." ".$request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'emp_type' => $request->emp_type,
            'other_emp' => $request->other_emp,
            'year_type' => $request->year_type,
            'pass_type' => $request->pass_type,
            'company_doj' => date("Y-m-d",strtotime($request->company_doj)),
           'email' => $request->email,
            'phone' => $request->phone,
            'race' => $request->race,
            'employee_id' => $employee->id,
            'branch_id' => $request['branch_id'],
            'department_id' => $request['department_id'],
            'designation_id' => $request['designation_id'],
            'reporting_id' => $request['report_id'],
            'respo_name' => $res,
            'donation_type' => $request['donation_type'],
            'dob' => date('Y-m-d', strtotime($request['dob'])),
            'documents' => $fileNameToStore,
            'company' => $request->company,
            'own_sg_car' => $request['own_sg_car'],
            'own_bike' => $request['own_bike'],
            'iunumber_b'=>$request->emp_sg_bike_iu,
            'regis_no_b'=>$request->regis_no_b,
            'iunumber_c'=>$request->emp_sg_car_iu,
            'regis_no_c'=>$request->regis_no_c,
            'nok' => $request->nok,
            'address' => $request->address,
            'uniform' => $request->uniform,
            'gender' => $request->gender,
            'uniform_size' => $request->uniform_size,
            'contract_period' => $request->contract_period,
            'other_contract'=> $request->emp_other_contract,
            'emp_other_prob'=>$request->emp_other_prob,
            'probation_period' => $request->probation_period,
            'notice_period' => $request->notice_period,
            'other_notice' =>$request->emp_other_notice,
            'start_hrs'=>$request->strt_hrs,
            'start_mins'=>$request->strt_mins,
            'end_hrs'=>$request->end_hrs,
            'end_mins'=>$request->end_mins,
            'total_work_hrs'=>0,
            'working_day'=>$request->own_friday,
           // 'identifications_type' => $request['identifications_type'],
            'identifications_no' =>$request['identifications_no'],
            'pay_grade' => 0,
           );
          // dd($input);
            //$employee->fill($input)->save();
            DB::table('employees')->where("id",$employee->id)->update($input);

            $created_date_time=date("Y-m-d h:i:s");

            if($request->hasFile('document_upload'))
            {
                $file = $request->file('document_upload');
                foreach($file as $key => $document1)
                    {
                         //dd($document);

                        $filenameWithExt = $request->file('document_upload')[$key]->getClientOriginalName();
                        $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        $extension       = $request->file('document_upload')[$key]->getClientOriginalExtension();
                        $fileNameToStore11 = $filename . '_' . time() . '.' . $extension;
                        $dir             = storage_path('uploads/document/');
                        $image_path      = $dir . $filenameWithExt;
                        // $fileNameToStore1[]=$fileNameToStore;
                        $document1->move(public_path().'/uploads/document/', $fileNameToStore11);

                        $inputqua=array('employee_id' => $employee->id,
                        'document_value' => $fileNameToStore11,
                        'created_at' => $created_date_time,
                        'created_by'=>\Auth::user()->creatorId());
                            DB::table('employee_documents')->insert($inputqua);
                    }

            }


            ///PERSONAL INFO INSERT//
            $input1=array(
            'passport_no' => $request->passport_no,
            'passport_expire' => date("Y-m-d",strtotime($request->passport_expire)),
            'tel' => $request->tel,
            'nationality' => $request->nationality,
            'religion' => $request->religion,
            'marital_status' => $request->marital_status,
            'marital_status1' => $request->emp_other_marital,
            'spouse' => $request->spouse,
            'other_payment' =>$request->emp_payment1,
            'no_of_child' => $request->no_of_child);
            DB::table('emp_personal_info')->where("user_id",$employee->user_id)->update($input1);

            ///END PERSONAL INFO INSERT//



              ///employee primary details//
              $input2=array(
              'emr_name1' => $request->emr_name1,
              'emr_phone1' => $request->emr_phone1,
              'emr_relation1' => $request->emr_relation1,
              'emr_phone12' => $request->emr_phone12);
              DB::table('emp_primary_details')->where("user_id",$employee->user_id)->update($input2);

              ///END primary INFO INSERT//


               ///employee secondry details//
               $input3=array(
               'emr_name2' => $request->emr_name2,
               'emr_phone2' => $request->emr_phone2,
               'emr_relation2' => $request->emr_relation2,
               'emr_phone22' => $request->emr_phone22);
               DB::table('emp_secondry_details')->where("user_id",$employee->user_id)->update($input3);

               ///END secondry INFO INSERT//


                 ///employee family details//
                 // $input4=array(
                 // 'emr_family_name2' => $request->emr_family_name2,
                 // 'emr_family_relation2' => $request->emr_family_relation2,
                 // 'emr_dob' => $request->emr_dob,
                 // 'emr_family_phone' => $request->emr_family_phone);
                 // DB::table('emp_family_info')->where("user_id",$employee->user_id)->update($input4);



                 $strt_hrs=$request->strt_hrs;
                 $strt_mins=$request->strt_mins;
                 $end_hrs=$request->end_hrs;
                 $end_mins=$request->end_mins;



                 $mytext=$request->emr_family_name2;

                 //print_r($mytext)


                 $value2=0;
                 $value3=0;
                 $value41=0;
                 $value51=0;
                 $value7=0;
                 $value8=0;
                 //print_r($mytext);
                 if(!empty($mytext))
                 {
                   foreach($mytext as $value){
                   $value1           = $value;
                   //print_r($value1);
                   $value12[]=$value1;
                 }
                   $value21=implode(',',$value12);
                 if($value21=='')
                 {
                   $value2=0;

                 }else {
                   // code...
                   $value2=implode(',',$value12);
                 }
                 }

                     $mytext1=$request->emr_family_relation2;
                     if(!empty($mytext1))
                     {
                       foreach($mytext1 as $values){
                       $value12           = $values;
                       //print_r($value1);
                       $value11[]=$value12;
                     }
                   $value3=implode(',',$value11);

                   }
                     $m3=$request->emr_dob;
                     //print_r($m3);
                     if(!empty($m3))
                     {
                       foreach($m3 as $value1){
                       $value31           = $value1;
                       //print_r($value1);
                       $value13[]=$value31;
                       }
                       $value41=implode(',',$value13);
                       //print_r($value4);
                   }

                   $mytext4=$request->emr_family_phone;
                   if(!empty($mytext4))
                   {
                     foreach($mytext4 as $vals){
                     $value42           = $vals;
                     //print_r($value1);
                     $value14[]=$value42;
                   }
                     $value51=implode(',',$value14);

                   }



                 if(!empty($request->emr_family_name2)){
                      ///employee family details//
                      $input4=array('emr_family_name2' => $value2,
                      'emr_family_relation2' => $value3,
                      'emr_dob' => $value41,
                      'emr_family_phone' => $value51,
                      'created_at' => $created_date_time);
                       DB::table('emp_family_info')->where("user_id",$employee->user_id)->update($input4);

                       ///end employee family details//
                 }


                  ///end employee family details//


                     ///employee experience details//
                 // $input5=array(
                 // 'exp_name' => $request->exp_name,
                 // 'exp_location' => $request->exp_location,
                 // 'exp_job_position' => $request->exp_job_position,
                 // 'exp_from' => $request->exp_from,
                 // 'exp_to' => $request->exp_to);
                 // DB::table('emp_experience_info')->where("user_id",$employee->user_id)->update($input5);




                 $mytext5=$request->exp_name;

                 //print_r($mytext)


                 $value9=0;
                 $value10=0;
                 $value11=0;
                 $value12=0;
                 $value13=0;
                 $value14=0;
                 //print_r($mytext);
                 if(!empty($mytext5))
                 {
                   foreach($mytext5 as $value5){
                   $value15           = $value5;
                   //print_r($value1);
                   $value125[]=$value15;
                 }
                   $value215=implode(',',$value125);
                 if($value215=='')
                 {
                   $value25=0;

                 }else {
                   // code...
                   $value25=implode(',',$value125);
                 }
                 }

                     $mytext26=$request->exp_location;
                     if(!empty($mytext26))
                     {
                       foreach($mytext26 as $values26){
                       $value126           = $values26;
                       //print_r($value1);
                       $value116[]=$value126;
                     }
                   $value36=implode(',',$value116);

                   }
                     $m36=$request->exp_job_position;
                     //print_r($m3);
                     if(!empty($m36))
                     {
                       foreach($m36 as $value123){
                       $value316           = $value123;
                       //print_r($value1);
                       $value136[]=$value316;
                       }
                       $value416=implode(',',$value136);
                       //print_r($value4);
                   }

                   $mytext406=$request->exp_from;
                   if(!empty($mytext406))
                   {
                     foreach($mytext406 as $vals406){
                     $value426           = $vals406;
                     //print_r($value1);
                     $value146[]=$value426;
                   }
                     $value516=implode(',',$value146);

                   }
                   $mytext407=$request->exp_to;
                   if(!empty($mytext407))
                   {
                     foreach($mytext407 as $vals407){
                     $value427           = $vals407;
                     //print_r($value1);
                     $value147[]=$value427;
                   }
                     $value517=implode(',',$value147);

                   }



                 if(!empty($request->exp_name)){
                      ///employee family details//
                      $input5=array('exp_name' => $value25,
                      'exp_location' => $value36,
                      'exp_job_position' => $value416,
                      'exp_from' => $value516,
                      'exp_to' => $value517,
                      'created_at' => $created_date_time);
                      DB::table('emp_experience_info')->where("user_id",$employee->user_id)->update($input5);

                       ///end employee family details//
                 }
















                  ///end employee experience details//








                    ///employee bank details//
                 $input6=array(
                 'bank_name' => $request->bank_name,
                 'bank_account_no' => $request->bank_account_no,
                 'bank_branch_code' => $request->bank_branch_code,
                 'bank_pay_now' => $request->bank_pay_now,
                 'unique_no' => $request->unique_no);
                 DB::table('emp_bank_info')->where("user_id",$employee->user_id)->update($input6);

                  ///end employee bank details//


                  ///employee salary details//
                //  $input7=array(
                //  'salary_type' => $request->salary_type,
                //  'salary_amount' => $request->salary_amount,
                //  'payment_type' => $request->payment_type);

                if(!empty($request->alloancw_type))
                {
                        if($request->alloancw_type=="Fixed")
                        {
                            $fixed_amount = $request->fixed_amount;
                            $variation_text=0;
                        }
                        if($request->alloancw_type=="Variation")
                        {
                            $fixed_amount=0;
                            $variation_text=$request->variation_text;
                        }
                }
                else{
                    $fixed_amount = $variation_text=0;
                }

                            $input7=array(
                            'salary_type' => $request->salary_type,
                            'salary_amount' => $request->salary_amount,
                            'payment_type' => $request->payment_type,
                            'deduction' => $request->deduction,
                            'alloancw_type' => $request->alloancw_type,
                            'variation_text' => $variation_text,
                            'fixed_amount' => $fixed_amount,
                            );

                            DB::table('emp_slary_info')->where("user_id",$employee->user_id)->update($input7);

                  ///end employee salary details//


                    ///employee cpf details//
                //  $input8=array(
                //  'cpf_contribution' => $request->cpf_contribution,
                //  'cpf_no' => $request->cpf_no,
                //  'emp_cpf_contribution' => $request->emp_cpf_contribution,
                //  'additional_rate' => $request->additional_rate,
                //  'total_rate' => $request->total_rate);
                //  DB::table('emp_cpf_info')->where("user_id",$employee->user_id)->update($input8);

                  ///end employee cpf details//


                  DB::table('emp_qualification')->where("user_id",$employee->user_id)->delete();
                  DB::table('emp_license')->where("user_id",$employee->user_id)->delete();
                  DB::table('emp_it')->where("user_id",$employee->user_id)->delete();
                  DB::table('emp_certificates')->where("user_id",$employee->user_id)->delete();
                  DB::table('emp_skills')->where("user_id",$employee->user_id)->delete();
                  DB::table('emp_deduction_amount')->where("employee_id",$employee->id)->delete();
                  $created_date_time=date("Y-m-d h:i:s");


                    ///employee deduction details//
                    if(!empty($request->deduction_id))
                    {
                        foreach($request->deduction_id as $key=>$val)
                        {
                            if($val=="987")
                            {
                                $inputqua=array('employee_id' => $employee->id,
                                'deduction_id' => $val,
                                'deduction_amount' => '',
                                'other_amount' => $request->other_amount[$key],
                                'other_text_d' => $request->other_text_d[$key],
                                'created_at' => $created_date_time);
                                DB::table('emp_deduction_amount')->insert($inputqua);
                            }
                            else
                            {
                                $inputqua=array('employee_id' => $employee->id,
                                'deduction_id' => $val,
                                'deduction_amount' => $request->deduction_amount[$key],
                                'other_amount' => '',
                                'other_text_d' =>'',
                                'created_at' => $created_date_time);
                                DB::table('emp_deduction_amount')->insert($inputqua);
                            }
                        }
                    }
                     ///end employee deduction details//

                   ///employee qualification details//
                   if(!empty($request->emp_qualification))
                   {
                       foreach($request->emp_qualification as $key=>$val)
                       {
                           if($val=='Others')
                           {
                             $inputqua=array('user_id' => $employee->user_id,
                             'title' => $val,
                             'emp_qual_text' => $request->emp_qual_text,
                             'created_at' => $created_date_time);
                             DB::table('emp_qualification')->insert($inputqua);
                           }
                           else
                           {
                             $inputqua=array('user_id' => $employee->user_id,
                             'title' => $val,
                             'emp_qual_text' => "",
                             'created_at' => $created_date_time);
                             DB::table('emp_qualification')->insert($inputqua);
                           }
                       }
                   }
                    ///end employee qualification details//


                    ///employee license details//
                //    if(!empty($request->emp_license))
                //    {
                //        foreach($request->emp_license as $key=>$val)
                //        {
                //            if($val=='Others')
                //            {
                //              $inputqua=array('user_id' => $employee->user_id,
                //              'title' => $val,
                //              'emp_licence_text' => $request->emp_licence_text,
                //              'created_at' => $created_date_time);
                //              DB::table('emp_license')->insert($inputqua);
                //            }
                //            else
                //            {
                //              $inputqua=array('user_id' => $employee->user_id,
                //              'title' => $val,
                //              'emp_licence_text' => "",
                //              'created_at' => $created_date_time);
                //              DB::table('emp_license')->insert($inputqua);
                //            }
                //        }
                //    }

                   if(!empty($request->emp_license))
                   {
                       foreach($request->emp_license as $key=>$val)
                       {
                           if($val=='Others')
                           {
                             $inputqua=array('user_id' => $employee->user_id,
                             'title' => $val,
                             'lic_expire_Date' => date("Y-m-d",strtotime($request->lic_expire_Date[$key])),
                             'emp_licence_text' => $request->other_text[$key],
                             'created_at' => $created_date_time);
                             DB::table('emp_license')->insert($inputqua);
                           }
                           else
                           {
                             $inputqua=array('user_id' => $employee->user_id,
                             'title' => $val,
                             'lic_expire_Date' => date("Y-m-d",strtotime($request->lic_expire_Date[$key])),
                             'emp_licence_text' => "",
                             'created_at' => $created_date_time);
                             DB::table('emp_license')->insert($inputqua);
                           }
                       }
                   }

                    ///end employee license details//


                      ///employee IT details//
                   if(!empty($request->emp_technical))
                   {
                       foreach($request->emp_technical as $key=>$val)
                       {
                           if($val=='Others')
                           {
                             $inputqua=array('user_id' => $employee->user_id,
                             'title' => $val,
                             'technical_other_text' => $request->technical_other_text,
                             'created_at' => $created_date_time);
                             DB::table('emp_it')->insert($inputqua);
                           }
                           else
                           {
                             $inputqua=array('user_id' => $employee->user_id,
                             'title' => $val,
                             'technical_other_text' => "",
                             'created_at' => $created_date_time);
                             DB::table('emp_it')->insert($inputqua);
                           }
                       }
                   }
                    ///end employee IT details//

                     ///employee Certificates details//
                   if(!empty($request->emp_ertificates))
                   {
                       foreach($request->emp_ertificates as $key=>$val)
                       {
                           if($val=='Others')
                           {
                             $inputqua=array('user_id' => $employee->user_id,
                             'title' => $val,
                             'emp_ertificates_text' => $request->emp_ertificates_text,
                             'created_at' => $created_date_time);
                             DB::table('emp_certificates')->insert($inputqua);
                           }
                           else
                           {
                             $inputqua=array('user_id' => $employee->user_id,
                             'title' => $val,
                             'emp_ertificates_text' => "",
                             'created_at' => $created_date_time);
                             DB::table('emp_certificates')->insert($inputqua);
                           }
                       }
                   }
                    ///end employee Certificates details//



                      ///employee Certificates details//
                   if(!empty($request->emp_skills))
                   {
                       foreach($request->emp_skills as $key=>$val)
                       {
                           if($val=='Others')
                           {
                             $inputqua=array('user_id' => $employee->user_id,
                             'title' => $val,
                             'emp_skills_text' => $request->emp_skills_text,
                             'created_at' => $created_date_time);
                             DB::table('emp_skills')->insert($inputqua);
                           }
                           else
                           {
                             $inputqua=array('user_id' => $employee->user_id,
                             'title' => $val,
                             'emp_skills_text' => "",
                             'created_at' => $created_date_time);
                             DB::table('emp_skills')->insert($inputqua);
                           }
                       }
                   }
                    ///end employee Certificates details//



            if($request->salary)
            {
                return redirect()->route('setsalary.index')->with('success', 'Employee successfully updated.');
            }

            if(\Auth::user()->type != 'employee')
            {
                return redirect()->route('employee.index')->with('success', 'Employee successfully updated.');
            }
            else
            {
                return redirect()->route('employee.show', \Illuminate\Support\Facades\Crypt::encrypt($employee->id))->with('success', 'Employee successfully updated.');
            }

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {

        if(Auth::user()->can('Delete Employee'))
        {

            $employee      = Employee::findOrFail($id);

            DB::table('emp_qualification')->where("user_id",$employee->user_id)->delete();
            DB::table('emp_license')->where("user_id",$employee->user_id)->delete();
            DB::table('emp_it')->where("user_id",$employee->user_id)->delete();
            DB::table('emp_certificates')->where("user_id",$employee->user_id)->delete();
            DB::table('emp_skills')->where("user_id",$employee->user_id)->delete();
            DB::table('emp_personal_info')->where("user_id",$employee->user_id)->delete();
            DB::table('emp_primary_details')->where("user_id",$employee->user_id)->delete();
            DB::table('emp_secondry_details')->where("user_id",$employee->user_id)->delete();
            DB::table('emp_family_info')->where("user_id",$employee->user_id)->delete();
            DB::table('emp_experience_info')->where("user_id",$employee->user_id)->delete();
            DB::table('emp_bank_info')->where("user_id",$employee->user_id)->delete();
            DB::table('emp_slary_info')->where("user_id",$employee->user_id)->delete();
            DB::table('emp_cpf_info')->where("user_id",$employee->user_id)->delete();
            DB::table('employee_manage_leave')->where("employee_id",$employee->id)->delete();

            $user          = User::where('id', '=', $employee->user_id)->first();
            $emp_documents = EmployeeDocument::where('employee_id', $employee->employee_id)->get();
            $employee->delete();
            $user->delete();
            $dir = storage_path('uploads/document/');
            foreach($emp_documents as $emp_document)
            {
                $emp_document->delete();
                if(!empty($emp_document->document_value))
                {
                    //unlink($dir . $emp_document->document_value);
                }

            }

            return redirect()->route('employee.index')->with('success', 'Employee successfully deleted.');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }
    public function delete_emp_docs(Request $request)
    {

      DB::table('employee_documents')->where("id",$request->image_id)->where("employee_id",$request->docs_id)->delete();
        $empId        = Crypt::encrypt($request->docs_id);
        $url_send=url("employee")."/".$empId."/edit";
        $result=array("docs_id"=>$url_send);
        return response()->json($result);
    }
    public function show($id)
    {

        if(\Auth::user()->can('Show Employee'))
        {
            $empId        = Crypt::decrypt($id);
            $documents    = Document::get();

            $employee     = Employee::find($empId);
            $branches     = Branch::get()->pluck('name', 'id');
            $departments  = Department::get()->pluck('name', 'id');
            $designations = Designation::where("id",$employee->designation_id)->first()->pluck('name');
            $employeesId  = \Auth::user()->employeeIdFormat($employee->employee_id);
            $employee_personal_info= DB::table("emp_personal_info")->where("user_id",$employee->user_id)->first();
            $employee_primary= DB::table("emp_primary_details")->where("user_id",$employee->user_id)->first();
            $employee_secondry= DB::table("emp_secondry_details")->where("user_id",$employee->user_id)->first();
            $employee_bank= DB::table("emp_bank_info")->where("user_id",$employee->user_id)->first();
            $employee_family= DB::table("emp_family_info")->where("user_id",$employee->user_id)->first();

            $employee_salary= DB::table("emp_slary_info")->where("user_id",$employee->user_id)->first();
            $employee_cpf= DB::table("emp_cpf_info")->where("user_id",$employee->user_id)->first();


            return view('employee.show', compact('employee', 'employeesId', 'branches', 'departments', 'designations', 'documents','employee_personal_info','employee_primary','employee_secondry','employee_bank','employee_family','employee_salary','employee_cpf'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function json(Request $request)
    {
        $designations = Designation::where('department_id', $request->department_id)->get()->pluck('name', 'id')->toArray();
        //$responsbilites = Responsbilites::where('department_id', $request->department_id)->get()->pluck('name', 'id')->toArray();

        return response()->json($designations);
    }


    public function json3(Request $request)
    {
        $report = Teams::where('supervisor_emp_id', $request->designation_id)->get()->pluck('id', 'team_name' )->toArray();
        //$responsbilites = Responsbilites::where('department_id', $request->department_id)->get()->pluck('name', 'id')->toArray();

        return response()->json($report);
    }


    public function json4(Request $request)
    {
        $report = Teams::where('supervisor_emp_id', $request->designation_id)->get()->pluck('id', 'team_name' )->toArray();
        //$responsbilites = Responsbilites::where('department_id', $request->department_id)->get()->pluck('name', 'id')->toArray();

        return response()->json($report);
    }

    public function json6(Request $request)
    {
          $departments      = Department::where('branch_id', $request->branch_id)->where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        //$responsbilites = Responsbilites::where('department_id', $request->department_id)->get()->pluck('name', 'id')->toArray();

        return response()->json($departments);
    }

    public function json7(Request $request)
    {
          $departments      = DeductionOption::where('id', $request->deduction_id)->where('created_by', \Auth::user()->creatorId())->get()->pluck('deduct_amt', 'id');
        //$responsbilites = Responsbilites::where('department_id', $request->department_id)->get()->pluck('name', 'id')->toArray();

        return response()->json($departments);
    }


    public function json2(Request $request)
    {
        $report = Designation::where('department_id', $request->department_id)->get()->pluck('name', 'id')->toArray();
        //$responsbilites = Responsbilites::where('department_id', $request->department_id)->get()->pluck('name', 'id')->toArray();

        return response()->json($report);
    }

    public function json1(Request $request)
    {
        $jbr = Jbr::where('designation_id', $request->department_id)->get()->pluck('res_name', 'id')->toArray();
        //$responsbilites = Responsbilites::where('department_id', $request->department_id)->get()->pluck('name', 'id')->toArray();

        return response()->json($jbr);
    }


    public function json_role(Request $request)
    {
        $employee=Employee::where("id",$request->role_emp_id)->first();
        $get_user_role=$get_user_role1=array();
        $get_user_role=User::where("id",$employee->user_id)->first();
        $get_user_role1 = $get_user_role->roles->pluck('name')->all();
        $roles = Role::all();
        $html='';

        if($roles){
                    foreach($roles as $role)
                    {
                        if (in_array($role->name, $get_user_role1))
                        {
                        $html.='<div class="col-lg-4 col-md-4 col-sm-6"><div class="form-group"><input type="checkbox" class="mr-1 get_skills" value="'.$role->name.'" name="role_name[]" checked="checked"><label for="">'.$role->name.'</label></div></div>';
                        }
                        else
                        {
                            $html.='<div class="col-lg-4 col-md-4 col-sm-6"><div class="form-group"><input type="checkbox" class="mr-1 get_skills" value="'.$role->name.'" name="role_name[]" ><label for="">'.$role->name.'</label></div></div>';
                        }
                }

            }

            $result=array("html"=>$html);
        return response()->json($result);
    }


    public function store_role(Request $request)
    {
      $employee=Employee::where("id",$request->employee_role_id)->first();

      $user=User::find($employee->user_id);
      $user->syncRoles($request->role_name);
      $user->save();
      return redirect()->route('employee.index')->with('success', 'Role assigned successfully.');
    }



    public function json_salry(Request $request)
    {


        $get_all_paygrade = EmpPaygrades::where('grade_type',$request->salary_type)->get();
        $html='';
        if(!empty($get_all_paygrade))
        {
            $html='<option value="">Select Pay Grade</option>';
            foreach($get_all_paygrade as $row)
            {
                $html.='<option value="'.$row->id.'">'.$row->grade_name.'</option>';
            }
        }
        $result=array("html"=>$html);
        return response()->json($result);
    }

    public function json_salry_amount(Request $request)
    {
        $get_all_paygrade = EmpPaygrades::where('id',$request->pay_grade)->first();

        $result=array("gross_salary"=>$get_all_paygrade->gross_salary);
        return response()->json($result);
    }
    function employeeNumber()
    {
        $latest = Employee::where('created_by', '=', \Auth::user()->creatorId())->latest()->first();
        if(!$latest)
        {
            return 1;
        }

        return $latest->employee_id + 1;
    }

    public function profile(Request $request)
    {
        if(\Auth::user()->can('Manage Employee Profile'))
        {
            $employees = Employee::where('created_by', \Auth::user()->creatorId());
            if(!empty($request->branch))
            {
                $employees->where('branch_id', $request->branch);
            }
            if(!empty($request->department))
            {
                $employees->where('department_id', $request->department);
            }
            if(!empty($request->designation))
            {
                $employees->where('designation_id', $request->designation);
            }
            $employees = $employees->get();

            $brances = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $brances->prepend('All', '');

            $departments = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $departments->prepend('All', '');

            $designations = Designation::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $designations->prepend('All', '');

            return view('employee.profile', compact('employees', 'departments', 'designations', 'brances'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function profileShow($id)
    {
        if(\Auth::user()->can('Show Employee Profile'))
        {
            $empId        = Crypt::decrypt($id);
            $documents    = Document::where('created_by', \Auth::user()->creatorId())->get();
            $branches     = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $departments  = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $designations = Designation::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $employee     = Employee::find($empId);
            $employeesId  = \Auth::user()->employeeIdFormat($employee->employee_id);

            return view('employee.show', compact('employee', 'employeesId', 'branches', 'departments', 'designations', 'documents'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function employee_ket($id)
    {
        $employee=Employee::where("id",$id)->first();
        $employee_salary=DB::table("emp_slary_info")->where("user_id",$employee->user_id)->first();
        $employee_deduction=DB::table("emp_deduction_amount")->where("employee_id",$employee->id)->get();
        $global_leave=DB::table("leave_types")->get();
        $designations = Designation::where("id",$employee->designation_id)->first();
        $res = DB::table("jbrs")->where("id",$employee->respo_name)->first();
        $payslip=DB::table("pay_slips")->where("employee_id",$employee->id)->first();

        return view('employee.ket',compact('employee','designations','payslip','res','employee_salary','employee_deduction','global_leave'));
    }
    public function lastLogin()
    {
        $users = User::where('created_by', \Auth::user()->creatorId())->get();

        return view('employee.lastLogin', compact('users'));
    }

    public function employeeJson(Request $request)
    {
        $employees = Employee::where('branch_id', $request->branch)->get()->pluck('name', 'id')->toArray();

        return response()->json($employees);
    }


    public function manage_leave($id)
    {

        $id = Crypt::decrypt($id);
        if(\Auth::user()->can('Manage Leave Employee'))
        {


//dd($employee_qalification1);
            return view('employee.manage_leave', compact('employee', 'employeesId', 'branches', 'departments', 'designations', 'documents','employee_personal','employee_primary','employee_secondry','employee_family','employee_experience','employee_bank','employee_slary','employee_cpf','employee_qalification1','employee_license1','employee_it1','employee_certificates1','employee_skills1','extra_text'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function set_salary_date(Request $request)
    {


        if(!empty($request->set_salry_d))
        {
            $created_date_time=date("Y-m-d h:i:s");
            $inputqua=array('from_d' => $request->from_d,
            'to_d' => $request->to_d);
            DB::table('emp_set_date')->where("id",$request->set_salry_d)->update($inputqua);
        }
        else
        {
            $created_date_time=date("Y-m-d h:i:s");
            $inputqua=array('from_d' => $request->from_d,
            'to_d' => $request->to_d,
             'created_at' => $created_date_time);
            DB::table('emp_set_date')->insert($inputqua);

        }
     return redirect()->route('employee.index')->with('success', 'Date successfully added.');
    }
    public function show_salary_date($id)
    {
        $get_employee_salary_date=DB::table('emp_set_date_custom')->where("employee_id",$id)->first();
        return view('employee.employee_salary',compact('get_employee_salary_date'));
    }
    public function set_salary_date_emp(Request $request)
    {
     //dd($request);

        if(!empty($request->emp_c_d))
        {
            $created_date_time=date("Y-m-d h:i:s");
            $inputqua=array('from_d' => $request->emp_from_d,
            'to_d' => $request->emp_to_d);
            DB::table('emp_set_date_custom')->where("id",$request->emp_c_d)->update($inputqua);
        }
        else
        {
            $created_date_time=date("Y-m-d h:i:s");
            $inputqua=array('from_d' => $request->emp_from_d,
            'to_d' => $request->emp_to_d,
            'employee_id' => $request->emp_sal_id,
             'created_at' => $created_date_time);
            DB::table('emp_set_date_custom')->insert($inputqua);

        }
     return redirect()->route('employee.index')->with('success', 'Date successfully added.');
    }


    public function emp_deduction_json(Request $request)
    {
        $deductions       = DeductionOption::where("id",$request->deduction_id)->first();
        $result=array("deductions"=>$deductions);
        return response()->json($result);
    }


    public function ket()
    {
        return view('employee.ket');

    }
}
