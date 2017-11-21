<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

function get_conn() {

    //Set your database permissions

    $servername = "localhost";
    $username = "mack";
    $password = "wsu1234";
    $dbname = "mack";

    //Try connecting to the database

    try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $conn;
    }
    catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }


}


//Initalize the Slim framework 

$app = new \Slim\App;


//Setup the Person/{id} route

$app->get('/Person/{id}', function (Request $request, Response $response) {

    //Grab the id of the user from the URI

    $id = $request->getAttribute('id');

    //Create a SQL Statement
    $sql = "select * from person where id=" .$id;

    //Grab a connection
    $conn = get_conn();

    //Get the results
    $results = $conn->query($sql);

    //Build up my JSON return value
    if (empty($results) == false)
        foreach ($results as $row)
            $userData['AllUsers']['Id'] = $row['id'];
            $userData['AllUsers']['Firstname'] = $row['firstname'];
            $userData['AllUsers']['Lastname'] = $row['lastname'];
            $userData['AllUsers']['Fullname'] = $row['firstname'] . " " . $row['lastname'];
            $userData['AllUsers']['Phone'] = $row['phone'];
    //Set the JSON return value
    $response->getBody()->write(json_encode($userData));

    //Close the database connection
    $conn = null;

    //Return the result
    return $response;
});

//Setup the /Person route

$app->get('/Person', function (Request $request, Response $response) {

    //Grab the id of the user from the URI

    //$id = $request->getAttribute('id');

    //Create a SQL Statement
    $sql = "select * from person";

    //Grab a connection
    $conn = get_conn();

    //Get the results
    $results = $conn->query($sql);

    //Build up my JSON return value
    if (empty($results) == false)
        foreach ($results as $row) {
             $id = "AllUsers" + $row['id'];
            $userData[$id]['Id'] = $row['id'];
            $userData[$id]['Firstname'] = $row['firstname'];
            $userData[$id]['Lastname'] = $row['lastname'];
            $userData[$id]['Phone'] = $row['phone'];
    }
    //Set the JSON return value
    $response->getBody()->write(json_encode($userData));

    //Close the database connection
    $conn = null;

    //Return the result
    return $response;
});


//Run the slim app

$app->run();


?>
