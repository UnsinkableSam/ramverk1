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
class RestApiExternalController implements ContainerInjectableInterface
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
            "anax/v2/ip-validator/RestApiExternal",
            [
                "header" => "hello",
                "text" => "text",
            ]
        );

        return $page->render([
            "title" => "$title",
        ]);
    }

    public function validateipActionGet($ipAdress = null): string
    {
        $keykey = $this->di->get("apikey");
        // if ($this->di->get("request")->getGet("ip")) {
        //     $ipInfo["IP"] = $this->di->get("request")->getGet("ip");
        //     $ipAdress = $this->di->get("request")->getGet("ip");
        // } else {
        //     $ipInfo["IP"] = $ipAdress;
        // }
        $ipInfo["IP"] = $this->di->get("request")->getGet("ip") ?? $ipAdress;
        $bob = $this->di->get("ExternalApi");
        $res = $bob->validateipJsonActionGet($ipInfo["IP"], $keykey);

        // $json_string = json_encode($res, JSON_PRETTY_PRINT);

        // $json = json_decode($res);

        $resString = json_encode($res, JSON_PRETTY_PRINT);

        return $resString;
    }

    public function validateipActionPost($ipAdress = null): string
    {
        $keykey = $this->di->get("apikey");
        // if ($this->di->request->getPost("ip")) {
        //     $ipInfo["IP"] = $this->di->request->getPost("ip");
        //     $ipAdress = $this->di->request->getPost("ip");
        // } else {
        //     $ipInfo["IP"] = $ipAdress;
        // }
        $ipInfo["IP"] = $this->di->get("request")->getGet("ip") ?? $ipAdress;
        $bob = $this->di->get("ExternalApi");
        $res = $bob->validateipJsonActionGet($ipInfo["IP"], $keykey);

        // $json_string = json_encode($res, JSON_PRETTY_PRINT);

        // $json = json_decode($res);

        $resString = json_encode($res, JSON_PRETTY_PRINT);

        return $resString;
    }
}
