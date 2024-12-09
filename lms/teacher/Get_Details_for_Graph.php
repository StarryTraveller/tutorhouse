require_once '../../connection.php';


 Fetch activities data along with the title based on the student's last name and subject
    $activitiesQuery = "SELECT a.activityid, a.remarks AS score, a.name AS title
                        FROM actsubmit AS a
                        WHERE a.studname = '$lastName' AND EXISTS (
                            SELECT 1 FROM activities AS act
                            WHERE a.activityid = act.id AND act.subject = '$subject'
                        )";
    $activitiesResult = mysqli_query($con, $activitiesQuery);
    
    $activitiesData = mysqli_fetch_all($activitiesResult, MYSQLI_ASSOC);

    echo json_encode($activitiesData);