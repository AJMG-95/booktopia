<?php

namespace App\Http\Controllers;

use App\Models\UserPost;
use App\Models\UserPostLdr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class UserPostController extends Controller
{

        /**
     * Muestra la lista de posts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $posts = UserPost::all(); // Esto es solo un ejemplo; puedes ajustar según tus necesidades

        return view('layouts/forum/index', ['posts' => $posts]);
    }

    /**
     * Almacena un nuevo post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addPost(Request $request)
    {
        try {
            $request->validate([
                'post_title' => 'nullable|string|max:50',
                'post_content' => 'required|string|max:255',
            ]);

            // Crea un nuevo post
            $post = new UserPost([
                'user_id' => Auth::id(), // Ajusta esto según cómo manejas la autenticación
                'post_title' => $request->input('post_title'),
                'post_content' => $request->input('post_content'),
            ]);

            $post->save();

            return redirect()->back()->with('success', '¡Post agregado con éxito!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al agregar el post.');
        }
    }

    /**
     * Marcar un post como "like" a través de Ajax.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $postId
     * @return \Illuminate\Http\JsonResponse
     */
    public function likePostAjax(Request $request, $postId)
    {
        // Validar si el post existe
        $post = UserPost::find($postId);

        if (!$post) {
            return response()->json(['error' => 'El post no existe.'], 404);
        }

        $existingLike = $post->likes()->where('user_id', Auth::id())->first();

        if ($existingLike) {
            // Si ya le dio "like", eliminar el registro existente
            $existingLike->delete();

            // Obtener el nuevo recuento de "Me gusta"
            $newLikesCount = $post->likes()->count();

            return response()->json(['message' => 'Has retirado tu "Me gusta" al post.', 'likes' => $newLikesCount]);
        }

        // Verificar si el usuario ya le dio "dislike" al post
        $existingDislike = $post->dislikes()->where('user_id', Auth::id())->first();

        if ($existingDislike) {
            // Si ya le dio "dislike", actualiza el registro existente a "like"
            $existingDislike->update(['dislikes' => false, 'likes' => true]);

            // Obtener el nuevo recuento de "Me gusta" y "No me gusta"
            $newLikesCount = $post->likes()->count();
            $newDislikesCount = $post->dislikes()->count();

            return response()->json(['message' => 'Post marcado como "Me gusta".', 'likes' => $newLikesCount, 'dislikes' => $newDislikesCount]);
        }

        // Agregar "like" al post
        $post->likes()->create([
            'user_id' => Auth::id(),
            'likes' => true,
        ]);

        // Obtener el nuevo recuento de "Me gusta"
        $newLikesCount = $post->likes()->count();

        return response()->json(['message' => 'Post marcado como "Me gusta".', 'likes' => $newLikesCount]);
    }

    /**
     * Marcar un post como "dislike" a través de Ajax.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $postId
     * @return \Illuminate\Http\JsonResponse
     */
    public function dislikePostAjax(Request $request, $postId)
    {
        // Validar si el post existe
        $post = UserPost::find($postId);

        if (!$post) {
            return response()->json(['error' => 'El post no existe.'], 404);
        }

        // Verificar si el usuario ya le dio "like" al post
        $existingLike = $post->likes()->where('user_id', Auth::id())->first();

        if ($existingLike) {
            // Si ya le dio "like", actualiza el registro existente a "dislike"
            $existingLike->update(['likes' => false, 'dislikes' => true]);

            // Obtener el nuevo recuento de "No me gusta" y "Me gusta"
            $newDislikesCount = $post->dislikes()->count();
            $newLikesCount = $post->likes()->count();

            return response()->json(['message' => 'Has cambiado tu "Me gusta" a "No me gusta".', 'dislikes' => $newDislikesCount, 'likes' => $newLikesCount]);
        }

        // Verificar si el usuario ya le dio "dislike" al post
        $existingDislike = $post->dislikes()->where('user_id', Auth::id())->first();

        if ($existingDislike) {
            // Si ya le dio "dislike", eliminar el registro existente
            $existingDislike->delete();

            // Obtener el nuevo recuento de "No me gusta"
            $newDislikesCount = $post->dislikes()->count();

            return response()->json(['message' => 'Has retirado tu "No me gusta" al post.', 'dislikes' => $newDislikesCount]);
        }

        // Agregar "dislike" al post
        $post->dislikes()->create([
            'user_id' => Auth::id(),
            'dislikes' => true,
        ]);

        // Obtener el nuevo recuento de "No me gusta"
        $newDislikesCount = $post->dislikes()->count();

        return response()->json(['message' => 'Post marcado como "No me gusta".', 'dislikes' => $newDislikesCount]);
    }

    /**
     * Reportar un post a través de Ajax.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $postId
     * @return \Illuminate\Http\JsonResponse
     */
    public function reportPostAjax(Request $request, $postId)
    {
        // Validar si el post existe
        $post = UserPost::find($postId);

        if (!$post) {
            return response()->json(['error' => 'El post no existe.'], 404);
        }

        // Verificar si el usuario ya reportó el post
        $existingReport = $post->reports()->where('user_id', Auth::id())->first();

        if ($existingReport) {
            // Si ya reportó, eliminar el registro existente
            $existingReport->delete();
            $newReportsCount = $post->reports()->count();
            return response()->json(['message' => 'Has retirado tu reporte al post.', 'reports' => $newReportsCount]);
        }

        // Agregar report al post
        $post->reports()->create([
            'user_id' => Auth::id(),
            'reports' => true,
        ]);

        // Obtener el nuevo recuento de "Reportes"
        $newReportsCount = $post->reports()->count();

        return response()->json(['message' => 'Post reportado.', 'reports' => $newReportsCount]);
    }

    /**
     * Eliminar un post y sus referencias.
     *
     * @param  int  $postId
     * @return \Illuminate\Http\Response
     */
    public function deletePost($postId)
    {
        // Buscar el post por ID
        $post = UserPost::find($postId);

        // Verificar si el post existe
        if (!$post) {
            return redirect()->back()->with('error', 'El post no existe.');
        }

        // Verificar si el usuario tiene permisos para eliminar el post
        if ($post->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'No tienes permisos para eliminar este post.');
        }

        // Eliminar referencias desde user_post_ldrs
        $post->likes()->delete();
        $post->dislikes()->delete();
        $post->reports()->delete();

        // Eliminar el post
        $post->delete();

        return redirect()->back()->with('success', 'Post y referencias eliminados correctamente.');
    }
}
