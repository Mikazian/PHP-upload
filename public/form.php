<?php

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === "POST") {

  $uploadDir = 'uploads/';
  $userInfo = array_map('trim', $_POST);
  $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);
  $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
  $authorizedExtensions = ['jpg', 'png', 'gif', 'webp'];
  $maxFileSize = 1000000;

  // Vérification formulaire
  if (empty($userInfo['firstname'])) {
    $errors[] = 'Le prénom est obligatoire';
  }

  if (empty($userInfo['lastname'])) {
    $errors[] = 'Le nom est obligatoire';
  }

  if (empty($userInfo['age'])) {
    $errors[] = 'L\'age est obligatoire';
  }

  if ($userInfo['age'] < 0) {
    $userInfo['age'] = 0;
    $errors[] = 'L\'age ne doit pas être inférieur à 0';
  }

  // Vérification upload
  if ((!in_array($extension, $authorizedExtensions))) {
    $errors[] = 'Veuillez sélectionner une image de type Jpg ou Png ou Gif ou Webp !';
  }

  if (file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize) {
    $errors[] = "Votre fichier doit faire moins de 1M !";
  }

  // si le fichier est ok
  if (empty($errors)) {
    $unique_id = uniqid();
    $new_file_name = 'avatar_' . $unique_id . '.' . $extension;
    $uploadFile = $uploadDir . $new_file_name;
    move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
    $success = "Le fichier $new_file_name a été téléchargé";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PHP - Upload</title>
  <link rel="stylesheet" href="/../assets/style/style.css" />
</head>

<body>

  <!-- ERRORS -->
  <?php if (!empty($errors)) : ?>
    <section class="errors-container">
      <ul>
        <?php foreach ($errors as $error) : ?>
          <li><?= $error ?></li>
        <?php endforeach ?>
      </ul>
    </section>
  <?php endif ?>

  </section>

  <!-- FORM -->
  <form method="post" enctype="multipart/form-data">
    <!-- champs formulaire -->
    <label for="firstname">Firstname</label>
    <input type="text" name="firstname" id="firstname" value="<?= $_POST['firstname'] ?? '' ?>" required />
    <label for="lastname">Lastname</label>
    <input type="text" name="lastname" id="lastname" value="<?= $_POST['lastname'] ?? '' ?>" required>
    <label for="age">Year</label>
    <input type="number" name="age" id="age" value="<?= $_POST['age'] ?? '' ?>" required>



    <!-- upload -->
    <label for="imageUpload">Upload an profil image</label>
    <input type="file" name="avatar" id="imageUpload" />
    <?= $success ?>

    <!-- button -->
    <div class="btn">
      <button name="send">Send</button>
    </div>

  </form>

  <!-- <?= var_dump($_POST) ?> -->

  <!-- CARD -->
  <section>
    <div class="card-user">
      <div class="card-title">
        <h1>Springfield, IL</h1>
      </div>
      <div class="card-content">
        <div class="card-container-info">
          <div class="card-info">
            <p>License#</p>
            <p>64209</p>
          </div>
          <div class="card-info">
            <p>Birth Date</p>
            <p>4-24-56</p>
          </div>
          <div class="card-info">
            <p>Expires</p>
            <p>4-24-2015</p>
          </div>
          <div class="card-info">
            <p>Class</p>
            <p>None</p>
          </div>
        </div>
        <div class="card-main-content">
          <div class="card-image">
            <!-- IMAGE -->
            <img src="<?= $uploadFile ?? '' ?>" alt="image card driver">
          </div>
          <div class="card-main-info">
            <div class="card-title-license">
              <h2>Drivers License</h2>
            </div>
            <div class="card-name-container">
              <div class="card-name">
                <p><?= htmlentities($_POST['firstname'] ?? '') . ' ' . htmlentities($_POST['lastname'] ?? '') ?></p>
                <p><?= htmlentities($_POST['age'] ?? '') . ' ' . ' old Plumtree BLVD ' ?></p>
                <p>Sprinfield, IL 62701</p>
              </div>
              <div class="card-container-info">
                <div class="card-info">
                  <p>sex</p>
                  <p>ok</p>
                </div>
                <div class="card-info">
                  <p>height</p>
                  <p>medium</p>
                </div>
                <div class="card-info">
                  <p>weight</p>
                  <p>medium</p>
                </div>
                <div class="card-info">
                  <p>hair</p>
                  <p>none</p>
                </div>
                <div class="card-info">
                  <p>eyes</p>
                  <p>oval</p>
                </div>
              </div>
              <div class="card-sign">
                <p>x <span><?= htmlentities($_POST['firstname'] ?? '') . ' ' . htmlentities($_POST['lastname'] ?? '') ?></span></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- <?= var_dump($_FILES); ?> -->
</body>

</html>