<?php

if (!isset($_SERVER['argv'][2])) {
	echo '
Add new user to database.

Usage: create-user.php <email> <password>
';
	exit(1);
}

list(, $email, $password) = $_SERVER['argv'];

$container = require __DIR__ . '/../bootstrap.php';
/** @var App\Model\UserManager $manager */
$manager = $container->getByType(App\Model\UserManager::class);

try {
	$manager->add($email, $password, TRUE);
	echo "User $email was added.\n";

} catch (App\Model\DuplicateNameException $e) {
	echo "Error: duplicate name.\n";
	exit(1);
}
