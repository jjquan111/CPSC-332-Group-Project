<?php



function getAllReviewers()
{
    try {
        $result = $GLOBALS['conn']->query("SELECT * FROM reviewer LIMIT 50");
        $reviewers = $result->fetch_all(MYSQLI_ASSOC);
        if (isset($reviewers)) {
            return [NULL, $reviewers];
        }
        return ['Failed to find reviewers.', NULL];
    } catch (Exception $e) {
        return ['Failed to find reviewers. ' . $e, NULL];
    }
}

function printSingle($reviewer)
{
    if (isset($reviewer['reviewerID'])) {
        return '<div class="col card border p-0 m-2">
                    <div class="card-body">
                            <a href="' . $GLOBALS['rootpath'] . '/reviewer/?reviewerid=' . $reviewer['reviewerID'] . '" class="btn btn-primary">View</a>
                            <a href="' . $GLOBALS['rootpath'] . '/event/?eventid=' . $event['eventID'] . '" class="btn btn-primary">View</a>
                    </div>
                </div>';
    }
    return '';
}

function printReviewers($reviewer)
{
    if (!empty($reviewer) {

        // these 2 lines are probably slow since it iterates throught the array 2 times
        $thereviewer = array_map('printSingle', $reviewer); // convert these posts into strings
        $allreviewers = implode($thereviewer);

        return '<div class="container"><div class="row row-cols-4 m-2 p-2">' . $allreviewers . '</div></div>';
    } else {
        return '<h4> Reviewers:</h1><p>No reviewers Found.</p>';
    }
}

?>