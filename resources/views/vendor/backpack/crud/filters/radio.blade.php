{{-- Text Backpack CRUD filter --}}

<li filter-name="{{ $filter->name }}" filter-type="{{ $filter->type }}" class="{{ Request::get($filter->name) ? 'active' : '' }}">
    {{--<a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $filter->label }} <span class="caret"></span></a>--}}
    <div>
        @foreach($filter->values as $key => $value)
            <input class="" id="text-filter-{{ $key }}" type="radio" value="{{ $value }}" name="radio-name">
            <span>{{ $key }}</span>
            <br>
        @endforeach
        <div class="text-filter-{{ str_slug($filter->name) }}-clear-button">
            <span class="btn btn-default">Clear</span>
        </div>
    </div>
</li>

{{-- ########################################### --}}
{{-- Extra CSS and JS for this particular filter --}}


{{-- FILTERS EXTRA JS --}}
{{-- push things in the after_scripts section --}}

@push('crud_list_scripts')
    <!-- include select2 js-->
    <script>
        jQuery(document).ready(function($) {
            @foreach($filter->values as $key => $value)
            $('#text-filter-{{ $key }}').on('change', function(e) {

                var parameter = '{{ $filter->name }}';
                if ($(this).is(':checked')) {
                    var value = $(this).val();
                } else {
                    var value = false;
                }

                // behaviour for ajax table
                var ajax_table = $('#crudTable').DataTable();
                var current_url = ajax_table.ajax.url();
                var new_url = addOrUpdateUriParameter(current_url, parameter, value);

                // replace the datatables ajax url with new_url and reload it
                new_url = normalizeAmpersand(new_url.toString());
                ajax_table.ajax.url(new_url).load();

                // add filter to URL
                crud.updateUrl(new_url);

                // mark this filter as active in the navbar-filters
                if (URI(new_url).hasQuery('{{ $filter->name }}', true)) {
                    $('li[filter-name={{ $filter->name }}]').removeClass('active').addClass('active');
                } else {
                    $('li[filter-name={{ $filter->name }}]').trigger('filter:clear');
                }
            });

            $('li[filter-name={{ str_slug($filter->name) }}]').on('filter:clear', function(e) {
                $('li[filter-name={{ $filter->name }}]').removeClass('active');
                $('#text-filter-{{ str_slug($filter->name) }}').val('');
            });

            // datepicker clear button
            $(".text-filter-{{ str_slug($filter->name) }}-clear-button").click(function(e) {
                e.preventDefault();

                $('li[filter-name={{ str_slug($filter->name) }}]').trigger('filter:clear');
                $('#text-filter-{{ $key }}').prop("checked", true);
                $('#text-filter-{{ $key }}').prop("checked", false).trigger('change');
            })
            $('#text-filter-{{ $key }}').prop("checked", false).trigger('change');
            @endforeach
            $('#remove_filters_button').on('click', function (e) {
                $("input[name='radio-name']").prop("checked", false).trigger('change');
            })
        });
    </script>
@endpush
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}