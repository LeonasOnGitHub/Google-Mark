<?php
namespace dashboard\PKSWidgets\TicketsNoAction;

use JobRouter\Api\Dashboard\v1\Widget;

class TicketsNoAction extends Widget
{
    public function getTitle()
    {
        return 'Tickets ohne Aktion seit mehr als 4 Tagen';
    }

    public function getCategory()
    {
        return 'cat_100_itOperations';
    }

    public function getDimensions()
    {
        return ([
            'minHeight' => 2,
            'minWidth' => 2,
            'maxHeight' => 6,
            'maxWidth' => 2,
        ]);
    }

    public function getData()
    {
        return [
            'unhandledOps' => $this->getUnhandledOpsTickets(),
            'unhandledDev' => $this->getUnhandledDevTickets(),
            'noEntries' => CONST_NO_ENTRIES,
        ];
    }

    private function getUnhandledOpsTickets()
    {
        $deskproDB = $this->getDBConnection('deskpro');
        $sql = "select d.title as department, subject, status, t.id as ticket_id, p.name as person, o.name as organization, DATEDIFF(CURDATE(), max(tm.date_created)) as last_action_diff, DATEDIFF(date(from_unixtime(cd.value)), CURDATE()) as targetdate_diff
		from tickets t left outer join people p on t.agent_id = p.id 
            left outer join custom_data_ticket cd on t.id = cd.ticket_id
            left outer join departments d on t.department_id = d.id
			left outer join organizations o on t.organization_id = o.id
			left outer join tickets_messages tm on t.id = tm.ticket_id
        where status NOT IN ('resolved', 'archived', 'hidden') and d.id IN (1)
        group by ticket_id
        having last_action_diff >= 5 and (targetdate_diff is null or targetdate_diff < 0)
        order by last_action_diff desc;";

        $result = $deskproDB->query($sql);

        if ($result === false) {
            return [];
        }

        return $deskproDB->fetchAll($result);
    }

    private function getUnhandledDevTickets()
    {
        $deskproDB = $this->getDBConnection('deskpro');
        $sql = "select d.title as department, subject, status, t.id as ticket_id, p.name as person, o.name as organization, DATEDIFF(CURDATE(), max(tm.date_created)) as last_action_diff, DATEDIFF(date(from_unixtime(cd.value)), CURDATE()) as targetdate_diff 
		from tickets t left outer join people p on t.agent_id = p.id 
            left outer join custom_data_ticket cd on t.id = cd.ticket_id
            left outer join departments d on t.department_id = d.id
			left outer join organizations o on t.organization_id = o.id
			left outer join tickets_messages tm on t.id = tm.ticket_id
        where status NOT IN ('resolved', 'archived', 'hidden') and d.id IN (6)
        group by ticket_id
        having last_action_diff >= 5 and (targetdate_diff is null or targetdate_diff < 0)
        order by last_action_diff desc;";

        $result = $deskproDB->query($sql);

        if ($result === false) {
            return [];
        }

        return $deskproDB->fetchAll($result);
    }

    public function isAuthorized()
    {
 		return $this->getUser()->isInJobFunction('PKS-All');
    }
}
