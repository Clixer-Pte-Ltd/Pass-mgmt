<button type="button" class="btn btn-info grad-info" data-toggle="modal" data-target="#modal-blacklist-{{ $entry->id }}">
	<span class="fa fa-trash">De-List</span>
</button>
<div class="modal modal-default fade" id="modal-blacklist-{{ $entry->id }}" datasqstyle="{'bottom':null}" datasqbottom="40" style="bottom: 40px; display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">De-list Pass Holder </h4>
			</div>
			<form action="{{ route('admin.pass-holder.blacklist', [$entry->getKey()]) }}" method="POST">
				<div class="modal-body">
					@csrf
					<div class="form-group" style="width: 90%">
						<label>Reason</label>
						<select name="blacklist_reason" class="form-control black_list_select" style="width: 100%" required>
							<option value="Resigned">Resigned</option>
							<option value="End of Contract">End of Contract</option>
							<option value="Terminated">Terminated</option>
							<option value="Others">Others</option>
						</select>
						<div style="padding: 4px 3px;; width: 100%; display: none" class="black_list_input">
							<label>Others</label>
							<input type="text" style="display: inline-block; width: 100%" class="form-control" name="blacklist_reason">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="btn-sn-{{ $entry->id }}">De-list</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<script>
	$(function() {
		$(document).on('change', '.black_list_select', function() {
			if ($(this).val() === 'Others') {
				$(this).attr('name', '');
				$(this).siblings('.black_list_input').css('display', 'block');
			} else {
				$(this).attr('name', 'blacklist_reason');
				$(this).siblings('.black_list_input').css('display', 'none');
			}
		})
	});
</script>
