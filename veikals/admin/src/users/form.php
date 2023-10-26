
<?php 
    if(!isset($_SESSION["id"])) {
        header('Location: /veikals/admin/index.php');
        exit();
    }
?>

<?php
    function outputAlert ($strMsg) {
        echo "<div class='alert alert-danger'>";
            echo $strMsg;
        echo "</div>";
    }
?>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="name">
                Vārds<span class="required-star">*</span>
            </label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Ievadi vārdu" 
                value="<?php if(isset($name)) echo $name; ?>">
            <?php
                if(isset($name) && empty($name))
                    outputAlert("Vārds ir nepieciešams");
            ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="surname">
                Uzvārds<span class="required-star">*</span>
            </label>
            <input type="text" class="form-control" name="surname" id="surname" placeholder="Ievadi uzvārdu" 
                value="<?php if(isset($surname)) echo $surname; ?>">
            <?php
                if(isset($surname) && empty($surname))
                    outputAlert("Uzvārds ir nepieciešams");
            ?>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="email">
        E-pasts<span class="required-star">*</span>
    </label>
    <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" 
        placeholder="name@example.com" formnovalidate="formnovalidate" value="<?php if(isset($email)) echo $email; ?>">
    <?php
        if(isset($email) && empty($email))
            outputAlert("E-pasts ir nepieciešams");
    ?>
</div>