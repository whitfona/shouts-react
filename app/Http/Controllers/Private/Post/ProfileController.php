<?php

namespace App\Http\Controllers\Private\Post;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    /**
     * POST update user profile information
     *
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'numeric', 'gte:0'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'id')->ignore($request->user_id)],
            'photo' => ['sometimes', 'mimes:heic,jpg,jpeg,png,bmp,gif,svg,webp', 'max:5000', 'nullable'],
        ]);

        $photoName = $request->photo;
        if ($request->photo && $request->photo instanceof UploadedFile) {
            $photoName = time() . '.' . 'jpg';
            Image::make($request->file('photo'))
                ->resize(512, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('/storage/users/') . $photoName);
        }

        $user = User::find($request->user_id);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($photoName) {
            $user->profile_image = $photoName;
        }

        $user->save();

        return redirect(route('profile'))->with('message', 'Profile successfully saved.');
    }
}
