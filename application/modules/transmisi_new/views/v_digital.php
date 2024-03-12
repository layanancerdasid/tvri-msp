<link rel="stylesheet" href="<?php echo  base_url() ?>assets/phpgrid/themes/cupertino/jquery-ui.custom.css"></link>  
<link rel="stylesheet" href="<?php echo  base_url() ?>assets/phpgrid/jqgrid/css/ui.jqgrid.css"></link> 
<script src="<?php echo base_url();?>assets/phpgrid/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo  base_url() ?>assets/phpgrid/jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?php echo  base_url() ?>assets/phpgrid/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>  
<script src="<?php echo  base_url() ?>assets/phpgrid/themes/jquery-ui.custom.min.js" type="text/javascript"></script>
<style>
	.ui-jqgrid tr.jqgrow td 
	{
		vertical-align: top;
		white-space: normal !important;
		padding:2px 5px;
	}
	.map, .vmap {
		width: 100%;
		height: 400px;
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
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Subheader-->
	<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
		<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
			<!--begin::Info-->
			<div class="d-flex align-items-center flex-wrap mr-1">
				<!--begin::Page Heading-->
				<?=$breadcrumbs;?>
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
						<div class="card-header border-0 pt-5">
							<div class="card-title">
								<div class="card-label">
									<div class="font-weight-bolder">Dashboard Sebaran Jenis Transmisi Digital LPP TVRI</div>
								</div>
							</div>
						</div>
						<!--end::Header-->
						<!--begin::Body-->
						
						<div class="card-body">
						<div class="row">
							<div class="col-md-3 my-2 my-md-0">
								<!--begin::Select-->
									<label>Lokasi LPP TVRI</label>
									<select name="lokasi" id="lokasi" class="form-control">
										<option value="">All</option>
										<?=$optionlokasi;?>
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
						
						</div>
						
						
						<div class="row">
						<div class="card-body d-flex flex-column">
							<!--begin::Chart-->
							<div class="flex-grow-1" style="position: relative;">
									<div class="clearfix pull-right" style="position: absolute;z-index: 10;margin-top: 5px;left: 0;background: rgba(255,255,255,0.9);padding: 5px;margin-left: 10px;">
										<label for="raddressInput">Search pemilik:</label>
										<input type="text" id="namalokasi" size="15"/>
										<button type="button" class="btn btn-sm social twitter" id="searchButton" style="margin-bottom: 4px">
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
								<div  id="divmap" class='map'></div>
							</div>
							<!--end::Chart-->
							
							<!--begin::Items-->
							<div class="mt-10 mb-5">
								<div class="row row-paddingless mb-10">
									<!--begin::Item-->
									<div class="col">
										<div class="d-flex align-items-center mr-2">
											<!--begin::Symbol-->
											<div class="symbol symbol-45 symbol-light-info mr-4 flex-shrink-0">
												<div class="symbol-label">
													<span class="svg-icon svg-icon-lg svg-icon-info">
														<i class="fas fa-file-medical-alt text-info icon-2x"></i>
														
													</span>
												</div>
											</div>
											<!--end::Symbol-->
											<!--begin::Title-->
											<div>
												<div class="font-size-h4 text-dark-75 font-weight-bolder"><div id="is_analog">100</div></div>
												<div class="font-size-sm text-muted font-weight-bold mt-1">Transmisi  Analog</div>
											</div>
											<!--end::Title-->
										</div>
									</div>
									<!--end::Item-->
									<!--begin::Item-->
									<div class="col">
										<div class="d-flex align-items-center mr-2">
											<!--begin::Symbol-->
											<div class="symbol symbol-45 symbol-light-danger mr-4 flex-shrink-0">
												<div class="symbol-label">
													<span class="svg-icon svg-icon-lg svg-icon-danger">
														<i class="fas fa-file-contract text-danger icon-2x"></i>
													</span>
												</div>
											</div>
											<!--end::Symbol-->
											<!--begin::Title-->
											<div>
												<div class="font-size-h4 text-dark-75 font-weight-bolder"><div id="is_digital">36</div></div>
												<div class="font-size-sm text-muted font-weight-bold mt-1">Transmisi Digital</div>
											</div>
											<!--end::Title-->
										</div>
									</div>
									<!--end::Item-->
								</div>
							</div>
							<!--end::Items-->
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


<script src="https://maps.google.com/maps/api/js?key=<?=$tokenapikey?>" type="text/javascript"></script>
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script type="text/javascript">
	var map;
	// var marker;
	var gmarkers = [];
	var markerCluster;
	var infowindow = new google.maps.InfoWindow();
	var searchButton = document.getElementById("searchButton").onclick = searchLocations;
	var bounds = new google.maps.LatLngBounds();
	
	$(document).ready(function () {
		/*inisiasi*/
			map = new google.maps.Map(document.getElementById('divmap'), {
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				zoom: 5,
				mapTypeControl: false,
				center: {lat: parseFloat(-0.789275), lng: parseFloat(113.92132700000002)}
			});
	});
	
	function load_lokasi(){
		cleargmarkers();
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>dashboard/load_lokasi",
			data: { lahan: $('#lahan').val() 
					,provinsi: $('#provinsi').val() 
					,transmisi: $('#transmisi').val() 
				  },
			success: function (response) {
				// console.info(response);
				var arrloc = JSON.parse(response)
				// console.info('total objek',arrloc.length);
				$("#is_analog").html(arrloc.sumAnalog.toString());
				$("#is_digital").html(arrloc.sumDigital.toString());
				if(arrloc.datas.length>0){ 
					//loop
					bounds = new google.maps.LatLngBounds(); // hilangkan jika butuh maps statis indonesia
					arrloc.datas.forEach(function (item, index) {
						addMarker(item);
					}); //end loop
					
					map.fitBounds(bounds);
					var listener = google.maps.event.addListener(map, "idle", function () {
					 map.setZoom(7);
					 map.fitBounds(bounds);
					 google.maps.event.removeListener(listener);
					 });
				}else{
					cleargmarkers();
					map = new google.maps.Map(document.getElementById('divmap'), {
						mapTypeId: google.maps.MapTypeId.ROADMAP,
						zoom: 5,
						mapTypeControl: false,
						center: {lat: parseFloat(-0.789275), lng: parseFloat(113.92132700000002)}
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
			 if(str.search(namalokasi.toLowerCase())!==-1){
					ketemu = 1;
					gmarkers[i].setMap(map);
					map.setZoom(13);
					map.panTo(gmarkers[i].position);
					new google.maps.event.trigger( gmarkers[i], 'click' );
					$('#namalokasi').val('');
					
			 }
			}
			
			if(ketemu==0){
				 alert('pencarian nama lokasi "'+namalokasi + '" tidak tersedia');
				 return false;
				 // $('#namalokasi').setfocus();
			}
	}

	function cleargmarkers() {
		setMapOnAll(null);
		if(gmarkers.length>0){
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
		if(gmarkers.length>0)
			map.fitBounds(bounds);
	}
	
	function addMarker(item) {
		var imagetower = '<?php echo base_url()?>/assets/img/maps_marker/parabola.png';
		var pictureLabel = document.createElement("img");
		var v;
		pictureLabel.src = imagetower;
		var marker = new google.maps.Marker({
			position: new google.maps.LatLng(item.lat, item.long)
			,map: map
			// ,label: item.nama_lokasi
			,label: {
				text: item.nama_lokasi+" ("+item.transmisi+")"
				,color: "rgba(0,0,0,0.0)"
				,fontSize: "10px"
			}
			,icon: imagetower
		});
			
		bounds.extend(marker.position);
		google.maps.event.addListener(marker, 'click', (function(marker, v) {
			return function() {
				var labwin = '<div id="iw-container">' +
				'<div class="iw-content"><b>'+item.nama_lokasi+' ('+item.transmisi +')</b><hr>' +
				'<table border=0 width="300px">'+
				'<tr><td valign="top">Kantor</td><td valign="top">&nbsp;:&nbsp;</td><td valign="top"> '+item.jenis_kantor+'</td></tr>' +
				'<tr><td valign="top">Lahan</td><td valign="top">&nbsp;:&nbsp;</td><td valign="top"> '+item.status_lahan+'</td></tr>' +
				'<tr><td valign="top">Alamat</td><td valign="top">&nbsp;:&nbsp;</td><td valign="top"> '+item.alamat+'</td></tr>' +
				'</table>'+
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
	
	$('#namalokasi').keypress(function (e) {
	 var key = e.which;
	 if(key == 13) {
			$('#searchButton').click();
			return false;  
		}
	}); 
	
	function reloadAll(){
		load_lokasi();
		load_grid();
		
	}
	
	function pemancar(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>transmisi/pemancar",
			success: function (response) {
				$("#gridpemancar").html(response);
				
			}
			
		});
	}
	
	setTimeout(function(){ 
		load_lokasi();
	}, 2000);
		
</script>

<script type="text/javascript">
	
</script>
