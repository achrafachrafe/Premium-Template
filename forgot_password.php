<?php

include "db.php";

$msg="";

if(isset($_POST["reset"])){

$email=trim($_POST["email"]);
$code=trim($_POST["recovery_code"]);
$password=password_hash($_POST["password"],PASSWORD_DEFAULT);

$stmt=$conn->prepare("
SELECT id
FROM admins
WHERE email=?
AND recovery_code=?
");

$stmt->bind_param("ss",$email,$code);

$stmt->execute();

$result=$stmt->get_result();

if($result->num_rows){

$update=$conn->prepare("
UPDATE admins
SET password=?
WHERE email=?
");

$update->bind_param(
"ss",
$password,
$email
);

$update->execute();

$msg="✅ Password updated successfully.";

}else{

$msg="❌ Invalid email or recovery code.";

}

}

?>

<!DOCTYPE html>
<html lang="fr">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Forgot Password</title>
<style>
    *{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{

    min-height:100vh;

    display:flex;

    justify-content:center;

    align-items:center;

    background:linear-gradient(135deg,#0f172a,#1e293b);

    padding:20px;

}

.card{

    width:100%;
    max-width:450px;

    background:rgba(255,255,255,.08);

    backdrop-filter:blur(20px);

    border:1px solid rgba(255,255,255,.15);

    border-radius:20px;

    padding:40px;

    color:#fff;

    box-shadow:0 20px 50px rgba(0,0,0,.35);

}

.card h2{

    text-align:center;

    margin-bottom:30px;

    font-size:30px;

}

.form-group{

    margin-bottom:20px;

}

.form-group label{

    display:block;

    margin-bottom:8px;

    font-weight:600;

}

.form-group input{

    width:100%;

    padding:14px 16px;

    border:none;

    border-radius:12px;

    outline:none;

    background:rgba(255,255,255,.08);

    color:#fff;

    border:1px solid rgba(255,255,255,.12);

    transition:.3s;

}

.form-group input:focus{

    border-color:#6C63FF;

    box-shadow:0 0 15px rgba(108,99,255,.35);

}

.form-group input::placeholder{

    color:#bbb;

}

button{

    width:100%;

    padding:15px;

    border:none;

    border-radius:12px;

    background:#6C63FF;

    color:#fff;

    font-size:17px;

    font-weight:700;

    cursor:pointer;

    transition:.3s;

}

button:hover{

    background:#4F46E5;

    transform:translateY(-2px);

}

.message{

    margin-bottom:20px;

    padding:15px;

    border-radius:10px;

    text-align:center;

    font-weight:600;

}

.success{

    background:rgba(46,204,113,.15);

    color:#2ecc71;

    border:1px solid #2ecc71;

}

.error{

    background:rgba(231,76,60,.15);

    color:#ff6b6b;

    border:1px solid #ff6b6b;

}

.back-login{

    text-align:center;

    margin-top:20px;

}

.back-login a{

    color:#6C63FF;

    text-decoration:none;

    font-weight:600;

}

.back-login a:hover{

    text-decoration:underline;

}
</style>
</head>

<body>

<div class="card">

<h2>Forgot Password</h2>

<?php if(!empty($msg)){ ?>

<div class="message <?= strpos($msg,'✅')!==false ? 'success':'error' ?>">
<?= $msg ?>
</div>

<?php } ?>

<form method="post">

<div class="form-group">
<label>Email</label>
<input type="email" name="email" required>
</div>

<div class="form-group">
<label>Recovery Code</label>
<input type="text" name="recovery_code" required>
</div>

<div class="form-group">
<label>New Password</label>
<input type="password" name="password" required>
</div>

<button type="submit" name="reset">
Reset Password
</button>

</form>

<div class="back-login">
<a href="login.php">← Back to Login</a>
</div>

</div>

</body>

</html>