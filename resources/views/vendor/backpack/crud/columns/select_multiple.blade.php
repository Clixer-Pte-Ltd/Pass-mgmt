{{-- relationships with pivot table (n-n) --}}
@php
    $results = data_get($entry, $column['name']);
    $limit = $column['limit'] ?? 100;
@endphp

<span>
    <?php
    if ($results && $results->count()) {
        $results_array = $results->pluck($column['attribute']);
        $str = implode(', ', $results_array->toArray());
        $strRs = substr($str, 0, $limit);
        if (strlen($str) > $limit) {
            $strRs .= '...';
        }
        echo $strRs;
    } else {
        echo '-';
    }
    ?>
</span>
