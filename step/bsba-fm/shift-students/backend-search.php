<?php

require '../../../database/config.php';

$querys = "SELECT * FROM academic GROUP BY status";
$querys_run = mysqli_query($conn, $querys);

if (mysqli_num_rows($querys_run) > 0) {

    foreach ($querys_run as $rows)
?><?php
            }

                    ?>
<?php

require '../../../database/config.php';

$querys1 = "SELECT * FROM semester GROUP BY sem_status";
$querys_run1 = mysqli_query($conn, $querys1);

if (mysqli_num_rows($querys_run1) > 0) {
    foreach ($querys_run1 as $rows1)
?><?php
            }

                    ?>

<?php

require '../../../database/config.php';

$querys11 = "SELECT * FROM academic WHERE status='1'";
$querys_run11 = mysqli_query($conn, $querys11);

if (mysqli_num_rows($querys_run11) > 0) {

    foreach ($querys_run11 as $rows11)
?><?php
            }

                    ?>
<?php

require '../../../database/config.php';
$querys111 = "SELECT * FROM semester WHERE sem_status='1'";
$querys_run111 = mysqli_query($conn, $querys111);

if (mysqli_num_rows($querys_run111) > 0) {
    foreach ($querys_run111 as $rows111)
?><?php
            }


                    ?>
<?php if (in_array($rows['status'] and $rows1['sem_status'], array('1'))) : ?>
    <?php
    /* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
    require '../../../database/config.php';

    // Check connection
    if ($conn === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    if (isset($_REQUEST["term"])) {
        // Prepare a select statement
        $start = $rows11['academic_start'];
        $end = $rows11['academic_end'];
        $semester = $rows111['semester_name'];

        $academic = "$start-$end";

        $sql = "SELECT * FROM students INNER JOIN shift_students s ON students.id_number = s.id_number INNER JOIN course c ON students.course_id = c.course_id INNER JOIN year_lvl y ON students.year_id = y.year_id WHERE semester_id = '$semester' AND academic = '$academic' AND (status_type = 'Shift Students' OR status_type = 'Shift Clear') AND course_code = 'BSBA' AND students.id_number LIKE ? LIMIT 5";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_term);

            // Set parameters
            $param_term = $_REQUEST["term"] . '%';

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                // Check number of rows in the result set
                if (mysqli_num_rows($result) > 0) {
                    // Fetch result rows as an associative array
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    ?>
                        <p><a href="./?search=<?php echo $row["id_number"] ?>"><?php echo $row["id_number"] ?></a></p>
    <?php
                    }
                } else {
                    echo "<p>No matches found</p>";
                }
            } else {
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }



    // close connection
    mysqli_close($conn);
    ?>
<?php endif; ?>