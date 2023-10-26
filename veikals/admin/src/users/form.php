
<?php
    function outputAlert ($strMsg) {
        echo "<div class='alert alert-danger'>";
            echo $strMsg;
        echo "</div>";
    }
?>

<div class="form-group">
    <label for="name">
        Vārds<span class="required-star">*</span>
    </label>
    <input type="text" class="form-control" name="name" id="name" placeholder="Ievadi vārdu" 
        value="<?php if(isset($name)) echo $name; ?>">
    <?php
        if(isset($name) && empty($name))
            outputAlert("Name is required");
    ?>
</div>
<div class="form-group">
    <label for="surname">
        Uzvārds<span class="required-star">*</span>
    </label>
    <input type="text" class="form-control" name="surname" id="surname" placeholder="Ievadi uzvārdu" 
        value="<?php if(isset($surname)) echo $surname; ?>">
    <?php
        if(isset($surName) && empty($surName))
            outputAlert("Surname is required");
    ?>
</div>
<div class="form-group">
    <label for="email">
        E-pasts<span class="required-star">*</span>
    </label>
    <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" 
        placeholder="name@example.com" formnovalidate="formnovalidate" value="<?php if(isset($email)) echo $email; ?>">
    <?php
        if(isset($email) && empty($email))
            outputAlert("Email is not valid");
    ?>
</div>