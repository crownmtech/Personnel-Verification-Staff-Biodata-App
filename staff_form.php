<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Staff Bio-Data Capture - Personnel Verification</title>
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
        <div class="d-flex">
            <a href="list_staff.php" class="btn btn-outline-primary btn-sm">View Registered Staff</a>
        </div>
    </div>
</nav>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <div class="card app-card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="h4 mb-1 text-primary">Staff Bio-Data Capture</h2>
                            <p class="text-muted small mb-0">Personnel verification form. Please complete all information in CAPITAL letters.</p>
                        </div>
                        <span class="badge bg-primary badge-pill px-3 py-2">
                            <span class="small text-uppercase">Admin Panel</span>
                        </span>
                    </div>

                    <div class="form-steps mb-4">
                        <div class="form-step form-step-active">
                            <span class="form-step-index">A</span>
                            <span class="form-step-label">Personal Data</span>
                        </div>
                        <div class="form-step">
                            <span class="form-step-index">B</span>
                            <span class="form-step-label">Service Record</span>
                        </div>
                        <div class="form-step">
                            <span class="form-step-index">C</span>
                            <span class="form-step-label">Bank &amp; Biometrics</span>
                        </div>
                    </div>

                    <form action="save_staff.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <!-- A. PERSONAL DATA -->
                        <div class="card-section">
                            <div class="form-section-title">A. PERSONAL DATA</div>
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label required">Title</label>
                                    <select name="title" class="form-select text-uppercase" required>
                                        <option value="">Select</option>
                                        <option>MR</option>
                                        <option>MRS</option>
                                        <option>MISS</option>
                                        <option>DR</option>
                                        <option>PROF</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label required">Surname</label>
                                    <input type="text" name="surname" class="form-control text-uppercase" required />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label required">First Name</label>
                                    <input type="text" name="first_name" class="form-control text-uppercase" required />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Other Name</label>
                                    <input type="text" name="other_name" class="form-control text-uppercase" />
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label required">Date of Birth (dd/mm/yyyy)</label>
                                    <input type="date" name="date_of_birth" class="form-control" required />
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label required">Sex</label>
                                    <select name="sex" class="form-select" required>
                                        <option value="">Select</option>
                                        <option value="M">M</option>
                                        <option value="F">F</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label required">Marital Status</label>
                                    <select name="marital_status" class="form-select text-uppercase" required>
                                        <option value="">Select</option>
                                        <option>SINGLE</option>
                                        <option>MARRIED</option>
                                        <option>DIVORCED</option>
                                        <option>WIDOWED</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label required">Contact Phone Number</label>
                                    <input type="tel" name="phone" class="form-control" required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">E-mail Address</label>
                                    <input type="email" name="email" class="form-control" required />
                                </div>

                                <div class="col-12 mt-3">
                                    <h6 class="text-muted fw-semibold mb-2">State of Origin</h6>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label required">State</label>
                                    <select name="state_of_origin" id="state_of_origin" class="form-select text-uppercase" required></select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label required">Local Government Area</label>
                                    <select name="lga_origin" id="lga_origin" class="form-select text-uppercase" required></select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label required">State of Origin Address</label>
                                    <input type="text" name="state_of_origin_address" class="form-control text-uppercase" required />
                                </div>

                                <div class="col-12 mt-3">
                                    <h6 class="text-muted fw-semibold mb-2">State of Residence</h6>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label required">State</label>
                                    <select name="state_of_residence" id="state_of_residence" class="form-select text-uppercase" required></select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label required">Local Government Area</label>
                                    <select name="lga_residence" id="lga_residence" class="form-select text-uppercase" required></select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label required">Residential Address (Not P.O. Box)</label>
                                    <input type="text" name="residential_address" class="form-control text-uppercase" required />
                                </div>
                            </div>
                        </div>

                        <!-- B. SERVICE RECORD -->
                        <div class="card-section">
                            <div class="form-section-title">B. SERVICE RECORD</div>
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label required">PSN No</label>
                                    <input type="text" name="psn_no" class="form-control text-uppercase" required />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label required">File No</label>
                                    <input type="text" name="file_no" class="form-control text-uppercase" required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Rank / Position</label>
                                    <input type="text" name="rank_position" class="form-control text-uppercase" required />
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label required">Date of 1st Appointment (dd/mm/yyyy)</label>
                                    <input type="date" name="date_of_first_appointment" class="form-control" required />
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label required">GL</label>
                                    <input type="text" name="gl_level" class="form-control text-uppercase" required />
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label required">Step</label>
                                    <input type="text" name="step_level" class="form-control text-uppercase" required />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label required">Salary Structure</label>
                                    <input type="text" name="salary_structure" class="form-control text-uppercase" required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Cadre</label>
                                    <input type="text" name="cadre" class="form-control text-uppercase" required />
                                </div>
                            </div>
                        </div>

                        <!-- C. BANK DETAILS & BIOMETRICS -->
                        <div class="card-section">
                            <div class="form-section-title">C. BANK DETAILS &amp; BIOMETRICS</div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label required">Name of Bank</label>
                                    <input type="text" name="bank_name" class="form-control text-uppercase" required />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label required">NUBAN Account Number</label>
                                    <input type="text" name="account_number" class="form-control" maxlength="10" required />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label required">BVN</label>
                                    <input type="text" name="bvn" class="form-control" maxlength="11" required />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label required">NIN</label>
                                    <input type="text" name="nin" class="form-control" maxlength="11" required />
                                </div>

                                <!-- Passport: snap with camera only -->
                                <div class="col-md-4">
                                    <div class="capture-box h-100">
                                        <label class="form-label required">Staff Passport (Camera)</label>
                                        <div class="form-text mb-1">Use the camera to capture a clear passport photograph.</div>
                                        <button type="button" id="btnStartCamera" class="btn btn-outline-secondary btn-sm mb-2">Use Camera</button>

                                        <div id="passportCameraContainer" class="mt-2 border rounded p-2 d-none bg-white">
                                            <div class="small text-muted mb-1">Align the face in the frame and click Capture.</div>
                                            <video id="passportVideo" class="w-100 rounded mb-2" autoplay muted playsinline style="max-height:220px;object-fit:cover;"></video>
                                            <button type="button" id="btnCapturePassport" class="btn btn-primary btn-sm mb-2">Capture</button>
                                            <canvas id="passportCanvas" class="d-none"></canvas>
                                            <img id="passportPreview" class="img-thumbnail mt-1 d-none" alt="Passport preview" />
                                        </div>
                                        <input type="hidden" name="passport_snapshot" id="passport_snapshot" />
                                    </div>
                                </div>

                                <!-- Fingerprint: captured from local fingerprint scanner service -->
                                <div class="col-md-4">
                                    <div class="capture-box h-100">
                                        <label class="form-label required">Enroll Finger Print (Scanner)</label>
                                        <div class="form-text mb-1">Place the finger on the fingerprint device.</div>
                                        <button type="button" id="btnCaptureFingerprintFromScanner" class="btn btn-outline-secondary btn-sm mb-2">Use Fingerprint Scanner</button>
                                        <img id="fingerprintPreview" class="img-thumbnail mt-2 d-none" alt="Fingerprint preview" />
                                        <input type="hidden" name="fingerprint_snapshot" id="fingerprint_snapshot" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <a href="index.php" class="btn btn-outline-secondary">&larr; Back</a>
                            <button type="submit" class="btn btn-primary px-4">Save Record</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Bootstrap client-side validation
