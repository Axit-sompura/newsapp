<?php

namespace App\Http\Controllers;

use App\Models\sites;
use Illuminate\Http\Request;
use Datatables;
use GuzzleHttp;
use mysql_xdevapi\Exception;

class SitesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (request()->ajax()) {
            $que = sites::select('*');
            return datatables()->of($que)
                ->addColumn('action', function ($que) {
                    $id = $que->id;
                    return "<a href='javascript:void(0);' id='delete' onClick='deleteFunc($id)' data-toggle='tooltip' data-original-title='Delete' class='delete btn btn-danger'><i class='fa fa-trash' aria-hidden='true'></i></a>";
                })
                ->editColumn('status', function ($que) {
                    if ($que->status == 1) {
                        $status = '<span class="badge badge-primary">Yes</span>';
                    } else {
                        $status = '<span class="badge badge-warning">No</span>';
                    }
                    return $status;
                })
                ->editColumn('created_at', function ($que) {
                    return Date($que->created_at);
                })
                ->editColumn('domain', function ($que) {
                    return substr($que->domain,0,60);
                })
                ->rawColumns(['action', 'status', 'created_at','domain'])
                ->escapeColumns(['status','action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('sites.index');
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->id;

        $sites = sites::Create(
            [
                'domain' => $request->domain,
                'status' => 0
            ]);

        return Response()->json($sites);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\sites $sites
     * @return \Illuminate\Http\Response
     */
    public function show(sites $sites)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\sites $sites
     * @return \Illuminate\Http\Response
     */
    public function edit(sites $sites, Request $request)
    {
        $where = array('id' => $request->id);
        $sites = sites::where($where)->first();

        return Response()->json($sites);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\sites $sites
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, sites $sites)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\sites $sites
     * @return \Illuminate\Http\Response
     */
    public function destroy(sites $sites, Request $request)
    {
        $data = sites::where('id', $request->id)->delete();

        return Response()->json($data);
    }
}
