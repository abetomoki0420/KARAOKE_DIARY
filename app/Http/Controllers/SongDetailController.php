<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\SongDetail as SongDetailResouce ;
use App\Song ;
use App\SongDetail ;

class SongDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     return SongDetailResouce::collection( SongDetail::all() );
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
        $song_id = $request->input('id' , '') ;
        $song = Song::find( $song_id );
        $song_detail = new SongDetail() ;
        $song_detail->artist_id = $song->artist->id ;
        $song_detail->song_id = $song_id ;
        $song_detail->score = $request->input('score', 0 );
        $song_detail->comment = $request->input('comment', '');

        $song_detail->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

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
    public function update(Request $request, $id)
    {
        $score = $request->input('score' , 0 );
        $comment = $request->input('comment', '' );
        $song_detail = SongDetail::find( $id );
        $song_detail->score = $score ;
        $song_detail->comment = $comment ;

        $song_detail->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $song_detail = SongDetail::find( $id ) ;

        $song_detail->delete();
    }
}
