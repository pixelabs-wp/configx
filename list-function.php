<?php

function config_x_page()
{
    global $wpdb;
    $table_name_functions = $wpdb->prefix . 'configx_functions_code';

    // Get all unique categories from the configx_functions_code table based on the selected category
    $categories = $wpdb->get_col("SELECT DISTINCT category FROM " . $table_name_functions . "  ORDER BY category ASC ");
    $selected_category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
    $where_condition = $selected_category ? " WHERE category = '$selected_category'" : '';
    $functions = $wpdb->get_results("SELECT * FROM " . $table_name_functions . " " . $where_condition ." ORDER BY function_name ASC ");

    // Set the selected category to the first category if none is selected
    if (empty($selected_category) && !empty($categories)) {
        $selected_category = $categories[0];
        $where_condition = " WHERE category = '$selected_category' ORDER BY function_name ASC";
        $functions = $wpdb->get_results("SELECT * FROM " . $table_name_functions . " " . $where_condition);
    } ?>
    <div class="custom-container">
        <div class="main-div">
            <div>
            <h1 class="head-list">ConfigX</h1>&nbsp;&nbsp;&nbsp;
            <button id="insertDataButton" class="button">Check For New Updates!</button>
            </div>
            
            <div>
            &nbsp;&nbsp;&nbsp;
                <button id="importButton" class="button">Import Data</button>
                &nbsp;&nbsp;&nbsp;
                <button id="exportButton" class="button button-primary">Export Data</button>
            </div>
        </div>
        <div id="myModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content" style="padding-bottom: 20px;">
                <span class="close" id="closeModal">&times;</span>
                <h2 style="margin-bottom: 20px;">Upload Json File To Merge Settings</h2>
                <input type="file" id="fileInput" accept=".json">
                <button id="uploadButton" class="button ">Upload</button>
            </div>
        </div>
        <div>
            <?php
            foreach ($categories as $category_option) {
                $selected = ($selected_category === $category_option) ? 'selected' : '';
                echo '<button class="category-button ' . $selected . ' button" data-category="' . esc_attr($category_option) . '">' . esc_html($category_option) . '</button>';
            } ?>
        </div>

        <?php
        if (!empty($functions)) {
        ?>
            <button class="button save-all-button">Save All</button>
            <div class="card">
  <?php          include_once(plugin_dir_path(__FILE__) . 'Custom Functions/updated.php');
?>
            </div>
            <?php
            foreach ($functions as $functionsss) {
            ?>
                <div class="card">
                    <h2><?php echo $functionsss->function_name; ?></h2>
                    <div class="status-toggle" style="display: block; margin-bottom: 10px;" data-function-id="<?php echo esc_attr($functionsss->id); ?>" data-current-status="<?php echo  esc_attr($functionsss->status); ?>">
                        <?php if ($functionsss->status == "active") { ?>
                            <input type="checkbox" checked>&nbsp; Enable &nbsp;&nbsp; <!-- AJAX request will be sent when this checkbox is clicked -->
                        <?php } else { ?>
                            <input type="checkbox"> &nbsp; Enable &nbsp;&nbsp; <!-- AJAX request will be sent when this checkbox is clicked -->
                        <?php } ?>
                    </div>
                    <div class="description">
                        <p><?php echo $functionsss->description; ?></p>
                    </div>
                    <button class="read-more">Read More</button>
                </div>
        <?php
            }
        } else {
            echo '<p>No functions found.</p>';
        } ?>
    </div>
<?php
}
?>