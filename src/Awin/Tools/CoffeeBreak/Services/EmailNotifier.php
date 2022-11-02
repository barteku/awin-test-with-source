<?php


namespace Awin\Tools\CoffeeBreak\Services;


use App\Entity\CoffeeBreakPreference;
use App\Entity\StaffMember;

class EmailNotifier implements NotifierInterface
{

    /**
     * @param StaffMember $staffMember
     * @param CoffeeBreakPreference $preference
     * @return bool
     */
    public function notifyStaffMember(StaffMember $staffMember, CoffeeBreakPreference $preference)
    {
        if (empty($staffMember->getEmail())) {
            throw new \RuntimeException("Cannot send notification - no Email");
        }


        /**
         * we send notification here
         * we can use symfony mailer for it
         */


        return true;
    }


}
