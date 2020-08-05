<?php
$xmlDoc = simplexml_load_file('restaurant_review.xml');
$restro = $xmlDoc->restaurant;

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    // dropdownlist selected
    if(isset($_POST['selectedRestName']))
    {
        $reqRestName = $_POST['selectedRestName'];
        $selectedRest = GetRestaurantByName($reqRestName);
        $infoArr = array(
            "address" => $selectedRest->location->address." ".$selectedRest->location->post_code,
            "summary" => $selectedRest->summary->__toString(),
            "rating" => $selectedRest->rating->__toString()
        );

        echo json_encode($infoArr);
    }

    // on click save button
    if(isset($_POST['newSummary']))
    {
        $reqRestNameToSave = $_POST['restName'];
        $selectedRestToSave = GetRestaurantByName($reqRestNameToSave);
        $selectedRestToSave->summary = $_POST['newSummary'];
		$selectedRestToSave->rating = $_POST['newRating'];
        $xmlDoc->asXML('restaurant_review.xml');
        // echo "All the changes are saved.";
    }
    
}

function GetRestaurantByName($name) {
    foreach($GLOBALS['restro'] AS $rest)
    {   
        if($rest->name == $name){
            return $rest;
        }
    }
    return null;
}







?>
