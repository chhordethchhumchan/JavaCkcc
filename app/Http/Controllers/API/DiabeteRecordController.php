<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\User;
use App\Ad;
use App\DiabeteRecord;
use Illuminate\Support\Facades\Auth;

class DiabeteRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id; 
        $user = User::findOrFail($user_id);

        $diabeteRecords = $user->DiabeteRecords;
       
        $ads = Ad::all();

        $data = [];
        $i = 0;

        //return $ads; die();
        foreach ($diabeteRecords->chunk(3) as $chunks) {

            $data[] = $ads[$i];

            foreach ($chunks as $item) {
                $data[] = $item;
            }

            $i++;
            if ($i == count($ads)) {
                $i = 0;
            }
        }

        return response()->json($data, 200);
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
        $validator = Validator::make($request->all(), [
            'blood' => 'required|numeric',
            'date_times' => 'required',
            'ill_type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error_code'=> 1,'message'=>$validator->errors()], 401);   
        } 

        $user = Auth::user();
        $diabeteRecord = new DiabeteRecord();
        $diabeteRecord->user_id = $user->id;
        $diabeteRecord->blood = $request->blood;
        $diabeteRecord->date_times = $request->date_times;
        $diabeteRecord->ill_type = $request->ill_type;
        $diabeteRecord->comment = $request->comment;
        $diabeteRecord->type = "diabeterecord";

        if($diabeteRecord->save()){
            return response()->json($diabeteRecord,201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'blood' => 'required|numeric',
            'date_times' => 'required',
            'ill_type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error_code'=> 1,'message'=>$validator->errors()], 401);   
        } 

        $user = Auth::user();
        $diabeteRecord =  DiabeteRecord::findOrFail($id);
        $diabeteRecord->user_id = $user->id;
        $diabeteRecord->blood = $request->blood;
        $diabeteRecord->date_times = $request->date_times;
        $diabeteRecord->ill_type = $request->ill_type;
        $diabeteRecord->comment = $request->comment;
        $diabeteRecord->type = "diabeterecord";

        if($diabeteRecord->save()){
            return response()->json($diabeteRecord,201);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
