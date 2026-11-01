<?php
$surname = $_POST['surname'] ?? '';
$email = $_POST['email'] ?? '';
$address = $_POST['address'] ?? '';
$state = $_POST['state'] ?? '-1';
$sex = $_POST['sex'] ?? '';
$vegetarian = isset($_POST['vegetarian']);
$states = array(
    "1" => "Australian Capital Territory",
    "2" => "Queensland",
    "3" => "Victoria",
    "4" => "New South Wales",
    "5" => "Tasmania",
    "6" => "South Australia",
    "7" => "Western Australia",
    "8" => "Northern Territory"
);
?>
<fieldset>
<legend>Person Details</legend>
<form name="myForm" action="processData_form.php" method="POST">
<div class="field">
<label for="surname">Surname</label>
<input type="text" name="surname" size="31" value="<?php echo htmlspecialchars($surname); ?>"/>
</div>
<div class="field">
<label for="email">Email address</label>
<input type="text" name="email" size="31" value="<?php echo htmlspecialchars($email); ?>"/>
</div>
<div class="field">
<label for="passwd">Password</label>
<input type="password" name="passwd" size="31"/>
</div>
<div class="field">
<label for="address">Street Address</label>
<textarea name="address" rows="3" cols="22"><?php echo htmlspecialchars($address); ?></textarea>
</div>
<div class="field">
<label for="state">State</label>
<select name="state">
<option value="-1">[choose your state]</option>
<?php
foreach ($states as $kode => $nama) {
    echo '<option value="' . $kode . '"';
    if ($state == $kode) {
        echo ' selected';
    }
    echo '>' . $nama . '</option>';
}
?>
</select>
</div>
<div class="field">
<input type="hidden" name="country" value="Australia"/>
</div>
<div class="field">
<label for="sex">Gender</label>
<input type="radio" name="sex" value="male"<?php if ($sex == "male") echo " checked"; ?>/>Male
<input type="radio" name="sex" value="female"<?php if ($sex == "female") echo " checked"; ?>/>Female
</div>
<div class="field">
<label for="vegetarian">Vegetarian?</label>
<input type="checkbox" name="vegetarian"<?php if ($vegetarian) echo " checked"; ?>/>
</div>
<div class="field">
<label>&nbsp;</label>
<input type="submit" value="Submit" name="submit"/><input type="reset" value="Reset" name="reset"/>
</div>
</form>
</fieldset>
