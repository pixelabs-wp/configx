<?php
// Add a menu item to the admin menu
function login_page_customizer_menu()
{
    add_menu_page(
        'Login Page Customizer',
        'Login Customizer',
        'manage_options',
        'login-page-customizer',
        'login_page_customizer_page'
    );
}
add_action('admin_menu', 'login_page_customizer_menu');

// Create the settings page
function login_page_customizer_page()
{
?>
    <div class="wrap">
        <h1>Login Page Customizer</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('login_page_customizer_settings');
            do_settings_sections('login-page-customizer');
            submit_button();
            ?>
        </form>
    </div>
<?php
}

// Register settings and fields
function login_page_customizer_init()
{
    register_setting('login_page_customizer_settings', 'login_page_customizer_options');

    // Add section for general settings
    add_settings_section('login_page_customizer_general', 'General Settings', 'login_page_customizer_general_section', 'login-page-customizer');
}
add_action('admin_init', 'login_page_customizer_init');

// Display the general settings section
function login_page_customizer_general_section()
{
    echo '<p>Configure general settings for the login page.</p>';

    $options = get_option('login_page_customizer_options');
    $custom_logo = isset($options['custom_logo']) ? esc_url($options['custom_logo']) : '';
    if(!$custom_logo)
    {
        $custom_logo = CONFIGX_PLUGIN_URL. "images/free-logo-3446031-2882300.png";
    }
    $background_image = isset($options['background_image']) ? esc_url($options['background_image']) : '';
    if(!$background_image)
    {
        $background_image = CONFIGX_PLUGIN_URL. "images/free-logo-3446031-2882300.png";
    }
    $background_color = isset($options['background_color']) ? $options['background_color'] : '';
    $box_width = isset($options['box_width']) ? esc_attr($options['box_width']) : '';
    $width_unit = isset($options['width_unit']) ? esc_attr($options['width_unit']) : 'px';
    $box_height = isset($options['box_height']) ? esc_attr($options['box_height']) : '';
    $height_unit = isset($options['height_unit']) ? esc_attr($options['height_unit']) : 'px';
    $padding = isset($options['padding']) ? $options['padding'] : array('top' => '', 'right' => '', 'bottom' => '', 'left' => '');
    $padding_unit = isset($options['paddings_unit']) ? esc_attr($options['paddings_unit']) : 'px';
    $radius = isset($options['radius']) ? esc_attr($options['radius']) : '';
    $radius_unit = isset($options['radius_unit']) ? esc_attr($options['radius_unit']) : 'px';
    $shadow_spread = isset($options['shadow_spread']) ? esc_attr($options['shadow_spread']) : '';
    $box_shadow_color = isset($options['box_shadow_color']) ? esc_attr($options['box_shadow_color']) : '';
    $background_image_option = isset($options['background_image_option']) ? $options['background_image_option'] : '';
    $text_color = isset($options['text_color']) ? esc_attr($options['text_color']) : '';
    $button_color = isset($options['button_color']) ? esc_attr($options['button_color']) : '';
    $button_text_color = isset($options['button_text_color']) ? esc_attr($options['button_text_color']) : '';
    $text_link_color = isset($options['text_link_color']) ? esc_attr($options['text_link_color']) : '';
    ?>
        <style>
            .radius-unit-label {
                display: inline-block;
                padding: 5px 10px;
                background-color: #e0e0e0;
                cursor: pointer;
                border-radius: 5px;
                margin-right: 5px;
            }
            .radius-unit-label input {
                position: absolute;
                top: -9999px;
            }
            .radius-unit-label:focus {
                outline: none;
                box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);
            }
            .custom-child{
                display: grid;
                grid-template-columns: 35%  45%;
                column-gap: 5%;
                width: 100%;
                margin-bottom: 10px;
            }
            .custom-child-1{
                display: grid;
                grid-template-columns: 25%  25%;
                width: 100%;
                margin-bottom: 10px;
            }
            .custom-child-2{
                display: grid;
                grid-template-columns: 15%  15% 25%;
                width: 100%;
                margin-bottom: 10px;
            }
            .custom-child-3{
                display: grid;
                grid-template-columns: 150px  150px;
                width: 100%;
                margin-bottom: 10px;
            }
            .block-div
            {
                display: block;
                margin-top: 20px;
                margin-bottom: 10px;
                font-weight: bold;
            }
            .input-div
            {
                display: inline-block;
                margin-top: 10px;
                margin-bottom: 10px;
                width: 74px !important;
            }
            .input-div-1
            {
                display: inline-block;
                margin-top: 0px;
                margin-bottom: 0px;
                width: 74px !important;
            }
            .padding-box{
                width: 400px;
            }
            .upload-btn
            {
                color: white;
                background-color: #2271B1;
                border-radius: 10px;
                padding: 10px;
                border: none;
            }
        </style>
    <?php
    
    echo '
    <div class="custom-child-3">
        <div>
            <input type="hidden" id="custom-logo-input" name="login_page_customizer_options[custom_logo]" value="" />
            <img id="custom-logo-preview" src="'.$custom_logo.'" alt="Custom Logo Preview" style="max-width: 80px;" /><br>
            <button id="custom-logo-upload-button" class="upload-btn">Upload <br>Custom Logo</button>
        </div>
        <div>
            <input type="hidden" id="background-image-input" name="login_page_customizer_options[background_image]" value="' . $background_image . '" />
            <img id="background-image-preview" src="'.$background_image.'" alt="Background Image Preview" style="max-width: 80px;" /><br>
            <button id="background-image-upload-button" class="upload-btn">Upload <br>Background Image</button>
        </div>
    </div>
    <div class="custom-child-3">
        <div>
            <label class="block-div">Background Color</label>
            <input type="color" onchange="changeValues(\'colorPicker-1\', \'selectedColor-1\')" id="colorPicker-1" name="login_page_customizer_options[background_color]" value="' . esc_attr($background_color) . '" class="color-picker" />
            <span onclick="resetValues(\'colorPicker-1\', \'selectedColor-1\')" style="cursor: pointer;"><svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M386.3 160H336c-17.7 0-32 14.3-32 32s14.3 32 32 32H464c17.7 0 32-14.3 32-32V64c0-17.7-14.3-32-32-32s-32 14.3-32 32v51.2L414.4 97.6c-87.5-87.5-229.3-87.5-316.8 0s-87.5 229.3 0 316.8s229.3 87.5 316.8 0c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0c-62.5 62.5-163.8 62.5-226.3 0s-62.5-163.8 0-226.3s163.8-62.5 226.3 0L386.3 160z"/></svg></span><br>
            <span id="selectedColor-1">' . esc_attr($background_color) . '</span>
        </div>
        <div>
            ';
            ?>
            <label class="block-div">Background Image Option</label>
            <select name="login_page_customizer_options[background_image_option]">
                <option value="contain" <?php selected($background_image_option, 'contain'); ?>>Contain</option>
                <option value="auto" <?php selected($background_image_option, 'auto'); ?>>Auto</option>
                <option value="cover" <?php selected($background_image_option, 'cover'); ?>>Cover</option>
            </select>
            <?php
            echo '
        </div>
    </div>
            
    <div class="custom-child-3">
        <div>
            <label class="block-div">Login Box Width</label>
            <label class="radius-unit-label" onclick="setPixelValues(\'pixel-1\' , \'percent-1\', \'box-width\', \'px\', \'w-px\', \'w-per\')" id="w-px">
                <input type="radio" id="pixel-1" name="login_page_customizer_options[width_unit]" value="px" ' . checked('px', $width_unit, false) . '> px
            </label>
            <label class="radius-unit-label" onclick="setPixelValues(\'pixel-1\' , \'percent-1\', \'box-width\', \'%\', \'w-px\', \'w-per\')" id="w-per">
                <input type="radio" id="percent-1" name="login_page_customizer_options[width_unit]" value="%" ' . checked('%', $width_unit, false) . '> %
            </label><br>
            <input type="number" class="input-div" id= "box-width" name="login_page_customizer_options[box_width]" value="' . $box_width . '" />
        </div>
    
        <div>
            <label class="block-div">Login Box Height</label>
            <label class="radius-unit-label" onclick="setPixelValues(\'pixel-2\' , \'percent-2\', \'height_unit\', \'px\', \'h-px\', \'h-per\')" id="h-px">
                <input type="radio" id="pixel-2" name="login_page_customizer_options[height_unit]" value="px" ' . checked('px', $height_unit, false) . '> px
            </label>
            <label class="radius-unit-label" onclick="setPixelValues(\'pixel-2\' , \'percent-2\', \'height_unit\', \'%\', \'h-px\', \'h-per\')" id="h-per">
                <input type="radio" id="percent-2" name="login_page_customizer_options[height_unit]" value="%" ' . checked('%', $height_unit, false) . '> %
            </label><br>
            <input type="number" class="input-div" id ="box-height" name="login_page_customizer_options[box_height]" value="' . $box_height . '" />
        </div>
        
    </div>
    <div class="custom-child-3">
        <div>
            <label class="block-div">Login Form Border Radius</label>
            <label class="radius-unit-label radius-unit-label-1" id="px">';
                if ($radius_unit == 'px') {
                    echo '<input type="radio" name="login_page_customizer_options[radius_unit]" value="px" checked> px';
                } else {
                    echo '<input type="radio" name="login_page_customizer_options[radius_unit]" value="px" > px';
                }
            echo ' </label>
            <label class="radius-unit-label radius-unit-label-2" id="per">';
                if ($radius_unit == '%') {
                    echo '<input type="radio" name="login_page_customizer_options[radius_unit]" value="%" checked> %';
                } else {
                    echo '<input type="radio" name="login_page_customizer_options[radius_unit]" value="%" > %';
                }
            echo '     
            </label>
            <br>
            <div style="margin-top: 10px; margin-bottom: 20px;">
                <input type="range"  name="login_page_customizer_options[radius]" id="login_page_customizer_radius" value="' . $radius . '" min="0" max="100" step="1">
                <span id="radius-value">' . $radius . $radius_unit . '</span>
            </div>
        </div>
        <div>
            <div style="margin-bottom: 10px">
                <label class="block-div">Login Form Padding</label>
                <label class="radius-unit-label" onclick="setPixelValues(\'pixel-3\' , \'percent-3\', \'padding_unit\', \'px\', \'pad-px\', \'pad-per\')" id="pad-px">
                    <input type="radio" id="pixel-3" name="login_page_customizer_options[paddings_unit]" value="px" ' . checked('px', $padding_unit, false) . '> px
                </label>
                <label class="radius-unit-label" onclick="setPixelValues(\'pixel-3\' , \'percent-3\', \'padding_unit\', \'%\', \'pad-px\', \'pad-per\')" id="pad-per">
                    <input type="radio" id="percent-3" name="login_page_customizer_options[paddings_unit]" value="%" ' . checked('%', $padding_unit, false) . '> %
                </label>
            </div>
            <div class="padding-box">
                <div class="custom-child-1">
                    <div>
                        <label for="login_page_customizer_padding_top">Top</label><br>
                        <input type="number" class="input-div-1" name="login_page_customizer_options[padding][top]" style="width: 80px" id="login_page_customizer_padding_top" value="'. esc_attr($padding['top']) . '" />
                    </div>
                    <div>
                        <label for="login_page_customizer_padding_right">Right</label><br>
                        <input type="number" class="input-div-1" name="login_page_customizer_options[padding][right]" id="login_page_customizer_padding_right" value="' . esc_attr($padding['right']) . '" />
                    </div> 
                </div>
                <div class="custom-child-1">
                    <div>
                        <label for="login_page_customizer_padding_bottom">Bottom</label><br>
                        <input type="number" class="input-div-1" name="login_page_customizer_options[padding][bottom]" id="login_page_customizer_padding_bottom" value="' . esc_attr($padding['bottom']) . '" />
                    </div>
                    <div>
                        <label for="login_page_customizer_padding_left">Left</label><br>
                        <input type="number" class="input-div-1" name="login_page_customizer_options[padding][left]" id="login_page_customizer_padding_left" value="' . esc_attr($padding['left']) . '" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="custom-child-3">
        <div>
            <label class="block-div">Login Box Shadow</label>
            <input type="color" onchange="changeValues(\'colorPicker-2\', \'selectedColor-2\')" id="colorPicker-2" name="login_page_customizer_options[box_shadow_color]" value="' . $box_shadow_color . '" class="color-picker" />
            <span onclick="resetValues(\'colorPicker-2\', \'selectedColor-2\')"  style="cursor: pointer;"><svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M386.3 160H336c-17.7 0-32 14.3-32 32s14.3 32 32 32H464c17.7 0 32-14.3 32-32V64c0-17.7-14.3-32-32-32s-32 14.3-32 32v51.2L414.4 97.6c-87.5-87.5-229.3-87.5-316.8 0s-87.5 229.3 0 316.8s229.3 87.5 316.8 0c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0c-62.5 62.5-163.8 62.5-226.3 0s-62.5-163.8 0-226.3s163.8-62.5 226.3 0L386.3 160z"/></svg></span><br>   
            <span id="selectedColor-2">' . $box_shadow_color . '</span>
        </div>
        <div>
            <label class="block-div">Login Form Shadow Spread</label>
            <input type="range" name="login_page_customizer_options[shadow_spread]" id="login_page_customizer_spread" value="' . $shadow_spread . '" />
            <span id="spread-value">' . $shadow_spread . '</span>
        </div>
    </div>
    <div class="custom-child-3">
        <div>
            <label class="block-div">Login Form Text</label>
            <input type="color" onchange="changeValues(\'colorPicker-3\', \'selectedColor-3\')" id="colorPicker-3" name="login_page_customizer_options[text_color]" value="' . $text_color . '" class="color-picker" />
            <span onclick="resetValues(\'colorPicker-3\', \'selectedColor-3\')" style="cursor: pointer;"><svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M386.3 160H336c-17.7 0-32 14.3-32 32s14.3 32 32 32H464c17.7 0 32-14.3 32-32V64c0-17.7-14.3-32-32-32s-32 14.3-32 32v51.2L414.4 97.6c-87.5-87.5-229.3-87.5-316.8 0s-87.5 229.3 0 316.8s229.3 87.5 316.8 0c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0c-62.5 62.5-163.8 62.5-226.3 0s-62.5-163.8 0-226.3s163.8-62.5 226.3 0L386.3 160z"/></svg></span><br>
            <span id="selectedColor-3">' . $text_color . '</span>
        </div>
        <div>
            <label class="block-div">Submit Button </label>
            <input type="color" onchange="changeValues(\'colorPicker-4\', \'selectedColor-4\')" id="colorPicker-4" name="login_page_customizer_options[button_color]" value="' . $button_color . '" class="color-picker" />
            <span onclick="resetValues(\'colorPicker-4\', \'selectedColor-4\')" style="cursor: pointer;"><svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M386.3 160H336c-17.7 0-32 14.3-32 32s14.3 32 32 32H464c17.7 0 32-14.3 32-32V64c0-17.7-14.3-32-32-32s-32 14.3-32 32v51.2L414.4 97.6c-87.5-87.5-229.3-87.5-316.8 0s-87.5 229.3 0 316.8s229.3 87.5 316.8 0c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0c-62.5 62.5-163.8 62.5-226.3 0s-62.5-163.8 0-226.3s163.8-62.5 226.3 0L386.3 160z"/></svg></span><br>
            <span id="selectedColor-4">' . $button_color . '</span>
        </div>
    </div>
    <div class="custom-child-3">
        <div>
            <label class="block-div">Submit Button Text</label>
            <input type="color" onchange="changeValues(\'colorPicker-5\', \'selectedColor-5\')" id="colorPicker-5" name="login_page_customizer_options[button_text_color]" value="' . $button_text_color . '" class="color-picker" />
            <span onclick="resetValues(\'colorPicker-5\', \'selectedColor-5\')" style="cursor: pointer;"><svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M386.3 160H336c-17.7 0-32 14.3-32 32s14.3 32 32 32H464c17.7 0 32-14.3 32-32V64c0-17.7-14.3-32-32-32s-32 14.3-32 32v51.2L414.4 97.6c-87.5-87.5-229.3-87.5-316.8 0s-87.5 229.3 0 316.8s229.3 87.5 316.8 0c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0c-62.5 62.5-163.8 62.5-226.3 0s-62.5-163.8 0-226.3s163.8-62.5 226.3 0L386.3 160z"/></svg></span><br>
            <span id="selectedColor-5" style="width: 100px;">' . $button_text_color . '</span>
        </div>
        <div>
            <label class="block-div">Login Form Links</label>
            <input type="color" onchange="changeValues(\'colorPicker-6\', \'selectedColor-6\')" id="colorPicker-6" name="login_page_customizer_options[text_link_color]" value="' . $text_link_color . '" class="color-picker" />
            <span onclick="resetValues(\'colorPicker-6\', \'selectedColor-6\')" style="cursor: pointer;"><svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M386.3 160H336c-17.7 0-32 14.3-32 32s14.3 32 32 32H464c17.7 0 32-14.3 32-32V64c0-17.7-14.3-32-32-32s-32 14.3-32 32v51.2L414.4 97.6c-87.5-87.5-229.3-87.5-316.8 0s-87.5 229.3 0 316.8s229.3 87.5 316.8 0c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0c-62.5 62.5-163.8 62.5-226.3 0s-62.5-163.8 0-226.3s163.8-62.5 226.3 0L386.3 160z"/></svg></span><br>
            <span id="selectedColor-6">' . $text_link_color . '</span>
        </div>
    </div>';
    ?>
        <script>

            function setPixelValues(pixel , percent, input, type, pixelLabel, percentLabel){
                event.preventDefault();
                var pxRadioButton = document.getElementById(pixel);
                var percentRadioButton = document.getElementById(percent);
                var pixelLabel = document.getElementById(pixelLabel);
                var percentLabel = document.getElementById(percentLabel);
                if (pxRadioButton.checked == true) {
                    pixelLabel.style.border = '1px solid';
                } else if (percentRadioButton.checked == true) {
                    percentLabel.style.border = '1px solid';
                }
                if(type == 'px'){
                    percentRadioButton.checked = false;
                    percentLabel.style.border = 'none';
                    pixelLabel.style.border = '1px solid black';
                    pxRadioButton.checked = true;
                }
                else if(type == '%')
                {
                    pxRadioButton.checked = false;
                    pixelLabel.style.border = 'none';
                    percentLabel.style.border = '1px solid black';
                    percentRadioButton.checked = true;
                }
            }
            document.addEventListener('DOMContentLoaded', function() {
                var pxRadiow = document.querySelector('input[name="login_page_customizer_options[width_unit]"][value="px"]');
                var percentRadiow = document.querySelector('input[name="login_page_customizer_options[width_unit]"][value="%"]');
                var w_1 = document.getElementById('w-px');
                var w_2 = document.getElementById('w-per');
                if (pxRadiow.checked == true) {
                    w_1.style.border = '1px solid';
                } else if (percentRadiow.checked == true) {
                    w_2.style.border = '1px solid';
                }

                var pxRadioh = document.querySelector('input[name="login_page_customizer_options[height_unit]"][value="px"]');
                var percentRadioh = document.querySelector('input[name="login_page_customizer_options[height_unit]"][value="%"]');
                var h_1 = document.getElementById('h-px');
                var h_2 = document.getElementById('h-per');
                if (pxRadioh.checked == true) {
                    h_1.style.border = '1px solid';
                } else if (percentRadioh.checked == true) {
                    h_2.style.border = '1px solid';
                }

                var pxRadioPad = document.querySelector('input[name="login_page_customizer_options[paddings_unit]"][value="px"]');
                var percentRadioPad = document.querySelector('input[name="login_page_customizer_options[paddings_unit]"][value="%"]');
                var pad_1 = document.getElementById('pad-px');
                var pad_2 = document.getElementById('pad-per');
                console.log(pxRadioPad);
                if (pxRadioPad.checked == true) {
                    pad_1.style.border = '1px solid';
                } else if (percentRadioPad.checked == true) {
                    pad_2.style.border = '1px solid';
                }
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var radiusInput = document.getElementById('login_page_customizer_radius');
                var radiusValue = document.getElementById('radius-value');
                var pxRadio = document.querySelector('input[name="login_page_customizer_options[radius_unit]"][value="px"]');
                var percentRadio = document.querySelector('input[name="login_page_customizer_options[radius_unit]"][value="%"]');
                var radius_1 = document.getElementById('px');
                var radius_2 = document.getElementById('per');
                if (pxRadio.checked == true) {
                    radius_1.style.border = '1px solid';
                } else if (percentRadio.checked == true) {
                    radius_2.style.border = '1px solid';
                }
                // Update the span content when the range input changes
                radiusInput.addEventListener('input', function() {
                    radiusValue.textContent = this.value + (pxRadio.checked ? 'px' : '%');
                });

                // Handle button clicks
                document.querySelectorAll('.radius-unit-label-1').forEach(function(label) {
                    label.addEventListener('click', function(e) {
                        e.preventDefault();
                        percentRadio.checked = false;
                        radius_2.style.border = 'none';
                        radius_1.style.border = '1px solid black';
                        pxRadio.checked = true;
                        radiusValue.textContent = radiusInput.value + (pxRadio.checked ? 'px' : '%');
                    });
                });

                document.querySelectorAll('.radius-unit-label-2').forEach(function(label1) {
                    label1.addEventListener('click', function(e) {
                        e.preventDefault();
                        pxRadio.checked = false;
                        radius_1.style.border = 'none';
                        radius_2.style.border = '1px solid black';
                        percentRadio.checked = true;
                        radiusValue.textContent = radiusInput.value + (pxRadio.checked ? 'px' : '%');
                    });
                });
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var spreadInput = document.getElementById('login_page_customizer_spread');
                var shadowValue = document.getElementById('spread-value');
            
                spreadInput.addEventListener('input', function() {
                    shadowValue.textContent = this.value +'px';
                });
            });
        </script>
        <script>
            function changeValues(id, selector){
                var id = document.getElementById(id);
                var selector = document.getElementById(selector);
                selector.textContent = id.value;
            }
            function resetValues(id, selector){
                var id = document.getElementById(id);
                var selector = document.getElementById(selector);
                id.value = '#FFFFFF';
                selector.textContent = '#FFFFFF';
            }
        </script>
    <?php

}

