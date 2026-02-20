<?php
// Landing page with a "Start App" button that takes admin into the biodata system.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Personnel Verification - Start App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/styles.css" rel="stylesheet" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <span class="badge bg-primary rounded-circle me-2">PV</span>
            <span>Personnel Verification</span>
        </a>
    </div>
</nav>

<section class="app-hero">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card app-card app-card-gradient text-white p-4 p-md-5">
                    <div class="row align-items-center g-4">
                        <div class="col-md-7">
                            <h1 class="display-5 fw-bold mb-3">BIO-DATA FORM<br/>PERSONNEL VERIFICATION</h1>
                            <a href="staff_form.php" class="btn btn-light btn-lg btn-start d-inline-flex align-items-center">
                                <span class="me-2">Start App</span>
                                <span class="bi bi-arrow-right"></span>
                            </a>
                        </div>
                        <div class="col-md-5 text-md-end">
                            <div class="bg-white bg-opacity-10 rounded-4 p-3">
                                <p class="mb-2 small text-uppercase text-white-50">Quick Access</p>
                                <ul class="list-unstyled small mb-0">
                                    <li>• Staff Bio-Data Capture</li>
                                    <li>• Passport &amp; Fingerprint Capture</li>
                                    <li>• Local Storage (Custom Server)</li>
                                    <li>• Export: PDF, Excel, CSV</li>
                                </ul>
                                <hr class="border-light border-opacity-25 my-3" />
                                <a href="list_staff.php" class="btn btn-outline-light btn-sm">View Registered Staff</a>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="text-center text-muted mt-3 small">Powered By Jay Jassen Tech.</p>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
