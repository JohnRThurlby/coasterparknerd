<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Str;

use App\Parks;

use Session;

class ParksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

          return view('admin.parks.index')->with('parks', Parks::all());

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          
        return view('admin.parks.create')->with('parks', Parks::all());

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      /*  $this->validate($request, [
          'title' =>  'required',
          'featured' => 'required|image',
          'content' => 'required',
          'category_id' => 'required',

        ]);

        $parks = Parks::create([

          'title' =>  $request->title,
          'featured' => 'uploads/posts/' . $featured_new_name,
          'content' => $request->content,
          'category_id' => $request->category_id,
          'slug' => Str::slug($request->title)

        ]);

        Session::flash('success', 'Post created successfully');

        return redirect()->route('posts');*/
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
       
      $park = Parks::find($id);

      return view('admin.parks.edit')->with( 'park', $park );

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

        $this->validate($request, [

        'parkname'     =>  'required',
        'parkphone'    => 'required',
        'parkaddress1' => 'required',
        'parkcity'     => 'required',
        'parkstate'    => 'required',
        'parkzip'      => 'required',
        'parkurl'      => 'required',
        'parklat'      => 'required',
        'parklon'      => 'required',
        'parkpic'      => 'required',
        'countryid' => 'required'

      ]);

        $park               = Parks::find($id);

        $park->parkname     = $request->parkname;

        $park->parkphone    = $request->parkphone;

        $park->parkaddress1 = $request->parkaddress1;

        $park->parkcity     = $request->parkcity;
          
        $park->parkstate    = $request->parkstate;

        $park->parkzip      = $request->parkzip;

        $park->parkwikilink = $request->parkwikilink;

        $park->parkurl      = $request->parkurl;

        $park->parklat      = $request->parklat;

        $park->parklon      = $request->parklon;

        $park->parkpic      = $request->parkpic;

        $park->countryid    = $request->countryid;

        


        $park->save();

        Session::flash('success', 'Park successfully updated.');

        return redirect()->route('parks');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $park = Parks::find($id);

      $park->delete();

      Session::flash('success', 'Park successfully deleted.');

      return redirect()->route('parks');

    }
    
}
