<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\User;
use App\Video;
use App\Ad;


class VideoController extends Controller
{

    public $successStatus = 200;
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

        $videos = $user->videos;
       
        $ads = Ad::all();

        $data = [];
        $i = 0;

        //return $ads; die();
        foreach ($videos->chunk(3) as $chunks) {

            $data[] = $ads[$i];
            foreach ($chunks as $item) {
                $data[] = $item;
            }

            $i++;
            if ($i == count($ads)) {
                $i = 0;
            }
        }
  
        return response()->json($data, $this->successStatus);

        // This code for get data with database and add ads to object.


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        return $user->id;
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
            'title'   => 'required',
            'description'   => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error_code'=> 1,'message'=>$validator->errors()], 401);   
        } 

        $user = Auth::user();
        $videos = new Video();
        $videos->user_id = $user->id;
        $videos->video_url = $request->video_url;
        $videos->title = $request->title;
        $videos->description = $request->description;
        $videos->type = "video";

        if ($videos->save()) {
            return response()->json($videos, 201);
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
