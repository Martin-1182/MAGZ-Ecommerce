@php
    if (isset($approved) and $approved == true) {
        $comments = $model->approvedComments;
    } else {
        $comments = $model->comments;
    }
@endphp

@if($comments->count() < 1)
    <h2>Zatiaľ tu nie sú žiadne komentáre.</h2>
@endif

<ul class="list-unstyled">
    @php
        $comments = $comments->sortByDesc('created_at');

        if (isset($perPage)) {
            $page = request()->query('page', 1) - 1;

            $parentComments = $comments->where('child_id', '');

            $slicedParentComments = $parentComments->slice($page * $perPage, $perPage);

            $m = Config::get('comments.model'); // This has to be done like this, otherwise it will complain.
            $modelKeyName = (new $m)->getKeyName(); // This defaults to 'id' if not changed.

            $slicedParentCommentsIds = $slicedParentComments->pluck($modelKeyName)->toArray();

            // Remove parent Comments from comments.
            $comments = $comments->where('child_id', '!=', '');

            $grouped_comments = new \Illuminate\Pagination\LengthAwarePaginator(
                $slicedParentComments->merge($comments)->groupBy('child_id'),
                $parentComments->count(),
                $perPage
            );

            $grouped_comments->withPath(request()->path());
        } else {
            $grouped_comments = $comments->groupBy('child_id');
        }
    @endphp
    @foreach($grouped_comments as $comment_id => $comments)
        {{-- Process parent nodes --}}
        @if($comment_id == '')
            @foreach($comments as $comment)
                @include('comments::_comment', [
                    'comment' => $comment,
                    'grouped_comments' => $grouped_comments
                ])
            @endforeach
        @endif
    @endforeach
</ul>

@isset ($perPage)
    {{ $grouped_comments->links() }}
@endisset

@auth
    @include('comments::_form')
@elseif(Config::get('comments.guest_commenting') == true)
    @include('comments::_form', [
        'guest_commenting' => true
    ])
@else
    <div class="card mb-5">
        <div class="card-body">
            <h5 class="card-title">Vyžaduje sa prihlásenie!</h5>
            <p class="card-text">Ak chcete pridať komentár, musíte sa prihlásiť.</p>
            <a href="{{ route('login') }}" class="button button-plain">Prihlásiť sa</a>
        </div>
    </div>
@endauth
