<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produits = Produit::all();
        if (count($produits) <= 0) {
            return response(['message' => "Aucun produits trouves"], 200);
        }
        return response($produits, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $produitsvalidation = $request->validate([
            'nom' => ['required', 'string'],
            'description' => ['required', 'string'],
            'categorie' => ['required', 'string'],
            'prix' => ['required', 'numeric'],
            'user_id' => ['required', 'numeric']
        ]);

        $produit = Produit::create([
            'nom' => $produitsvalidation['nom'],
            'description' => $produitsvalidation['description'],
            'categorie' => $produitsvalidation['categorie'],
            'prix' =>  $produitsvalidation['prix'],
            'user_id' =>  $produitsvalidation['user_id']
        ]);

        return response(['message' => 'Voiture ajoutee'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $produit = DB::table('produits')
            ->join("users", 'produits.user_id', '=', 'users.id')
            ->select("produits.*", "users.name", "users.email")
            ->where("produits.id", '=', $id)
            ->get()
            ->first();
        return $produit;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $produitsvalidation = $request->validate([
            'nom' => ['string'],
            'description' => ['string'],
            'categorie' => ['string'],
            'prix' => ['numeric'],
            'user_id' => ['required', 'numeric']
        ]);

        $produit = Produit::find($id);
        if (!$produit) {
            return response(['message' => "Aucun produits trouves avec cette id $id"], 404);
        }

        if ($produit->user_id != $produitsvalidation['user_id']) {
            return response(['message' => "Action interdite"], 403);
        }

        $produit->update($produitsvalidation);
        return response(['message' => 'produit maj.'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $produitsvalidation = $request->validate([


            'user_id' => ['required', 'numeric']
        ]);

        $produit = Produit::find($id);
        if (!$produit) {
            return response(['message' => "Aucun produits trouves avec cette id $id"], 404);
        }

        if ($produit->user_id != $produitsvalidation['user_id']) {
            return response(['message' => "Action interdite"], 403);
        }

        $value = Produit::destroy($id);
        if (boolval($value) == false) {
            return response(['message' => "Aucun produits trouves avec cette id $id"], 404);
        }
        return response(['message' => 'produit supprime!']);
    }
}
