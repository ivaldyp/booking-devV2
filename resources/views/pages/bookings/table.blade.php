@extends('layouts.master')

@section('content')

    <section class="content">
      <div class="row">
        <div class="col-lg-12">
          @if(Session::has('message'))
            <div class="alert alert-danger">{{ Session::get('message') }}</div>
          @endif
        </div>
      </div>
      <!-- <div class="row">
        <div class="col-xs-3">
          <button class="btn btn-success" style="margin-bottom: 10px">Tambah</button>
        </div>
      </div> -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Pinjaman Disetujui</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Acara</th>
                    <th>Deskripsi</th>
                    <th>Peminjam</th>
                    <th>Bidang Peminjam</th>
                    <th>Ruang</th>
                    <th>Jumlah Peserta</th>
                    <th class="col-lg-1">Waktu</th>
                    <th>File Surat</th>
                    <th>Status Booking</th>
                    <!-- <th>Keterangan</th> -->
                    <!-- <th>Tanggal Dibuat</th> -->
                    <?php if(Auth::check() && Auth::user()->user_status != 2) { ?>
                      <th> Aksi </th>
                    <?php } ?>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($bookingdone as $key => $data) { ?>
                  <tr>
                    <input type="hidden" name="id_booking" id="form_book_not_id_booking" value="{{ $data->id_booking }}">
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $data->surat->surat_judul }}</td>
                    <td>{{ $data->surat->surat_deskripsi }}</td>
                    <td>{{ $data->nama_peminjam }}<hr>{{ $data->nip_peminjam }}</td>
                    <td>{{ $data->bidang->bidang_name }}</td>
                    <td>{{ $data->room->room_name }}</td>
                    <td>{{ $data->booking_total_tamu }}</td>

                    <?php 
                      $booking_date2 = DateTime::createFromFormat('Y-m-d', $data->booking_date);
                      $booking_date3 = $booking_date2->format('d-M-Y');
                    ?>
                    <td>{{ $booking_date3 }}<hr>

                    <?php
                      $time1 = explode(":", explode(" ", $data->time1->time_name)[1]);
                      $time2 = explode(":", explode(" ", $data->time2->time_name)[1]);
                    ?>
                    {{ $time1[0] . ":" . $time1[1] }} - {{ $time2[0] . ":" . $time2[1] }}</td>

                    <?php $file_name = explode("~", $data->surat->file_name); ?>
                    <td><a href="{{ url('booking/download') }}/{{ $data->surat->id_surat }}"> {{ $file_name[2] }} </a></td>
                    <td bgcolor="#64de5d">
                      {{ $data->status->status_name }}
                    </td>
                    
                    <!-- <td>{{$data->tanggal_dibuat}}</td> -->
                    <?php if(Auth::check() && Auth::user()->user_status != 2) { ?>
                      <td>
                        <?php if($data->status->  status_id == 2) { ?>
                          -
                        <?php } else { ?>
                          <button type="button" class="btn btn-success btn_booking_not_edit_stat" data-toggle="modal" data-target="#modal-default" id="{{ $data->id_booking }}||{{ $data->keterangan_status }}||{{ $data->booking_date }}||{{ $data->time1->id_time }}||{{ $data->time2->id_time }}||{{ $data->room->booking_room }}||{{ $data->status->status_id }}"><i class="fa fa-edit"></i></button>
                        <?php } ?>
                      </td>
                    <?php } ?>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Pinjaman Belum Disetujui</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Acara</th>
                    <th>Deskripsi</th>
                    <th>Nama Peminjam</th>
                    <th>Bidang Peminjam</th>
                    <th>Ruang</th>
                    <th>Jumlah Peserta</th>
                    <th class="col-lg-1">Waktu</th>
                    <th>File Surat</th>
                    <th>Status Booking</th>
                    <!-- <th>Keterangan</th> -->
                    <!-- <th>Tanggal Dibuat</th> -->
                    <?php if(Auth::check() && Auth::user()->user_status != 2) { ?>
                      <th> Aksi </th>
                    <?php } ?>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($bookingnot as $key => $data) { ?>
                  <tr>
                    <input type="hidden" name="id_booking" id="form_book_not_id_booking" value="{{ $data->id_booking }}">
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $data->surat->surat_judul }}</td>
                    <td>{{ $data->surat->surat_deskripsi }}</td>
                    <td>{{ $data->nama_peminjam }}<hr>{{ $data->nip_peminjam }}</td>
                    <td>{{ $data->bidang->bidang_name }}</td>
                    <td>{{ $data->room->room_name }}</td>
                    <td>{{ $data->booking_total_tamu }}</td>

                    <?php 
                      $booking_date2 = DateTime::createFromFormat('Y-m-d', $data->booking_date);
                      $booking_date3 = $booking_date2->format('d-M-Y');
                      ?>
                      <td>{{ $booking_date3 }}<hr>

                    <?php
                      $time1 = explode(":", explode(" ", $data->time1->time_name)[1]);
                      $time2 = explode(":", explode(" ", $data->time2->time_name)[1]);
                    ?>
                    {{ $time1[0] . ":" . $time1[1] }} - {{ $time2[0] . ":" . $time2[1] }}</td>

                    <?php $file_name = explode("~", $data->surat->file_name); ?>
                    <td><a href="{{ url('booking/download') }}/{{ $data->surat->id_surat }}"> {{ $file_name[2] }} </a></td>
                    <td bgcolor='yellow'>
                      {{ $data->status->status_name }}
                    </td>
                    <!-- <td>
                      <?php if (is_null($data->keterangan_status) || $data->keterangan_status == '') {
                        echo "-";
                      } else {
                        if ($data->booking_status == 2){
                          echo "Buat ulang pinjaman <br><hr>";
                        }
                        echo $data->keterangan_status;
                      }?>
                    </td> -->
                    <!-- <td>{{$data->tanggal_dibuat}}</td> -->
                    <?php if(Auth::check() && Auth::user()->user_status != 2) { ?>
                      <td>
                        <?php if($data->status->status_id == 2) { ?>
                          -
                        <?php } else { ?>
                          <button type="button" class="btn btn-success btn_booking_not_edit_stat" data-toggle="modal" data-target="#modal-default" id="{{ $data->id_booking }}||{{ $data->keterangan_status }}||{{ $data->booking_date }}||{{ $data->time1->id_time }}||{{ $data->time2->id_time }}||{{ $data->booking_room }}||{{ $data->status->status_id }}"><i class="fa fa-edit"></i></button>
                        <?php } ?>
                      </td>
                    <?php } ?>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Pinjaman Tidak Disetujui</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example3" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Acara</th>
                    <th>Deskripsi</th>
                    <th>Nama Peminjam</th>
                    <th>Bidang Peminjam</th>
                    <th>Ruang</th>
                    <th>Jumlah Peserta</th>
                    <th class="col-lg-1">Waktu</th>
                    <th>File Surat</th>
                    <th>Status Booking</th>
                    <th>Keterangan</th>
                    <!-- <th>Tanggal Dibuat</th> -->
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($bookingcancel as $key => $data) { ?>
                  <tr>
                    <input type="hidden" name="id_booking" id="form_book_not_id_booking" value="{{ $data->id_booking }}">
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $data->surat->surat_judul }}</td>
                    <td>{{ $data->surat->surat_deskripsi }}</td>
                    <td>{{ $data->nama_peminjam }}<hr>{{ $data->nip_peminjam }}</td>
                    <td>{{ $data->bidang->bidang_name }}</td>
                    <td>{{ $data->room->room_name }}</td>
                    <td>{{ $data->booking_total_tamu }}</td>
                    
                    <?php 
                      $booking_date2 = DateTime::createFromFormat('Y-m-d', $data->booking_date);
                      $booking_date3 = $booking_date2->format('d-M-Y');
                    ?>
                    <td>{{ $booking_date3 }}<hr>

                    <?php
                      $time1 = explode(":", explode(" ", $data->time1->time_name)[1]);
                      $time2 = explode(":", explode(" ", $data->time2->time_name)[1]);
                    ?>
                    {{ $time1[0] . ":" . $time1[1] }} - {{ $time2[0] . ":" . $time2[1] }}</td>

                    <?php $file_name = explode("~", $data->surat->file_name); ?>
                    <td><a href="{{ url('booking/download') }}/{{ $data->surat->id_surat }}"> {{ $file_name[2] }} </a></td>
                    <td bgcolor="#ff3333"><b>
                      {{ $data->status->status_name }}
                    </b></td>
                    <td>Buat ulang pinjaman
                      <?php if ($data->keterangan_status != 'NULL' && $data->keterangan_status != '') {
                        echo "<br><hr>";
                        echo $data->keterangan_status;
                      } ?>
                    </td>
                    <!-- <td>{{$data->tanggal_dibuat}}</td> -->
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Ubah status booking ruangan</h4>
                </div>
                <form method="POST" action="booking/updateStatus" class="form-horizontal">
                @csrf
                  <div class="modal-body">
                    <input type="hidden" name="id_booking" id="modal_id_booking">
                    <input type="hidden" name="booking_date" id="modal_booking_date">
                    <input type="hidden" name="time_start" id="modal_time_start">
                    <input type="hidden" name="time_end" id="modal_time_end">
                    <input type="hidden" name="booking_room" id="modal_booking_room">
                    <input type="hidden" name="status_id" id="modal_status_id">

                    <div id="book-status-1"></div>
                    <div id="book-status-2"></div>

                    <div class="form-group">
                      <label for="keterangan_status" class="col-lg-2 control-label"> Keterangan </label>
                      <div class="col-lg-8">
                        <textarea class="form-control" id="keterangan_status" name="keterangan_status" rows="3" autocomplete="off"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-success pull-right">Simpan</button>
                    <button type="button" class="btn btn-default pull-right" style="margin-right: 10px" data-dismiss="modal">Close</button>
                  </div>
                </form>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->
        </div>
      </div>
    </section>

