<?php
namespace dashboard\PKSWidgets\MapsMarker4S;

use JobRouter\Api\Dashboard\v1\Widget;

class Adress
{
    public $name;
    public $street;
    public $zip;

    public function __construct($name, $street, $zip)
    {
        $this->name = $name;
        $this->street = $street;
        $this->zip = $zip;
    }
}

class MapsMarker4S  extends Widget
{
    public function getTitle()
    {
        return 'Maps mit Marken';
    }

    public function getCategory()
    {
        return 'administration';
    }

    public function getDimensions()
    {
        return ([
            'minHeight' => 1,
            'minWidth' => 1,
            'maxHeight' => 2,
            'maxWidth' => 2,
        ]);
    }
	
	public function getStyles()
	{
		return '
		';
	}	

    public function getData()
    {
        return [
            'items' => $this->getAdresses(),
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
	
    public function isAuthorized()
    {
        return true || $this->getCurrentUsername() == 'admin' || $this->isCurrentUserInJobFunction('PKS-All');
    }
}
