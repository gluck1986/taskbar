<?php
/**
 * @var string $error
 * @var string $name
 */

if ($error) {
    echo <<<HTML
<div class="alert alert-warning" role="alert">
  $error
</div>
HTML;

}
?>

<form class="form-signin" method="post">
    <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72"
         height="72">
    <h1 class="h3 mb-3 font-weight-normal">Вход</h1>
    <label for="inputName" class="sr-only">Имя</label>
    <input type="text" value="<?= $name ?>" name="name" id="inputName" class="form-control" placeholder="имя" required
           autofocus>
    <label for="inputPassword" class="sr-only">Пароль</label>
    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
</form>