@endsection

@section('datatable')

<script>
  $(function () {
    $("#example1").DataTable();
    $("#example2").DataTable();
    $("#example3").DataTable();

    $('.btn_booking_not_edit_stat').click(function() {

      var data = (this.id).split('||');
      console.log(data)

      if (data[6] == 1) {
        $("#book-status-1").append("<div class='form-group'><label for='booking_status' class='col-lg-2 control-label'> Ubah Status </label><div class='col-lg-8'><div class='radio'><label><input type='radio' name='booking_status' id='optionsRadios1' value='3' checked>OK</label></div><div class='radio'><label><input type='radio' name='booking_status' id='optionsRadios2' value='2'>Batal</label></div></div></div>");
      } else if (data[6] == 3) {
        $("#book-status-2").append("<div class='form-group'><label for='booking_status' class='col-lg-2 control-label'> Ubah Status </label><div class='col-lg-8'><div class='checkbox'><label for='booking_status' class='control-label'><input type='checkbox' name='booking_status' id='optionsCheck2' value='2'>Batal</label></div></div></div>");
      }

      $('#modal_id_booking').val(data[0]);
      if (data[1] == '' || data[1] == null) {
        $('#modal_keterangan_status').val('-');
      } else {
        $('#modal_keterangan_status').val(data[1]);
      }
      $('#modal_booking_date').val(data[2]);
      $('#modal_time_start').val(data[3]);
      $('#modal_time_end').val(data[4]);
      $('#modal_booking_room').val(data[5]);
      $('#modal_status_id').val(data[6]);
    });

    $("#modal-default").on("hidden.bs.modal", function () {
      $("#book-status-1").empty();
      $("#book-status-2").empty();
    });
  });
</script>

@endsection
