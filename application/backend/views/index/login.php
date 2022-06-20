<?php

$inputEmail = HelperForm::input('email', 'form[email]', $data['name'] ?? '', 'form-control', 'placeholder="Email"');
$inputPassword = HelperForm::input('password', 'form[password]', $data['name'] ?? '', 'form-control', 'placeholder="Password"');

$linkAction = URL::createLink($this->arrParams['module'], $this->arrParams['controller'], $this->arrParams['action'])
?>
<?= $this->errors ?? '' ?>
<form action="<?= $linkAction ?>" method="post">
    <div class="input-group mb-3">
        <?= $inputEmail ?>
        <?= HelperForm::iconFormLogin('fa-envelope') ?>
    </div>
    <div class="input-group mb-3">
        <?= $inputPassword ?>
        <?= HelperForm::iconFormLogin('fa-lock') ?>
    </div>
    <button type="submit" name="form[submit]" value="submit" class="btn btn-info btn-block">Sign In</button>
</form>