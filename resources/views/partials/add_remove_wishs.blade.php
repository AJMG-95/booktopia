@if (isset($book))
    @php
        $user = Auth::user();
        $isInWishlist = $user->wishes->contains('book_id', $book->id);
    @endphp

    @if (!$isInWishlist)
        <form action="{{ route('wishes.add', ['id' => $book->id]) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-primary"><i class="bi bi-bookmark"></i></button>
        </form>
    @else
        <form action="{{ route('wishes.remove', ['id' => $book->id]) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger"><i class="bi bi-bookmark-fill"></i></button>
        </form>
    @endif

@endif

@if (isset($editionBook))
    @php
        $user = Auth::user();
        $isInWishlist = $user->wishes->contains('book_id', $editionBook->id);
    @endphp
        @if (!$isInWishlist)
            <form action="{{ route('wishes.add', ['id' => $editionBook->id]) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-primary"><i class="bi bi-bookmark"></i></button>
            </form>
        @else
            <form action="{{ route('wishes.remove', ['id' => $editionBook->id]) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"><i class="bi bi-bookmark-fill"></i></button>
            </form>
        @endif
@endif
