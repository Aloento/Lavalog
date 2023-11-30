<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LikeController extends Controller
{
  public function show(Chirp $chirp): JsonResponse
  {
    $isLiked = $chirp->likes()->where('user_id', auth()->id())->exists();
    return response()->json(['isLiked' => $isLiked]);
  }

  public function store(Request $request)
  {
    auth()->user()->likes()->create([
      'user_id' => auth()->id(),
      'chirp_id' => $request->chirp_id,
    ]);
  }

  public function destroy(Chirp $chirp)
  {
    $this->authorize('delete', $chirp);

    $chirp->likes()->where('user_id', auth()->id())->delete();
  }
}
