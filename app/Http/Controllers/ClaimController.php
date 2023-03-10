<?php

namespace App\Http\Controllers;

use App\Commission;
use App\Employee;
use App\Claim;
use App\ClaimsItems;
use Illuminate\Http\Request;
use DB;
use Closure;
use Illuminate\Support\Facades\Log;



class ClaimController extends Controller
{



    public function index()
    {
        $usr = \Auth::user();
        if($usr->can('Claim'))
        {

            $get_claim=Claim::all();
            return view('claim.index',compact('get_claim'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function show()
    {
    }

    public function create()
    {



        if(\Auth::user()->can('Create Claim'))
        {
            $employees  = Employee::where('created_by', '=', \Auth::user()->creatorId())->get();
            $claim_status_values = Claim::claim_status_values();
            $claim_tax_values = Claim::claim_tax_values();
            $claim_tax_pcent = Claim::claim_tax_pcent();
//var_dump($employees);
            $claim_id = Claim::claim_id();
            $displaytype = 'create';



// unique check to remove




            return view('claim.create', compact('displaytype','employees','claim_id','claim_status_values','claim_tax_values','claim_tax_pcent'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }



    public function edit($id)
    {

        $claim = Claim::find($id);
        if(\Auth::user()->can('Claim'))
        {
            if($claim->created_by == \Auth::user()->creatorId())
            {
                $employees  = Employee::where('created_by', '=', \Auth::user()->creatorId())->get();
                $claim_status_values = Claim::claim_status_values();
                $claim_tax_values = Claim::claim_tax_values();
                $claim_tax_pcent = Claim::claim_tax_pcent();

                $claim_id = $claim->id;
                $displaytype = 'edit';
                $claim_docs = explode("#",$claim->documents);
                $claim_items = ClaimsItems::where('claim_id', '=', $id)->get();

//var_dump($claim_items);
                return view('claim.create', compact('claim_docs','displaytype','employees','claim_id','claim_status_values','claim_tax_values','claim_tax_pcent','claim','claim_items'));

                //return view('claim.edit', compact('claim','employees'));
                //return view('claim.edit', compact('claim','employees'));
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







    public function delete_clt_docs(Request $request)
    {

      DB::table('claims_items')->where("id",$request->image_id)->update(['documents' => '']);
        //$claimId        = Crypt::encrypt($request->claim_id);
        $claimId        = $request->claim_id;
        $url_send=url("claim")."/".$claimId."/edit";
        $result=array("image_id"=>$url_send);
        return response()->json($result);
    }





public function delete_clm_docs(Request $request)
{
  try {
    //$claimId        = Crypt::encrypt($request->claim_id);
    $claim = Claim::find($request->claim_id);
    $claim_docs = explode("#",$claim->documents);
  $new_docs = [];
  for($i=0;$i<count($claim_docs);$i++) {
      if($request->image_id != $claim_docs[$i]) {
        $new_docs[] =$claim_docs[$i];
      }
    }

    $notarrfileNameToStore1 = '';
      if(!empty($new_docs))
      {
          $notarrfileNameToStore1=implode("#", $new_docs);
      }

            DB::table('claims')->where("id",$request->claim_id)->update([
              'documents' => trim($notarrfileNameToStore1,"#"),
            ]);
      $claimId        = $request->claim_id;
    $url_send=url("claim")."/".$claimId."/edit";
    $result=array("image_id"=>$url_send);
    return response()->json($result);
  }

  catch (\Exception $e) {
//var_dump($e);
Log::info(json_encode($e));
  return response()->json(json_encode($e));

}
}



    public function store(Request $request)
    {

        if(\Auth::user()->can('Create Claim'))
        {


            // todo IMPLEMENTATION OF DYNAMIC VALIDATIONS
            // DYNAMICALLY RULES TO BE MADE
            // ASSOCIATE WITH VALIDATOR

            $vrules = [
                               'employee_id' => 'required|unique:claims,employee_id',
                               'title' => 'required',
                               'claimdate' => 'required',
                               'status' => 'required',
                               'remark' => 'required',
                               'documents.0' => 'mimes:png,jpg,jpeg,pdf,docs,xlsx,csv',
                               'documents.1' => 'mimes:png,jpg,jpeg,pdf,docs,xlsx,csv',
                               'documents.2' => 'mimes:png,jpg,jpeg,pdf,docs,xlsx,csv',
                               'documents.3' => 'mimes:png,jpg,jpeg,pdf,docs,xlsx,csv',
                               'documents.4' => 'mimes:png,jpg,jpeg,pdf,docs,xlsx,csv',
                           ];


//item[0][quantity]
            if(isset($request->item))
            foreach($request->item as $key => $itemdetail)
            {

              $vrules['item.'.$key.'.quantity'] = 'required|numeric|gt:0';
              $vrules['item.'.$key.'.item_name'] = 'required';
              $vrules['item.'.$key.'.price'] = 'required|numeric|gt:0';
              $vrules['item.'.$key.'.tax_id'] = 'required';
              $vrules['item.'.$key.'.document'] = 'mimes:png,jpg,jpeg,pdf,docs,xlsx,csv';

            }
            if(!isset($request->item))
            {

            //var_dump($messages);
            //exit();
                return redirect()->back()->with('error', "Please add atleast one row on claim items.");
            }
//var_dump($vrules);

            // messages bag will do later if client said

            $validator = \Validator::make(
                $request->all(), $vrules
            );


            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
//var_dump($messages);
//exit();
                return redirect()->back()->with('error', $messages->first());
            }

//var_dump($request->documents);

            // FILE UPLOADING
            $fileNameToStore1=[];
            $fileNameToStore='';
            if($request->hasFile('documents'))
            {
                $file = $request->file('documents');
                foreach($file as $key => $document)
                     {
                         //dd($document);

                    $filenameWithExt = $request->file('documents')[$key]->getClientOriginalName();
                    $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension       = $request->file('documents')[$key]->getClientOriginalExtension();
                    $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                    $dir             = storage_path('uploads/document/');
                    $image_path      = $dir . $filenameWithExt;
                    $fileNameToStore1[]=$fileNameToStore;
                    $document->move(public_path().'/uploads/document/', $fileNameToStore);
                     }

            }
            $notarrfileNameToStore1 = '';
            if(!empty($fileNameToStore1))
            {
                $notarrfileNameToStore1=implode("#", $fileNameToStore1);
            }

            //Uploading the item file
            $itemfileNameToStore1=[];
            foreach($request->item as $key => $itemdetail)
            {
              $ifileNameToStore = '';
              //print_r($itemdetail['document']);
              if(isset($itemdetail['document']))
              if($itemdetail['document']->isFile())
              {
                //  $file = $itemdetail['document']->file('document');
 //dd($document);

                      $filenameWithExt =  $request->file('item.'.$key.'.document')->getClientOriginalName();
//echo $filenameWithExt;
                      $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                      $extension       = $request->file('item.'.$key.'.document')->getClientOriginalExtension();
                      $ifileNameToStore = $filename . '_' . time() . '.' . $extension;
                      $dir             = storage_path('uploads/document/');
                      $image_path      = $dir . $filenameWithExt;
                      $request->file('item.'.$key.'.document')->move(public_path().'/uploads/document/', $ifileNameToStore);
                }
                $itemfileNameToStore1[] = $ifileNameToStore;


            }

//var_dump($itemfileNameToStore1);

            // Storing in DB if all goes well

                DB::beginTransaction();

                try {

                  // STATIC PART OF THE FORM
                  $claim              = new Claim();
                  $claim->employee_id = $request->employee_id;
                  $claim->claimdate = date('Y-m-d', strtotime($request->claimdate));
                  $claim->title       = $request->title;
                  $claim->amount      = 0;
                  $claim->remark      = $request->remark;
                  $claim->status      = $request->status;
                  $claim->documents   = trim($notarrfileNameToStore1,"#");
                  $claim->created_by  = \Auth::user()->creatorId();
                  $claim->save();

//var_dump($request->item);
//  print_r($itemdetail['item_name']);


                  // DYNAMIC PART LOGIC OF THE FORM
                  if($claim->id) {
                    foreach($request->item as $key => $itemdetail)
                    {
                      $claimitems = new ClaimsItems();
                      $claimitems->claim_id  =  $claim->id;
                      $claimitems->title = $itemdetail['item_name'];
                      $claimitems->qty = $itemdetail['quantity'];
                      $claimitems->price = $itemdetail['price'];
                      $claimitems->tax = $itemdetail['tax_id'];
                      $claimitems->remark = $itemdetail['description'];
                      $claimitems->documents = $itemfileNameToStore1[$key];
                      $claimitems->created_by = \Auth::user()->creatorId();
                      $claimitems->save();
                      unset($claimitems);
                    }
                  }


                  DB::commit();

                } catch (\Exception $e) {
//var_dump($e);
                  Log::info(json_encode($e));
                  DB::rollback();
                  //return redirect()->back()->with('error', 'Error saving - Incorrect data entered.');

                }


//exit();

            return redirect()->route('claim.index')->with('success', 'Claim  successfully created.');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

 //var_dump($request->item);








//var_dump($request);
//json_encode($request->all);
//echo (json_encode($request->all));
//exit();
    }








    public function update(Request $request, Claim $claim)
    {



       // dd($request);
     if(\Auth::user()->can('Claim'))
        {
            if($claim->created_by == \Auth::user()->creatorId())
            {



                          $vrules = [
                                             'title' => 'required',
                                             'claimdate' => 'required',
                                             'status' => 'required',
                                             'remark' => 'required',
                                             'documents.0' => 'mimes:png,jpg,jpeg,pdf,docs,xlsx,csv',
                                             'documents.1' => 'mimes:png,jpg,jpeg,pdf,docs,xlsx,csv',
                                             'documents.2' => 'mimes:png,jpg,jpeg,pdf,docs,xlsx,csv',
                                             'documents.3' => 'mimes:png,jpg,jpeg,pdf,docs,xlsx,csv',
                                             'documents.4' => 'mimes:png,jpg,jpeg,pdf,docs,xlsx,csv',
                                         ];


              //item[0][quantity]
                          if(isset($request->item))
                          foreach($request->item as $key => $itemdetail)
                          {

                            $vrules['item.'.$key.'.quantity'] = 'required|numeric|gt:0';
                            $vrules['item.'.$key.'.item_name'] = 'required';
                            $vrules['item.'.$key.'.price'] = 'required|numeric|gt:0';
                            $vrules['item.'.$key.'.tax_id'] = 'required';
                            $vrules['item.'.$key.'.document'] = 'mimes:png,jpg,jpeg,pdf,docs,xlsx,csv';

                          }

                          if(!isset($request->item))
                          {

                          //var_dump($messages);
                          //exit();
                              return redirect()->back()->with('error', "Please add atleast one row on claim items.");
                          }
              //var_dump($vrules);

                          // messages bag will do later if client said

                          $validator = \Validator::make(
                              $request->all(), $vrules
                          );


                          if($validator->fails())
                          {
                              $messages = $validator->getMessageBag();
              //var_dump($messages);
              //exit();
                              return redirect()->back()->with('error', $messages->first());
                          }

              //var_dump($request->documents);

                          // FILE UPLOADING
                          $fileNameToStore1=[];
                          $fileNameToStore='';
                          if($request->hasFile('documents'))
                          {
                              $file = $request->file('documents');
                              foreach($file as $key => $document)
                                   {
                                       //dd($document);

                                  $filenameWithExt = $request->file('documents')[$key]->getClientOriginalName();
                                  $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                                  $extension       = $request->file('documents')[$key]->getClientOriginalExtension();
                                  $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                                  $dir             = storage_path('uploads/document/');
                                  $image_path      = $dir . $filenameWithExt;
                                  $fileNameToStore1[]=$fileNameToStore;
                                  $document->move(public_path().'/uploads/document/', $fileNameToStore);
                                   }

                          }
                          $notarrfileNameToStore1 = '';
                          if(!empty($fileNameToStore1))
                          {
                              $notarrfileNameToStore1=implode("#", $fileNameToStore1);
                          }

                          //Uploading the item file
                          $itemfileNameToStore1=[];
                          foreach($request->item as $key => $itemdetail)
                          {
                            $ifileNameToStore = '';
                            //print_r($itemdetail['document']);
                            if(isset($itemdetail['document']))
                            if($itemdetail['document']->isFile())
                            {
                              //  $file = $itemdetail['document']->file('document');
               //dd($document);

                                    $filenameWithExt =  $request->file('item.'.$key.'.document')->getClientOriginalName();
              //echo $filenameWithExt;
                                    $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                                    $extension       = $request->file('item.'.$key.'.document')->getClientOriginalExtension();
                                    $ifileNameToStore = $filename . '_' . time() . '.' . $extension;
                                    $dir             = storage_path('uploads/document/');
                                    $image_path      = $dir . $filenameWithExt;
                                    $request->file('item.'.$key.'.document')->move(public_path().'/uploads/document/', $ifileNameToStore);
                              }
                              $itemfileNameToStore1[] = $ifileNameToStore;


                          }

              //var_dump($itemfileNameToStore1);

                          // Storing in DB if all goes well

                              DB::beginTransaction();

                              try {

                                // STATIC PART OF THE FORM

                                $claim->claimdate = date('Y-m-d', strtotime($request->claimdate));
                                $claim->title       = $request->title;
                                $claim->amount      = 0;
                                $claim->remark      = $request->remark;
                                $claim->status      = $request->status;
                                if($request->edit_documents == "") {
                                  $claim->documents   =  trim($notarrfileNameToStore1,"#");  /// this to modify
                                } else {
                                  if($notarrfileNameToStore1 != "") {
                                  $claim->documents   =  $request->edit_documents.'#'.trim($notarrfileNameToStore1,"#");  /// this to modify
                                  }
                                }

                                $claim->created_by  = \Auth::user()->creatorId();
                                $claim->save();

              //var_dump($request->item);
              //  print_r($itemdetail['item_name']);


                                // DYNAMIC PART LOGIC OF THE FORM
                                if($claim->id) {
                                  $tocheckrows = "0";
                                  $y = 0;
//var_dump($request->item);
  //var_dump($itemfileNameToStore1);
                                  foreach($request->item as $key => $itemdetail)
                                  {
                                    if($itemdetail['item_id'] > 0) {
                                      if($itemfileNameToStore1[$y] != "") {
                                        DB::table('claims_items')->where("id",$itemdetail['item_id'])->update([
                                          'title' => $itemdetail['item_name'],
                                          'qty' =>  $itemdetail['quantity'],
                                          'price' =>  $itemdetail['price'],
                                          'tax' => $itemdetail['tax_id'],
                                          'remark' => $itemdetail['description'],
                                          'documents' => $itemfileNameToStore1[$y],
                                          'created_by' => \Auth::user()->creatorId(),
                                        ]);
                                      } else {
                                        DB::table('claims_items')->where("id",$itemdetail['item_id'])->update([
                                          'title' => $itemdetail['item_name'],
                                          'qty' =>  $itemdetail['quantity'],
                                          'price' =>  $itemdetail['price'],
                                          'tax' => $itemdetail['tax_id'],
                                          'remark' => $itemdetail['description'],
                                          'created_by' => \Auth::user()->creatorId(),
                                        ]);
                                      }
                                      $y = $y + 1;
                                      $tocheckrows = $tocheckrows.",".$itemdetail['item_id'];
                                      //'documents',
                                    } else {
                                      $claimitems = new ClaimsItems();
                                      $claimitems->claim_id  =  $claim->id;
                                      $claimitems->title = $itemdetail['item_name'];
                                      $claimitems->qty = $itemdetail['quantity'];
                                      $claimitems->price = $itemdetail['price'];
                                      $claimitems->tax = $itemdetail['tax_id'];
                                      $claimitems->remark = $itemdetail['description'];
                                      $claimitems->documents = $itemfileNameToStore1[$key];
                                      $claimitems->created_by = \Auth::user()->creatorId();
                                      $claimitems->save();
                                      $tocheckrows = $tocheckrows.",".$claimitems->id;
                                      unset($claimitems);
                                    }
                                  }
                                  ClaimsItems::where('claim_id',$claim->id)->whereNotIn('id', explode(',', $tocheckrows))->delete();
                                }


                                DB::commit();

                              } catch (\Exception $e) {
            //  var_dump($e);
                                Log::info(json_encode($e));
                                DB::rollback();
                                return redirect()->back()->with('error', 'Error saving - Incorrect data entered.');

                              }


              //exit();

                          return redirect()->route('claim.index')->with('success', 'Claim  successfully created.');

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

    public function destroy(Claim $claim)
    {

      if(\Auth::user()->can('Claim'))
        {
            if($claim->created_by == \Auth::user()->creatorId())
            {
                ClaimsItems::where('claim_id',$claim->id)->delete();
                $claim->delete();
                // leave them here only for the time + transaction
                return redirect()->back()->with('success', __('Claim successfully deleted.'));
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
