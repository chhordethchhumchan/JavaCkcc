<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Text;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Ad;

class TextController extends Controller
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

        $texts = $user->texts;
       
        $ads = Ad::all();

        $data = [];
        $i = 0;

        //return $ads; die();
        foreach ($texts->chunk(3) as $chunks) {

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
            'url' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error_code'=> 1,'message'=>$validator->errors()], 401);   
        } 
        $user = Auth::user();
        $text = new Text();
        $text->user_id = $user->id;
        $text->title = $request->title;
        $text->description = $request->description;
        $text->url = $request->url;
        $text->type = "text";

        if($request->hasFile('image')) {
            $file = $request->image;
            $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
            $filename = $timestamp. '-' .$file->getClientOriginalName();
            $file->move(public_path('/text'), $filename);
            $text->image = "text/".$filename;

        }
        if($text->save()){

            return response()->json(['success'=>$text], $this->successStatus);

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
        
    }
}
