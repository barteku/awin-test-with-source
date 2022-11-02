<?php


namespace Awin\Tools\CoffeeBreak\Manager;


class CoffeeBreakPreferenceManager extends ModelManager
{
    /**
     * @param string $team
     * @return array
     */
    public function getPreferencesForToday(string $team = 'developers'){
        return $this->getRepository()->getPreferencesForTodayForTeam($team);
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getPreferencesForTodayForUser(int $userId){
        return $this->getRepository()->getPreferencesForTodayForUser($userId);
    }
///viktors.kockarevs@awin.com

}
