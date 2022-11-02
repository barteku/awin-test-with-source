<?php


namespace Awin\Tools\CoffeeBreak\Entity;


interface OfficeTeamInterface
{
    const CONTACT_SERVICE_SLACK = 1;
    const CONTACT_SERVICE_EMAIL = 2;


    public function getName();
    public function getTeamMembers();


}
