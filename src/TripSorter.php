<?php

namespace TS;

class TripSorter
{
    // initiate function
    public function createSort()
    {
        $cardsArray = $this->getCards();
        $cardsCount = count($cardsArray);
        $sortedCards = $this->recSort($cardsArray, $cardsCount, 0);
        return $this->createHTML($sortedCards);
    }

    // return recursive array
    private function recSort($cardsArray, $cardsCount, $startIndex = 0)
    {
        if ($startIndex == $cardsCount - 1) {
            return $cardsArray;
        }

        for ($i = $startIndex; $i < $cardsCount; $i++) {
            for ($k = $i + 1; $k < $cardsCount; $k++) {
                if ($cardsArray[$i]['Departure'] == $cardsArray[$k]['Arrival']) {
                    $cardsArray = $this->swap($cardsArray, $i, $k);
                    return $this->recSort($cardsArray, $cardsCount, $i);
                }
            }
        }

        return $cardsArray;
    }

    // return swap array

    private function swap($cardsArray, $i, $k)
    {
        $temp            = $cardsArray[$i];
        $cardsArray[$i] = $cardsArray[$k];
        $cardsArray[$k] = $temp;

        return $cardsArray;
    }

    // return html output

    public function createHTML($sortedCards)
    {
        $htmlString = "<ol>";
        foreach ($sortedCards as $card) {
            switch ($card['Transportation']) {
                case "Train":
                    $htmlString .= $this->createTrainHtml($card);
                    break;
                case "Bus":
                    $htmlString .= $this->createBusHtml($card);
                    break;
                case "Plane":
                    $htmlString .= $this->createPlaneHtml($card);
                    break;
            }
        }

        return $htmlString . $this->arrivalMsg() . "</ol>";
    }

    // return train HTML
    private function createTrainHtml($card)
    {
        return "<li>Take train ". $card['TransportationNumber'] ." from ".$card['Departure']." to ".$card['Arrival'].". " . $this->createGateHTML($card) . $this->createSeatHTML($card) . "</li>";
    }

    // return bus HTML
    private function createBusHtml($card)
    {
        return "<li>Take the airport bus from ".$card['Departure']." to ".$card['Arrival']."." . $this->createSeatHTML($card) . "</li>";
    }

    // return plane HTML

    private function createPlaneHtml($card)
    {
        return "<li>From ".$card['Departure'].", take flight ".$card['TransportationNumber']." to ".$card['Arrival'].". " . $this->createGateHTML($card) . $this->createSeatHTML($card) . $this->createBaggageHTML($card) . "</li>";
    }

    // return arraive msg html

    private function arrivalMsg()
    {
        return "<li>You have arrived at your final destination.</li>";
    }

    // return baggage HTML

    private function createBaggageHTML($card)
    {
        return !empty($card['Baggage']) ? ", Baggage drop at ticket counter ".$card['Baggage']."" : ", Baggage will we automatically transferred from your last leg";
    }

    // return gate HTML

    private function createGateHTML($card)
    {
        return empty($card['Gate']) ?: "Gate ".$card['Gate']."";
    }

    // return seat HTML

    private function createSeatHTML($card)
    {
        return !empty($card['Seat']) ? " Sit in seat ".$card['Seat']."" : "No seat assignment";
    }

    // return cards array

    public function getCards()
    {
        return array(
            array(
                "Departure" => "Stockholm",
                "Arrival" => "New York",
                "Transportation" => "Plane",
                "TransportationNumber" => "SK22",
                "Seat" => "7B",
                "Gate" => "22"
            ),
            array(
                "Departure" => "Madrid",
                "Arrival" => "Barcelona",
                "Transportation" => "Train",
                "TransportationNumber" => "78A",
                "Seat" => "45B"
            ),
            array(
                "Departure" => "Gerona Airport",
                "Arrival" => "Stockholm",
                "Transportation" => "Plane",
                "TransportationNumber" => "SK455",
                "Seat" => "3A",
                "Gate" => "45B",
                "Baggage" => "334"
            ),
            array(
                "Departure" => "Barcelona",
                "Arrival" => "Gerona Airport",
                "Transportation" => "Bus"
            ),
        );
    }
}
