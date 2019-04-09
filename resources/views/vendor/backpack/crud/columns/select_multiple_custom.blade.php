{{-- relationships with pivot table (n-n) --}}
@php
    $results = data_get($entry, $column['name']);
@endphp

<span>
    <?php
    if ($results && $results->count()) {
        $results_array = $results->pluck($column['attribute']);
        $list = $results_array->toArray();
        $len = count($list);
        $str = '';
        for ($i = 0; $i < $len; $i+=3) {
            $str .= implode(', ', array_filter([$list[$i], @$list[$i+1], @$list[$i+2]])) . "<br>";
        }
        echo $str;
    } else {
        echo '-';
    }
    ?>
</span>
