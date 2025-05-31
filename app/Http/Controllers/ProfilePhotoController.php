<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfilePhotoController extends Controller
{
    /**
     * Télécharger une nouvelle photo de profil
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Supprimer l'ancienne photo si elle existe
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        // Stocker la nouvelle image
        $path = $request->file('profile_photo')->store('profile-photos', 'public');

        // Mettre à jour le chemin de la photo dans la base de données
        $user->profile_photo_path = $path;
        $user->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Photo de profil mise à jour avec succès',
                'photo_url' => $user->profile_photo_url
            ]);
        }

        return redirect()->back()->with('success', 'Photo de profil mise à jour avec succès.');
    }

    /**
     * Supprimer la photo de profil actuelle
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();

        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);

            $user->profile_photo_path = null;
            $user->save();
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Photo de profil supprimée avec succès',
                'photo_url' => $user->profile_photo_url
            ]);
        }

        return redirect()->back()->with('success', 'Photo de profil supprimée avec succès.');
    }
}