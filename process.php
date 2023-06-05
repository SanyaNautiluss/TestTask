<?php

// обробка AJAX запиту на php
$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmpassword = $_POST['confirmpassword'];

// Валідація email, паролів
if (strpos($email, '@') === false) {
    echo "Email повинен містити символ '@'.";
    exit;
}
if ($password !== $confirmpassword) {
    echo 'Паролі не співпадають.';
    return;
  }

// Масив з існуючими користувачами 
  require_once 'Users.php';

// Перевірка, чи існує користувач з таким email
foreach ($users as $user) {
    if ($user['email'] === $email) {
        echo "Користувач з таким email вже існує.";
        exit;
    }
}

// Логування результату перевірки в файл
$log = "Реєстрація: " . date('Y-m-d H:i:s') . " - Новий користувач: " . $name . " " . $surname . " (" . $email . ")";
file_put_contents('registration.log', $log . PHP_EOL, FILE_APPEND);

// запис даних з форми до масива з існуючими користувачами
$newUser = array(
    'id' => count($users) + 1,
    'name' => $name,
    'email' => $email,
    'password' => $password
);
$users[] = $newUser;
file_put_contents('users.php', '<?php $users = ' . var_export($users, true) . ';');
echo "success"; 
?>
