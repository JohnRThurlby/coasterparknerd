<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Str;

use App\Parkrides;

use Session;

class RidesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

          return view('admin.rides.index')->with('parkrides', Parkrides::all());

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.rides.create')->with('parkrides', Parkrides::all());

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
      $parkride = Parkrides::find($id);

      return view('admin.rides.edit')->with( 'parkride', $parkride );
      
    }

     /**
     * Updte the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function update(Request $request, $id)
    {

        $this->validate($request, [

        'parkid'       => 'required',
        'ridename'     => 'required',
        'rideduration' => 'required',
        'rideopened'   => 'required',
        'ridespeed'    => 'required',
        'ridelevel'    => 'required',
        'ridelength'   => 'required',
        'ridehgtreq'   => 'required',
        'ridetype'     => 'required',
        'rideurl'      => 'required',
        'ridemanu'     => 'required',
        'parkarea'     => 'required',
        'rideoccup'    => 'required',
        'ridehgt'      => 'required',
        'ridevehtype'  => 'required'

        ]);

        $parkride           = Parkrides::find($id);

        $parkride->parkid       = $request->parkid;
        $parkride->ridename     = $request->ridename;
        $parkride->rideduration = $request->rideduration;
        $parkride->rideopened   = $request->rideopened;
        $parkride->ridespeed    = $request->ridespeed;
        $parkride->ridelevel    = $request->ridelevel;
        $parkride->ridelength   = $request->ridelength;
        $parkride->ridehgtreq   = $request->ridehgtreq;
        $parkride->ridetype     = $request->ridetype;
        $parkride->rideurl      = $request->rideurl;
        $parkride->ridemanu     = $request->ridemanu;
        $parkride->parkarea     = $request->parkarea;
        $parkride->rideoccup    = $request->rideoccup;
        $parkride->ridehgt      = $request->ridehgt;
        $parkride->ridevehtype  = $request->ridevehtype;


        $parkride->save();

        Session::flash('success', 'Ride successfully updated.');

        return redirect()->route('parkrides');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
        'parkid'       => 'required',
        'ridename'     => 'required',
        'rideduration' => 'required',
        'rideopened'   => 'required',
        'ridespeed'    => 'required',
        'ridelevel'    => 'required',
        'ridelength'   => 'required',
        'ridehgtreq'   => 'required',
        'ridetype'     => 'required',
        'rideurl'      => 'required',
        'ridemanu'     => 'required',
        'parkarea'     => 'required',
        'rideoccup'    => 'required',
        'ridehgt'      => 'required',
        'ridevehtype'  => 'required'

        ]);

        $parkride = Parkrides::create([

        'parkid'       => $request->parkid,
        'ridename'     => $request->ridename,
        'rideduration' => $request->rideduration,
        'rideopened'   => $request->rideopened,
        'ridespeed'    => $request->ridespeed,
        'ridelevel'    => $request->ridelevel,
        'ridelength'   => $request->ridelength,
        'ridehgtreq'   => $request->ridehgtreq,
        'ridetype'     => $request->ridetype,
        'rideurl'      => $request->rideurl,
        'ridemanu'     => $request->ridemanu,
        'parkarea'     => $request->parkarea,
        'rideoccup'    => $request->rideoccup,
        'ridehgt'      => $request->ridehgt,
        'ridevehtype'  => $request->ridevehtype
        
        ]);

        Session::flash('success', 'Ride created successfully');

        return redirect()->route('parkrides');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $parkride = Parkrides::find($id);

      $parkride->delete();

      Session::flash('success', 'Ride successfully deleted.');

      return redirect()->route('parkrides');

    }

}
