<?php
session_start();
include("includes/db.php");
include("includes/header.php");
?>
<div class="layout">

    <?php include("includes/sidebar.php"); ?>

<div class="main">

<div class="card contact-card">

<h2>Contact Us</h2>

<p class="sub-text">
If you have an inquiry regarding MCAPrepHub, we'll help you find the right answer in no time.
</p>

<form method="POST" class="contact-form">

<div class="form-group">
<label>Select Subject</label>
<select name="subject" required>
    <option value="General Inquiry">General Inquiry</option>
    <option value="Report">Report</option>
</select>
</div>

<div class="form-group">
<label>Email</label>
<input type="email" name="email" placeholder="Enter your email" required>
</div>

<div class="form-group">
<label>Phone No</label>
<input type="text" name="phone" placeholder="Enter phone number" required>
</div>

<div class="form-group">
<label>Your Question</label>
<textarea name="message" placeholder="Write your query..." required></textarea>
</div>

<button class="btn submit-btn" name="submit">Submit</button>

</form>
</div>
</div>
</div>
<?php include("includes/footer.php"); ?>

<?php
if(isset($_POST['submit'])){
    $subject=$_POST['subject'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $msg=$_POST['message'];

    mysqli_query($conn,"INSERT INTO queries(subject,email,phone,message)
    VALUES('$subject','$email','$phone','$msg')");

    echo "<script>alert('Query submitted successfully');</script>";
}
?>