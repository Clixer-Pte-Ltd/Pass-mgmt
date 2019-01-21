<button class="btn btn-primary grad-primary" data-toggle="modal" data-target="#modal-sub-constructor">
    <span class="ladda-label">
        <i class="fa fa-plus"></i> Bulk Import Sub Constructors
    </span>
</button>

<div class="modal modal-primary fade" id="modal-sub-constructor" style="bottom: 40px; display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('admin.sub-constructor.import') }}" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Import Sub Constructors</h4>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <p><input type="file" name="import_file" /></p>
                    <p>Note: 
                        <ul>
                            <li>
                                Make sure your excel file contains header in first row (Name, Uen, Tenancy Start Date, Tenancy End Date, Tenant UEN)
                            </li>
                            <li>
                                Make sure you place single quote in begin of date's cell (Tenancy Start Date, Tenancy End Date)
                            </li>
                            <li>
                                Make sure date format is: dd/mm/yyyy (like 25/12/2018)
                            </li>
                            <li>
                                All invalid rows will be ignored automatically
                            </li>
                            <li>
                                Demo file: <a href="{{ route('admin.sub-constructor.import.demo') }}" class="btn btn-xs btn-warning">download demo</a>
                            </li>
                        </ul>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline">Import</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@if(!empty(Session::get('not_have_file')) && Session::get('not_have_file') == 1)
    <script>
        showModal = true;
        modalId = '#modal-sub-constructor';
    </script>
@else
    <script>
        showModal = false;
        modalId = '';
    </script>
@endif