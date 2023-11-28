<?php
    include 'MiniImageSelectElement.php';
?>

<tr>
    <td><input value="noņemt" type='button'/></td>
    <td><?php echo $row[$rowKeys[0]]; ?></td>
    <td>
        <input type="text" value="<?php echo $row[$rowKeys[1]]; ?>">
    </td>
    <td>
        <textarea 
            rows="6" 
            cols="30"
        ><?php echo $row[$rowKeys[2]]; ?></textarea>
    </td>
    <td>
        <?php 
            MiniImageSelectElement::load(
                $dataKeys[2].'-'.$index,
                $row[$rowKeys[3]],
                $data['form-data'][$dataKeys[2]]['allowed_file_formats']
            );
        ?>
    </td>
    <td>
        <input 
            type="number" 
            value="<?php echo $row[$rowKeys[4]]; ?>"
            step=".01"
        >
    </td>
    <td>
        <input 
            type="number" 
            value="<?php echo $row[$rowKeys[5]]; ?>"
        >
    </td>
    <td>
        <select 
            value="<?php echo $row[$rowKeys[6]]; ?>">
            <?php
                $catRows = Database::getAllRowsFrom('product_categories');
                foreach ($catRows as $catRow) {
                    $selected = $catRow[$tagName] == $variableData['value'] ? ' selected' : '';
                    echo '<option 
                        value="'.$catRow[$tagName].'"
                        '.$selected.'
                    >'.$catRow['name'].'</option>';
                }
            ?>
        </select>
    </td>
</tr>