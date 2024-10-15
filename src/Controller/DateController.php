<?php

namespace App\Controller;

use DateTime;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DateController


{
    #[Route("/date", name: "date", methods: ["GET"])]

    function number()
    {


        $date = new DateTime();
        $formattedDate = $date->format('d-m-y h:i:s');

        return new Response("<h2>la date est : $formattedDate</h2", Response::HTTP_OK);
    }

    
}
