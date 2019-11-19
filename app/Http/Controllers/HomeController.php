<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Bidang;
use App\Booking;
use App\Room;
use App\Subbidang;
use App\Surat;
use App\Time;
use App\User_Type;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [];
        if (Auth::check()) {
            $user_status = $this->user->user_status;
            // $data['user_status'] = 
            //     json_encode(DB::select('SELECT *
            //                 FROM user_types
            //                 where id_userType = '.$user_status));

            $data['user_status'] = User_Type::where('id_userType', $user_status);
            Session::put('user_status', $user_status);
            $data_user = User::where('id_user',$this->user->id_user)
                            ->leftjoin('subbidangs', 'subbidangs.id_subbidang', '=', 'users.user_subbidang')
                            ->leftjoin('bidangs', 'bidangs.id_bidang', '=', 'subbidangs.id_bidang')
                            ->get();
            Session::put('user_data', $data_user[0]);
        }
        
        return view('home', $data);
    }

    public function index2()
    {

        $data = [];
        if (Auth::check()) {
            $user_status = $this->user->user_status;
            // $data['user_status'] = 
            //     json_encode(DB::select('SELECT *
            //                 FROM user_types
            //                 where id_userType = '.$user_status));

            $data['user_status'] = User_Type::where('id_userType', $user_status);
            Session::put('user_status', $user_status);
            $data_user = User::where('id_user',$this->user->id_user)
                            ->leftjoin('subbidangs', 'subbidangs.id_subbidang', '=', 'users.user_subbidang')
                            ->leftjoin('bidangs', 'bidangs.id_bidang', '=', 'subbidangs.id_bidang')
                            ->get();
            Session::put('user_data', $data_user[0]);
        }
        return view('home2', $data);
    }

    public function index3(Request $request)
    {
        $data = [];
        if (Auth::check()) {
            $user_status = $this->user->user_status;
            // $data['user_status'] = 
            //     json_encode(DB::select('SELECT *
            //                 FROM user_types
            //                 where id_userType = '.$user_status));

            $data['user_status'] = User_Type::where('id_userType', $user_status);
            Session::put('user_status', $user_status);
            $data_user = User::where('id_user',$this->user->id_user)
                            ->leftjoin('subbidangs', 'subbidangs.id_subbidang', '=', 'users.user_subbidang')
                            ->leftjoin('bidangs', 'bidangs.id_bidang', '=', 'subbidangs.id_bidang')
                            ->get();
            Session::put('user_data', $data_user[0]);
        }
        $bidangs = Bidang::get();
        if (is_null($request->id_bidang)) {
            $id_bidang = 1;
        } else {
            $id_bidang = $request->id_bidang;
        }

        $times = Time::get();

        $rooms = Room::
                    where('room_owner', $id_bidang)
                    ->orderBy('id_room', 'ASC')
                    ->get();

        $datenow = date('Y-m-d');

        $bookings = Booking::
                    where('booking_date', $datenow)
                    ->where('booking_status', 3)
                    ->where('booking_room_owner', $id_bidang)
                    ->orderBy('time_start', 'ASC')
                    ->orderBy('booking_room', 'ASC')
                    ->get();
        // var_dump(count($bookings));
        // die();   
        return view('home3', $data)
                ->with('times', $times)
                ->with('rooms', $rooms)
                ->with('bookings', $bookings)
                ->with('bidangs', $bidangs)
                ->with('id_bidang', $id_bidang);
    }

    public function index4(Request $request)
    {
        $data = [];
        if (Auth::check()) {
            $user_status = $this->user->user_status;
            // $data['user_status'] = 
            //     json_encode(DB::select('SELECT *
            //                 FROM user_types
            //                 where id_userType = '.$user_status));

            $data['user_status'] = User_Type::where('id_userType', $user_status);
            Session::put('user_status', $user_status);
            $data_user = User::where('id_user',$this->user->id_user)
                            ->leftjoin('subbidangs', 'subbidangs.id_subbidang', '=', 'users.user_subbidang')
                            ->leftjoin('bidangs', 'bidangs.id_bidang', '=', 'subbidangs.id_bidang')
                            ->get();
            Session::put('user_data', $data_user[0]);
        }
        $bidangs = Bidang::get();
        if (is_null($request->id_bidang)) {
            $id_bidang = 1;
        } else {
            $id_bidang = $request->id_bidang;
        }

        $times = Time::get();

        $rooms = Room::
                    where('room_owner', $id_bidang)
                    ->orderBy('id_room', 'ASC')
                    ->get();

        $datenow = date('Y-m-d');

        $bookings = Booking::
                    where('booking_date', $datenow)
                    ->where('booking_status', 3)
                    ->where('booking_room_owner', $id_bidang)
                    ->orderBy('booking_room', 'ASC')
                    ->orderBy('time_start', 'ASC')
                    ->get();
        // var_dump($times[21]);
        // die();   
        return view('home4', $data)
                ->with('times', $times)
                ->with('rooms', $rooms)
                ->with('bookings', $bookings)
                ->with('bidangs', $bidangs)
                ->with('id_bidang', $id_bidang);
    }

    public function index5(Request $request)
    {
        $data = [];
        if (Auth::check()) {
            $user_status = $this->user->user_status;
            // $data['user_status'] = 
            //     json_encode(DB::select('SELECT *
            //                 FROM user_types
            //                 where id_userType = '.$user_status));

            $data['user_status'] = User_Type::where('id_userType', $user_status);
            Session::put('user_status', $user_status);
            $data_user = User::where('id_user',$this->user->id_user)
                            ->leftjoin('subbidangs', 'subbidangs.id_subbidang', '=', 'users.user_subbidang')
                            ->leftjoin('bidangs', 'bidangs.id_bidang', '=', 'subbidangs.id_bidang')
                            ->get();
            Session::put('user_data', $data_user[0]);
        }

        $bidangs = Bidang::get();

        $times = Time::get();

        $rooms = Room::
                    orderBy('room_owner', 'ASC')
                    ->orderBy('id_room', 'ASC')
                    ->get();

        $datenow = date('Y-m-d');

        $bookings = Booking::
                    where('booking_date', $datenow)
                    ->where('booking_status', 3)
                    ->orderBy('booking_room_owner', 'ASC')
                    ->orderBy('booking_room', 'ASC')
                    ->orderBy('time_start', 'ASC')
                    ->get();
        // echo "<pre>";
        // var_dump($bookings);
        // die();   
        return view('home5', $data)
                ->with('bidangs', $bidangs)
                ->with('times', $times)
                ->with('rooms', $rooms)
                ->with('bookings', $bookings);
    }


    public function read()
    {
        // $data['bookings'] = 
        //     DB::select("SELECT b.id_booking, s.id_surat, s.surat_judul, s.surat_deskripsi, b.booking_date, TO_CHAR(b.booking_date, 'dd-mm-yyyy') as booking_date2, r.room_name,
        //     t1.id_time, TO_CHAR(t1.time_name, 'HH24:MI') as time_start, TO_CHAR(t2.time_name, 'HH24:MI') as time_end
        //     FROM public.bookings b
        //     INNER JOIN surats s ON s.id_surat = b.id_surat
        //     INNER JOIN times t1 ON t1.id_time = b.time_start
        //     INNER JOIN times t2 ON t2.id_time = b.time_end
        //     INNER JOIN rooms r ON r.id_room = b.booking_room
        //     WHERE b.soft_delete = false
        //     AND b.booking_status = 3");
        // return $data;

        // $data['bookings'] = 
        //     DB::select('SELECT b.id_booking, s.id_surat, s.surat_judul, s.surat_deskripsi, b.booking_date, DATE_FORMAT(b.booking_date, "%d-%m-%Y") as booking_date2, r.room_name,
        //         t1.id_time, DATE_FORMAT(t1.time_name, "%H:%i") as time_start, t2.id_time, DATE_FORMAT(t2.time_name, "%H:%i") as time_end
        //         FROM bookings b
        //         INNER JOIN surats s ON s.id_surat = b.id_surat
        //         INNER JOIN times t1 ON t1.id_time = b.time_start
        //         INNER JOIN times t2 ON t2.id_time = b.time_end
        //         INNER JOIN rooms r ON r.id_room = b.booking_room
        //         WHERE b.soft_delete = 0
        //         AND b.booking_status = 3');
        // return $data;

        $bookings = Booking::with('surat')
                            ->with('time1')
                            ->with('time2')
                            ->with('room')
                            ->where('soft_delete', false)
                            ->where('booking_status', 3)
                            ->get();
        return $bookings;
    }
}
