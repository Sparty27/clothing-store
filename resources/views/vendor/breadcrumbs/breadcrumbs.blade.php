@unless ($breadcrumbs->isEmpty())
    <div class="breadcrumbs">
        <ul>
            @foreach($breadcrumbs as $breadcrumb)
                @if ($breadcrumb->url && !$loop->last)
                    <li class="decoration-transparent">
                        <a href="{{ $breadcrumb->url }}" class="dark:text-white">{{ $breadcrumb->title }}</a>
                    </li>
                @else
                    <li>
                        <strong class="text-primary">{{ $breadcrumb->title }}</strong>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
@endunless