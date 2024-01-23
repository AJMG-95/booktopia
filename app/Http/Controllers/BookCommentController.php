<?php

namespace App\Http\Controllers;

use App\Models\BookComment;
use Illuminate\Http\Request;
use App\Models\EditionBook;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class BookCommentController extends Controller
{
    /**
     * Almacena un nuevo comentario para un libro.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addComment(Request $request, $id)
    {
        try {
            $request->validate([
                'comment' => 'required|string|max:255',
            ]);

            // Obtén el libro
            $book = EditionBook::findOrFail($id);

            // Crea un nuevo comentario
            $comment = new BookComment([
                'user_id' => Auth::id(), // Ajusta esto según cómo manejas la autenticación
                'book_id' => $book->id,
                'body' => $request->input('comment'),
            ]);

            $comment->save();

            return redirect()->back()->with('success', '¡Comentario agregado con éxito!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al agregar el comentario.');
        }
    }

    /**
     * Dar like a un comentario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $commentId
     * @return \Illuminate\Http\Response
     */
    public function likeComment (Request $request, $commentId)
    {
        $comment = BookComment::findOrFail($commentId);
        $comment->increment('likes');

        return redirect()->back();
    }

    /**
     * Dar dislike a un comentario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $commentId
     * @return \Illuminate\Http\Response
     */
    public function dislikeComment (Request $request, $commentId)
    {
        $comment = BookComment::findOrFail($commentId);
        $comment->increment('dislikes');

        return redirect()->back();
    }

    /**
     * Reportar un comentario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $commentId
     * @return \Illuminate\Http\Response
     */
    public function reportComment (Request $request, $commentId)
    {
        $comment = BookComment::findOrFail($commentId);
        $comment->increment('reports');

        return redirect()->back();
    }

    /**
     * Elimina un comentario.
     *
     * @param  int  $commentId
     * @return \Illuminate\Http\Response
     */
    public function deleteComment($commentId)
    {
        try {
            $comment = BookComment::findOrFail($commentId);

            // Verifica si el usuario tiene permisos para eliminar el comentario
            if (Auth::check() && (Auth::id() == $comment->user_id || Auth::user()->is_admin)) {
                $comment->delete();

                return redirect()->back()->with('success', '¡Comentario eliminado con éxito!');
            }

            return redirect()->back()->with('error', 'No tienes permisos para eliminar este comentario.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al eliminar el comentario. Detalles: ' . $e->getMessage());
        }
    }
}
