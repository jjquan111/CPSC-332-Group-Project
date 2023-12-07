<?php



function getAllEvents()
{
    try {
        $result = $GLOBALS['conn']->query("SELECT * FROM EventView LIMIT 50");
        $events = $result->fetch_all(MYSQLI_ASSOC);
        if (isset($events)) {
            return [NULL, $events];
        }
        return ['Failed to find Events.', NULL];
    } catch (Exception $e) {
        return ['Failed to find Events. ' . $e, NULL];
    }
}

function printSingle($event)
{
    if (isset($event['eventID'])) {
        return '<div class="col card border p-0 m-2">
                    <div class="card-body">
                            <h4>' . issetor($event['eventName']) . '</h4>
                            <p class="card-text">' . issetor($event['description']) . '</p>
                            <a href="' . $GLOBALS['rootpath'] . '/event/?eventid=' . $event['eventID'] . '" class="btn btn-primary">View</a>
                    </div>
                    <div class="card-footer"><small class="text-muted"> Start: '
            . date_format(date_create(issetor($post['startTime'])), 'm/d/Y') .
            '</small></br>
                    <small class="text-muted"> End: '
            . date_format(date_create(issetor($post['endTime'])), 'm/d/Y') .
            '</small></br>
                    <small class="text-muted"> Capacity: ' . number_format(issetor($event['capacity'])) . '</small></div>
                </div>';
    }
    return '';
}

function printEvents($events)
{
    if (!empty($events)) {

        // these 2 lines are probably slow since it iterates throught the array 2 times
        $prettyevents = array_map('printSingle', $events); // convert these posts into strings
        $allevents = implode($prettyevents);

        return '<div class="container"><div class="row row-cols-4 m-2 p-2">' . $allevents . '</div></div>';
    } else {
        return '<h4>EventView of events</h1><p>No Events Found.</p>';
    }
}

?>