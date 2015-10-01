<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Car.php";

    $app = new Silex\Application();

    $app->get("/", function()
    {
        return "
         <!DOCTYPE html>
         <html>
         <head>
             <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css'>
             <title>Find a Car</title>
         </head>
         <body>
             <div class='container'>
                 <h1>Find a Car!</h1>
                 <form action='view_cars'>
                     <div class='form-group'>
                         <label for='price'>Enter Maximum Price:</label>
                         <input id='max_price' name='max_price' class='form-control' type='number'>
                     </div>
                     <div class='form-group'>
                         <label for='price'>Enter Maximum Mileage:</label>
                         <input id='max_miles' name='max_miles' class='form-control' type='number'>
                     </div>
                     <button type='submit' class='btn-default'>Search <span class='glyphicon glyphicon-search'></span></button>
                 </form>
             </div>
         </body>
         </html>
        ";
    });


    $app->get("/view_cars", function ()
    {
        $porsche = new Car("2014 Porsche 911", "images/porsche.jpg", 114991, 7864);
        $ford = new Car("2011 Ford F450", "images/ford.jpg", 55995, 14241);
        $lexus = new Car("2013 Lexus RC 350", "images/lexus.jpg", 44700, 20000);
        $mercedes = new Car ("Mercedes Benz CLS550", "images/mercedes.jpg", 39900, 37979);

        $cars = array($porsche, $ford, $lexus, $mercedes);
        $cars_matching_search = array();

        foreach ($cars as $car)
        {
            if ($car->worthBuying($_GET['max_price'], $_GET['max_miles']))
            {
                 array_push($cars_matching_search, $car);
            }
        }

        if (empty($cars_matching_search))
        {
            echo '<h3>There are no cars that match your search</h3>';
        }
        else
        {
            $output = "";
            foreach ($cars_matching_search as $match)
            {
                $output = $output .
                "
                <!DOCTYPE html>
                <html>
                <head>
                    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css'>
                    <title>Car Search Results</title>
                    </head>
                    <body>
                    <div class='container'>
                        <li><strong>" . $match->getModel() . "</strong></li>
                        <img src=" . $match->getPicture() . " class='img-rounded'>
                        <ul>
                            <li>$" . $match->getPrice() . "</li>
                            <li>Miles: " . $match->getMiles() . "</li>
                        </ul>
                    </div>
                    </body>
                </html>
                ";
            }
        }
        return $output;
    });

    return $app;

?>
