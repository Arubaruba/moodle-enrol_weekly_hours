<?php

/**
 * Renders a list of teachers and their available tutoring hours
 * @param array(teacher) $teachers
 */
function available_teachers_template($teachers) {
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
                <td><?= implode(', ', $teacher['days_available'])?></td>
                <td>
                    <?=$teacher['percent_positive_reviews']?>% Positive
                    &ndash;
                    <a href="<?=$teacher['reviews_url']?>"><?=$teacher['review_count']?> Reviews</a>
                </td>
                <td><button onclick="window.location = '<?=$teacher['schedule_url']?>'">Schedule Lessons</button><td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php
}
