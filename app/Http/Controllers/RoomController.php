<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Bidang;
use App\Room;
use App\Room_type;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data['rooms'] = 
        //         DB::select('SELECT r.*, b.id_bidang, b.bidang_name, rt.id_roomType, rt.roomType_name
        //                     FROM rooms r
        //                     INNER JOIN bidangs b ON b.id_bidang = r.room_owner
        //                     INNER JOIN room_types rt ON rt.id_roomType = r.room_type
        //                     ORDER BY b.id_bidang ASC, r.room_name ASC ');

        // $data['bidangs'] = 
        //         DB::select('SELECT id_bidang, bidang_name
        //                     FROM bidangs');

        // $data['room_types'] = 
        //         DB::select('SELECT id_roomType, roomType_name
        //                     FROM room_types');    

        $rooms = Room::
                        // leftJoin('bidangs as b', 'b.id_bidang', '=', 'rooms.room_owner')
                        with('bidang')
                        ->with('roomtype')
                        // ->orderBy('b.id_bidang', 'asc')
                        ->orderBy('room_name', 'asc')
                        ->get();

        $bidangs = Bidang::join('subbidangs', 'subbidangs.id_bidang', '=', 'bidangs.id_bidang')->get();

        $room_types = Room_type::get();
        
        return view('pages.rooms.table')->with('rooms', $rooms)->with('bidangs', $bidangs)->with('room_types', $room_types);    
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
        $room = new Room;
        $room->id_room = $request->id_room;
        $room->room_name = $request->room_name;

        $room_ids = explode("||", $request->room_owner);
        $room->room_owner = $room_ids[0];
        $room->room_subowner = $room_ids[1];

        $room->room_type = $request->room_type;
        $room->room_floor = $request->room_floor;
        $room->room_capacity = $request->room_capacity;

        $room->save();

        return redirect('/ruang')->with('message', 'Data Ruang berhasil ditambah');
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
    public function update(Request $request)
    {
        // DB::update("UPDATE rooms 
        //             SET room_name = '$request->room_name',
        //                 room_owner = '$request->room_owner',
        //                 room_type = '$request->room_type',
        //                 room_floor = '$request->room_floor',
        //                 room_capacity = '$request->room_capacity' 
        //             WHERE id_room = '$request->id_room' ");

        $room = Room::find($request->id_room);
        $room->room_name = $request->room_name;
        $room->room_owner = $request->room_owner;
        $room->room_type = $request->room_type;
        $room->room_floor = $request->room_floor;
        $room->room_capacity = $request->room_capacity;
        $room->save();

        return redirect('ruang')->with('message', 'Berhasil melakukan perubahan data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $room = Room::find($id);
        if($room->delete()) {
            return redirect('ruang')->with('message', 'Data berhasil dihapus');
        } else {
            return redirect('ruang')->with('message', 'Data gagal dihapus');
        }
    }
}