// AJAX handler for custom logo upload
add_action('wp_ajax_custom_logo_upload', 'handle_custom_logo_upload');
function handle_custom_logo_upload() {
    if (isset($_FILES['custom_logo'])) {
        $file = $_FILES['custom_logo'];
        $upload_overrides = array('test_form' => false);
        $uploaded_file = wp_handle_upload($file, $upload_overrides);
        if ($uploaded_file && empty($uploaded_file['error'])) {
            $response = array(
                'success' => true,
                'data'    => array('url' => $uploaded_file['url']),
            );
        } else {
            $response = array(
                'success' => false,
                'data'    => array('message' => $uploaded_file['error']),
            );
        }
        echo json_encode($response);
    }
    wp_die();
}

// AJAX handler for custom logo upload
add_action('wp_ajax_background_image_upload', 'handle_background_image_upload');
function handle_background_image_upload() {
    if (isset($_FILES['background_image'])) {
        $file = $_FILES['background_image'];
        $upload_overrides = array('test_form' => false);
        $uploaded_file = wp_handle_upload($file, $upload_overrides);
        if ($uploaded_file && empty($uploaded_file['error'])) {
            $response = array(
                'success' => true,
                'data'    => array('url' => $uploaded_file['url']),
            );
        } else {
            $response = array(
                'success' => false,
                'data'    => array('message' => $uploaded_file['error']),
            );
        }
        echo json_encode($response);
    }
    wp_die();
}

