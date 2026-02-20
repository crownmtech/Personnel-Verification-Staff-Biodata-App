<?php
require_once 'config.php';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="staff_records.csv"');

$out = fopen('php://output', 'w');

// Header row
fputcsv($out, [
    'S/N', 'ID', 'Title', 'Surname', 'First Name', 'Other Name', 'Date of Birth', 'Sex', 'Marital Status',
    'State of Origin', 'LGA (Origin)', 'State of Origin Address',
    'State of Residence', 'LGA (Residence)', 'Residential Address',
    'Phone', 'Email',
    'PSN No', 'File No', 'Rank / Position', 'Date of 1st Appointment', 'GL', 'Step', 'Salary Structure', 'Cadre',
    'Bank Name', 'Account Number', 'BVN', 'NIN',
    'Passport Path', 'Fingerprint Path', 'Created At'
]);

$stmt = $pdo->query('SELECT * FROM staff ORDER BY id ASC');
$sn = 1;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($out, [
        $sn++, $row['id'], $row['title'], $row['surname'], $row['first_name'], $row['other_name'], $row['date_of_birth'], $row['sex'], $row['marital_status'],
        $row['state_of_origin'], $row['lga_origin'], $row['state_of_origin_address'],
        $row['state_of_residence'], $row['lga_residence'], $row['residential_address'],
        $row['phone'], $row['email'],
        $row['psn_no'], $row['file_no'], $row['rank_position'], $row['date_of_first_appointment'], $row['gl_level'], $row['step_level'], $row['salary_structure'], $row['cadre'],
        $row['bank_name'], $row['account_number'], $row['bvn'], $row['nin'],
        $row['passport_path'], $row['fingerprint_path'], $row['created_at']
    ]);
}

fclose($out);
exit;
