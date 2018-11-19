<?php

namespace App\Http\Controllers;

//APIリソースを使用
use App\Http\Resources\Karaoke as KaraokeResource ;

use App\Karaoke;
use Illuminate\Http\Request;

class KaraokeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return KaraokeResource::collection(Karaoke::all());
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
        $karaoke = new Karaoke() ;
        $karaoke->user_id = 1 ; //Dummy
        $karaoke->artist = $request->input('artist' , '');
        $karaoke->title = $request->input('title' , '');
        $karaoke->memo = "" ;
        
        $karaoke->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Karaoke  $karaoke
     * @return \Illuminate\Http\Response
     */
    public function show(Karaoke $karaoke)
    {
        //1データ表示
        return new KaraokeResource($karaoke);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Karaoke  $karaoke
     * @return \Illuminate\Http\Response
     */
    public function edit(Karaoke $karaoke)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Karaoke  $karaoke
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Karaoke $karaoke)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Karaoke  $karaoke
     * @return \Illuminate\Http\Response
     */
    public function destroy(Karaoke $karaoke)
    {
        //
    }
}
