<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Repositories\Data;
use App\Repositories\Ranking;

class Repository
{
    function createDatabase(): void 
    {
        DB::unprepared(file_get_contents('database/build.sql'));
    }

    function insertTeam(array $team): int
    {
        return DB::table('teams')
                        ->insertGetId($team);
    }

    function insertMatch(array $match): int
    {
        return DB::table('matches')
                        ->insertGetId($match);                              
    }

    function teams(): array
    {
        return DB::table('teams')
                        ->orderBy('id')
                        ->get()
                        ->toArray();
    }

    function matches(): array
    {
        return DB::table('matches')
                        ->orderBy('id')
                        ->get()
                        ->toArray();
    }

    function fillDatabase(): void
    {
        $this->data = new Data();

        $teams = $this->data->teams();
        $matches = $this->data->matches();

        foreach($teams as $team){
            $this->insertTeam($team);
        }
        
        foreach($matches as $match){
            $this->insertMatch($match);
        }

    }

    function team($teamId) : array
    {   

        $array = DB::table('teams')
                        ->where('id', $teamId)
                        ->get()
                        ->toArray();

        if(count($array)==0){
            throw new Exception('Équipe inconnue');
        } 

        return $array[0];  
    }

    function match($matchId) : array
    {   

        $array = DB::table('matches')
                        ->where('id', $matchId)
                        ->get()
                        ->toArray();

        if(count($array)==0){
            throw new Exception('Match inconnu');
        } 

        return $array[0];  
    }

    function updateRanking(): void
    {
        DB::table('ranking')->delete();

        $this->ranking = new Ranking();

        $array = $this->ranking->sortedRanking($this->teams(), $this->matches());

        DB::table('ranking')->insert($array);    

    }

    function sortedRanking() : array
    {        
        return DB::table('ranking')
                    ->join('teams', 'ranking.team_id', '=', 'teams.id')
                    ->orderBy('rank')
                    ->get(['ranking.*', 'teams.name'])
                    ->toArray();
    }

    function teamMatches($teamId) : array
    {
        $matches = DB::table('matches')
                            ->join('teams as teams0', 'matches.team0', '=', 'teams0.id')
                            ->join('teams as teams1', 'matches.team1', '=', 'teams1.id')
                            ->where('matches.team0', $teamId)
                            ->orWhere('matches.team1', $teamId)
                            ->orderBy('m_date')
                            ->get(['matches.*', 'teams0.name as name0', 'teams1.name as name1'])
                            ->toArray();

        return $matches;
    }

    function rankingRow($teamId) : array
    {
        $array = DB::table('ranking')
                        ->join('teams', 'ranking.team_id', '=', 'teams.id')
                        ->where('teams.id', $teamId)
                        ->get(['ranking.*', 'teams.name'])
                        ->toArray();

        if(count($array)==0){
        throw new Exception('Équipe inconnue');
        } 

        return $array[0];  
    }

    //USERS 

    function addUser(string $email, string $password): int
    {
        $passwordHash =  Hash::make($password);

        return DB::table('users')
                        ->insertGetId(['email'=>$email, 'password_hash'=>$passwordHash]);   
    }

    function getUser(string $email, string $password): array
    {
       
        $rows = DB::table('users')
                        ->where('email', $email)
                        ->get();

        if (count($rows)==0) {
            throw new Exception("Utilisateur inconnu"); 
        }

        $row = $rows[0];
                
        if(!(Hash::check($password, $row['password_hash'])))
        {
            throw new Exception("Utilisateur inconnu");    
        }

        return ['id' => $row['id'], 'email'=> $row['email']];
    }

    function changePassword(string $email, string $oldPassword, string $newPassword): void 
    {   
        $rows = DB::table('users')
                            ->where('email', $email)
                            ->get('password_hash');

        if (count($rows)==0) {
            throw new Exception("Utilisateur inconnu"); 
        }

        $oldPasswordHash = $rows[0]['password_hash'];

        if(!(Hash::check($oldPassword, $oldPasswordHash)))
        {
            throw new Exception("Utilisateur inconnu");    
        }
       
        $newPasswordHash =  Hash::make($newPassword);

        DB::table('users')
                ->where('email', $email)
                ->update(['password_hash' => $newPasswordHash]);
        
    }

    function deleteMatch($macthId): void
    {
        DB::table('matches')
            ->where('id', $macthId)
            ->delete();
    }
}
