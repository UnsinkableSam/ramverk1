<?php
/**
 * Supply the basis for the navbar as an array.
 */
return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "my-navbar rm-default rm-desktop",

    // Here comes the menu items
    "items" => [
        [
            "text" => "Hem",
            "url" => "",
            "title" => "Första sidan, börja här.",
        ],

        [
            "text" => "Om",
            "url" => "om",
            "title" => "Om denna webbplats.",
        ],
        [
            "text" => "Login",
            "url" => "user/login",
            "title" => "login",
        ],
        [
            "text" => "Register",
            "url" => "user/create",
            "title" => "register",
        ],
        [
            "text" => "User page",
            "url" => "user/user",
            "title" => "User page",
        ],
       

        [
            "text" => "Questions",
            "url" => "showall",
            "title" => "showall",
        ],

        [
            "text" => "Tags",
            "url" => "tags",
            "title" => "tags",
        ],


       
    ],
];