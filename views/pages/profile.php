<?php
// filepath: coursework_scrum1.0/views/pages/profile.php

/** @var array $profileUser */

$profileOld = $_SESSION['profile_old_data'] ?? [];
$profileErrors = $_SESSION['profile_errors'] ?? [];
$profileSuccess = $_SESSION['success_message'] ?? '';

if (isset($_SESSION['profile_errors'])) {
    unset($_SESSION['profile_errors']);
}
if (isset($_SESSION['success_message'])) {
    unset($_SESSION['success_message']);
}

$displayFullname = $profileOld['fullname'] ?? ($profileUser['fullname'] ?? '');
$displayPhone = $profileOld['phone'] ?? ($profileUser['phone'] ?? '');
$displayAddress = $profileOld['address'] ?? ($profileUser['address'] ?? '');
$joinedDate = !empty($profileUser['created_at']) ? date('d/m/Y H:i', strtotime((string) $profileUser['created_at'])) : 'N/A';
$csrfToken = $_SESSION['csrf_tokens']['update_profile'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Born Car</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require_once __DIR__ . '/../layouts/header.php'; ?>

    <div class="container profile-page-wrap">
        <h1 class="page-title">My Profile</h1>

        <?php if (!empty($profileErrors)): ?>
            <div class="msg-error profile-msg-block">
                <?php foreach ($profileErrors as $error): ?>
                    <?= htmlspecialchars((string) $error) ?><br>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($profileSuccess)): ?>
            <div class="msg-success profile-msg-block"><?= htmlspecialchars((string) $profileSuccess) ?></div>
        <?php endif; ?>

        <div class="profile-card-box">
            <form action="index.php?action=update_profile" method="POST" autocomplete="off">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

                <div class="form-group">
                    <label for="profile_email">Email</label>
                    <input id="profile_email" type="email" class="form-control" value="<?= htmlspecialchars((string) ($profileUser['email'] ?? '')) ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="profile_fullname">Full Name <span class="required-star">*</span></label>
                    <input id="profile_fullname" type="text" name="fullname" class="form-control" value="<?= htmlspecialchars((string) $displayFullname) ?>" maxlength="100" required>
                </div>

                <div class="form-group">
                    <label for="profile_phone">Phone Number <span class="required-star">*</span></label>
                    <input id="profile_phone" type="text" name="phone" class="form-control" value="<?= htmlspecialchars((string) $displayPhone) ?>" maxlength="20" required>
                </div>

                <div class="form-group">
                    <label for="profile_address">Address</label>
                    <input id="profile_address" type="text" name="address" class="form-control" value="<?= htmlspecialchars((string) $displayAddress) ?>" maxlength="255">
                </div>

                <div class="profile-meta-row">
                    <span class="profile-meta-label">Member since</span>
                    <span class="profile-meta-value"><?= htmlspecialchars($joinedDate) ?></span>
                </div>

                <button type="submit" class="btn-submit profile-save-btn">Save Profile</button>
            </form>
        </div>
    </div>

    <?php include __DIR__ . '/../layouts/footer.php'; ?>
</body>

</html>