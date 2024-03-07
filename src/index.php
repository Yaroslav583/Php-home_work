<?php
$errors = [
    'name' => null,
    'email' => null,
    'password' => null,
    'agreement' => null,


];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo 'IS GET';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo 'IS POST';
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $agreement = isset($_POST['agreement']) ? $_POST['agreement'] : null;

    /*
     * NAME
     */

    if ($name === '') {
        $errors['name'] = 'Name required';
    }

    $nameLength = mb_strlen($name);

    if ($nameLength < 3) {
        $errors['name'] = 'The name must be more than 3 characters';
    }
    if ($nameLength > 255) {
        $errors['name'] = 'The name must be less than 255 characters';
    }


    /*
     * EMAIL
     */

    if ($email === '') {
        $errors['email'] = 'Email required';
    }

    $emailLength = mb_strlen($email);

    if ($emailLength < 3) {
        $errors['email'] = 'The email must be more than 3 characters';
    }
    if ($emailLength > 255) {
        $errors['email'] = 'The email must be less than 255 characters';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email mast be valid email';
    }
    if (!preg_match('/^\S+@\S+\.\S+$/', $email)) {
        $errors['email'] = 'Email must contain @ and .';
    }

    /*
    * PASSWORD
    */

    if ($password === '') {
        $errors['password'] = 'Password required';
    }


    if (mb_strlen($password) < 8) {
        $errors['password'] = 'The password must be more than 8 characters';
    }
    if (!preg_match('/^[a-zA-Z0-9]+$/', $password)) {
        $errors['password'] = 'The password must contain letters and numbers';
    }


    /*
    * AGREEMENT
    */


    if ($agreement === null) {
        $errors['agreement'] = 'there must be an agreement';
    }


    /*
     * Clearing fields after successful validation check
    */


    if (empty(array_filter($errors))) {

        $_POST['name'] = '';
        $_POST['email'] = '';
        $_POST['password'] = '';
        $_POST['agreement'] = '';

    }
}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP GET/POST</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h2 class="mt-5 mb-3">Registration</h2>
    <form method="POST" action="index.php">
        <div class="form-group mt-5">
            <label for="name">Name</label>
            <input type="text" class="form-control <?= !empty($errors['name']) ? 'is-invalid' : '' ?>" id="name"
                   name="name" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">
            <div class="invalid-feedback"><?= $errors['name'] ?></div>
        </div>
        <div class="form-group mt-3">
            <label for="email">Email</label>
            <input type="email" class="form-control <?= !empty($errors['email']) ? 'is-invalid' : '' ?>" id="email"
                   name="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
            <div class="invalid-feedback"><?= $errors['email'] ?></div>

        </div>
        <div class="form-group mt-3">
            <label for="password">Password</label>
            <input type="password" class="form-control <?= !empty($errors['password']) ? 'is-invalid' : '' ?>"
                   id="password" name="password">
            <div class="invalid-feedback"><?= $errors['password'] ?></div>
        </div>
        <div class="form-group mt-3">
            <label for="country">Country</label>
            <select class="form-control" id="country" name="country">
                <option value="ukraine">Ukraine</option>
                <option value="poland">Poland</option>
                <option value="usa">USA</option>
            </select>
        </div>
        <div class="form-group mt-5">
            <label>Gender</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="male" value="male" checked>
                <label class="form-check-label" for="male">Man</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                <label class="form-check-label" for="female">Woman</label>
            </div>
        </div>
        <div class=" form-check mt-5">
            <input type="checkbox" class="form-check-input <?= !empty($errors['agreement']) ? 'is-invalid' : '' ?>"
                   id="agreement" name="agreement" <?= isset($_POST['agreement']) ? 'checked' : '' ?>>

            <label class="form-check-label" for="agreement">I agree with the terms of the site</label>
            <div class="invalid-feedback"><?= $errors['agreement'] ?></div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Sign up</button>
    </form>
</div>
</body>
</html>