<?php

namespace App\Services\CP\User;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService
{
    public function getLoggedUser()
    {
        return auth()->user();
    }

    public function getUserId()
    {
        return $this->getLoggedUser()->id;
    }

    public function getUserWithProfile($userId)
    {
        return User::
//            ->active()
            where('id', $userId)->first();
    }

    public function update(User $user, array $data): void
    {
        if (Arr::has($data, 'password')) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);
    }

    public function uploadImage(string $image): string
    {
        $mimeInfo = explode('/', mime_content_type($image));
        $extension = end($mimeInfo);
        $imageName = Str::uuid().time().'.'.$extension;
        $sign = explode('base64,', $image);
        $sign = end($sign);
        $sign = str_replace(' ', '+', $sign);

        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));

        $publicPath = public_path('uploads/users/');

        file_put_contents($publicPath.$imageName, $imageData);

        return $imageName;
    }

    public function restrictUser(string $userId): void
    {
        User::where('id', $userId)->update([
            'restricted' => true,
        ]);
    }
}