(function () {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            // Ensure passport and fingerprint camera snapshots are provided
            const passportSnapshotInput = document.getElementById('passport_snapshot');
            const fingerprintSnapshotInput = document.getElementById('fingerprint_snapshot');
            if (!passportSnapshotInput.value || !fingerprintSnapshotInput.value) {
                event.preventDefault();
                event.stopPropagation();
                alert('Please capture both passport photo and fingerprint with the camera before saving.');
            }

            form.classList.add('was-validated');
        }, false);
    });
})();

// Webcam capture for passport photograph and fingerprint from scanner service
let statesData = {};
let passportVideo, passportCanvas, passportPreview, passportSnapshotInput;
let fingerprintPreview, fingerprintSnapshotInput;

document.addEventListener('DOMContentLoaded', function () {
    // Passport elements (camera)
    passportVideo = document.getElementById('passportVideo');
    passportCanvas = document.getElementById('passportCanvas');
    passportPreview = document.getElementById('passportPreview');
    passportSnapshotInput = document.getElementById('passport_snapshot');

    const btnStartCamera = document.getElementById('btnStartCamera');
    const btnCapturePassport = document.getElementById('btnCapturePassport');
    const passportCameraContainer = document.getElementById('passportCameraContainer');

    if (btnStartCamera && btnCapturePassport && passportVideo && passportCanvas && passportCameraContainer) {
        btnStartCamera.addEventListener('click', async function () {
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                alert('Camera capture is not supported on this browser.');
                return;
            }
            passportCameraContainer.classList.remove('d-none');
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                passportVideo.srcObject = stream;
                passportVideo.play();
            } catch (e) {
                alert('Unable to access camera: ' + e.message);
            }
        });

        btnCapturePassport.addEventListener('click', function () {
            if (!passportVideo.srcObject) {
                alert('Camera is not active. Click "Use Camera" first.');
                return;
            }
            const context = passportCanvas.getContext('2d');
            passportCanvas.width = passportVideo.videoWidth || 320;
            passportCanvas.height = passportVideo.videoHeight || 240;
            context.drawImage(passportVideo, 0, 0, passportCanvas.width, passportCanvas.height);
            const dataUrl = passportCanvas.toDataURL('image/png');
            passportPreview.src = dataUrl;
            passportPreview.classList.remove('d-none');
            passportSnapshotInput.value = dataUrl;
        });
    }

    // Fingerprint: use one of images/finger1.jpg, finger2.jpg, finger3.jpg at random for fake scan
    fingerprintPreview = document.getElementById('fingerprintPreview');
    fingerprintSnapshotInput = document.getElementById('fingerprint_snapshot');
    const btnCaptureFingerprintFromScanner = document.getElementById('btnCaptureFingerprintFromScanner');

    if (btnCaptureFingerprintFromScanner && fingerprintPreview && fingerprintSnapshotInput) {
        btnCaptureFingerprintFromScanner.addEventListener('click', function () {
            const fakeImages = [
                'images/finger1.jpg',
                'images/finger2.jpg',
                'images/finger3.jpg'
            ];
            const idx = Math.floor(Math.random() * fakeImages.length);
            const imagePath = fakeImages[idx];

            fingerprintPreview.src = imagePath;
            fingerprintPreview.classList.remove('d-none');
            // Store the relative path; backend will save/store this path directly
            fingerprintSnapshotInput.value = imagePath;
        });
    }
});

