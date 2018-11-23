<?php

namespace App\Http\Controllers;

use App\Http\Resources\Category as CategoryResource ;

use Illuminate\Support\Collection ;
use App\Category;
use App\Song ;
use App\Http\Resources\Song as SongResource ;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $song_id = $request->input('song_id' , '');
        $name = $request->input('name','');

        $category = new Category() ;
        $category->song_id = $song_id ;
        $category->name = $name ;

        $category->save();

        $song = $category->song ;
        return CategoryResource::collection( $song->categories );
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $song = Song::find( $id );

        return CategoryResource::collection( $song->categories );
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function showSongsHaveCategory($id){
      $collection = collect([]);

      $category = Category::find($id);
      $target_tag_name = $category->name ;
      $user = $category->song->artist->user ;
      $songs = $user->songs ;
      // dd($songs);
      foreach( $songs as $song ){
        foreach( $song->categories as $category ){
          if($category->name == $target_tag_name ){
            $collection = $collection->merge( $song );
          }
        }
      }
      // dd( $collection );
      // $songs = $songs()->whereHas('categories' , function($query){
      //   $query->where('name' ,'=' ,  $target_tag_name );
      // })->get();
      // dd( $user->songs()->whereHas('categories' , function($query) use ($target_tag_name){
      //   $query->where('name' , '=' , $target_tag_name );
      // })->get() );
      // Song::
      $songs = $user->songs()->whereHas('categories' , function($query) use ($target_tag_name){
        $query->where('name' , '=' , $target_tag_name );
      })->get() ;
      return SongResource::collection( $songs );

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
      $category = Category::find( $id );
      $song = $category->song ;

      $category->delete();
      return CategoryResource::collection( $song->categories );
    }
}
