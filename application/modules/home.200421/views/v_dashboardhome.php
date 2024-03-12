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
									<h4>Dashboard Sebaran LPPa Transmisi TVRI</h4>
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
														<div id="is_vhf" class="myDIV">-</div>
														<div class="hide" id="titleVhf"></div>
													</div>
													<div class="font-size-sm text-muted font-weight-bold mt-1">Trans. VHF</div>
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
														<div id="is_analog" class="myDIV">-</div>
														<div class="hide" id="titleAnalog"></div>
													</div>
													<div class="font-size-sm text-muted font-weight-bold mt-1">Trans. Analog</div>
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
														<div id="is_digital" class="myDIV">-</div>
														<div class="hide" id="titleDigital"></div>
													</div>
													<div class="font-size-sm text-muted font-weight-bold mt-1">Trans. Digital</div>
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
														<div id="is_dualcast" class="myDIV">-</div>
														<div class="hide" id="titleDualcast"></div>
													</div>
													<div class="font-size-sm text-muted font-weight-bold mt-1">Trans. Dualcast</div>
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
													<div class="font-size-sm text-muted font-weight-bold mt-1">Trans. Unknown</div>
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
														<div id="totlLokasi">-</div>
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
				url: "<?= base_url(); ?>home/load_lokasi",
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
					$("#titleAnalog").html(arrloc.titleAnalog.toString());
					$("#titleDigital").html(arrloc.titleDigital.toString());
					$("#titleDualcast").html(arrloc.titleDualcast.toString());
					$("#titleVhf").html(arrloc.titleVhf.toString());
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
	<!--begin::Scrolltop-->
	<div id="kt_scrolltop" class="scrolltop">
		<span class="svg-icon">
			<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Up-2.svg-->
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
					<polygon points="0 0 24 0 24 24 0 24" />
					<rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
					<path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
				</g>
			</svg>
			<!--end::Svg Icon-->
		</span>
	</div>
	<!--end::Scrolltop-->

	<script>
		var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";
	</script>
	<!--begin::Global Config(global config for global JS scripts)-->
	<script>
		var KTAppSettings = {
			"breakpoints": {
				"sm": 576,
				"md": 768,
				"lg": 992,
				"xl": 1200,
				"xxl": 1200
			},
			"colors": {
				"theme": {
					"base": {
						"white": "#ffffff",
						"primary": "#6993FF",
						"secondary": "#E5EAEE",
						"success": "#1BC5BD",
						"info": "#8950FC",
						"warning": "#FFA800",
						"danger": "#F64E60",
						"light": "#F3F6F9",
						"dark": "#212121"
					},
					"light": {
						"white": "#ffffff",
						"primary": "#E1E9FF",
						"secondary": "#ECF0F3",
						"success": "#C9F7F5",
						"info": "#EEE5FF",
						"warning": "#FFF4DE",
						"danger": "#FFE2E5",
						"light": "#F3F6F9",
						"dark": "#D6D6E0"
					},
					"inverse": {
						"white": "#ffffff",
						"primary": "#ffffff",
						"secondary": "#212121",
						"success": "#ffffff",
						"info": "#ffffff",
						"warning": "#ffffff",
						"danger": "#ffffff",
						"light": "#464E5F",
						"dark": "#ffffff"
					}
				},
				"gray": {
					"gray-100": "#F3F6F9",
					"gray-200": "#ECF0F3",
					"gray-300": "#E5EAEE",
					"gray-400": "#D6D6E0",
					"gray-500": "#B5B5C3",
					"gray-600": "#80808F",
					"gray-700": "#464E5F",
					"gray-800": "#1B283F",
					"gray-900": "#212121"
				}
			},
			"font-family": "Poppins"
		};
	</script>
	<!--end::Global Config-->