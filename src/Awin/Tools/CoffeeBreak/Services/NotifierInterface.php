<?php


namespace Awin\Tools\CoffeeBreak\Services;


use App\Entity\CoffeeBreakPreference;
use App\Entity\StaffMember;



interface NotifierInterface
{

    public function notifyStaffMember(StaffMember $staffMember, CoffeeBreakPreference $preference);
}
