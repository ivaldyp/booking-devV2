@extends('layouts.master')

@section('content')

    <section class="content">
      <div class="row">
        <div class="col-lg-12">
          @if(Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}</div>
          @endif
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Histori Berdasarkan Bidang</h3>
            </div>
            <div class="box-body">
              <form method="GET" action="bidang">
                <div class="form-row">
                  <div class="form-group col-xs-3">
                    <select class="form-control" name="bidang_peminjam" id="bidang_peminjam" required>
                      <?php foreach ($bidangs as $data) { ?>
                        <option value="{{ $data->id_bidang }}" 
                          <?php 
                            if ($id_bidang == $data->id_bidang) {
                              echo "selected";
                            }
                          ?>
                        >{{ $data->bidang_name }}</option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group col-xs-1">
                    <select class="form-control" name="monthnow" id="monthnow" required>
                      <?php foreach ($montharray as $key => $data) { ?>
                        <option value="{{ $key + 1 }}" 
                          <?php 
                            if ($monthnow == $key+1) {
                              echo "selected";
                            }
                          ?>
                        >{{ $data }}</option>
                      <?php } ?>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                
              </form>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Acara</th>
                    <th class="col-lg-3">Deskripsi</th>
                    <th>Nama Peminjam</th>
                    <th>Bidang Peminjam</th>
                    <th>Ruang</th>
                    <th>Jumlah Peserta</th>
                    <th class="col-lg-1">Waktu</th>
                    <th>File Surat</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($listbidang as $key => $data) { ?>
                  <tr>
                    <input class="form_book_done_id_booking" type="hidden" name="id_booking" value="{{ $data->id_booking }}">
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
    </section>

@endsection

@section('datatable')

<script>
  $(function () {
    // $('#bidang_peminjam').change(function() {
    //     this.form.submit();
    // });

    $("#example1").DataTable();
    $('.btn_booking_done_edit_stat').click(function() {
      var data = (this.id).split('||');
      $('#modal_id_booking').val(data[0]);
      if (data[1] == '' || data[1] == null) {
        $('#modal_keterangan_status').val('-');
      } else {
        $('#modal_keterangan_status').val(data[1]);
      }
    });
  });
</script>

@endsection
