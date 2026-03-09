<?php
namespace App\Http\Controllers;

use App\Models\Level;

class LevelController extends Controller
{
    public function show(Level $level)
    {
        $user = Auth::user();

        // التحقق من أن المستخدم لديه كوبون صالح لهذا المستوى
        $hasAccess = $user->subscribedLevels->contains($level->id);

        if (! $hasAccess) {
            abort(403, 'غير مصرح لك بمشاهدة هذا المحتوى.');
        }

        $videos = $level->videos;
        return view('level.show', compact('level', 'videos'));
    }
}
