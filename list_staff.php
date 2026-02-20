<?php
require_once 'config.php';

$stmt = $pdo->query('SELECT * FROM staff ORDER BY id ASC');
$staff = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registered Staff - Personnel Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/styles.css" rel="stylesheet" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <span class="badge bg-primary rounded-circle me-2">PV</span>
            <span>Personnel Verification</span>
        </a>
        <div class="d-flex gap-2">
            <a href="staff_form.php" class="btn btn-primary btn-sm">New Registration</a>
        </div>
    </div>
</nav>

<div class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">Registered Staff</h2>
        <div class="d-flex gap-2">
            <div class="btn-group">
                <a href="export_csv.php" class="btn btn-outline-secondary btn-sm">Export CSV</a>
                <a href="export_excel.php" class="btn btn-outline-success btn-sm">Export Excel</a>
                <a href="export_pdf.php" class="btn btn-outline-danger btn-sm">Export PDF</a>
            </div>
            <form action="reset_database.php" method="post" onsubmit="return confirm('This will delete ALL staff records and their passport/fingerprint files. Continue?');">
                <button type="submit" class="btn btn-outline-danger btn-sm">Clear Database</button>
            </form>
        </div>
    </div>

    <?php if (isset($_GET['saved'])): ?>
        <div class="alert alert-success alert-sm py-2">Staff record saved successfully.</div>
    <?php endif; ?>
    <?php if (isset($_GET['reset'])): ?>
        <div class="alert alert-warning alert-sm py-2">All staff records and image files have been cleared.</div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle table-sm mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Passport</th>
                        <th>Full Name</th>
                        <th>PSN / File No</th>
                        <th>Rank / Position</th>
                        <th>State (Origin / Residence)</th>
                        <th>Phone</th>
                        <th>E-mail</th>
                        <th>Fingerprint</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!$staff): ?>
                    <tr><td colspan="10" class="text-center text-muted py-4">No staff registered yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($staff as $index => $row): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td>
                                <?php if (!empty($row['passport_path']) && file_exists(__DIR__ . '/' . $row['passport_path'])): ?>
                                    <img src="<?php echo htmlspecialchars($row['passport_path']); ?>" class="table-avatar" alt="Passport" />
                                <?php else: ?>
                                    <span class="text-muted small">N/A</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-uppercase">
                                <?php echo htmlspecialchars($row['title'] . ' ' . $row['surname'] . ' ' . $row['first_name'] . ' ' . $row['other_name']); ?>
                            </td>
                            <td class="text-uppercase small">
                                <?php echo htmlspecialchars($row['psn_no']); ?><br />
                                <span class="text-muted"><?php echo htmlspecialchars($row['file_no']); ?></span>
                            </td>
                            <td class="text-uppercase small"><?php echo htmlspecialchars($row['rank_position']); ?></td>
                            <td class="text-uppercase small">
                                <?php echo htmlspecialchars($row['state_of_origin']); ?><br />
                                <span class="text-muted"><?php echo htmlspecialchars($row['state_of_residence']); ?></span>
                            </td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td class="small"><?php echo htmlspecialchars($row['email']); ?></td>
                            <td>
                                <?php if (!empty($row['fingerprint_path']) && file_exists(__DIR__ . '/' . $row['fingerprint_path'])): ?>
                                    <img src="<?php echo htmlspecialchars($row['fingerprint_path']); ?>" class="table-avatar" alt="Fingerprint" />
                                <?php else: ?>
                                    <span class="text-muted small">N/A</span>
                                <?php endif; ?>
                            </td>
                            <td class="small text-muted"><?php echo htmlspecialchars($row['created_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
