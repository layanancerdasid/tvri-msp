<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="d-flex flex-row flex-column-fluid page">
				<!--begin::Aside-->
				<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
					<!--begin::Brand-->
					<div class="brand flex-column-auto" id="kt_brand">
						<!--begin::Logo-->
						<a href="index.html" class="brand-logo">
							<img alt="Logo" class="w-65px" src="<?=base_url();?>assets/img/metroconic/logo-tvri-white_w198_h138.png" />
						</a>
						<!--end::Logo-->
					</div>
					<!--end::Brand-->
					<!--begin::Aside Menu-->
					<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
						<!--begin::Menu Container-->
						<div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
							<!--begin::Menu Nav-->
							<ul class="menu-nav">
								<li class="menu-item" aria-haspopup="true">
									<a href="index.html" class="menu-link">
										<i class="menu-icon flaticon2-architecture-and-city"></i>
										<span class="menu-text">Export</span>
									</a>
								</li>
								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="javascript:;" class="menu-link menu-toggle">
										<i class="menu-icon flaticon2-telegram-logo"></i>
										<span class="menu-text">Actions</span>
										<i class="menu-arrow"></i>
									</a>
									<div class="menu-submenu">
										<i class="menu-arrow"></i>
										<ul class="menu-subnav">
											<li class="menu-item menu-item-parent" aria-haspopup="true">
												<span class="menu-link">
													<span class="menu-text">Actions</span>
												</span>
											</li>
											<li class="menu-item" aria-haspopup="true">
												<a href="#" class="menu-link">
													<i class="menu-bullet menu-bullet-line">
														<span></span>
													</i>
													<span class="menu-text">Reports</span>
												</a>
											</li>
											<li class="menu-item" aria-haspopup="true">
												<a href="#" class="menu-link">
													<i class="menu-bullet menu-bullet-line">
														<span></span>
													</i>
													<span class="menu-text">Messages</span>
												</a>
											</li>
											<li class="menu-item" aria-haspopup="true">
												<a href="#" class="menu-link">
													<i class="menu-bullet menu-bullet-line">
														<span></span>
													</i>
													<span class="menu-text">Notes</span>
												</a>
											</li>
											<li class="menu-item" aria-haspopup="true">
												<a href="#" class="menu-link">
													<i class="menu-bullet menu-bullet-line">
														<span></span>
													</i>
													<span class="menu-text">Remarks</span>
												</a>
											</li>
										</ul>
									</div>
								</li>
								<li class="menu-item" aria-haspopup="true">
									<a href="#" onclick="logout_();return false;" class="menu-link">
										<i class="menu-icon flaticon2-graph-1"></i>
										<span class="menu-text">Logout</span>
									</a>
								</li>
							</ul>
							<!--end::Menu Nav-->
						</div>
						<!--end::Menu Container-->
					</div>
					<!--end::Aside Menu-->
				</div>
				<!--end::Aside-->
				
				
				<!--begin::Wrapper-->
				<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" class="header header-fixed">
						<!--begin::Container-->
						<div class="container-fluid d-flex align-items-stretch justify-content-between">
							<!--begin::Header Menu Wrapper-->
							<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
								<!--begin::Header Menu-->
								<div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
									<!--begin::Header Nav-->
									<ul class="menu-nav">
										<li class="menu-item" aria-haspopup="true">
											<a href="<?=base_url();?>dashboard" class="menu-link">
												<span class="menu-text">Dashboard</span>
											</a>
										</li>
										<li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="click" aria-haspopup="true">
											<a href="javascript:;" class="menu-link menu-toggle">
												<span class="menu-text">Features</span>
												<span class="menu-desc"></span>
												<i class="menu-arrow"></i>
												
											</a>
											<div class="menu-submenu menu-submenu-classic menu-submenu-left">
												<ul class="menu-subnav">
													<li class="menu-item menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
														<a href="javascript:;" class="menu-link menu-toggle">
															<span class="svg-icon menu-icon">
																<i class="menu-icon fas fa-money-bill-alt"></i>
															</span>
															<span class="menu-text">Proyek Pengadaan</span>
															<i class="menu-arrow"></i>
														</a>
														<div class="menu-submenu menu-submenu-classic menu-submenu-right">
															<ul class="menu-subnav">
																<li class="menu-item" aria-haspopup="true">
																	<a href="<?=base_url()?>pengadaan/lelang" class="menu-link">
																		<i class="menu-bullet menu-bullet-dot">
																			<span></span>
																		</i>
																		<span class="menu-text">Pengadaan Lelang</span>
																	</a>
																</li>
																<li class="menu-item" aria-haspopup="true">
																	<a href="<?=base_url()?>pengadaan/nonlelang" class="menu-link">
																		<i class="menu-bullet menu-bullet-dot">
																			<span></span>
																		</i>
																		<span class="menu-text">Pengadaan Non Lelang</span>
																	</a>
																</li>
															</ul>
														</div>
													</li>
													<li class="menu-item" aria-haspopup="true">
														<a href="<?=base_url()?>proyek" class="menu-link">
															<span class="svg-icon menu-icon">
																<i class="menu-icon fas fa-money-bill-alt"></i>
															</span>
															<span class="menu-text">Monitoring Proyek</span>
														</a>
													</li>
												</ul>
											</div>
										</li>										
										<li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="click" aria-haspopup="true">
											<a href="javascript:;" class="menu-link menu-toggle">
												<span class="menu-text">Metering</span>
												<span class="menu-desc"></span>
												<i class="menu-arrow"></i>
												
											</a>
											<div class="menu-submenu menu-submenu-classic menu-submenu-left">
												<ul class="menu-subnav">
													<li class="menu-item" aria-haspopup="true">
														<a href="<?=base_url()?>metering/dashboard" class="menu-link">
															<span class="svg-icon menu-icon">
																<i class="menu-icon fas fa-money-bill-alt"></i>
															</span>
															<span class="menu-text">Dashboard Metering</span>
														</a>
													</li>
													<li class="menu-item" aria-haspopup="true">
														<a href="<?=base_url()?>metering/qc_metering" class="menu-link">
															<span class="svg-icon menu-icon">
																<i class="menu-icon fas fa-money-bill-alt"></i>
															</span>
															<span class="menu-text">QC Metering</span>
														</a>
													</li>
													<li class="menu-item" aria-haspopup="true">
														<a href="<?=base_url()?>metering/report" class="menu-link">
															<span class="svg-icon menu-icon">
																<i class="menu-icon fas fa-money-bill-alt"></i>
															</span>
															<span class="menu-text">Laporan Metering</span>
														</a>
													</li>
												</ul>
											</div>
										</li>
										<li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="click" aria-haspopup="true">
											<a href="javascript:;" class="menu-link menu-toggle">
												<span class="menu-text">Akun</span>
												<span class="menu-desc"></span>
												<i class="menu-arrow"></i>
												
											</a>
											<div class="menu-submenu menu-submenu-classic menu-submenu-left">
												<ul class="menu-subnav">
													<li class="menu-item" aria-haspopup="true">
														<a href="<?=base_url()?>auth/users" class="menu-link">
															<span class="svg-icon menu-icon">
																<i class="menu-icon fas fa-money-bill-alt"></i>
															</span>
															<span class="menu-text">Akun Pengguna</span>
														</a>
													</li>
													<li class="menu-item" aria-haspopup="true">
														<a href="<?=base_url()?>auth/group_menu" class="menu-link">
															<span class="svg-icon menu-icon">
																<i class="menu-icon fas fa-money-bill-alt"></i>
															</span>
															<span class="menu-text">Grup Pengguna</span>
														</a>
													</li>
												</ul>
											</div>
										</li>

										<li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="click" aria-haspopup="true">

											<a href="javascript:;" class="menu-link menu-toggle">
												<span class="menu-text">Master</span>
												<span class="menu-desc"></span>
												<i class="menu-arrow"></i>
												
											</a>
											<div class="menu-submenu menu-submenu-classic menu-submenu-left">
												<ul class="menu-subnav">
													<li class="menu-item" aria-haspopup="true">
																	<a href="<?=base_url()?>master/fft_size" class="menu-link">
															<span class="svg-icon menu-icon">
																<i class="menu-icon fas fa-money-bill-alt"></i>
															</span>
															<span class="menu-text">FFT Size</span>
														</a>
													</li>
													<li class="menu-item" aria-haspopup="true">
																	<a href="<?=base_url()?>master/provinsi" class="menu-link">
															<span class="svg-icon menu-icon">
																<i class="menu-icon fas fa-money-bill-alt"></i>
															</span>
															<span class="menu-text">Wilayah (Propinsi - Desa)</span>
														</a>
													</li>
													<li class="menu-item" aria-haspopup="true">
																<a href="<?=base_url()?>master/kanal" class="menu-link">
															<span class="svg-icon menu-icon">
																<i class="menu-icon fas fa-money-bill-alt"></i>
															</span>
															<span class="menu-text">Kanal Siaran</span>
														</a>
													</li>
													<li class="menu-item" aria-haspopup="true">
																	<a href="<?=base_url()?>master/arealayanan" class="menu-link">
															<span class="svg-icon menu-icon">
																<i class="menu-icon fas fa-money-bill-alt"></i>
															</span>
															<span class="menu-text">Wilayah Layanan TVRI</span>
														</a>
													</li>
													<li class="menu-item" aria-haspopup="true">
																	<a href="<?=base_url()?>master/modulation" class="menu-link">
															<span class="svg-icon menu-icon">
																<i class="menu-icon fas fa-money-bill-alt"></i>
															</span>
															<span class="menu-text">Modulation</span>
														</a>
													</li>
													<li class="menu-item" aria-haspopup="true">
																	<a href="<?=base_url()?>master/pegawai" class="menu-link">
															<span class="svg-icon menu-icon">
																<i class="menu-icon fas fa-money-bill-alt"></i>
															</span>
															<span class="menu-text">Pegawai</span>
														</a>
													</li>
													<li class="menu-item" aria-haspopup="true">
																	<a href="<?=base_url()?>master/lokasi" class="menu-link">
															<span class="svg-icon menu-icon">
																<i class="menu-icon fas fa-money-bill-alt"></i>
															</span>
															<span class="menu-text">Peta Lokasi</span>
														</a>
													</li>
													<li class="menu-item" aria-haspopup="true">
																	<a href="<?=base_url()?>master/polarisasi" class="menu-link">
															<span class="svg-icon menu-icon">
																<i class="menu-icon fas fa-money-bill-alt"></i>
															</span>
															<span class="menu-text">Polarisasi</span>
														</a>
													</li>
													<li class="menu-item" aria-haspopup="true">
																	<a href="<?=base_url()?>master/plot_pattern" class="menu-link">
															<span class="svg-icon menu-icon">
																<i class="menu-icon fas fa-money-bill-alt"></i>
															</span>
															<span class="menu-text">Plot Pattern</span>
														</a>
													</li>
													<li class="menu-item" aria-haspopup="true">
																	<a href="<?=base_url()?>master/vendor" class="menu-link">
															<span class="svg-icon menu-icon">
																<i class="menu-icon fas fa-money-bill-alt"></i>
															</span>
															<span class="menu-text">Vendor</span>
														</a>
													</li>
														
													<li class="menu-item menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
														<a href="<?=base_url()?>master3/vendor" class="menu-link menu-toggle">
															<span class="svg-icon menu-icon">
																<i class="menu-icon fas fa-money-bill-alt"></i>
															</span>
															<span class="menu-text">Kantor TVRI</span>
															<i class="menu-arrow"></i>
														</a>
														<div class="menu-submenu menu-submenu-classic menu-submenu-right">
															<ul class="menu-subnav">
																<li class="menu-item" aria-haspopup="true">
																	<a href="<?=base_url()?>master/kantor" class="menu-link">
																		<i class="menu-bullet menu-bullet-dot">
																			<span></span>
																		</i>
																		<span class="menu-text">Kantor Pusat</span>
																	</a>
																</li>
																<li class="menu-item" aria-haspopup="true">
																	<a href="<?=base_url()?>master/kantor" class="menu-link">
																		<i class="menu-bullet menu-bullet-dot">
																			<span></span>
																		</i>
																		<span class="menu-text">Kantor Daerah</span>
																	</a>
																</li>
																<li class="menu-item" aria-haspopup="true">
																	<a href="<?=base_url()?>master/kantor" class="menu-link">
																		<i class="menu-bullet menu-bullet-dot">
																			<span></span>
																		</i>
																		<span class="menu-text">Site Transmisi</span>
																	</a>
																</li>
															</ul>
														</div>
													</li>
													<li class="menu-item" aria-haspopup="true">
																<a href="<?=base_url()?>master/kat_pengadaan" class="menu-link">
															<span class="svg-icon menu-icon">
																<i class="menu-icon fas fa-money-bill-alt"></i>
															</span>
															<span class="menu-text">Kategori Pengadaan</span>
														</a>
													</li>
													<li class="menu-item" aria-haspopup="true">
																	<a href="<?=base_url()?>master/satker" class="menu-link">
															<span class="svg-icon menu-icon">
																<i class="menu-icon fas fa-money-bill-alt"></i>
															</span>
															<span class="menu-text">Satker</span>
														</a>
													</li>
												</ul>
											</div>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="<?=base_url();?>surattugas" class="menu-link">
												<span class="menu-text">Surat Tugas</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="<?=base_url();?>auth/logout" class="menu-link">
												<span class="menu-text">Logout</span>
											</a>
										</li>
									</ul>
									
										</ul>
									<!--end::Header Nav-->
								</div>
								<!--end::Header Menu-->
							</div>
			  
							<!--end::Header Menu Wrapper-->
	   
							<!--begin::Topbar-->
							<div class="topbar">
								
								<!--begin::User-->
								<div class="topbar-item">
									<div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
										<span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
										<span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">Sean</span>
										<span class="symbol symbol-35 symbol-light-success">
											<span class="symbol-label font-size-h5 font-weight-bold">S</span>
										</span>
									</div>
								</div>
								<!--end::User-->
							</div>
							<!--end::Topbar-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Header-->
					
					
					
					
					
					