<div data-controller="layouts--layout-list" data-layouts--layout-list-url="{{route($route,$attributes)}}">
    <a data-action="layouts--layout-list#edit">@isset($text) {{$text}} @else <i class="icon-menu"></i> @endisset</a>
</div>