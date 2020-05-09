<?php

if (!function_exists('textInput')) {
    function textInput($name, $label, $value, $error = null)
    {
        $value = htmlspecialchars($value);
        if ($error) {
            $errorNotify = <<<HTML
<div class="invalid-feedback">
      $error
</div>
HTML;
            $inputSubClass = 'is-invalid';
        } else {
            $inputSubClass = '';
            $errorNotify = '';
        }

        $value = $value ? "value=\"$value\"" : '';

        $content = <<<HTML
                <label for="Input$name">$label</label>
                <input type="text" $value
                       class="form-control $inputSubClass"
                       id="Input$name" name="$name">
                $errorNotify
HTML;

        return $content;
    }
}

if (!function_exists('emailInput')) {
    function emailInput($name, $label, $value, $error = null)
    {
        $value = htmlspecialchars($value);
        if ($error) {
            $errorNotify = <<<HTML
<div class="invalid-feedback">
      $error
</div>
HTML;
            $inputSubClass = 'is-invalid';
        } else {
            $inputSubClass = '';
            $errorNotify = '';
        }

        $value = $value ? "value=\"$value\"" : '';

        $content = <<<HTML
                <label for="Input$name">$label</label>
                <input type="email" $value
                       class="form-control $inputSubClass"
                       id="Input$name" name="$name">
                $errorNotify
HTML;

        return $content;
    }
}

if (!function_exists('textArea')) {
    function textArea($name, $label, $value, $error = null)
    {
        $value = htmlspecialchars($value);
        if ($error) {
            $errorNotify = <<<HTML
<div class="invalid-feedback">
      $error
</div>
HTML;
            $inputSubClass = 'is-invalid';
        } else {
            $inputSubClass = '';
            $errorNotify = '';
        }
        $content = <<<HTML
                <label for="Input$name">$label</label>
                <textarea type="text"
                       class="form-control $inputSubClass"
                       id="Input$name" name="$name">$value</textarea>
                $errorNotify
HTML;
        return $content;
    }
}
