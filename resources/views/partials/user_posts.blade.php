<style>
    .posts-section {
        max-height: 400px;
        /* Ajusta la altura máxima según tus necesidades */
        overflow-y: auto;
    }
</style>

@if (count($userPosts) > 0)
    <div class=" w-100 mt-5 border border-dark rounded p-4 bg-light mb-5">
        <h3 class="mb-4 text-center text-primary">Posts</h3>
        <div class="posts-section w-100 mt-5 border border-dark rounded p-4 bg-light mb-5">
            @foreach ($userPosts as $post)
                <div class="post mb-4 p-3 border border-dark rounded bg-white">
                    <div class="user-info mb-2 d-flex justify-content-between">
                        <div class="fw-bold text-primary">{{ $post->user->nickname }} : <h4 class="text-black">
                                <ins>{{ $post->post_title }}</ins> </h4>
                        </div>

                        <div class="text-muted">{{ $post->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="post-body">
                        {{ $post->post_content }}
                    </div>
                    <div class="interaction mt-3 d-flex justify-content-between align-items-center">
                        @auth
                            @if (Auth::check() && (Auth::id() == $post->user_id || Auth::user()->is_admin))
                                <!-- Add your delete button and modal here -->
                                <button type="button" class="btn btn-sm btn-outline-danger" title="Eliminar"
                                    data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $post->id }}">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                                <!-- Modal de Confirmación -->
                                <div class="modal fade" id="confirmDeleteModal{{ $post->id }}" tabindex="-1"
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
                                                    action="{{ route('user_post.delete', ['postId' => $post->id]) }}">
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
                                <form id="likeForm{{ $post->id }}" method="POST"
                                    action=" {{ route('post.like.ajax', ['postId' => $post->id]) }}">
                                    @csrf
                                    <button type="button" class="btn btn-sm btn-outline-success like-btn me-2"
                                        title="Me gusta" onclick="likePost({{ $post->id }})">
                                        <i class="bi bi-hand-thumbs-up"></i> Me gusta
                                        <span class="badge bg-success"
                                            id="likes-count-{{ $post->id }}">{{ $post->getLikes() }}</span>
                                    </button>
                                </form>
                                <form id="dislikeForm{{ $post->id }}" method="POST"
                                    action="{{ route('post.dislike.ajax', ['postId' => $post->id]) }}">
                                    @csrf
                                    <button type="button" class="btn btn-sm btn-outline-danger dislike-btn"
                                        title="No me gusta" onclick="dislikePost({{ $post->id }})">
                                        <i class="bi bi-hand-thumbs-down"></i> No me gusta
                                        <span class="badge bg-danger"
                                            id="dislikes-count-{{ $post->id }}">{{ $post->getDislikes() }}</span>
                                    </button>
                                </form>
                                <form id="reportForm{{ $post->id }}" method="POST"
                                    action="{{ route('post.report.ajax', ['postId' => $post->id]) }}">
                                    @csrf
                                    <button type="button" class="btn btn-sm btn-outline-info ms-2" title="Reportar"
                                        onclick="reportPost({{ $post->id }})">
                                        Reportar
                                        <span class="badge bg-info"
                                            id="reports-count-{{ $post->id }}">{{ $post->getReports() }}</span>
                                    </button>
                                </form>
                            </div>

                        @endauth

                        @guest
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success me-2" title="Likes">{{ $post->getlikes() }} Likes</span>
                                <span class="badge bg-danger me-2" title="Dislikes">{{ $post->getDislikes() }}
                                    Dislikes</span>
                                <span class="badge bg-info" title="Reports">{{ $post->getReports() }} Reports</span>
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
        <div class="posts-section w-100 mt-5 border border-dark rounded p-4 bg-light mb-5">
            <p class="mt-3 text-center">No hay comentarios para este libro.</p>
        </div>
    </div>
@endif
<!-- Botón para abrir el modal de comentarios siempre visible -->




<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    function likePost(postId) {
        var form = $('#likeForm' + postId);

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                // Actualizar el recuento de "Me gusta" en el DOM
                $('#dislikes-count-' + postId).text(response.dislikes);
                $('#likes-count-' + postId).text(response.likes);
                // Actualizar el recuento de "No me gusta" en el DOM (puede que sea necesario si cambió de dislike a like)
            },
            error: function(error) {
                var errorMessage = (error.responseJSON && error.responseJSON.error) ? error.responseJSON
                    .error : 'Error desconocido';
                alert('Error: ' + errorMessage);
            }
        });
    }

    function dislikePost(postId) {
        var form = $('#dislikeForm' + postId);

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                // Actualizar el recuento de "No me gusta" en el DOM
                $('#dislikes-count-' + postId).text(response.dislikes);
                // Actualizar el recuento de "Me gusta" en el DOM (puede que sea necesario si cambió de like a dislike)
                $('#likes-count-' + postId).text(response.likes);
            },
            error: function(error) {
                var errorMessage = (error.responseJSON && error.responseJSON.error) ? error.responseJSON
                    .error : 'Error desconocido';
                alert('Error: ' + errorMessage);
            }
        });
    }


    function reportPost(postId) {
        var form = $('#reportForm' + postId);

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {


                // Actualizar el recuento de "Reportes" en el DOM
                $('#reports-count-' + postId).text(response.reports);

            },
            error: function(error) {
                var errorMessage = (error.responseJSON && error.responseJSON.error) ? error.responseJSON
                    .error : 'Error desconocido';
                alert('Error: ' + errorMessage);
            }
        });
    }
</script>
