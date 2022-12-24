<?php

namespace App\Http\Controllers\Private\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class ProfileUpdateController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'id')->ignore($request->user()->id)],
            'profile_image' => [ 'sometimes', 'max:5000', 'nullable',
                function ($attribute, $value, $fail) {
                    if (!is_string($value) && !($value instanceof UploadedFile)) {
                        $fail('The '.$attribute.' must either be a string or file.');
                    }
                }
            ],
        ]);

        $photoName = $request->profile_image;
        if ($request->profile_image && $request->profile_image instanceof UploadedFile) {
            $photoName = time() . '.' . 'jpg';
            Image::make($request->file('photo'))
                ->resize(512, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->orientate()
                ->save(public_path('/storage/users/') . $photoName);
        }

        $user = User::find($request->user()->id);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($photoName) {
            $user->profile_image = $photoName;
        }

        $user->save();

        return response('Profile successfully updated.', 200);
    }
}
