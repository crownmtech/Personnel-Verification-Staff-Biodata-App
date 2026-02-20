<?php
require_once 'config.php';

header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header('Content-Disposition: attachment; filename="staff_records.xls"');

echo "<table border='1'>";
// Header row
echo "<tr>
<th>S/N</th><th>ID</th><th>Title</th><th>Surname</th><th>First Name</th><th>Other Name</th>
<th>Date of Birth</th><th>Sex</th><th>Marital Status</th>
<th>State of Origin</th><th>LGA (Origin)</th><th>State of Origin Address</th>
<th>State of Residence</th><th>LGA (Residence)</th><th>Residential Address</th>
<th>Phone</th><th>Email</th>
<th>PSN No</th><th>File No</th><th>Rank / Position</th><th>Date of 1st Appointment</th>
<th>GL</th><th>Step</th><th>Salary Structure</th><th>Cadre</th>
<th>Bank Name</th><th>Account Number</th><th>BVN</th><th>NIN</th>
<th>Passport Path</th><th>Fingerprint Path</th><th>Created At</th>
</tr>";

$stmt = $pdo->query('SELECT * FROM staff ORDER BY id ASC');
$sn = 1;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>';
    echo '<td>' . $sn++ . '</td>';
    foreach ([
        'id','title','surname','first_name','other_name','date_of_birth','sex','marital_status',
        'state_of_origin','lga_origin','state_of_origin_address',
        'state_of_residence','lga_residence','residential_address',
        'phone','email',
        'psn_no','file_no','rank_position','date_of_first_appointment','gl_level','step_level','salary_structure','cadre',
        'bank_name','account_number','bvn','nin',
        'passport_path','fingerprint_path','created_at'
    ] as $field) {
        echo '<td>' . htmlspecialchars($row[$field]) . '</td>';
    }
    echo '</tr>';
}

echo '</table>';
exit;
