@if ($crud->bulk_actions)
	<a href="javascript:void(0)" onclick="bulkSendInfoEntries(this)" class="btn btn-default btn-sm bulk-button"><i class="fa fa-mail-forward"></i>Send Mail Account Info</a>
@endif

@push('after_scripts')
<script>
	if (typeof bulkSendInfoEntries != 'function') {
	  function bulkSendInfoEntries(button) {

	      if (typeof crud.checkedItems === 'undefined' || crud.checkedItems.length == 0)
	      {
	      	new PNotify({
	              title: "{{ trans('backpack::crud.bulk_no_entries_selected_title') }}",
	              text: "{{ trans('backpack::crud.bulk_no_entries_selected_message') }}",
	              type: "warning"
	          });

	      	return;
	      }

	      var message = ("Are you sure you want to send mail to these :number entries?").replace(":number", crud.checkedItems.length);
	      var button = $(this);

	      // show confirm message
	      if (confirm(message) == true) {
	      	  var ajax_calls = [];
      		  var delete_route = "{{ url($crud->route) }}/bulk-send-email-info";

	      	  // submit an AJAX delete call
      		  $.ajax({
	              url: delete_route,
	              type: 'POST',
				  data: { entries: crud.checkedItems },
	              success: function(result) {
	                  // Show an alert with the result
	                  new PNotify({
	                      title: ("Result"),
	                      text: crud.checkedItems.length+" emails are sending...",
	                      type: "success"
	                  });

	                  crud.checkedItems = [];
			      	  crud.table.ajax.reload();
	              },
	              error: function(result) {
	                  // Show an alert with the result
	                  new PNotify({
	                      title: "Error",
	                      text: "Some thing wrong",
	                      type: "warning"
	                  });
	              }
	          });
	      }
      }
	}
</script>
@endpush
