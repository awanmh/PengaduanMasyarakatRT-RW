@if(Auth::user()->role === 'rt')
    <form action="{{ route('comments.store', $complaint->id) }}" method="POST">
        @csrf
        <textarea name="comment" rows="3" class="form-control" placeholder="Tulis komentar..."></textarea>
        <button type="submit" class="btn btn-primary mt-2">Kirim Komentar</button>
    </form>
@endif
<h5>Komentar:</h5>
@foreach ($complaint->comments as $comment)
    <div class="border p-2 my-2">
        <strong>{{ $comment->user->name }} ({{ $comment->user->role }})</strong><br>
        {{ $comment->comment }}
        <div class="text-muted small">{{ $comment->created_at->diffForHumans() }}</div>
    </div>
@endforeach
