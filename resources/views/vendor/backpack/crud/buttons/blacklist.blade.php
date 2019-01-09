@if ($crud->hasAccess('delete'))
	<button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#modal-blacklist-{{ $entry->id }}">
		<span class="fa fa-trash">Blacklist</span>
	</button>
	<div class="modal modal-default fade" id="modal-blacklist-{{ $entry->id }}" datasqstyle="{'bottom':null}" datasqbottom="40" style="bottom: 40px; display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
					<h4 class="modal-title">Blacklist Pass Holder </h4>
				</div>
				<form action="{{ route('admin.pass-holder.blacklist', [$entry->getKey()]) }}" method="POST">
					<div class="modal-body">
						@csrf
						<div class="form-group" style="width: 90%">
							<label>Reason</label>
							<input type="text" name="blacklist_reason" class="form-control" style="width: 100%" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary" id="btn-sn-{{ $entry->id }}">Blacklist</button>
					</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
@endif