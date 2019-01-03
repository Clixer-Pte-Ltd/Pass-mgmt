<button class="btn btn-primary ladda-button" data-toggle="modal" data-target="#modal-sub-constructor-account">
    <span class="ladda-label">
        <i class="fa fa-plus"></i> Bulk Import Sub-Constructor's Account
    </span>
</button>

<div class="modal modal-primary fade" id="modal-sub-constructor-account" style="bottom: 40px; display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('admin.sub-constructor.account.import') }}" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Import Sub-Constructor's Accounts</h4>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <p><input type="file" name="import_file" /></p>
                    <p>Note: 
                        <ul>
                            <li>
                                Make sure your excel file contains header in first row (Name, Email, Phone, Company UEN)
                            </li>
                            <li>
                                New email will be sent to inform user about their password and 2FA Authenticator
                            </li>
                            <li>
                                All invalid rows will be ignored automatically
                            </li>
                            <li>
                                Demo file: <a href="{{ route('admin.sub-constructor.account.import.demo') }}" class="btn btn-xs btn-warning">download demo</a>
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
        modalId = '#modal-sub-constructor-account';
    </script>
@else
    <script>
        showModal = false;
        modalId = '';
    </script>
@endif
