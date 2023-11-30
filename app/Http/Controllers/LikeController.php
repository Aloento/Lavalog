<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\RedirectResponse;

class LikeController extends Controller
{
  public function store(Chirp $chirp): RedirectResponse
  {
    $chirp->likes()->create([
      'user_id' => auth()->id(),
    ]);

    return back();
  }

  public function destroy(Chirp $chirp): RedirectResponse
  {
    $this->authorize('delete', $chirp);

    $chirp->likes()->where('user_id', auth()->id())->delete();

    return back();
  }
}
