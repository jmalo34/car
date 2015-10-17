<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Car.php";

    session_start();
    $porsche = new Car("2014 Porsche 911", "images/porsche.jpg", 114991, 7864);
    $ford = new Car("2011 Ford F450", "images/ford.jpg", 55995, 14241);
    $lexus = new Car("2013 Lexus RC 350", "images/lexus.jpg", 44700, 20000);
    $mercedes = new Car ("Mercedes Benz CLS550", "images/mercedes.jpg", 39900);

    if (empty($_SESSION['da_carz']))
    {
        $_SESSION['da_carz'] = array($porsche, $ford, $lexus, $mercedes);
    }

    $app = new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

    // $car_lot = array($porsche, $ford, $lexus, $mercedes);
    //
    // $_SESSION['da_carz'] = array($car_lot);

    $app->get("/", function() use ($app)
    {
        return $app['twig']->render('cars.html.twig');
    });

    $app->post("/list_car", function () use ($app)
    {
        $new_car = new Car($_POST['make_model'], $_POST['picture'], $_POST['price'], $_POST['miles']);
        $new_car->save();

        return $app['twig']->render('list_car.html.twig', array('list_car' => $new_car));
    });


    $app->get("/car_lot", function () use ($app)
    {

        return $app['twig']->render('car_lot.html.twig', array('autos' => Car::getAll()));
    });

    $app->get("/match_cars", function () use ($app)
    {
        $cars_matching_search = array(); Car::worthBuying($_GET[max_price], $_GET[max_miles]);

        return $app['twig']->render('match_cars.html.twig', array('cars_matching_search' => $cars_matching_search, ));
    });

    $app->post("/delete_cars", function () use ($app)
    {
        Car::deleteAll();

        return $app['twig']->render('delete_cars.html.twig');
    });

    return $app;

?>
