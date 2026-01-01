<?php
function inputElement($icon, $placeholder, $name, $value){
    echo "
    <div class='input-group mb-3'>
        <div class='input-group-text bg-gradient-primary text-white'>
            <i class='fas fa-fw'>{$icon}</i>
        </div>
        <input type='text' class='form-control' name='{$name}' value='{$value}' 
               placeholder='{$placeholder}' autocomplete='off'>
    </div>";
}

function buttonElement($id, $class, $icon, $name, $attr = ''){
    echo "<button type='submit' id='{$id}' name='{$name}' class='btn {$class} mx-2 my-1' {$attr}>
            <i class='fas fa-fw'>{$icon}</i>
          </button>";
}
