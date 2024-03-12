<style>
	.ui-jqgrid tr.jqgrow td {
		vertical-align: top;
		white-space: normal !important;
		padding: 2px 5px;
	}

	.map,
	.vmap {
		width: 100%;
		height: 600px;
	}

	.card-body {
		font-weight: 400;
		font-size: 0.90rem;
	}

	td {
		font-weight: 400;
		font-size: 0.90rem;
	}
</style>
<style>
	.hide {
		display: none;
	}

	.myDIV:hover+.hide {
		position: absolute;
		z-index: 99;
		display: inline-block;
		border-bottom: 1px dotted black;
		width: 250px;
		background-color: #ffffff;
		color: #777777;
		text-align: left;
		border-radius: 2px;
		padding-left: 5px;
		font-size: 12px;
		font-family: "Lucida Console", "Courier New", monospace;
	}
</style>
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Subheader-->
	<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
		<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
			<!--begin::Info-->
			<div class="d-flex align-items-center flex-wrap mr-1">
				<!--begin::Page Heading-->
				<?= $breadcrumbs; ?>
				<!--end::Page Heading-->
			</div>
			<!--end::Info-->

		</div>
	</div>
	<!--end::Subheader-->
	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class="container">

			<div class="row">
				<div class="col-xl-12">
					<!--begin::Mixed Widget 16-->
					<div class="card card-custom card-stretch gutter-b">
						<!--begin::Header-->
						<!--<div class="card-header border-0 pt-1">
							<div class="card-title card-label">
								<div class="font-weight-bolder">Dashboard Sebaran LPP Transmisi TVRI</div>
							</div>
						</div>-->
						<!--end::Header-->
						<!--begin::Body-->

						<div class="card-body">
							<div class="card-title card-label">
								<div class="font-weight-bolder">
									<h4>Dashboard Sebaran LPP TVRI</h4>
								</div>
							</div>
							<div class="row">

								<div class="col-md-3 my-2 my-md-0">
									<!--begin::Select-->
									<label>Provinsi</label>
									<select name="provinsi" id="provinsi" class="form-control">
										<option value="">All</option>
										<?= $optionwilayah; ?>
									</select>
									<!--end::Select-->
								</div>
								<div class="col-md-2 my-2 my-md-0">
									<!--begin::Input-->
									<label>Merk Pemancar</label>
									<select name="merk" id="merk" class="form-control">
										<option value="">All</option>
										<?= $optionmerk; ?>
									</select <!--end::Input-->
								</div>

								<div class="col-md-2 my-2 my-md-0">
									<!--begin::Select-->
									<label>Tipe Transmisi</label>
									<select name="transmisi" id="transmisi" class="form-control">
										<option value="">All</option>
										<option value="Digital">Digital</option>
										<option value="Dualcast">Dualcast</option>
										<option value="DiDual">Digital & Dualcast</option>
										<option value="Analog">Analog</option>
										<option value="VHF">VHF</option>
										<option value="AnVhf">Analog & VHF</option>
										<option value="Unknown/STL">Unknown / STL</option>
									</select>
									<!--end::Select-->
								</div>
								<div class="col-md-3 my-2 my-md-0">
									<!--begin::Select-->
									<label>&nbsp;</label>
									<a href="javascript:;" onClick="load_lokasi();" class="form-control btn btn-light-primary  font-weight-bold">Search</a>
									<!--end::Select-->
								</div>


							</div>
							<!--begin::Items-->
							<div class="mt-2 mb-5">
								<div class="row row-paddingless mb-2">
									<!--begin::Item-->
									<div class="col">
										<div class="d-flex align-items-center mr-2">
											<!--begin::Symbol-->
											<div class="symbol symbol-45 symbol-light-danger mr-4 flex-shrink-0">
												<div class="symbol-label">
													<img src="<?php echo base_url() ?>/assets/img/maps_marker/Vhf.png">
												</div>
											</div>
											<!--end::Symbol-->
											<!--begin::Title-->
											<div>
												<div class="font-size-h4 text-dark-75 font-weight-bolder">
													<div id="is_vhf">-</div>
												</div>
												<div class="font-size-sm text-muted font-weight-bold mt-1">VHF</div>
											</div>
											<!--end::Title-->
										</div>
									</div>
									<!--end::Item-->
									<!--begin::Item-->
									<div class="col">
										<div class="d-flex align-items-center mr-2">
											<!--begin::Symbol-->
											<div class="symbol symbol-45 symbol-light-warning mr-4 flex-shrink-0">
												<div class="symbol-label">
													<img src="<?php echo base_url() ?>/assets/img/maps_marker/Analog.png">
												</div>
											</div>
											<!--end::Symbol-->
											<!--begin::Title-->
											<div>
												<div class="font-size-h4 text-dark-75 font-weight-bolder">
													<div id="is_analog">-</div>
												</div>
												<div class="font-size-sm text-muted font-weight-bold mt-1">Analog</div>
											</div>
											<!--end::Title-->
										</div>
									</div>
									<!--end::Item-->
									<!--begin::Item-->
									<div class="col">
										<div class="d-flex align-items-center mr-2">
											<!--begin::Symbol-->
											<div class="symbol symbol-45 symbol-light-primary mr-4 flex-shrink-0">
												<div class="symbol-label">
													<img src="<?php echo base_url() ?>/assets/img/maps_marker/Digital.png">
												</div>
											</div>
											<!--end::Symbol-->

											<!--begin::Title-->
											<div>
												<div class="font-size-h4 text-dark-75 font-weight-bolder">
													<div id="is_digital">-</div>
												</div>
												<div class="font-size-sm text-muted font-weight-bold mt-1">Digital</div>
											</div>
											<!--end::Title-->
										</div>
									</div>
									<!--end::Item-->
									<!--begin::Item-->
									<div class="col">
										<div class="d-flex align-items-center mr-2">
											<!--begin::Symbol-->
											<div class="symbol symbol-45 symbol-light-success  mr-4 flex-shrink-0">
												<div class="symbol-label">
													<img src="<?php echo base_url() ?>/assets/img/maps_marker/Dualcast.png">
												</div>
											</div>
											<!--end::Symbol-->
											<!--begin::Title-->
											<div>
												<div class="font-size-h4 text-dark-75 font-weight-bolder">
													<div id="is_dualcast">-</div>
												</div>
												<div class="font-size-sm text-muted font-weight-bold mt-1">Dualcast</div>
											</div>
											<!--end::Title-->
										</div>
									</div>
									<!--end::Item-->
									<!--begin::Item-->
									<div class="col">
										<div class="d-flex align-items-center mr-2">
											<!--begin::Symbol-->
											<div class="symbol symbol-45 symbol-light-dark  mr-4 flex-shrink-0">
												<div class="symbol-label">
													<img src="<?php echo base_url() ?>/assets/img/maps_marker/New.png">
												</div>
											</div>
											<!--end::Symbol-->
											<!--begin::Title-->
											<div>
												<div class="font-size-h4 text-dark-75 font-weight-bolder">
													<div id="is_unknown" class="myDIV">-</div>
													<div class="hide" id="titleUnknown"></div>
												</div>
												<div class="font-size-sm text-muted font-weight-bold mt-1">Unknown</div>
											</div>
											<!--end::Title-->
										</div>
									</div>
									<!--end::Item-->
									<!--begin::Item-->
									<div class="col">
										<div class="d-flex align-items-center mr-2">
											<!--begin::Symbol-->
											<div class="symbol symbol-45 symbol-light-danger  mr-4 flex-shrink-0">
												<div class="symbol-label">
													<span class="svg-icon svg-icon-lg svg-icon-danger ">
														<i class="icon-2x text-danger-50 flaticon-placeholder-1"></i>
													</span>
												</div>
											</div>
											<!--end::Symbol-->
											<!--begin::Title-->
											<div>
												<div class="font-size-h4 text-danger-75 font-weight-bolder">
													<div id="totlLokasi" class="myDIV">-</div>
													<div class="hide" id="titleLokasi"></div>
												</div>
												<div class="font-size-sm text-muted font-weight-bold mt-1">Lokasi</div>
											</div>
											<!--end::Title-->
										</div>
									</div>
									<!--end::Item-->
								</div>
							</div>
							<!--end::Items-->
							<div class="row">
								<!--begin::Chart-->
								<div class="flex-grow-1" style="position: relative;">
									<div class="clearfix pull-right" style="position: absolute;z-index: 10;margin-top: 1px;left: 600px;background: rgba(255,255,255,0.9);padding: 0px;margin-left: 10px;">
										<label for="raddressInput">Search Lokasi:</label>
										<input type="text" id="namalokasi" size="8" />
										<button type="button" class="btn btn-sm social twitter" id="searchButton" style="margin-bottom: 2px">
											<i class="fa fa-search"></i>
											<span>Search</span>
										</button>
										<button type="button" class="btn btn-sm social twitter" id="showall" style="margin-bottom: 4px" onclick="showMarkers();">
											<i class="fa fa-list"></i>
											<span>Show All</span>
										</button>
										<div>
										</div>
									</div>
									<div id="divmap" class='map'></div>
								</div>
								<!--end::Chart-->


							</div>
						</div>
						<!--end::Body-->
					</div>
					<!--end::Mixed Widget 16-->
				</div>
			</div>


		</div>
		<!--end::Container-->
	</div>
	<!--end::Entry-->
