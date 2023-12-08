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
                    <p>' . issetor($eventdetails['description']) . '</p>
                    <p> Start Time:' . date_format(date_create(issetor($post['startTime'])), 'm/d/Y') . '</p>
                    <p> End Time:'. date_format(date_create(issetor($post['endTime'])), 'm/d/Y') .'</p>
                    <p> Capacity:' . number_format(issetor($eventdetails['capacity'])) . '</p>
                    <p> Event Type: ' . issetor($eventdetails['eventType']) . '</p>
                    <p> University: ' . issetor($eventdetails['uniName']) . '</p>
                    <p> Venue: ' . issetor($eventdetails['venueName']) . '</p>
                    <p> address: ' . issetor($eventdetails['address']) . '</p>
                    <p> Speaker: ' . issetor($eventdetails['speakerName']) . '</p>
                    <p> Sponsor: ' . issetor($eventdetails['Fname']) . issetor($eventdetails['Lname']) . '</p>
                    <a href="' . $GLOBALS['rootpath'] . '/event/createReviewer.php?eventid=' . $eventdetails['eventID'] . '" class="btn btn-primary">Create Reviewer</a>
                    <a href="' . $GLOBALS['rootpath'] . '/event/createAbstract.php?eventid=' . $eventdetails['eventID'] . '" class="btn btn-primary">Create Abstract</a>

                                        </div>';
}

// =======
// function getEventDetails($eventid) {
//     try {
//         $stmt = $GLOBALS['conn']->prepare("SELECT * FROM _event WHERE eventID = ?");
//         $stmt->bind_param("i", $eventid);
//         $stmt->execute();
//         $result = $stmt->get_result();
//         $jobpost = $result->fetch_assoc();
//         if (isset($jobpost)) {
//             return [NULL, $jobpost];
//         }
//         return ['Failed to find JobPost.', NULL];
//     }
//     catch (Exception $e) {
//         return ['Failed to find JobPost. ' . $e, NULL];
//     }
// }
// >>>>>>> main
?>