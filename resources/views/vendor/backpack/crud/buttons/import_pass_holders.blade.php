<button class="btn btn-primary ladda-button" data-toggle="modal" data-target="#modal-pass-holder">
    <span class="ladda-label">
        <i class="fa fa-plus"></i> Bulk Import Pass Holders
    </span>
</button>

<div class="modal modal-primary fade" id="modal-pass-holder" style="bottom: 40px; display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('admin.pass-holder.import') }}" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Import Pass Holders</h4>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <p><input type="file" name="import_file" /></p>
                    <p>Note: 
                        <ul>
                            <li>
                                Make sure your excel file contains header in first row (Applicant Name, NRIC, PassExpirydate, Nationality, Company, RU Name, RU Email, AS Name, AS Email, Zone)
                            </li>
                            <li>
                                Make sure you place single quote in begin of date's cell (PassExpirydate)
                            </li>
                            <li>
                                Make sure date format is: dd/mm/yyyy (like 25/12/2018)
                            </li>
                            <li>
                                Make sure you add comma as separator of zones column
                            </li>
                            <li>
                                All invalid rows will be ignored automatically
                            </li>
                            <li>
                                Demo file: <a href="{{ route('admin.pass-holder.import.demo') }}" class="btn btn-xs btn-warning">download demo</a>
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
        modalId = '#modal-pass-holder';
    </script>
@else
    <script>
        showModal = false;
        modalId = '';
    </script>
@endif