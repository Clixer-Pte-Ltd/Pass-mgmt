@if ($crud->hasAccess('delete'))
	<a href="javascript:void(0)" onclick="collectEntry(this)" data-route="{{ route('admin.terminate-pass-holder.collect', [$entry->getKey()]) }}" class="btn btn-xs btn-primary" data-button-type="collect"><i class="fa fa-get-pocket"></i> Returned</a>
@endif

<script>
	if (typeof collectEntry != 'function') {
	  $("[data-button-type=collect]").unbind('click');

	  function collectEntry(button) {
	      // ask for confirmation before deleting an item
	      // e.preventDefault();
	      var button = $(button);
	      var route = button.attr('data-route');
	      var row = $("#crudTable a[data-route='"+route+"']").closest('tr');

	      if (confirm("Are you sure to do it?") == true) {
	          $.ajax({
	              url: route,
	              type: 'POST',
	              success: function(result) {
	                  // Show an alert with the result
	                  new PNotify({
	                      title: "Success",
	                      text: "Returned successful",
	                      type: "success"
	                  });

	                  // Hide the modal, if any
	                  $('.modal').modal('hide');

	                  // Remove the details row, if it is open
	                  if (row.hasClass("shown")) {
	                      row.next().remove();
	                  }

	                  // Remove the row from the datatable
	                  row.remove();
	              },
	              error: function(result) {
	                  // Show an alert with the result
	                  new PNotify({
	                      title: "Ooop!",
	                      text: "Your item is not returned!",
	                      type: "warning"
	                  });
	              }
	          });
	      } else {
	      	  // Show an alert telling the user we don't know what went wrong
	          new PNotify({
	              title: "Ooop!",
	              text: "Your item is not returned!",
	              type: "info"
	          });
	      }
      }
	}

	// make it so that the function above is run after each DataTable draw event
	// crud.addFunctionToDataTablesDrawEventQueue('collectEntry');
</script>