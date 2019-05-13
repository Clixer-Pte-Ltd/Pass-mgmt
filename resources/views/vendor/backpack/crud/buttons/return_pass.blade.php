@if ($entry->status == PASS_STATUS_WAITING_CONFIRM_RETURN && backpack_user()->hasAnyRole([CAG_ADMIN_ROLE, CAG_STAFF_ROLE]))
	<button type="button" class="btn btn-info grad-blue" data-toggle="modal" data-target="#modal-return-{{ $entry->id }}">
	<span class="fa fa-trash">
			Confirm
	</span>
	</button>
@elseif ($entry->status == PASS_STATUS_BLACKLISTED && backpack_user()->hasAnyRole([COMPANY_CO_ROLE, COMPANY_AS_ROLE, CAG_ADMIN_ROLE, CAG_STAFF_ROLE]))
	<button type="button" class="btn btn-info grad-blue" data-toggle="modal" data-target="#modal-return-{{ $entry->id }}">
	<span class="fa fa-trash">
			Return
	</span>
	</button>
@else

@endif

<div class="modal modal-default fade" id="modal-return-{{ $entry->id }}" datasqstyle="{'bottom':null}" datasqbottom="40" style="bottom: 40px; display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Return Pass Holder </h4>
			</div>
			<form action="{{ route('admin.blacklist-pass-holder.return', [$entry->getKey()]) }}" method="POST">
				<div class="modal-body">
					@csrf
					<div class="form-group" style="width: 90%">
						@if (!backpack_user()->hasAnyRole([CAG_ADMIN_ROLE, CAG_STAFF_ROLE]))
							<p>The notification email will be sent to CAG Admin to confirm this action.</p>
						@endif
						<p> Are you sure continute?</p>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="btn-sn-{{ $entry->id }}">Return</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
