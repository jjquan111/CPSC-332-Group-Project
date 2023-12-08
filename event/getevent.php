<?php
function getEventDetails($eventid)
{
    try {
        $stmt = $GLOBALS['conn']->prepare("SELECT * FROM EventDetailView WHERE eventID = ?");
        $stmt->bind_param("i", $eventid);
        $stmt->execute();
        $result = $stmt->get_result();
        $event1 = $result->fetch_assoc();
        if (isset($event1)) {
            return [NULL, $event1];
        }
        return ['Failed to find Event.', NULL];
    } catch (Exception $e) {
        return ['Failed to find Event. ' . $e, NULL];
    }
}

function printEventDetails($eventdetails)
{
    // convert $postdetails key/value array to pretty html
    // should add any fields I forgot to include, benefits etc
    return '<div class="col border p-4">
                    <h4>' . issetor($eventdetails['eventName']) . '</h4>
                    <h5>' . issetor($eventdetails['capacity']) . '</h5>
                    <p>' . issetor($eventdetails['description']) . '</p>
                    <p>' . var_export($eventdetails, TRUE) . '</p>
                    </div>';
}

?>