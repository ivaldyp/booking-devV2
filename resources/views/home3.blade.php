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
				<div class="col-lg-12">
					<form method="GET" action="home3">
						<div class="form-row">
							<div class="form-group col-lg-4 col-xs-12">
								<select class="form-control" name="id_bidang" id="id_bidang" required onchange="this.form.submit()">
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
		              	</div>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="box box-primary">
						<div class="box-body no-padding">
							<?php if (count($rooms) > 0) { ?>
							<table class="table col-xs-10">
								<thead>
								<?php
									for ($i=0; $i <= count($rooms); $i++) { 
										if ($i == 0) {
											echo "<th class='col-xs-1'>Waktu</th>";
										} else {
											echo "<th>".$rooms[$i-1]->room_name."</th>";
										}
									}
								?>
								</thead>
								<tbody>
								<?php
									for ($i=0; $i < count($times); $i++) { 
										for ($j=0; $j <= count($rooms); $j++) { 
											if ($j == 0) {
												echo "<td>".$times[$i]->time_name."</th>";
											} else {
												echo "<td></td>";
											}
										}
									}
								?>
								</tbody>
							</table>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<!-- <div class="row">
				<div class="col-xs-3">
		      		<a href="{{ url('/') }}"><button class="btn btn-success" style="margin-bottom: 10px">Agenda View</button></a>
		      	</div>
			</div> -->
			<!-- <div class="row">
				<div class="col-md-12">
					<div class="box box-primary">
						<div class="box-body no-padding">
							<div id="calendar"></div>
						</div>
					</div>
				</div>
			</div> -->
			<!-- BEGIN MODAL -->
			<div class="modal fade" id="my-event">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title"><strong>Detail</strong></h4>
						</div>
						<div class="modal-body"></div>
						<div class="modal-footer">
							<button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
							<!-- <button type="button" class="btn btn-success save-event waves-effect waves-light">Create event</button>
							<button type="button" class="btn btn-danger delete-event waves-effect waves-light" data-dismiss="modal">Delete</button> -->
						</div>
					</div>
				</div>
			</div>

			<!-- Modal Add Category -->
			<div class="modal fade" id="add-new-event">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title"><strong>Add</strong> a category</h4>
						</div>
						<div class="modal-body">
							<form role="form">
								<div class="row">
									<div class="col-md-6">
										<label class="control-label">Category Name</label>
										<input class="form-control form-white" placeholder="Enter name" type="text" name="category-name"/>
									</div>
									<div class="col-md-6">
										<label class="control-label">Choose Category Color</label>
										<select class="form-control form-white" data-placeholder="Choose a color..." name="category-color">
												<option value="success">Success</option>
												<option value="danger">Danger</option>
												<option value="info">Info</option>
												<option value="primary">Primary</option>
												<option value="warning">Warning</option>
												<option value="inverse">Inverse</option>
										</select>
									</div>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal">Save</button>
							<button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- <script src="{{ URL::asset('plugins2/bower_components/calendar/dist/cal-init.js') }}"></script> -->
		<!-- /.content -->

@endsection 

@section('cal-init')
	<script type="text/javascript">
		$(function () {

		});
	</script>
	<!-- <script src="{{ URL::asset('plugins2/bower_components/calendar/dist/cal-init.js') }}"></script> -->
@endsection