<?php

namespace App\Http\Controllers;

use App\Http\Resources\Song as SongResource ;
use App\Http\Resources\SongDetail as SongDetailResource ;

use App\Song ;
use App\Artist ;

use Illuminate\Http\Request;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     return SongResource::collection( Song::all());
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $song = new Song() ;
      $song->artist_id = $request->input('artist_id' , 0);
      $song->name = $request->input('title' ,'' );

      $song->save();
    }

    /**
     * Store a newly created YoutubeURL about song in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateURL(Request $request)
    {
      $baseURL = 'https://www.youtube.com/embed/' ;

      $id = $request->input('id','');
      $song = Song::find($id);

      $url = $request->input('youtubeURL' , '');
      $arr = explode('v=' , $url);
      $youtubeID = $arr[1] ;
      $embedURL = $baseURL . $youtubeID ;

      $song->URL = $embedURL ;
      $song->save() ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $song = Song::find( $id );
      return SongDetailResource::collection( $song->Details->sortByDesc('created_at') );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showURL($id)
    {
      $song = Song::find( $id );

      if(is_null($song->URL)){
        return null ;
      }else{
        return $song->URL ;
      }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $song = Song::find( $id ) ;

        $song->delete() ;
    }
}
