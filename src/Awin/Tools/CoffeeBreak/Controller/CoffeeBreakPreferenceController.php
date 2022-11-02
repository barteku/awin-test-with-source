<?php
namespace Awin\Tools\CoffeeBreak\Controller;


use App\Entity\OfficeTeamInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CoffeeBreakPreferenceController extends Controller
{

    /**
     * Publishes the list of preferences in the requested format
     */
    public function todayAction(Request $request)
    {
        $team = $request->get('team', 'developers');
        $format = $request->get('_format', 'html');


        $t = $this->get("app.coffee_break_preferences.manager")->getPreferencesForToday($team);


        $contentType = "text/html";

        switch ($format) {
            case "json":
                $responseContent = $this->getJsonForResponse($t);
                $contentType = "application/json";
                break;

            case "xml":
                $responseContent = $this->getXmlForResponse($t);
                $contentType = "text/xml";
                break;

            default:
                $responseContent = $this->getHtmlForResponse($t);
        }

        return new Response($responseContent, 200, ['Content-Type' => $contentType]);
    }


    /**
     * @param int $staffMemberId
     * @return Response
     */
    public function notifyStaffMemberAction($staffMemberId)
    {
        $slackNotifier = $this->get('slack.notifier');
        $emailNotifier = $this->get('email.notifier');

        $t = $this->get("app.coffee_break_preferences.manager")->getPreferencesForTodayForUser($staffMemberId);
        $notificationSent = false;

        foreach ($t as $preference){
            if($preference->getRequestedBy()->getTeam()->getPreferredContactService() === OfficeTeamInterface::CONTACT_SERVICE_SLACK){
                $notificationSent = $slackNotifier->notifyStaffMember($preference->getRequestedBy(), $preference);
            }else{
                $notificationSent = $emailNotifier->notifyStaffMember($preference->getRequestedBy(), $preference);
            }

        }


        return new Response($notificationSent ? "OK" : "NOT OK", 200);
    }


    private function getJsonForResponse(array $preferences)
    {
        return json_encode([
            "preferences" => array_map(
                function ($preference) {
                    return $preference->getAsArray();
                },
                $preferences
            )
        ]);
    }

    private function getXmlForResponse(array $preferences)
    {
        $preferencesNode = new \SimpleXMLElement("preferences");
        foreach ($preferences as $preference) {
            $preferencesNode->addChild($preference->getAsXmlNode());
        }

        return $preferencesNode->asXML();
    }

    private function getHtmlForResponse(array $preferences)
    {
        $html = "<ul>";
        foreach ($preferences as $preference) {

            $html .= $preference->getAsListElement();
        }
        $html .= "</ul>";
        return $html;
    }
}
