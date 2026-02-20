<?php
require_once 'config.php';

// This export uses the FPDF library. Download FPDF from https://www.fpdf.org and place
// the main fpdf.php file in a "lib" directory next to this file, e.g. lib/fpdf.php
// Then this script will generate a simple landscape PDF table of all staff records.

$fpdfPath = __DIR__ . '/lib/fpdf.php';
if (!file_exists($fpdfPath)) {
    header('Content-Type: text/html; charset=utf-8');
    echo '<h3>PDF export not configured</h3>';
    echo '<p>The FPDF library is missing. To enable PDF export:</p>';
    echo '<ol>';
    echo '<li>Download FPDF from <a href="https://www.fpdf.org" target="_blank" rel="noopener">https://www.fpdf.org</a> (latest stable zip).</li>';
    echo '<li>Create a <code>lib</code> folder inside this application directory.</li>';
    echo '<li>Copy <code>fpdf.php</code> from the FPDF zip into the <code>lib</code> folder so the path is <code>lib/fpdf.php</code>.</li>';
    echo '</ol>';
    exit;
}

require_once $fpdfPath;

class StaffPDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 8, 'STAFF BIO-DATA - PERSONNEL VERIFICATION', 0, 1, 'C');
        $this->Ln(2);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 7);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

$pdf = new StaffPDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->SetFont('Arial', '', 8);
$pdf->SetAutoPageBreak(true, 15);

function pdf_text($pdf, $text)
{
    return iconv('UTF-8', 'ISO-8859-1//TRANSLIT', (string)$text);
}

