@php $arr = $paginator->toArray(); @endphp
<p class="page_number_text">
    <span>{{ $arr['from'] }}-{{ $arr['to'] }}</span> / {{ $arr['total'] }}</p>