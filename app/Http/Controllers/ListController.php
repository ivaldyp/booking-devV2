<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Bidang;
use App\Booking;
use App\Booking_Status;
use App\Room;
use App\Surat;
use App\Time;
use App\User;
use App\Http\Controllers\Controller;

class ListController extends Controller
{
    public function getBidang(Request $request)
    {
        if (!(is_null($request->monthnow))) {
            $monthnow = $request->monthnow;
        } else {
            $monthnow = date('m');
        }

        $montharray = ['Jan', 'Feb', 'Mar', 
                        'Apr', 'Mei', 'Jun',
                        'Jul', 'Agu', 'Sep',
                        'Okt', 'Nov', 'Des'];

        if (!(is_null($request->bidang_peminjam))) {
            $id_bidang = $request->bidang_peminjam;
        } else {
            if (is_null(Session::get('user_data')->user_bidang)) {
                $id_bidang = 1;
            } else {
                $id_bidang = Session::get('user_data')->user_bidang;
            }
        }
        $bidangs = Bidang::get();
        $listbidang = Booking::with('status')
                        ->with('surat')
                        ->with('bidang')
                        ->with('room')
                        ->with('time1')
                        ->with('time2')
                        ->where('booking_status', 3)
                        ->where('bidang_peminjam', $id_bidang)
                        ->whereMonth('booking_date', $monthnow)
                        ->orderBy('booking_date', 'desc')
                        ->orderBy('time_start', 'asc')
                        ->orderBy('time_end', 'asc')
                        ->get();
        return view('pages.lists.bidang')
                ->with('listbidang', $listbidang)
                ->with('bidangs', $bidangs)
                ->with('id_bidang', $id_bidang)
                ->with('monthnow', $monthnow)
                ->with('montharray', $montharray);
    }

    public function getRuang()
    {
        //
    }

    public function changeBidang(Request $request)
    {
        $id_bidang = $request->bidang_peminjam;
        $bidangs = Bidang::get();
        $listbidang = Booking::with('status')
                        ->with('surat')
                        ->with('bidang')
                        ->with('room')
                        ->with('time1')
                        ->with('time2')
                        ->where('booking_status', 3)
                        ->where('bidang_peminjam', $id_bidang)
                        ->orderBy('booking_date', 'desc')
                        ->orderBy('time_start', 'asc')
                        ->orderBy('time_end', 'asc')
                        ->get();
        return view('pages.lists.bidang')->with('listbidang', $listbidang)->with('bidangs', $bidangs);
    }

    public function changeRuang()
    {
        //
    }
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
        //
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
