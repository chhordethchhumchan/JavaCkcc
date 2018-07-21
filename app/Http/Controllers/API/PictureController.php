<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\User;
use App\Picture;
use Carbon\Carbon;
use App\Ad;

class PictureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        // $user_id = Auth::user()->id; 
        // $user = User::findOrFail($user_id);

        $user = User::all();
        $pictures = $user->pictures;
       
        $ads = Ad::all();

        $data = [];
        $i = 0;

        //return $ads; die();
        foreach ($pictures->chunk(3) as $chunks) {

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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        if ($validator->fails()) {
            return response()->json(['error_code'=> 1,'message'=>$validator->errors()], 401);   
        } 
        $user = Auth::user();
        $picture = new Picture();
        $picture->user_id = $user->id;
        $picture->title = $request->title;
        $picture->description = $request->description;
        $picture->type = "picture";

        if($request->hasFile('image')) {
            $file = $request->image;
            $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
            $filename = $timestamp. '-' .$file->getClientOriginalName();
            $file->move(public_path('/picture'), $filename);
            $picture->image = "picture/".$filename;

        }
        if($picture->save()){
            return response()->json($picture,201);
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
        //
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
