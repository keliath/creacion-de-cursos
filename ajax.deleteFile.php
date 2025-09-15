<?php
// Delete temporary uploaded files for a given professor id.
// Accept id from POST 'idProfe', GET 'idProfe', GET 'idp', or caller variable $idProfe when included.

$id = null;
if (isset($_POST['idProfe'])) {
    $id = $_POST['idProfe'];
} elseif (isset($_GET['idProfe'])) {
    $id = $_GET['idProfe'];
} elseif (isset($_GET['idp'])) {
    $id = $_GET['idp'];
} elseif (isset($idProfe)) {
    $id = $idProfe;
}

if ($id === null || $id === '') {
    // Nothing to do; avoid emitting warnings that would break headers.
    return;
}

$pattern = "./temp/" . $id . "/*";
$matches = glob($pattern) ?: [];
foreach ($matches as $path) {
    if (is_file($path)) {
        @unlink($path);
    }
}
