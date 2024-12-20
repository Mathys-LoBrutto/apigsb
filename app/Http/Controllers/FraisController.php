<?php

namespace App\Http\Controllers;

use App\dao\FraisService;
use App\Models\Frai;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FraisController extends Controller
{
    public function listeFrais($idfrais){

        try {
            $FraisService = new FraisService();
            $monfrais = $FraisService->EtatService($idfrais);

            $visiteur=Auth::user();
            if ($monfrais->id_visiteur != $visiteur->id_visiteur)
                return redirect(route('login'));


            return response()->json($monfrais);

        }catch(QueryException $e){
            throw new MonExeption ($e->getMessage());
        }
    }

    public function ajoutFrais(Request $request){
        try {
            $FraisService = new FraisService();
            $Frais =new Frai();
            $Frais->id_visiteur = $request->json('id_visiteur');
            $Frais->id_etat = 2;
            $Frais->anneemois = $request->json('anneemois');
            $Frais->nbjustificatifs = $request->json('nbjustificatifs');
            $Frais->datemodification=now();
            $FraisService->FraisAjout($Frais);

            return response()->json(['message : '=> 'Insertion réalisée', 'id_frais :'=>$Frais->id_frais]);
        } catch(QueryException $e){
            throw new MonExeption ($e->getMessage());
        }


    }

    public function modifFrais(Request $request){
        try {
            $FraisService = new FraisService();
            $Frais = new Frai();
            $Frais->id_frais = $request->json('id_frais');
            $Frais->anneemois = $request->json('anneemois');
            $Frais->id_visiteur = $request->json('id_visiteur');
            $Frais->nbjustificatifs = $request->json('nbjustificatifs');
            $Frais->montantvalide = $request->json('montantvalide');
            $Frais->id_etat = $request->json('id_etat');
            $Frais->datemodification=now();

            $FraisService->FraisModif($Frais);

            return response()->json(['message : '=> 'Modification réalisée', 'id_frais :'=>$Frais->id_frais]);

        }catch(QueryException $e){
            throw new MonExeption ($e->getMessage());
        }


    }


    public function supprFrais(Request $request){
        try {
            $FraisService = new FraisService();

            $id_Frais= $request->json('id_frais');
            $FraisService->supprFrais($id_Frais);

            return response()->json(['message : '=> 'Supression réalisée', 'id_frais :'=>$id_Frais]);

        }catch(QueryException $e){
            throw new MonExeption ($e->getMessage());
        }
    }

    public function listeFraisVisiteur($idVisiteur)
    {
        try {
            $FraisService = new FraisService();
            $fraisVisiteur = $FraisService->FraisVisiteur($idVisiteur);


            return response()->json($fraisVisiteur);

        }catch(QueryException $e){
            throw new MonExeption ($e->getMessage());
        }
    }
}
