<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection ;
use App\User ;
use App\Http\Resources\User as UserResource ;
use App\Http\Resources\Artist as ArtistResource ;
use App\Http\Resources\Category as CategoryResource ;
use Illuminate\Http\Request;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     //
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $uid = $request->input('uid', '' );
        $name = $request->input('displayName' , '');
        $user = User::where('uid','=' , $uid )->first();

        if( is_null($user) ){
          //Have not Registered yet , then Register User
          $user = new User ;
          $user->uid = $uid ;
          $user->name = $name ;

          $user->save() ;
        }

        return new UserResource( $user );
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $uid
     * @return \Illuminate\Http\Response
     */
    public function show($uid)
    {
        $user = User::where('uid' , '=' , $uid )->first();
        return ArtistResource::collection( $user->artists );
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $uid
     * @return \Illuminate\Http\Response
     */
    public function showCategories($uid){
      $user = User::where('uid' , '=' , $uid )->first();
      $collection = collect([]);

      foreach( $user->songs as $song ){
          $collection = $collection->merge( $song->categories ) ;
      }
      // dd($collection);
      return CategoryResource::collection( $collection );
      // dd( $user->songs()->with('categories')->get()->toArray() );
      // $res = $user->songs()->with(['categories'=> function($query){
      //   return $query->select('name');
      // }])->get();
      // dd($res);
      // foreach( $user->songs()->with('categories')->get()->toArray() as $array ){
      //   // dd($array["categories"]);
      //   dd( $array );
      // }
      // foreach( $user->songs as $song ){
      //   foreach( $song->categories as $category ){
      //
      //   }
      // }

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
    // public function destroy($id)
    // {
    //     //
    // }
}
