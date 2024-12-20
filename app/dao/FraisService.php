<?php

namespace App\dao;

use App\Models\Frai;
use App\Models\Etat;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class FraisService
{
    public function EtatService($idfrais){
        try {
            $unfrais = Frai::query()->select()->join('Etat' , 'Frais.id_etat', '=', 'Etat.id_etat' )->where('id_frais' ,'=', $idfrais )->first();


            return $unfrais;

        }catch(Exception $e){
            return response()->json(['status'=>$e->getMessage()]);
        }

    }

    public function FraisAjout(Frai $Frais){
        try {
            $Frais->save();
        }catch(QueryException $e){
            throw new MonExeption ($e->getMessage());
        }
    }

    public function FraisModif($Frais)
    {
        try {
            $Frais->update();


        }catch(QueryException $e){
            throw new MonExeption ($e->getMessage());
        }
    }

    public function supprFrais($id_frais){
        try {
            Frai::destroy($id_frais);


        }catch(QueryException $e){
            throw new MonExeption ($e->getMessage());
        }
    }

    public function FraisVisiteur($idVisiteur)
    {
        try {
            $FraisVisiteur =  Frai::query()->select()->join('Etat' , 'Frais.id_etat', '=', 'Etat.id_etat' )->where('id_visiteur' ,'=', $idVisiteur )->get();
            return $FraisVisiteur;
        }catch(QueryException $e){
            throw new MonExeption ($e->getMessage());
        }

    }
}
