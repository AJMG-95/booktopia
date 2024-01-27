<style>
    .comments-section {
        max-height: 400px;
        /* Ajusta la altura máxima según tus necesidades */
        overflow-y: auto;
    }
</style>

@if (count($userComments) > 0)
    <div class=" w-100 mt-5 border border-dark rounded p-4 bg-light mb-5">
        <h3 class="mb-4 text-center text-primary">Comentarios</h3>
        <div class="comments-section w-100 mt-5 border border-dark rounded p-4 bg-light mb-5">
            @foreach ($userComments as $comment)
                <div class="comment mb-4 p-3 border border-dark rounded bg-white">
                    <div class="user-info mb-2 d-flex justify-content-between">
                        <div class="fw-bold text-primary">{{ $comment->user->nickname ? $comment->user->nickname : "Usuario Eliminado"}}</div>
                        <div class="text-muted">{{ $comment->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="comment-body">
                        {{ $comment->body }}
                    </div>
                    <div class="interaction mt-3 d-flex justify-content-between align-items-center">
                        @auth
                            @if (Auth::check() && (Auth::id() == $comment->user_id || Auth::user()->is_admin))
                                <button type="button" class="btn btn-sm btn-outline-danger" title="Eliminar"
                                    data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $comment->id }}">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>

                                <!-- Modal de Confirmación -->
                                <div class="modal fade" id="confirmDeleteModal{{ $comment->id }}" tabindex="-1"
                                    aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar eliminación
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Estás seguro de que deseas eliminar este comentario?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancelar</button>
                                                <form method="POST"
                                                    action="{{ route('comments.delete', ['commentId' => $comment->id]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="d-flex align-items-center">
                                <form id="likeForm{{ $comment->id }}" method="POST"
                                    action="{{ route('comments.like.ajax', ['commentId' => $comment->id]) }}">
                                    @csrf
                                    <button type="button" class="btn btn-sm btn-outline-success like-btn" title="Me gusta"
                                        onclick="likeComment({{ $comment->id }})">
                                        <i class="bi bi-hand-thumbs-up"></i> Me gusta
                                        <span class="badge bg-success"
                                            id="likes-count-{{ $comment->id }}">{{ $comment->getLikes() }}</span>
                                    </button>
                                </form>
                                <form id="dislikeForm{{ $comment->id }}" method="POST"
                                    action="{{ route('comments.dislike.ajax', ['commentId' => $comment->id]) }}">
                                    @csrf
                                    <button type="button" class="btn btn-sm btn-outline-danger dislike-btn"
                                        title="No me gusta" onclick="dislikeComment({{ $comment->id }})">
                                        <i class="bi bi-hand-thumbs-down"></i> No me gusta
                                        <span class="badge bg-danger"
                                            id="dislikes-count-{{ $comment->id }}">{{ $comment->getDislikes() }}</span>
                                    </button>
                                </form>
                                <form id="reportForm{{ $comment->id }}" method="POST"
                                    action="{{ route('comments.report.ajax', ['commentId' => $comment->id]) }}">
                                    @csrf
                                    <button type="button" class="btn btn-sm btn-outline-info ms-2" title="Reportar"
                                        onclick="reportComment({{ $comment->id }})">
                                        Reportar
                                        <span class="badge bg-info"
                                            id="reports-count-{{ $comment->id }}">{{ $comment->getReports() }}</span>
                                    </button>
                                </form>
                            </div>
                        @endauth

                        @guest
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success me-2" title="Likes">{{ $comment->getLikes() }} Likes</span>
                                <span class="badge bg-danger me-2" title="Dislikes">{{ $comment->getDislikes() }}
                                    Dislikes</span>
                                <span class="badge bg-info" title="Reports">{{ $comment->getReports() }} Reports</span>
                            </div>
                        @endguest
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@else
    <!-- No hay comentarios -->
    <div class=" w-100 mt-5 border border-dark rounded p-4 bg-light mb-5">
        <h3 class="mb-4 text-center text-primary">Comentarios</h3>
        <div class="comments-section w-100 mt-5 border border-dark rounded p-4 bg-light mb-5">
            <p class="mt-3 text-center">No hay comentarios para este libro.</p>
        </div>

    </div>
@endif

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    function likeComment(commentId) {
        var form = $('#likeForm' + commentId);

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                // Actualizar el recuento de "Me gusta" en el DOM
                $('#dislikes-count-' + commentId).text(response.dislikes);
                $('#likes-count-' + commentId).text(response.likes);
                // Actualizar el recuento de "No me gusta" en el DOM (puede que sea necesario si cambió de dislike a like)
            },
            error: function(error) {
                var errorMessage = (error.responseJSON && error.responseJSON.error) ? error.responseJSON
                    .error : 'Error desconocido';
                alert('Error: ' + errorMessage);
            }
        });
    }

    function dislikeComment(commentId) {
        var form = $('#dislikeForm' + commentId);

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                // Actualizar el recuento de "No me gusta" en el DOM
                $('#dislikes-count-' + commentId).text(response.dislikes);
                // Actualizar el recuento de "Me gusta" en el DOM (puede que sea necesario si cambió de like a dislike)
                $('#likes-count-' + commentId).text(response.likes);
            },
            error: function(error) {
                var errorMessage = (error.responseJSON && error.responseJSON.error) ? error.responseJSON
                    .error : 'Error desconocido';
                alert('Error: ' + errorMessage);
            }
        });
    }


    function reportComment(commentId) {
        var form = $('#reportForm' + commentId);

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {


                // Actualizar el recuento de "Reportes" en el DOM
                $('#reports-count-' + commentId).text(response.reports);

            },
            error: function(error) {
                var errorMessage = (error.responseJSON && error.responseJSON.error) ? error.responseJSON
                    .error : 'Error desconocido';
                alert('Error: ' + errorMessage);
            }
        });
    }
</script>




