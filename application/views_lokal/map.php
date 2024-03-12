<link href="<?=base_url();?>assets/css/bootstrap.min.css" rel="stylesheet"  />
<style>
    #map {
        height: 100%;
    }
</style>
<script>
$(document).ready(function() {
	$('#butsave').on('click', function() {
		var nama_lokasi = $('#kantor').val();
		var route = $('#route').val();
		var street_number = $('#street_number').val();
		var lat = $('#lat').val();
		var lng = $('#lng').val();
		var alamat = $('#alamat').val();
		if(kantor!="" || route!="" && lat!="" && lng!=""){
			$("#butsave").attr("disabled", "disabled");
			$.ajax({
				url: "<?php echo base_url("master/savekantor");?>",
				type: "POST",
				data: {
					type: 1,
					nama_lokasi: nama_lokasi,
					latitude: lat,
					longitude: lng,
					alamat: alamat,
					jalan: route
				},
				cache: false,
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
					if(dataResult.statusCode==200){
						$("#butsave").removeAttr("disabled");
						$('#fupForm').find('input:text').val('');
						$("#success").show();
						$('#success').html('Data added successfully !'); 						
					}
					else if(dataResult.statusCode==201){
					   alert("Error occured !");
					}
					
				}
			});
		}
		else{
			alert('Please fill all the field !');
		}
	});
});
</script>		
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
								<!--begin::Row-->
								<div class="container">
								<div class="row">
									<div class="col-md-7">
										<!--begin::Card-->
										<div class="card card-custom gutter-b example example-compact">
											<div class="card-header">
												<h3 class="card-title">Kantor/Site Transmisi</h3>
												<div class="card-toolbar">
													<div class="example-tools justify-content-center">
														<i class="fa fa-building"></i>
													</div>
												</div>
											</div>
											<!--begin::Form-->
									<form action="savekantor" id="form" method="post" class="form-horizontal form-label-left">
									<div class="card-body">
										<div class="form-group mb-8">
											<div class="alert alert-success alert-dismissible" id="success" style="display:none;">
											  <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
											</div>
											<div class="card-header">
												<div class="form-group row">
												<div class="col-lg-12">
												 <label>* Nama Kantor/Site Transmisi:</label>
												 <input type="text" name="kantor" id="kantor"class="form-control" placeholder="Nama Kantor/Site Transmisi ..." value=""/>
												</div>
											   </div>
												<div class="form-group row">
													<div class="col-md-6">
													 <label>Kategori:</label>
														<select class="form-control form-control-sm" name="kategori" id="kategori">
															<?php 
																foreach($jenis as $data_jenis)
																{
																	if($data_jenis->kode == $kategori)
																	{
																?>

																<option value="<?php echo $data_jenis->kode; ?>" selected><?php echo $data_jenis->nama; ?></option>

																<?php 
																	}
																	else
																	{
																?>
																
																<option value="<?php echo $data_jenis->kode; ?>"><?php echo $data_jenis->nama; ?></option>

																<?php		
																	}
																}
																?>
														</select>  
													</div>
													<div class="col-md-6">
													 <label>Status Lahan:</label>
														<select class="form-control form-control-sm" id="status" name="status">
															<?php 
																foreach($kategori_kantor as $data_kategori_kantor)
																{
																	if($data_kategori_kantor->id_kategori == $status)
																	{
																?>

																<option value="<?php echo $data_kategori_kantor->idstatuslahan; ?>" selected><?php echo $data_kategori_kantor->nama_status_lahan; ?></option>

																<?php 
																	}
																	else
																	{
																?>
																
																<option value="<?php echo $data_kategori_kantor->idstatuslahan; ?>"><?php echo $data_kategori_kantor->nama_status_lahan; ?></option>

																<?php		
																	}
																}
																?>
													  </select>   
													</div>													
												</div>												
												<div class="form-group row">
													<div class="col-md-10">
													 <label>* Alamat Jalan:</label>
														<input id="route"  name="route" class="form-control" placeholder="ALamat Jalan .." />
													</div>
													<div class="col-md-2">
													 <label>* No:</label>
														<input class="form-control" id="street_number"  name="street_number" placeholder="No"  class="form-control"> 
													</div>													
												 </div>
												<div class="form-group row">
													<div class="col-md-4">
													 <label>* Lat (X):</label>
													 <input id="lat" name="lat" type="text" placeholder="Latitude"  class="form-control">
													</div>
													<div class="col-md-4">
													 <label>* Lng (Y):</label>
													 <input id="lng" name="lng" type="text" placeholder="Longitude" class="form-control">
													</div>
													<div class="col-md-4">
													 <label>* Plus Code:</label>
													 <input class="form-control" id="plus_code" name="plus_code" placeholder="Kode Plus .."></input>
													</div>
											   </div>
											   <div class="form-group row">
													<div class="col-md-6">
													 <label>* Propinsi:</label>
														<input id="administrative_area_level_1" name="administrative_area_level_1"  type="text" placeholder="Propinsi ..." class="form-control">
													</div>
													<div class="col-md-6">
													 <label>* Kab/Kota:</label>
														<input class="form-control" id="administrative_area_level_2" name="administrative_area_level_2" class="form-control" placeholder="Kab/Kota ..."></input>  
													</div>													
											  </div>
											  <div class="form-group row">
													<div class="col-md-6">
													 <label>* Kecamatan:</label>
														<input class="form-control" id="administrative_area_level_3"  name="administrative_area_level_3" class="form-control" placeholder="Kecamatan .."></input> 
													</div>
													<div class="col-md-6">
													 <label>* Kelurahan/Desa:</label>
														<input class="form-control" id="administrative_area_level_4" name="administrative_area_level_4" placeholder="Desa .."></input>   
													</div>													
												</div>
												<div class="form-group row">
													<div class="col-md-3">
													 <label>* Kodepos:</label>
														<input class="form-control" id="postal_code" name="postal_code" placeholder="Kodepos .."></input>  
													</div>
													<div class="col-md-9">
													 <label>* Alamat Lengkap:</label>
														<textarea class="form-control" id="alamat" name="alamat" rows="3"  placeholder="Alamat Lengkap.."></textarea> 
													</div>													
												 </div>											  
											</div>
											<div class="card-footer">
													<button type="submit" class="btn btn-primary mr-2" id="butsave">Simpan</button>
													<button type="reset" class="btn btn-secondary">Cancel</button>
												</div>
										</div>
								
									</div>
									</div>
										<!--end::Card-->
										
									</div>
									<div class="col-lg-5">
										<!--begin::Card-->
										<div id="locationField">
											<input id="autocomplete" placeholder="Nama tempat atau alamat ..." type="text" size="65%"></input>
										</div>
										<div id="map" style="width: 100%; height: 500px;"></div>
										<div id="infowindow-content">
											<img src="" width="16" height="16" id="place-icon">
											<span id="place-name" class="title"></span><br>
											<span id="place-address"></span>
										</div>
										<!--end::Card-->
									</div>
								</div>
								<!--End::Row-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Entry-->
					</div>
					
					<!--end::Content-->
		<!--begin::Global Theme Bundle(used by all pages)-->
		<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		<!--end::Global Theme Bundle-->
		<!--begin::Page Vendors(used by this page)-->
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLrLCVrnWBCAWWE6t8KXJtW5Kpa1zN1HQ&libraries=places&callback=initMap&region=id&language=id" async defer></script>
<script>
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
		lat: 'lat',
		lng: 'lng',
        administrative_area_level_2: 'long_name',
        administrative_area_level_1: 'long_name',
		 administrative_area_level_3: 'long_name',
        administrative_area_level_4: 'long_name',
        postal_code: 'long_name'
    };



    var input = document.getElementById('autocomplete');

    function initMap() {
        var geocoder;
        var autocomplete;

        geocoder = new google.maps.Geocoder();
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {
                lat: -6.212983899999999,
                lng: 106.800878
            },
            zoom: 13
        });
        var card = document.getElementById('locationField');
        autocomplete = new google.maps.places.Autocomplete(input);

        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete.bindTo('bounds', map);

        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29),
            draggable: true
        });

        autocomplete.addListener('place_changed', function() {
            infowindow.close();
            marker.setVisible(false);
            var place = autocomplete.getPlace();
			//document.getElementById("lat").value = place.geometry['location'].lat();
			//document.getElementById("lng").value = place.geometry['location'].lng();
			var lat = place.geometry.location.lat();
			var lng = place.geometry.location.lng();
            console.log(place);

            if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17); // Why 17? Because it looks good.
            }
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }

            infowindowContent.children['place-icon'].src = place.icon;
            infowindowContent.children['place-name'].textContent = place.name;
            infowindowContent.children['place-address'].textContent = address;
            infowindow.open(map, marker);
            fillInAddress();

        });

        function fillInAddress(new_address) { // optional parameter
            if (typeof new_address == 'undefined') {
                var place = autocomplete.getPlace(input);
				var lat = place.geometry.location.lat();
				var lng = place.geometry.location.lng();
				var plus_code = place.plus_code.global_code;
				var placeId = place.place_id;
				var alamat = place.formatted_address;
            } else {
                place = new_address;
            }
            //console.log(place);
            for (var component in componentForm) {
                document.getElementById(component).value = '';
                document.getElementById(component).disabled = false;
            }

            for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                if (componentForm[addressType]) {
                    var val = place.address_components[i][componentForm[addressType]];
                    document.getElementById(addressType).value = val;
					var lat = place.geometry.location.lat();
					var lng = place.geometry.location.lng();
					var plus_code = place.plus_code.global_code;
					var alamat = place.formatted_address;
                }
			}
			document.getElementById("lat").value = lat;
			document.getElementById("lng").value = lng;
			document.getElementById("plus_code").value = plus_code;
			document.getElementById("alamat").value = alamat;
        }

        google.maps.event.addListener(marker, 'dragend', function() {
            geocoder.geocode({
                'latLng': marker.getPosition()
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        console.log(autocomplete);
                        $('#autocomplete').val(results[0].formatted_address);
                        infowindow.setContent(results[0].formatted_address);
                        infowindow.open(map, marker);
                        // google.maps.event.trigger(autocomplete, 'place_changed');
                        fillInAddress(results[0]);
                    }
                }
            });
        });
    }
</script>
