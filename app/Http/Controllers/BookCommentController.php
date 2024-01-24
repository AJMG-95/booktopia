<?php

namespace App\Http\Controllers;

use App\Models\BookComment;
use App\Models\CommentLdr;
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
     * Marcar un comentario como "like" a través de Ajax.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $commentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function likeCommentAjax(Request $request, $commentId)
    {
        // Validar si el comentario existe
        $comment = BookComment::find($commentId);

        if (!$comment) {
            return response()->json(['error' => 'El comentario no existe.'], 404);
        }

        $existingLike = $comment->likes()->where('user_id', Auth::id())->first();

        if ($existingLike) {
            // Si ya le dio "like", eliminar el registro existente
            $existingLike->delete();

            // Obtener el nuevo recuento de "Me gusta"
            $newLikesCount = $comment->likes()->count();

            return response()->json(['message' => 'Has retirado tu "Me gusta" al comentario.', 'likes' => $newLikesCount]);
        }


        // Verificar si el usuario ya le dio "dislike" al comentario
        $existingDislike = $comment->dislikes()->where('user_id', Auth::id())->first();

        if ($existingDislike) {
            // Si ya le dio "dislike", actualiza el registro existente a "like"
            $existingDislike->update(['dislikes' => false, 'likes' => true]);

             // Obtener el nuevo recuento de "Me gusta"
             $newLikesCount = $comment->likes()->count();
             $newDislikesCount = $comment->dislikes()->count();

            return response()->json(['message' => 'Comentario marcado como "Me gusta".', 'likes' => $newLikesCount, 'dislikes' => $newDislikesCount]);
        }



        // Agregar "like" al comentario
        $comment->likes()->create([
            'user_id' => Auth::id(),
            'likes' => true,
        ]);

        // Obtener el nuevo recuento de "Me gusta"
        $newLikesCount = $comment->likes()->count();

        return response()->json(['message' => 'Comentario marcado como "Me gusta".', 'likes' => $newLikesCount]);
    }

    /**
     * Marcar un comentario como "dislike" a través de Ajax.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $commentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function dislikeCommentAjax(Request $request, $commentId)
    {
        // Validar si el comentario existe
        $comment = BookComment::find($commentId);

        if (!$comment) {
            return response()->json(['error' => 'El comentario no existe.'], 404);
        }

        // Verificar si el usuario ya le dio "like" al comentario
        $existingLike = $comment->likes()->where('user_id', Auth::id())->first();

        if ($existingLike) {
            // Si ya le dio "like", actualiza el registro existente a "dislike"
            $existingLike->update(['likes' => false, 'dislikes' => true]);

            // Obtener el nuevo recuento de "No me gusta"
            $newDislikesCount = $comment->dislikes()->count();
            $newLikesCount = $comment->likes()->count();

            return response()->json(['message' => 'Has cambiado tu "Me gusta" a "No me gusta".', 'dislikes' => $newDislikesCount, 'likes' => $newLikesCount]);
        }

        // Verificar si el usuario ya le dio "dislike" al comentario
        $existingDislike = $comment->dislikes()->where('user_id', Auth::id())->first();

        if ($existingDislike) {
            // Si ya le dio "dislike", eliminar el registro existente
            $existingDislike->delete();

            // Obtener el nuevo recuento de "No me gusta"
            $newDislikesCount = $comment->dislikes()->count();

            return response()->json(['message' => 'Has retirado tu "No me gusta" al comentario.', 'dislikes' => $newDislikesCount]);
        }

        // Agregar "dislike" al comentario
        $comment->dislikes()->create([
            'user_id' => Auth::id(),
            'dislikes' => true,
        ]);

        // Obtener el nuevo recuento de "No me gusta"
        $newDislikesCount = $comment->dislikes()->count();

        return response()->json(['message' => 'Comentario marcado como "No me gusta".', 'dislikes' => $newDislikesCount]);
    }


    /**
     * Reportar un comentario a través de Ajax.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $commentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function reportCommentAjax(Request $request, $commentId)
    {
        // Validar si el comentario existe
        $comment = BookComment::find($commentId);

        if (!$comment) {
            return response()->json(['error' => 'El comentario no existe.'], 404);
        }

        // Verificar si el usuario ya reportó el comentario
        $existingReport = $comment->reports()->where('user_id', Auth::id())->first();

        if ($existingReport) {
            // Si ya reportó, eliminar el registro existente
            $existingReport->delete();
            $newReportsCount = $comment->reports()->count();
            return response()->json(['message' => 'Has retirado tu reporte al comentario.', 'reports' => $newReportsCount]);
        }

        // Agregar report al comentario
        $comment->reports()->create([
            'user_id' => Auth::id(),
            'reports' => true,
        ]);

        // Obtener el nuevo recuento de "Reportes"
        $newReportsCount = $comment->reports()->count();

        return response()->json(['message' => 'Comentario reportado.', 'reports' => $newReportsCount]);
    }

    /**
     * Eliminar un comentario y sus referencias.
     *
     * @param  int  $commentId
     * @return \Illuminate\Http\Response
     */
    public function deleteComment($commentId)
    {
        // Buscar el comentario por ID
        $comment = BookComment::find($commentId);

        // Verificar si el comentario existe
        if (!$comment) {
            return redirect()->back()->with('error', 'El comentario no existe.');
        }

        // Verificar si el usuario tiene permisos para eliminar el comentario
        if ($comment->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'No tienes permisos para eliminar este comentario.');
        }

        // Eliminar referencias desde comment_ldrs
        $comment->likes()->delete();
        $comment->dislikes()->delete();
        $comment->reports()->delete();

        // Eliminar el comentario
        $comment->delete();

        return redirect()->back()->with('success', 'Comentario y referencias eliminados correctamente.');
    }
}
