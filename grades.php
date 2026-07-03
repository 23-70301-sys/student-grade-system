<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$students = [
    ['id' => 'S-1001', 'name' => 'Alonzo, Marie',    'subject' => 'Computer Science 101', 'prelim' => 88, 'midterm' => 91, 'final' => 85],
    ['id' => 'S-1002', 'name' => 'Bautista, Juan',   'subject' => 'Computer Science 101', 'prelim' => 74, 'midterm' => 70, 'final' => 68],
    ['id' => 'S-1003', 'name' => 'Cruz, Angela',     'subject' => 'Computer Science 101', 'prelim' => 95, 'midterm' => 97, 'final' => 96],
    ['id' => 'S-1004', 'name' => 'Dela Peña, Mark',  'subject' => 'Computer Science 101', 'prelim' => 60, 'midterm' => 65, 'final' => 58],
    ['id' => 'S-1005', 'name' => 'Estrada, Liza',    'subject' => 'Computer Science 101', 'prelim' => 82, 'midterm' => 79, 'final' => 84],
    ['id' => 'S-1006', 'name' => 'Fernandez, Paolo', 'subject' => 'Computer Science 101', 'prelim' => 91, 'midterm' => 88, 'final' => 93],
    ['id' => 'S-1007', 'name' => 'Garcia, Nicole',   'subject' => 'Computer Science 101', 'prelim' => 70, 'midterm' => 72, 'final' => 74],
    ['id' => 'S-1008', 'name' => 'Hernandez, Kyle',  'subject' => 'Computer Science 101', 'prelim' => 55, 'midterm' => 60, 'final' => 62],
    ['id' => 'S-1009', 'name' => 'Ignacio, Beatriz', 'subject' => 'Computer Science 101', 'prelim' => 99, 'midterm' => 95, 'final' => 98],
    ['id' => 'S-1010', 'name' => 'Javier, Renz',     'subject' => 'Computer Science 101', 'prelim' => 78, 'midterm' => 74, 'final' => 71],
];

const GRADE_WEIGHTS = ['prelim' => 0.30, 'midterm' => 0.30, 'final' => 0.40];
const PASSING_GRADE = 75;

function computeFinalGrade(array $student): float
{
    $weighted = ($student['prelim'] * GRADE_WEIGHTS['prelim'])
        + ($student['midterm'] * GRADE_WEIGHTS['midterm'])
        + ($student['final'] * GRADE_WEIGHTS['final']);

    return round($weighted, 2);
}

function remarkFor(float $average): string
{
    return $average >= PASSING_GRADE ? 'Passed' : 'Failed';
}

foreach ($students as &$student) {
    $student['average'] = computeFinalGrade($student);
    $student['remarks'] = remarkFor($student['average']);
}
unset($student);

$averages = array_column($students, 'average');
$classAverage = count($averages) ? round(array_sum($averages) / count($averages), 2) : 0;
$highestGrade = count($averages) ? max($averages) : 0;
$lowestGrade  = count($averages) ? min($averages) : 0;
$passedCount  = count(array_filter($students, fn($s) => $s['remarks'] === 'Passed'));
$passRate     = count($students) ? round(($passedCount / count($students)) * 100, 1) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade Management &middot; Student Grade Management System</title>
    <link rel="stylesheet" href="css/cssstyle.css">
</head>
<body class="grades-page">

<div class="grades-container">
    <header class="grades-header">
        <div class="header-identity">
            <span class="seal">SG</span>
            <div>
                <h2>Grade Management</h2>
                <p class="grades-subtitle"><?= htmlspecialchars($students[0]['subject'] ?? 'All Subjects') ?></p>
            </div>
        </div>
        <nav class="grades-nav">
            <a href="dashboard.php">&larr; Back to Dashboard</a>
        </nav>
    </header>

    <section class="summary-cards" aria-label="Class summary statistics">
        <div class="summary-card">
            <span class="summary-label">Total Students</span>
            <span class="summary-value"><?= count($students) ?></span>
        </div>
        <div class="summary-card">
            <span class="summary-label">Class Average</span>
            <span class="summary-value"><?= $classAverage ?>%</span>
        </div>
        <div class="summary-card">
            <span class="summary-label">Highest Grade</span>
            <span class="summary-value"><?= $highestGrade ?>%</span>
        </div>
        <div class="summary-card">
            <span class="summary-label">Lowest Grade</span>
            <span class="summary-value"><?= $lowestGrade ?>%</span>
        </div>
        <div class="summary-card">
            <span class="summary-label">Pass Rate</span>
            <span class="summary-value"><?= $passRate ?>%</span>
        </div>
    </section>

    <section class="table-controls">
        <input
            type="text"
            id="gradeSearch"
            placeholder="Search by name or student ID..."
            aria-label="Search student records"
        >

        <select id="statusFilter" aria-label="Filter by status">
            <option value="all">All Statuses</option>
            <option value="passed">Passed Only</option>
            <option value="failed">Failed Only</option>
        </select>

        <button type="button" id="exportCsvBtn" class="secondary-btn">Export CSV</button>
    </section>

    <div class="table-wrapper">
        <table id="gradesTable" class="grades-table">
            <thead>
                <tr>
                    <th data-sort="id" data-type="string">Student ID</th>
                    <th data-sort="name" data-type="string">Name</th>
                    <th data-sort="prelim" data-type="number">Prelim</th>
                    <th data-sort="midterm" data-type="number">Midterm</th>
                    <th data-sort="final" data-type="number">Final</th>
                    <th data-sort="average" data-type="number">Average</th>
                    <th data-sort="remarks" data-type="string">Remarks</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                <tr
                    data-search="<?= htmlspecialchars(strtolower($student['id'] . ' ' . $student['name'])) ?>"
                    data-status="<?= strtolower($student['remarks']) ?>"
                >
                    <td data-value="<?= htmlspecialchars($student['id']) ?>"><?= htmlspecialchars($student['id']) ?></td>
                    <td data-value="<?= htmlspecialchars($student['name']) ?>"><?= htmlspecialchars($student['name']) ?></td>
                    <td data-value="<?= $student['prelim'] ?>"><?= $student['prelim'] ?></td>
                    <td data-value="<?= $student['midterm'] ?>"><?= $student['midterm'] ?></td>
                    <td data-value="<?= $student['final'] ?>"><?= $student['final'] ?></td>
                    <td data-value="<?= $student['average'] ?>"><strong><?= $student['average'] ?></strong></td>
                    <td data-value="<?= htmlspecialchars($student['remarks']) ?>">
                        <span class="badge badge-<?= strtolower($student['remarks']) ?>"><?= htmlspecialchars($student['remarks']) ?></span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p id="noResultsMsg" class="no-results" hidden>No matching student records found.</p>
    </div>
</div>

<script src="js/jsapp.js"></script>
</body>
</html>
