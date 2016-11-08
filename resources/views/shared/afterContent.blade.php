@if(!empty($previousTableRow) || !empty($nextTableRow))
    <?php $path = dirname(Request::path()); ?>
    <nav>
        <ul class="pager">
            @if(!empty($previousTableRow))

                @if($previousTableRow->slug)
                    <li class="previous"><a href="{{@URL::to( $path ) }}/{{ $previousTableRow->slug }}"><span aria-hidden="true">&larr;</span> {{ $previousTableRow->slug }}</a></li>
                @elseif($previousTableRow->id)
                    <li class="previous"><a href="{{@URL::to( $path ) }}/{{ $previousTableRow->id }}"><span aria-hidden="true">&larr;</span> {{ $previousTableRow->id }}</a></li>
                @endif
            @endif

            @if(!empty($nextTableRow))
                @if($nextTableRow->slug)
                    <li class="next"><a href="{{@URL::to( $path ) }}/{{ $nextTableRow->slug }}">{{ $nextTableRow->slug }} <span aria-hidden="true">&rarr;</span></a></li>
                @elseif($nextTableRow->id)
                    <li class="next"><a href="{{@URL::to( $path ) }}/{{ $nextTableRow->id }}">{{ $nextTableRow->id }} <span aria-hidden="true">&rarr;</span></a></li>
                @endif
            @endif
        </ul>
    </nav>
@endif