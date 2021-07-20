<?php

/*
 * Osclass - software for creating and publishing online classified advertising platforms
 * Maintained and supported by Mindstellar Community
 * https://github.com/mindstellar/Osclass
 * Copyright (c) 2021.  Mindstellar
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *                     GNU GENERAL PUBLIC LICENSE
 *                        Version 3, 29 June 2007
 *
 *  Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 *  Everyone is permitted to copy and distribute verbatim copies
 *  of this license document, but changing it is not allowed.
 *
 *  You should have received a copy of the GNU Affero General Public
 *  License along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */

use mindstellar\form\base\FormInputs;

/**
 * Class Form
 * +@deprecated Use \mindstellar\form\base\FormInputs or \mindstellar\form\base\FormBuilder instead
 */
class Form
{
    private static $FormInputs;

    /**
     * @return \mindstellar\form\base\FormInputs
     */
    public static function formInputs()
    {
        if (!self::$FormInputs instanceof FormInputs) {
            self::$FormInputs = new FormInputs();
        }

        return self::$FormInputs;
    }
    /**
     * @param $name
     * @param $items
     * @param $fld_key
     * @param $fld_name
     * @param $default_item
     * @param $id
     */
    protected static function generic_select($name, $items, $fld_key, $fld_name, $default_item, $id)
    {
        $name = osc_esc_html($name);
        $attributes['id'] = preg_replace('|([^_a-zA-Z0-9-]+)|', '', $name);
        $options['defaultValue'] = $id;
        $options['selectPlaceholder'] = $default_item;
        $values = [];
        foreach ($items as $i) {
            if (isset($fld_key) && isset($fld_name)) {
                $values[] = [$i[$fld_key], $i[$fld_name]]; 
            }
        }
        echo self::formInputs()->select($name,$values,$attributes,$options);
    }

    /**
     * @param      $name
     * @param      $value
     * @param null $maxLength
     * @param bool $readOnly
     * @param bool $autocomplete
     */
    protected static function generic_input_text(
        $name,
        $value,
        $maxLength = null,
        $readOnly = false,
        $autocomplete = true
    ) {
        $name = $name;
        $attributes['id'] = preg_replace('|([^_a-zA-Z0-9-]+)|', '', $name);
        if (isset($maxLength)) {
            $attributes['maxlength'] = $maxLength;
        }
        if ($readOnly) {
            $attributes['readonly'] = 'readonly';
            $attributes['disabled'] = 'disabled';
        }
        $attributes['readonly'] = $readOnly;
        if (!$autocomplete) {
            $attributes['autocomplete'] = 'off';
        }
        echo self::formInputs()->text($name,$value,$attributes);
    }

    /**
     * @param      $name
     * @param      $value
     * @param null $maxLength
     * @param bool $readOnly
     */
    protected static function generic_password($name, $value, $maxLength = null, $readOnly = false)
    {
        $name = $name;
        $attributes['id'] = preg_replace('|([^_a-zA-Z0-9-]+)|', '', $name);
        if (isset($maxLength)) {
            $attributes['maxlength'] = $maxLength;
        }
        if ($readOnly) {
            $attributes['readonly'] = 'readonly';
            $attributes['disabled'] = 'disabled';
        }
        echo self::formInputs()->password($name,$value,$attributes);
    }

    /**
     * @param $name
     * @param $value
     */
    protected static function generic_input_hidden($name, $value)
    {
        $attributes['id'] = preg_replace('|([^_a-zA-Z0-9-]+)|', '', $name);
        echo self::formInputs()->hidden($name,$value,$attributes);
    }

    /**
     * @param      $name
     * @param      $value
     * @param bool $checked
     */
    protected static function generic_input_checkbox($name, $value, $checked = false)
    {
        $attributes['id'] = preg_replace('|([^_a-zA-Z0-9-]+)|', '', $name);
        $options['noCheckboxLabel'] = true;
        if ($checked) {
            $attributes['checked'] = 'checked';
        }
        echo self::formInputs()->checkbox($name,$value,$attributes,$options);
    
    }

    /**
     * @param $name
     * @param $value
     */
    protected static function generic_textarea($name, $value)
    {
        $id = preg_replace('|([^_a-zA-Z0-9-]+)|', '', $name);
        $attributes['id'] = $id;
        echo self::formInputs()->textarea($name,$value,$attributes);
    }
}
