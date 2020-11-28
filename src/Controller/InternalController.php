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
class InternalController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * @var string $db a sample member variable that gets initialised
     */
    private $db = "not active";
    // private $info;

    public function initialize(): void
    {
        // Use to initialise member variables.
        $this->db = "active";
    }

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
            "anax/v2/ip-validator/ipValidator",
            [
                "header" => "hello",
                "text" => "text",
            ]
        );

        return $page->render([
            "title" => "$title",
        ]);
    }

    public function ipinfoAction(): object
    {
        $title = " | Ip info";
        $page = $this->di->get("page");
        $page->add("anax/v2/ip-validator/ipinfo", [
            "ip" => $this->di->get("request")->getGet("ip"),
            "type" => $this->di->get("request")->getGet("type"),
            "domain" => $this->di->get("request")->getGet("domain"),
        ]);

        return $page->render([
            "title" => "$title",
        ]);
    }

    public function validateipActionGet($ipAdress): void
    {
        print_r("hello");
        // print_r($this->di);
        $ipInfo["IP"] = $this->di->get("request")->getGet("ip") ?? $ipAdress;
        // if ($this->di->request->getGet("ip")) {
        //   $ipInfo["IP"] = $this->di->request->getGet("ip");
        //   $ip = $this->di->request->getGet("ip");
        // } else {
        //   $ipInfo["IP"] = $ip;
        // }
        $internalValidator = $this->di->get("validate");

        $res = $internalValidator->validateLocalActionGet($ipInfo["IP"]);
        $obj = json_decode($res[0]);

        $this->di->get("response")->redirect("InternalController/ipinfo/?ip=" . $obj->IP
            . "&type=" . $obj->Type . "&domain=" . $obj->Domain);
    }
}
