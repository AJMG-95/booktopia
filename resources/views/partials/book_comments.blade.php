<style>
    .comments-section {
        max-height: 400px;
        /* Ajusta la altura máxima según tus necesidades */
        overflow-y: auto;
    }
</style>

@if (count($comments) > 0)
    <div class=" w-100 mt-5 border border-dark rounded p-4 bg-light mb-5">
        <h3 class="mb-4 text-center text-primary">Comentarios</h3>
        <div class="comments-section w-100 mt-5 border border-dark rounded p-4 bg-light mb-5">
            @foreach ($comments as $comment)
                <div class="comment mb-4 p-3 border border-dark rounded bg-white">
                    <div class="user-info mb-2 d-flex justify-content-between">
                        <div class="fw-bold text-primary">{{ $comment->user->nickname }}</div>
                        <div class="text-muted">{{ $comment->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="comment-body">
                        {{ $comment->body }}
                    </div>
                    <div class="interaction mt-3 d-flex justify-content-between align-items-center">
                        @auth
                            @if (Auth::check() && (Auth::id() == $comment->user_id || Auth::user()->is_admin))
                                <form method="POST" action="{{ route('comments.delete', ['commentId' => $comment->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            @endif
                            <div class="d-flex align-items-center">
                                <form method="POST" action="{{ route('comments.like', ['commentId' => $comment->id]) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Me gusta">
                                        <i class="bi bi-hand-thumbs-up"></i> Me gusta
                                        <span class="badge bg-success"
                                            id="likes-count-{{ $comment->id }}">{{ $comment->likes }}</span>
                                    </button>
                                </form>
                                <form method="POST"
                                    action="{{ route('comments.dislike', ['commentId' => $comment->id]) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger ms-2" title="No me gusta">
                                        <i class="bi bi-hand-thumbs-down"></i> No me gusta
                                        <span class="badge bg-danger"
                                            id="dislikes-count-{{ $comment->id }}">{{ $comment->dislikes }}</span>
                                    </button>
                                </form>
                                <form method="POST"
                                    action="{{ route('comments.report', ['commentId' => $comment->id]) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-info ms-2" title="Reportar">
                                        Reportar
                                        <span class="badge bg-info"
                                            id="reports-count-{{ $comment->id }}">{{ $comment->reports }}</span>
                                    </button>
                                </form>
                            </div>
                        @endauth

                        @guest
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success me-2" title="Likes">{{ $comment->likes }} Likes</span>
                                <span class="badge bg-danger me-2" title="Dislikes">{{ $comment->dislikes }}
                                    Dislikes</span>
                                <span class="badge bg-info" title="Reports">{{ $comment->reports }} Reports</span>
                            </div>
                        @endguest
                    </div>
                </div>
            @endforeach
        </div>
        <div class=" text-center mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#commentModal{{ $editionBook->id }}">
                <i class="bi bi-chat-square-text"></i> Comentar
            </button>
        </div>
    </div>
@else
    <!-- No hay comentarios -->
    <div class=" w-100 mt-5 border border-dark rounded p-4 bg-light mb-5">
        <h3 class="mb-4 text-center text-primary">Comentarios</h3>
        <div class="comments-section w-100 mt-5 border border-dark rounded p-4 bg-light mb-5">
            <p class="mt-3 text-center">No hay comentarios para este libro.</p>
        </div>
        <div class=" text-center mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#commentModal{{ $editionBook->id }}">
                <i class="bi bi-chat-square-text"></i> Comentar
            </button>
        </div>
    </div>
@endif
<!-- Botón para abrir el modal de comentarios siempre visible -->


<!-- Modal para Comentarios -->
<div class="modal fade" id="commentModal{{ $editionBook->id }}" tabindex="-1" aria-labelledby="commentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentModalLabel">Comentar sobre
                    {{ $editionBook->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario para comentarios -->
                <form method="post" action="{{ route('comments.add', ['id' => $editionBook->id]) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="comment">Tu comentario:</label>
                        <textarea class="form-control" name="comment" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Comentar</button>
                </form>
            </div>
        </div>
    </div>
</div>




{{-- <!-- Agrega esto en el encabezado de tu archivo Blade -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


<script>
    function deleteComment(commentId) {
        if (confirm('¿Estás seguro de que quieres eliminar este comentario?')) {
            // Realizar la llamada AJAX para eliminar el comentario
            axios.delete(`/comments/${commentId}`)
                .then(response => {
                    // Después de eliminar, puedes recargar la página o actualizar los comentarios con AJAX
                })
                .catch(error => {
                    console.error('Error al eliminar el comentario', error);
                });
        }
    }

    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function likeComment(commentId) {
    axios.post(`/comments/${commentId}/like`)
        .then(response => {
            // Actualizar la cantidad de likes y refrescar la interfaz
            const likesCountElement = document.getElementById(`likes-count-${commentId}`);
            likesCountElement.innerText = response.data.likes;
        })
        .catch(error => {
            console.error('Error al dar like al comentario', error);
        });
}

function dislikeComment(commentId) {
    axios.post(`/comments/${commentId}/dislike`)
        .then(response => {
            // Actualizar la cantidad de dislikes y refrescar la interfaz
            const dislikesCountElement = document.getElementById(`dislikes-count-${commentId}`);
            dislikesCountElement.innerText = response.data.dislikes;
        })
        .catch(error => {
            console.error('Error al dar dislike al comentario', error);
        });
}

function reportComment(commentId) {
    axios.post(`/comments/${commentId}/report`)
        .then(response => {
            // Actualizar la cantidad de reports y refrescar la interfaz
            const reportsCountElement = document.getElementById(`reports-count-${commentId}`);
            reportsCountElement.innerText = response.data.reports;
        })
        .catch(error => {
            console.error('Error al reportar el comentario', error);
        });
}
</script>
 --}}
