<?php

namespace enrol_weeklyhours;

/**
 * Renders a list of teachers and their available tutoring hours
 * @param array(teacher) $teachers
 */
function available_teachers_template($teachers, $instanceid, $courseid) {
    ?>
    <h2>Available Teachers:</h2>

    <table class="flexible generaltable generalbox">
        <tr>
            <th>Teacher</th>
            <th>Days Available</th>
            <th>Student Feedback</th>
            <th>Schedule Lessons</th>
        </tr>
        <?php foreach ($teachers as &$teacher): ?>
            <tr>
                <td><?= $teacher['name'] ?></td>
                <td><?= implode(', ', $teacher['days_available']) ?></td>
                <td>
                    <?= $teacher['percent_positive_reviews'] ?>% Positive
                    &ndash;
                    <a href="<?= $teacher['reviews_url'] ?>"><?= $teacher['review_count'] ?> Reviews</a>
                </td>
                <td>
                    <!-- We want a button that acts like a link - so we have to put it in a form-->
                    <form action="<?= $teacher['schedule_url'] ?>">
                        <!-- Because of this workaround, GET params do not work, so hidden fields are required -->
                        <input type="hidden" name="teacherid" value="<?=$teacher['id']?>">
                        <input type="hidden" name="instanceid" value="<?=$instanceid?>">
                        <input type="hidden" name="courseid" value="<?=$courseid?>">
                        <button type="submit">Schedule Lessons</button>
                    </form>
                <td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php
}
