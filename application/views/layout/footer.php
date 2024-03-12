					<!--begin::Footer-->
					<div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
						<!--begin::Container-->
						<div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
							<!--begin::Copyright-->
							<div class="text-dark order-2 order-md-1">
								<span class="text-muted font-weight-bold mr-2">2020 ©</span>
								<a href="#" target="_blank" class="text-dark-75 text-hover-primary">TVRI</a>
							</div>
							<!--end::Copyright-->
							<!--begin::Nav-->
							<div class="nav nav-dark">
								<a href="#" class="nav-link pl-0 pr-5">Created by</a>
								<a href="ptmsp.id" target="_blank" class="nav-link pl-0 pr-5">PT. Multimedia Solusi Prima</a>
							</div>
							<!--end::Nav-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Footer-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Main-->
		
		
		<script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>
		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->
		
		<script src="<?=base_url()?>assets/js/metroconic/plugins.bundle-cc.js"></script>
		<script src="<?=base_url()?>assets/js/metroconic/prismjs.bundle.js"></script>
		<script src="<?=base_url()?>assets/js/metroconic/scripts.bundle.js"></script>
		<!--end::Global Theme Bundle-->
	</body>
	<!--end::Body-->
</html>

<script type="text/javascript">
// function logout_(){
	/*https://sweetalert2.github.io*/	 
	// Swal.fire({
		// title: 'Konfirmasi Status Alat?',
		// text: "Dengan ini kami menyatakan konfirmasi bahwa alat bantuan headend pada minggu ini masih terkendala sesuai ticket laporan #id xxx yang dilaporakan pada tanggal dd-mm-yyyy?",
		// icon: 'warning',
		// // showDenyButton: true,
		// showCancelButton: true,
		// confirmButtonColor: '#3085d6',
		// cancelButtonColor: '#d33',
		// confirmButtonText: 'Kirim',
		// background: '#fff url(<?=base_url();?>/assets/img/login-bg2.jpg)',
		// footer: 'Jika ada kendala buat tiket pelaporan melalui link ini berikut sebagai bukti otentik<br><i class="fas fa-ticket-alt"></i>'
	// }).then((result) => {
		// if (result.isConfirmed) {
			// window.location.replace("<?php echo base_url();?>auth/logout");
		// }
		// if (result.isDenied) {
			// Swal.fire('Changes are not saved', '', 'info')
		// }
	// })
// }

function logout_(){
	/*https://sweetalert2.github.io*/	 
	Swal.fire({
		title: 'Sign Out',
		// text: "You will be returned to the login screen",
		text: "You can always access your content by signing back in",
		icon: 'info',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		background: '#fff url(<?=base_url();?>/assets/img/login-bg2.jpg) top left',
		confirmButtonText: 'Sign Out'
		
	}).then((result) => {
		if (result.isConfirmed) {
			window.location.replace("<?php echo base_url();?>auth/logout");
		}
	})
}

		
		
function encodingAll_(id){
	var d = new Date();
	var token = lpad(d.getDate(),2)
							+lpad((d.getMonth()+1),2)
							+d.getFullYear()
							+id;
	return encodeURIComponent(btoa(token));
}	

function lpad(n, width, z) {
	z = z || '0';
	n = n + '';
	return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
}


</script>