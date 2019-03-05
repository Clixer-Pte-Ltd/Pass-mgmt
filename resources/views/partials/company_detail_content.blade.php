<div class="col-md-12">
    <div class="col-md-4">
        @include('partials.company_detail', ["entry" => $entry])
    </div>
    <div class="col-md-8">
        @include('partials.tenant_detail', ["entry" => $entry])
    </div>
</div>