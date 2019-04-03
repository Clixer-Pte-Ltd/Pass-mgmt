<div class="row">
	<div class="col-md-12">
		<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-users"></i> Accounts Registered</a></li>
					<li><a href="#tab_2" data-toggle="tab"><i class="fa fa-users"></i> Account Pending Register </a></li>
				@if(backpack_user()->hasAnyRole([COMPANY_CO_ROLE, CAG_STAFF_ROLE, CAG_ADMIN_ROLE, COMPANY_AS_ROLE]) && $entry instanceof App\Models\Tenant)
					<li><a href="#tab_3" data-toggle="tab"><i class="fa fa-building"></i> Sub Constructors</a></li>
				@endif
				</ul>
				<div class="tab-content">
						<div class="tab-pane active" id="tab_1">
								<div class="row">
									<div class="box no-padding no-border">
										@foreach($entry->accounts()->whereNotNull('phone')->get() as $account)
												<div class="col-md-6">
													<div class="info-box bg-green">
															<span class="info-box-icon"><i class="fa fa-user"></i></span>

															<div class="info-box-content">
																	<span class="info-box-number">Name: {{ $account->name }}</span>
																	<span class="info-box-text">Contact: {{ $account->phone }}</span>
																	<span class="info-box-text">Email: {{ $account->email }}</span>
																	<span class="text-right info-box-text">
																		<a href="{{ route('admin.tenant.account.2fa', [$entry->id, $account->id]) }}" class="btn btn-xs btn-default"><i class="fa fa-google-plus-square"></i> Config 2FA</a>
																		@if($account->id !== auth()->user()->id && !backpack_user()->hasAnyRole([COMPANY_CO_ROLE, COMPANY_AS_ROLE]))
																			<a href="javascript:void(0)" onclick="deleteEntry(this)" data-route="{{ route('crud.user.destroy', [$account->id]) }}" class="btn btn-xs btn-danger" data-button-type="delete"><i class="fa fa-trash"></i> Delete</a>
																		@endif
																	</span>

															</div>
															<!-- /.info-box-content -->
													</div>
												</div>


										@endforeach

									</div>
								</div>
						</div>
						<div class="tab-pane" id="tab_2">
							<div class="row">
								<div class="box no-padding no-border">
									@foreach($entry->accounts()->whereNull('phone')->get() as $account)
										<div class="col-md-6">
											<div class="info-box bg-green">
												<span class="info-box-icon"><i class="fa fa-user"></i></span>

												<div class="info-box-content">
													<span class="info-box-number">Name: {{ $account->name }}</span>
													<span class="info-box-text">Contact: {{ $account->phone }}</span>
													<span class="info-box-text">Email: {{ $account->email }}</span>
													<span class="text-right info-box-text">
														@if($account->id !== auth()->user()->id && !backpack_user()->hasAnyRole([COMPANY_CO_ROLE, COMPANY_AS_ROLE]))
															<a href="javascript:void(0)" onclick="deleteEntry(this)" data-route="{{ route('crud.user.destroy', [$account->id]) }}" class="btn btn-xs btn-danger" data-button-type="delete"><i class="fa fa-trash"></i> Delete</a>
														@endif
													</span>

												</div>
												<!-- /.info-box-content -->
											</div>
										</div>


									@endforeach

								</div>
							</div>
						</div>
						<!-- /.tab-pane -->
						@if(backpack_user()->hasAnyRole([COMPANY_CO_ROLE, CAG_STAFF_ROLE, CAG_ADMIN_ROLE, COMPANY_AS_ROLE]) && $entry instanceof App\Models\Tenant)
						<div class="tab-pane" id="tab_3">
							<div class="row">
								@foreach($entry->subContructors as $company)
									<div class="col-md-6">
										<a href="{{ backpack_user()->hasAnyRole([CAG_ADMIN_ROLE, CAG_STAFF_ROLE]) ? route('crud.sub-constructor.show', [$company->id]) : '#' }}">
											<div class="box box-widget widget-user">
												<!-- Add the bg color to the header using any of the bg-* classes -->
												<div class="widget-user-header bg-green-active">
													<h3 class="widget-user-username">{{ $company->name }}</h3>
													<h5 class="widget-user-desc">{{ $company->uen }}</h5>
												</div>
												<div class="widget-user-image">
													<img class="img-circle" src="{{ asset('images/company-sub.png') }}" alt="User Avatar">
												</div>
												<div class="box-footer">
													<div class="row">
														<div class="col-sm-4 border-right">
															<div class="description-block">
																<h5 class="description-header">Tenancy Start Date</h5>
																<span class="description-text">{{ custom_date_format($company->tenancy_start_date) }}</span>
															</div>
														<!-- /.description-block -->
														</div>
														<!-- /.col -->
														<div class="col-sm-4 border-right">
															<div class="description-block">
																<h5 class="description-header">Status</h5>
																<span class="description-text">{{ getCompanyStatus($company->status) }}</span>
															</div>
															<!-- /.description-block -->
														</div>
														<!-- /.col -->
														<div class="col-sm-4">
															<div class="description-block">
																<h5 class="description-header">Tenancy End Date</h5>
																<span class="description-text">{{ custom_date_format($company->tenancy_end_date) }}</span>
															</div>
															<!-- /.description-block -->
														</div>
														<!-- /.col -->
													</div>
													<!-- /.row -->
												</div>
											</div>
										</a>
									</div>
								@endforeach
							</div>
						</div>
						<!-- /.tab-pane -->
						@endif
				</div>
				<!-- /.tab-content -->
		</div>
	</div>
</div>