// ---------------- working end ---------------
function custom_login_page_styles()
{
    $options = get_option('login_page_customizer_options');
    $background_color = isset($options['background_color']) ? $options['background_color'] : '';
    $box_width = isset($options['box_width']) ? esc_attr($options['box_width']) : '';
    $box_height = isset($options['box_height']) ? esc_attr($options['box_height']) : '';
    $padding = isset($options['padding']) ? $options['padding'] : array('top' => '', 'right' => '', 'bottom' => '', 'left' => '');
    if ($padding['top'] == null) {
        $padding['top'] = 0;
    }
    if ($padding['right'] == null) {
        $padding['right'] = 0;
    }
    if ($padding['bottom'] == null) {
        $padding['bottom'] = 0;
    }
    if ($padding['left'] == null) {
        $padding['left'] = 0;
    }
    if ($padding['top'] == null && $padding['right'] == null && $padding['bottom'] == null && $padding['left'] == null) {
        $paddingSize = null;
    }
    $padding_unit = isset($options['paddings_unit']) ? esc_attr($options['paddings_unit']) : 'px';
    $radius = isset($options['radius']) ? esc_attr($options['radius']) : '';
    $unit = isset($options['radius_unit']) ? esc_attr($options['radius_unit']) : 'px';
    $height_unit = isset($options['height_unit']) ? esc_attr($options['height_unit']) : 'px';
    $shadow_spread = isset($options['shadow_spread']) ? esc_attr($options['shadow_spread']) : '';
    $box_shadow_color = isset($options['box_shadow_color']) ? esc_attr($options['box_shadow_color']) : '';
    $background_image_option = isset($options['background_image_option']) ? $options['background_image_option'] : '';
    $text_color = isset($options['text_color']) ? esc_attr($options['text_color']) : '';
    $button_color = isset($options['button_color']) ? esc_attr($options['button_color']) : '';
    $button_text_color = isset($options['button_text_color']) ? esc_attr($options['button_text_color']) : '';
    $text_link_color = isset($options['text_link_color']) ? esc_attr($options['text_link_color']) : '';
    $custom_logo = isset($options['custom_logo']) ? esc_url($options['custom_logo']) : '';
    $background_image = isset($options['background_image']) ? esc_url($options['background_image']) : '';

    echo '
    <style type="text/css">';
    if ($background_color) {
        echo '   body.login {
            background-color: ' . esc_attr($background_color) . '; /* Set background color to red */
        }';
    }

    echo '.login h1 a {
            background-image: url("' . $custom_logo . '") !important;
          }';

    echo ' body.login {
            background-image: url("' . $background_image . '");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            background-size: ' . $background_image_option . ';
          }';
    if ($box_width) {
        echo '  body.login div#login
          {
            width: ' . esc_attr($box_width) . ';
          }';
    }
    if ($box_height) {
        echo ' body.login div#login form#loginform
          {
            display: flex;
            flex-direction: column;
            justify-content: center;          
            height: ' . esc_attr($box_height) . esc_attr($height_unit) . ';
          }';
    }
    if ($paddingSize) {
        echo ' body.login div#login form#loginform
          {
            padding: ' . esc_attr($padding['top']) . esc_attr($padding_unit) . ' ' . esc_attr($padding['right']) .  esc_attr($padding_unit) . ' ' . esc_attr($padding['bottom']) .  esc_attr($padding_unit) . ' ' . esc_attr($padding['left']) .  esc_attr($padding_unit) . ';
          }';
    }
    if ($radius) {
        echo ' body.login div#login form#loginform
          {
            border-radius: ' . esc_attr($radius) . esc_attr($unit) . ';
          }';
    }
    if ($shadow_spread && $box_shadow_color) {
        echo 'body.login div#login form#loginform
          {
            box-shadow: 10px 10px 10px ' . esc_attr($shadow_spread) . 'px ' . esc_attr($box_shadow_color) . ';
          }';

    }
    else if($shadow_spread ){
        echo 'body.login div#login form#loginform
        {
          box-shadow: 10px 10px 10px ' . esc_attr($shadow_spread) . 'px;
        }';
    }
     else if($box_shadow_color){
        echo 'body.login div#login form#loginform
          {
            box-shadow: 10px 10px 10px 5px ' . esc_attr($box_shadow_color) . ';
          }';
    }
    if ($text_color) {
        echo '   body.login {
            color: '. $text_color .';
        }';
    }
    if ($button_color) {
        echo '   body.login div#login form#loginform p.submit input#wp-submit {
            background-color: '. $button_color .';
        }';
    }
    if ($button_text_color) {
        echo '   body.login div#login form#loginform p.submit input#wp-submit {
            color: '. $button_text_color .';
        }';
    }
    if ($text_link_color) {
        echo '   body.login div#login p#nav a {
            color: '. $text_link_color .';
        }
        body.login div#login p#backtoblog a {
            color: '. $text_link_color .';
        }
        ';
    }
    echo '
    </style>';
}

add_action('login_enqueue_scripts', 'custom_login_page_styles');


// Enqueue necessary scripts and styles
add_action('admin_enqueue_scripts', 'enqueue_custom_logo_upload_scripts');
function enqueue_custom_logo_upload_scripts() {
    wp_enqueue_media();
    wp_enqueue_script('custom-logo-upload-script', CONFIGX_PLUGIN_URL  . '/js/custom-logo-upload.js', array('jquery'), null, true);
    // Localize the script with new data
    wp_localize_script('custom-logo-upload-script', 'custom_logo_upload_vars', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
}

// Add more field functions as needed

// Enqueue scripts for color picker
function login_page_customizer_scripts()
{
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_script('login-page-customizer-script', plugin_dir_url(__FILE__) . 'js/script.js', array('wp-color-picker'), false, true);
}
add_action('admin_enqueue_scripts', 'login_page_customizer_scripts');
?>