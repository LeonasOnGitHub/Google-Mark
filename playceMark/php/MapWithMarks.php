<?php
namespace dashboard\GoogleMapsMark\MapWithMarks;

use JobRouter\Api\Dashboard\v1\Widget;

class TicketsNoAction extends Widget
{
    public function getTitle()
    {
        return "Google Maps Marks";
    }

    public function getCategory()
    {
        return 'administration';
    }

    public function getDimensions()
    {
        return ([
            'minHeight' => 4,
            'minWidth' => 4,
            'maxHeight' => 6,
            'maxWidth' => 6,
        ]);
    }

    

    public function getData()
    {
        return [
            'unhandledOps' => $this->getAdresses(),
            'noEntries' => CONST_NO_ENTRIES,
        ];
    }

    private function getAdresses(){
        /* FIXME PROZESSTABELLE ANBINDEN

        $jobDB = $this->getJobDB();
        $sql = 'SELECT username as label, last_action as value FROM JRSESSIONS';
        $result = $jobDB->query($sql);
        if ($result === false) {
            return [];
        }
        return $jobDB->fetchAll($result);
        */
        
        // Array mit Objekten erstellen und initialisieren
        $adressArray = [
            new Adress("A", "Behrenstraße 66", 10117),
            new Adress("B", "Lichtenberger Str. 28", 10243),
            new Adress("C", "Schönleinstraße 29", 10967)
        ];
        return $adressArray;
    }

}
class Adress {
            public $name;
            public $street;
            public $zip;
        
            public function __construct($name, $street, $zip) {
                $this->name = $name;
                $this->street = $street;
                $this->zip = $zip;
            }
        }