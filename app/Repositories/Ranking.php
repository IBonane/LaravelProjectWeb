<?php

namespace App\Repositories;

class Ranking {

    function goalDifference(int $goalFor, int $goalAgainst): int {
        
        return $goalFor - $goalAgainst;
    }

    function points(int $matchWonCount, int $drawMatchCount): int{

        return 3 * $matchWonCount + $drawMatchCount;
    }

    function teamWinsMatch(int $teamId, array $match): bool {

        return (($match['team0'] == $teamId) && ($match['score0'] > $match['score1'])) || 
               (($match['team1'] == $teamId) && ($match['score1'] > $match['score0']));
    }

    function teamLosesMatch(int $teamId, array $match): bool {
        
        return (($match['team0'] == $teamId) && ($match['score0'] < $match['score1'])) || 
               (($match['team1'] == $teamId) && ($match['score1'] < $match['score0']));
    }
    
    function teamDrawsMatch(int $teamId, array $match): bool {

        return (($match['team0'] == $teamId) || 
               ($match['team1'] == $teamId)) && 
               ($match['score0'] == $match['score1']);
    }    

    function goalForCountDuringAMatch(int $teamId, array $match): int {

        
        return ($match['team0'] == $teamId) ? $match['score0']:
               (($match['team1'] == $teamId) ? $match['score1']:
               0);
    }

    function goalAgainstCountDuringAMatch(int $teamId, array $match): int {
        
        return ($match['team0'] == $teamId) ? $match['score1']:
               (($match['team1'] == $teamId) ? $match['score0']:
               0);        
    }

    function goalForCount(int $teamId, array $matches): int {

        $goalForTotal = 0;

        foreach ($matches as $match){

            $goalForTotal += $this->goalForCountDuringAMatch($teamId, $match);
        }

        return $goalForTotal;
    }

    function goalAgainstCount(int $teamId, array $matches): int {

        $goalAgainstTotal = 0;

        foreach ($matches as $match){

            $goalAgainstTotal += $this->goalAgainstCountDuringAMatch($teamId, $match);
        }

        return $goalAgainstTotal;
    }

    function matchWonCount(int $teamId, array $matches): int {

        $matchWonTotal = 0;

        foreach ($matches as $match){

            $matchWonTotal += $this->teamWinsMatch($teamId, $match);
        }

        return $matchWonTotal;
    }


    function matchLostCount(int $teamId, array $matches): int {

        $matchLostTotal = 0;

        foreach ($matches as $match){

            $matchLostTotal += $this->teamLosesMatch($teamId, $match);
        }

        return $matchLostTotal;
    }

    function DrawMatchCount(int $teamId, array $matches): int {

        $matchDrawTotal = 0;

        foreach ($matches as $match){

            $matchDrawTotal += $this->teamDrawsMatch($teamId, $match);
        }

        return $matchDrawTotal;
    }

    function rankingRow(int $teamId, array $matches): array {

        
        return [

            'team_id'            => $teamId,
            'match_played_count' => ($this->matchWonCount($teamId, $matches) + $this->matchLostCount($teamId, $matches) + $this->drawMatchCount($teamId, $matches)),
            'match_won_count'    => $this->matchWonCount($teamId, $matches),
            'match_lost_count'   => $this->matchLostCount($teamId, $matches),
            'draw_count'         => $this->drawMatchCount($teamId, $matches),
            'goal_for_count'     => $this->goalForCount($teamId, $matches),
            'goal_against_count' => $this->goalAgainstCount($teamId, $matches),
            'goal_difference'    => $this->goalDifference($this->goalForCount($teamId, $matches), $this->goalAgainstCount($teamId, $matches)),
            'points'             => $this->points($this->matchWonCount($teamId, $matches), $this->drawMatchCount($teamId, $matches)),

        ];
    }

    function unsortedRanking(array $teams, array $matches): array {

        $result = [];

        foreach($teams as $team){

            $result[] = $this->rankingRow($team['id'], $matches);
        }
        
        return $result;
    }

    
    static function compareRankingRow(array $row1, array $row2): int {

        if($row1['points'] != $row2['points'] ){
            return $row2['points'] - $row1['points'];
        }

        if($row1['goal_difference'] != $row2['goal_difference'] ){
            return $row2['goal_difference'] - $row1['goal_difference'];
        }

        if($row1['goal_for_count'] != $row2['goal_for_count'] ){
            return $row2['goal_for_count'] - $row1['goal_for_count'];
        }

        return 0;
    }

    function sortedRanking(array $teams, array $matches): array {

        $result = $this->unsortedRanking($teams, $matches);
        usort($result, ['App\Repositories\Ranking', 'compareRankingRow']);

        for ($rank = 1; $rank <= count($teams); $rank++) {
            // TODO : ajouter le rang dans le tableau associatif $result[$rank - 1] 
            $result[$rank - 1]['rank'] = $rank;
        }

        return $result;
    }



}