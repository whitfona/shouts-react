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
            'photo' => [ 'sometimes', 'max:5000', 'nullable',
                function ($attribute, $value, $fail) {
                    if (!is_string($value) && !($value instanceof UploadedFile)) {
                        $fail('The '.$attribute.' must either be a string or file.');
                    }
                }
            ],
        ]);

        $photoName = $request->photo;
        if ($request->photo && !$request->photo instanceof UploadedFile) {
            $split = preg_split("/(https:\/\/itsyourshout.ca\/storage\/beers\/)|(http:\/\/localhost:8000\/storage\/beers\/)/", $request->photo);
            $photoName = $split[1];
        }
        if ($request->photo && $request->photo instanceof UploadedFile) {
            $photoName = time() . '.' . 'jpg';
            Image::make($request->file('photo'))
                ->resize(512, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->orientate()
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