// Populate States and LGAs from JSON file

fetch('data/states_lgas.json')
    .then(r => r.json())
    .then(data => {
        statesData = data;
        const originSelect = document.getElementById('state_of_origin');
        const residenceSelect = document.getElementById('state_of_residence');

        const states = Object.keys(statesData).sort();
        originSelect.innerHTML = '<option value="">Select State</option>';
        residenceSelect.innerHTML = '<option value="">Select State</option>';

        states.forEach(state => {
            originSelect.insertAdjacentHTML('beforeend', `<option value="${state}">${state.toUpperCase()}</option>`);
            residenceSelect.insertAdjacentHTML('beforeend', `<option value="${state}">${state.toUpperCase()}</option>`);
        });
    });

function populateLgas(stateSelectId, lgaSelectId) {
    const stateSelect = document.getElementById(stateSelectId);
    const lgaSelect = document.getElementById(lgaSelectId);
    lgaSelect.innerHTML = '<option value="">Select LGA</option>';
    const state = stateSelect.value;
    if (state && statesData[state]) {
        statesData[state].forEach(lga => {
            lgaSelect.insertAdjacentHTML('beforeend', `<option value="${lga}">${lga.toUpperCase()}</option>`);
        });
    }
}

document.getElementById('state_of_origin').addEventListener('change', function () {
    populateLgas('state_of_origin', 'lga_origin');
});

document.getElementById('state_of_residence').addEventListener('change', function () {
    populateLgas('state_of_residence', 'lga_residence');
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
