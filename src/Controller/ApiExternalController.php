<?php
namespace Anax\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample JSON controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 */
class ApiExternalController implements ContainerInjectableInterface
{

    use ContainerInjectableTrait;

    /**
     * @var string $db a sample member variable that gets initialised
     */
    // private $db = "not active";

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction(): object
    {
        $title = " | Ip Json API";
        $page = $this->di->get("page");
        $page->add(
            "anax/v2/ip-validator/apiExternal",
            [
                "header" => "hello",
                "text" => "text",
            ]
        );

        return $page->render([
            "title" => "$title",
        ]);
    }

    public function externalInfoAction(): object
    {

        $title = " | Ip info";
        $page = $this->di->get("page");
        $page->add("anax/v2/ip-validator/externalInfo", [
            "ip" => $this->di->get("request")->getGet("ip"),
            "type" => $this->di->get("request")->getGet("type"),
            "country" => $this->di->get("request")->getGet("country"),
            "latitude" => $this->di->get("request")->getGet("latitude"),
            "longitude" => $this->di->get("request")->getGet("longitude"),
        ]);

        return $page->render([
            "title" => "$title",
        ]);
    }

    public function validateipActionGet($ipAdress = null): void
    {
        $keykey = $this->di->get("apikey");

        // if ($this->di->get("request")->getGet("ip")) {
        //     $ipInfo["IP"] = $this->di->get("request")->getGet("ip") ?? $ipAdress;
        //     // $ipAdress = $this->di->request->getGet("ip");
        // } else {
        //     $ipInfo["IP"] = $ipAdress;
        // }
        $ipInfo["IP"] = $this->di->get("request")->getGet("ip") ?? $ipAdress;
        $apiEx = $this->di->get("ExternalApi");
        $res = $apiEx->validateipActionGet($ipInfo["IP"], $keykey);
        $obj = $res;
        $obj = json_decode($res);

        $this->di->get("response")->redirect("apiExternal/externalInfo/?ip=" . $obj->ip
            . "&type=" . $obj->type . "&country=" . $obj->country_name
            . "&longitude=" . $obj->longitude . "&latitude=" . $obj->latitude);
    }
}