$stmt = $pdo->query('SELECT * FROM staff ORDER BY id ASC');
$sn = 1;
$recordsPerPage = 2;
$recordsOnCurrentPage = 0;
$pageContentTopY = 0; // will be set after AddPage() based on header
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // Ensure at most two staff records per page
    if ($recordsOnCurrentPage == 0 || $recordsOnCurrentPage >= $recordsPerPage) {
        $pdf->AddPage();
        // After AddPage(), Header() has run; record top Y for content area
        $pageContentTopY = $pdf->GetY();
        $recordsOnCurrentPage = 0;
    }
    $recordsOnCurrentPage++;

    // For the second record on the same page, start lower on the page
    if ($recordsOnCurrentPage == 2) {
        // Compute a mid-page starting Y based on page height and known bottom margin
        if (method_exists($pdf, 'GetPageHeight')) {
            $pageHeight = $pdf->GetPageHeight();
        } else {
            // Fallback to A4 portrait height in mm
            $pageHeight = 297;
        }
        // We know we set an auto page break bottom margin of 15mm
        $bottomMargin = 15;
        $topY         = $pageContentTopY > 0 ? $pageContentTopY : $pdf->GetY();
        $usableHeight = $pageHeight - $topY - $bottomMargin;
        $halfHeight   = $usableHeight / 2;
        $secondStartY = $topY + $halfHeight + 5; // small gap between halves
        $pdf->SetY($secondStartY);
    }

    $fullName = strtoupper(trim($row['title'] . ' ' . $row['surname'] . ' ' . $row['first_name'] . ' ' . $row['other_name']));

    // Per-staff title before displaying details
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 6, pdf_text($pdf, 'STAFF BIO-DATA - PERSONNEL VERIFICATION'), 0, 1, 'C');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(0, 6, pdf_text($pdf, 'FULL DETAIL OF ' . $fullName), 0, 1, 'C');
    $pdf->Ln(1);

    // Header line per staff (S/N, ID, NAME)
    $pdf->SetFont('Arial', 'B', 8);
    $headerLine = sprintf('S/N: %d   ID: %s   NAME: %s',
        $sn++,
        $row['id'],
        $fullName
    );
    $pdf->Cell(0, 6, pdf_text($pdf, $headerLine), 0, 1, 'L');

    $pdf->SetFont('Arial', '', 8);

    // Define two-column layout (left: A-C details, right: D. Biometrics & Meta)
    $leftX         = $pdf->GetX();
    $topY          = $pdf->GetY();
    $leftColWidth  = 120; // mm
    $rightColWidth = 60;  // mm
    $columnGap     = 10;  // mm between columns
    $rightX        = $leftX + $leftColWidth + $columnGap;

    // A. PERSONAL DATA
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell($leftColWidth, 5, pdf_text($pdf, 'A. PERSONAL DATA'), 0, 1, 'L');
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell($leftColWidth, 4, pdf_text($pdf, 'DOB: ' . $row['date_of_birth'] . '   Sex: ' . $row['sex'] . '   Marital: ' . $row['marital_status']), 0, 1, 'L');
    $pdf->Cell($leftColWidth, 4, pdf_text($pdf, 'State of Origin: ' . $row['state_of_origin'] . ' (' . $row['lga_origin'] . ')'), 0, 1, 'L');
    $pdf->Cell($leftColWidth, 4, pdf_text($pdf, 'Origin Address: ' . $row['state_of_origin_address']), 0, 1, 'L');
    $pdf->Cell($leftColWidth, 4, pdf_text($pdf, 'State of Residence: ' . $row['state_of_residence'] . ' (' . $row['lga_residence'] . ')'), 0, 1, 'L');
    $pdf->Cell($leftColWidth, 4, pdf_text($pdf, 'Residential Address: ' . $row['residential_address']), 0, 1, 'L');
    $pdf->Cell($leftColWidth, 4, pdf_text($pdf, 'Phone: ' . $row['phone'] . '   Email: ' . $row['email']), 0, 1, 'L');

    // B. SERVICE RECORD
    $pdf->Ln(1);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell($leftColWidth, 5, pdf_text($pdf, 'B. SERVICE RECORD'), 0, 1, 'L');
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell($leftColWidth, 4, pdf_text($pdf, 'PSN No: ' . $row['psn_no'] . '   File No: ' . $row['file_no']), 0, 1, 'L');
    $pdf->Cell($leftColWidth, 4, pdf_text($pdf, 'Rank / Position: ' . $row['rank_position']), 0, 1, 'L');
    $pdf->Cell($leftColWidth, 4, pdf_text($pdf, 'Date of 1st Appointment: ' . $row['date_of_first_appointment']), 0, 1, 'L');
    $pdf->Cell($leftColWidth, 4, pdf_text($pdf, 'GL: ' . $row['gl_level'] . '   Step: ' . $row['step_level'] . '   Salary Structure: ' . $row['salary_structure']), 0, 1, 'L');
    $pdf->Cell($leftColWidth, 4, pdf_text($pdf, 'Cadre: ' . $row['cadre']), 0, 1, 'L');

    // C. BANK DETAILS
    $pdf->Ln(1);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell($leftColWidth, 5, pdf_text($pdf, 'C. BANK DETAILS'), 0, 1, 'L');
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell($leftColWidth, 4, pdf_text($pdf, 'Bank: ' . $row['bank_name'] . '   Account No: ' . $row['account_number']), 0, 1, 'L');
    $pdf->Cell($leftColWidth, 4, pdf_text($pdf, 'BVN: ' . $row['bvn'] . '   NIN: ' . $row['nin']), 0, 1, 'L');

    // Capture bottom of left column to align right column height
    $leftBottomY = $pdf->GetY();

    // D. BIOMETRICS & META (right-hand side)
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetXY($rightX, $topY);
    $pdf->Cell($rightColWidth, 5, pdf_text($pdf, 'D. BIOMETRICS & META'), 0, 1, 'L');

    $passportFile = !empty($row['passport_path']) ? __DIR__ . '/' . $row['passport_path'] : null;
    $fingerFile   = !empty($row['fingerprint_path']) ? __DIR__ . '/' . $row['fingerprint_path'] : null;

    // Calculate vertical space for passport and fingerprint so they align with left column height
    $imagesTopY      = $topY + 7; // heading height (5) + small gap
    $columnBottomY   = $leftBottomY;
    $availableHeight = $columnBottomY - $imagesTopY;
    if ($availableHeight < 20) {
        $availableHeight = 20; // minimum height to avoid zero or negative values
    }
    $imageGap       = 4; // gap between passport and fingerprint
    $slotHeight     = ($availableHeight - $imageGap) / 2;
    $passportHeight = $slotHeight;
    $fingerHeight   = $slotHeight;

    // Passport (top, right column)
    $passportY = $imagesTopY;
    if ($passportFile && file_exists($passportFile)) {
        // Draw passport using fixed height; width is automatic to preserve aspect ratio
        $pdf->Image($passportFile, $rightX, $passportY, 0, $passportHeight);
    } else {
        $pdf->SetXY($rightX, $passportY);
        $pdf->Rect($rightX, $passportY, $rightColWidth, $passportHeight);
        $pdf->SetFont('Arial', 'I', 7);
        $pdf->SetXY($rightX, $passportY + $passportHeight / 2 - 2);
        $pdf->Cell($rightColWidth, 4, pdf_text($pdf, 'No Passport'), 0, 0, 'C');
        $pdf->SetFont('Arial', '', 8);
    }

    // Fingerprint (below passport, right column)
    $fingerY = $passportY + $passportHeight + $imageGap;
    if ($fingerFile && file_exists($fingerFile)) {
        // Draw fingerprint using fixed height; width is automatic to preserve aspect ratio
        $pdf->Image($fingerFile, $rightX, $fingerY, 0, $fingerHeight);
    } else {
        $pdf->SetXY($rightX, $fingerY);
        $pdf->Rect($rightX, $fingerY, $rightColWidth, $fingerHeight);
        $pdf->SetFont('Arial', 'I', 7);
        $pdf->SetXY($rightX, $fingerY + $fingerHeight / 2 - 2);
        $pdf->Cell($rightColWidth, 4, pdf_text($pdf, 'No Fingerprint'), 0, 0, 'C');
        $pdf->SetFont('Arial', '', 8);
    }

    // Move cursor below the tallest column and print meta info
    $finalY = max($leftBottomY, $fingerY + $fingerHeight);
    $pdf->SetXY($leftX, $finalY + 2);
    $pdf->Cell(0, 4, pdf_text($pdf, 'Created At: ' . $row['created_at']), 0, 1, 'L');

    // Spacer between records (each record already on its own page)
    $pdf->Ln(3);
}

$pdf->Output('D', 'staff_records.pdf');
exit;