</div>
<!--end::Content-->


<script src="https://maps.google.com/maps/api/js?key=<?= $tokenapikey ?>" type="text/javascript"></script>
<script src="<?= $base_url ?>assets/js/markerclusterer.js"></script>
<script type="text/javascript">
	var map;
	// var marker;
	var gmarkers = [];
	var markerCluster;
	var infowindow = new google.maps.InfoWindow();
	var searchButton = document.getElementById("searchButton").onclick = searchLocations;
	var bounds = new google.maps.LatLngBounds();

	$(document).ready(function() {
		/*inisiasi*/
		map = new google.maps.Map(document.getElementById('divmap'), {
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			zoom: 5,
			mapTypeControl: false,
			center: {
				lat: parseFloat(-0.789275),
				lng: parseFloat(113.92132700000002)
			}
		});
	});

	function load_lokasi() {
		cleargmarkers();
		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>dashboard/load_lokasi",
			data: {
				merk: $('#merk').val(),
				provinsi: $('#provinsi').val(),
				transmisi: $('#transmisi').val(),
				jenis_transmisi: $('#transmisi').val()
			},
			success: function(response) {
				// console.info(response);
				var arrloc = JSON.parse(response)
				// console.info('total objek',arrloc.length);
				$("#is_analog").html(arrloc.sumAnalog.toString());
				$("#is_vhf").html(arrloc.sumVhf.toString());
				$("#is_digital").html(arrloc.sumDigital.toString());
				$("#is_dualcast").html(arrloc.sumDualcast.toString());
				$("#is_unknown").html(arrloc.sumUnknown.toString());
				$("#totlLokasi").html(arrloc.totlLokasi.toString());
				$("#titleUnknown").html(arrloc.titleUnknown.toString());
				if (arrloc.datas.length > 0) {
					//loop
					bounds = new google.maps.LatLngBounds(); // hilangkan jika butuh maps statis indonesia
					arrloc.datas.forEach(function(item, index) {
						addMarker(item);
					}); //end loop

					map.fitBounds(bounds);
					// var listener = google.maps.event.addListener(map, "idle", function () {
					map.setZoom(5);
					// map.fitBounds(bounds);
					// google.maps.event.removeListener(listener);
					// });
				} else {
					cleargmarkers();
					map = new google.maps.Map(document.getElementById('divmap'), {
						mapTypeId: google.maps.MapTypeId.ROADMAP,
						zoom: 15,
						mapTypeControl: false,
						center: {
							lat: parseFloat(-0.789275),
							lng: parseFloat(113.92132700000002)
						}
					});
				}
			}

		});
	}

	function searchLocations() {
		var namalokasi = document.getElementById("namalokasi").value;
		var ketemu = 0;
		// cleargmarkers();
		for (var i = 0; i < gmarkers.length; i++) {
			var str = gmarkers[i].label.text.toLowerCase();
			console.info(str);
			if (str.search(namalokasi.toLowerCase()) !== -1) {
				ketemu = 1;
				gmarkers[i].setMap(map);
				map.setZoom(13);
				map.panTo(gmarkers[i].position);
				new google.maps.event.trigger(gmarkers[i], 'click');
				$('#namalokasi').val('');

			}
		}

		if (ketemu == 0) {
			alert('pencarian nama lokasi "' + namalokasi + '" tidak tersedia');
			return false;
			// $('#namalokasi').setfocus();
		}
	}

	function cleargmarkers() {
		setMapOnAll(null);
		if (gmarkers.length > 0) {
			map.fitBounds(bounds);
		}

	}

	function setMapOnAll(map) {
		for (var i = 0; i < gmarkers.length; i++) {
			gmarkers[i].setMap(map);
		}
	}

	function showMarkers() {
		setMapOnAll(map);
		if (gmarkers.length > 0)
			map.fitBounds(bounds);
	}

	function addMarker(item) {
		var imagetower = '<?php echo base_url() ?>/assets/img/maps_marker/Analog.png';
		var pictureLabel = document.createElement("img");
		var v;
		pictureLabel.src = imagetower;
		if (item.jenis_transmisi == "Dualcast") {
			var imagetower = '<?php echo base_url() ?>/assets/img/maps_marker/Dualcast.png';
		} else if (item.jenis_transmisi == "Digital") {
			var imagetower = '<?php echo base_url() ?>/assets/img/maps_marker/Digital.png';
		} else if (item.jenis_transmisi == "Analog") {
			var imagetower = '<?php echo base_url() ?>/assets/img/maps_marker/Analog.png';
		} else if (item.jenis_transmisi == "VHF") {
			var imagetower = '<?php echo base_url() ?>/assets/img/maps_marker/Vhf.png';
		} else {
			var imagetower = '<?php echo base_url() ?>/assets/img/maps_marker/New.png';
		}
		var v;
		pictureLabel.src = imagetower;
		var marker = new google.maps.Marker({
			position: new google.maps.LatLng(item.lat, item.long),
			map: map
				// ,label: item.nama_lokasi
				,
			label: {
				text: item.nama_lokasi + " (" + item.jenis_transmisi + ")",
				color: "rgba(0,0,0,0.0)",
				fontSize: "10px"
			},
			icon: imagetower
		});

		bounds.extend(marker.position);
		google.maps.event.addListener(marker, 'click', (function(marker, v) {
			return function() {
				var labwin = '<div id="iw-container">' +
					'<div class="iw-content"><b>' + item.nama_lokasi + ' (' + item.jenis_transmisi + ')</b><hr>' +
					'<table border=0 width="450px">' +
					'<tr><td valign="top"  width="110px">Alamat</td><td valign="top">&nbsp;:&nbsp;</td><td valign="top"> ' + item.alamat + '</td></tr>' +
					'<tr><td valign="top">Koordinat (Lat,Lng)</td><td valign="top">&nbsp;:&nbsp;</td><td valign="top">' + item.lat + ',' + item.long + '</td></tr>' +
					'<tr><td valign="top">Channel</td><td valign="top">&nbsp;:&nbsp;</td><td valign="top"> ' + item.channel + '</td></tr>' +
					'<tr><td valign="top">Merk Pemancar</td><td valign="top">&nbsp;:&nbsp;</td><td valign="top"> ' + item.merk + '</td></tr>' +
					'<tr><td valign="top">Wilayah Layanan</td><td valign="top">&nbsp;:&nbsp;</td><td valign="top"> ' + item.wilayah_layanan + '</td></tr>' +
					'<tr><td valign="top">P I C</td><td valign="top">&nbsp;:&nbsp;</td><td valign="top"> ' + item.pic + '</td></tr>' +
					'<tr><td valign="top">Telp PIC</td><td valign="top">&nbsp;:&nbsp;</td><td valign="top"> ' + item.telp_pic + '</td></tr>' +
					'<tr><td valign="top">Last Update</td><td valign="top">&nbsp;:&nbsp;</td><td valign="top"> ' + item.last_update + '</td></tr>' +
					'</table>' +
					'</div>' +
					'<div class="iw-bottom-gradient"></div>' +
					'</div>';
				infowindow.setContent(labwin);
				infowindow.open(map, marker);
			}
		})(marker, v));
		gmarkers.push(marker);
		// map.fitBounds(bounds);
	}

	$('#namalokasi').keypress(function(e) {
		var key = e.which;
		if (key == 13) {
			$('#searchButton').click();
			return false;
		}
	});

	setTimeout(function() {
		load_lokasi();
	}, 2000);
</script>

<script type="text/javascript">

</script>