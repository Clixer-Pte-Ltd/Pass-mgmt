@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        <small>{!! $crud->getSubheading() ?? trans('backpack::crud.add').' '.$crud->entity_name !!}.</small>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.add') }}</li>
	  </ol>
	</section>
@endsection

@section('content')
@if ($crud->hasAccess('list'))
		@if(session()->has(SESS_TENANT_MY_COMPANY))
				<a href="{{ route('admin.tenant.my-company') }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Back</a>
		@else
				@if(session()->has(SESS_TENANT_SUB_CONSTRUCTOR))
						<a href="{{ route('crud.tenant.show', [session()->get(SESS_TENANT_SUB_CONSTRUCTOR)]) }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Back</a>
				@else
					<a href="{{ starts_with(URL::previous(), url($crud->route)) ? URL::previous() : url($crud->route) }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a>
				@endif
		@endif
@endif
<div class="row m-t-20">
	<div class="{{ $crud->getCreateContentClass() }}">
		<!-- Default box -->

		@include('crud::inc.grouped_errors')

		  <form method="post"
		  		action="{{ url($crud->route) }}"
				@if ($crud->hasUploadFields('create'))
				enctype="multipart/form-data"
				@endif
		  		>
		  {!! csrf_field() !!}
		  <div class="col-md-12">

		    <div class="row display-flex-wrap">
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
		      @if(view()->exists('vendor.backpack.crud.form_content'))
		      	@include('vendor.backpack.crud.form_content', [ 'fields' => $crud->getFields('create'), 'action' => 'create' ])
		      @else
		      	@include('crud::form_content', [ 'fields' => $crud->getFields('create'), 'action' => 'create' ])
		      @endif
		    </div><!-- /.box-body -->
		    <div class="">
                @if(session()->has(SESS_TENANT_SUB_CONSTRUCTOR) || (session()->has(SESS_TENANT_MY_COMPANY)))
                    <button type="submit" class="btn btn-success">
                        <span class="fa fa-save" role="presentation" aria-hidden="true"></span> &nbsp;
                        <span>Save</span>
										</button>
										@if(session()->has(SESS_TENANT_MY_COMPANY))
												<a href="{{ route('admin.tenant.my-company') }}" class="btn btn-default"><span class="fa fa-ban"></span> &nbsp;{{ trans('backpack::crud.cancel') }}</a>
										@else
												<a href="{{ route('crud.tenant.show', [session()->get(SESS_TENANT_SUB_CONSTRUCTOR)]) }}" class="btn btn-default"><span class="fa fa-ban"></span> &nbsp;{{ trans('backpack::crud.cancel') }}</a>
										@endif
                @else
                    @include('crud::inc.form_save_buttons')
                @endif

		    </div><!-- /.box-footer-->

		  </div><!-- /.box -->
		  </form>
	</div>
</div>

@endsection
