<?php
function xml_page_customizer_menu()
{
    add_menu_page(
        'XML Page Customizer',
        'XML Customizer',
        'manage_options',
        'xml-page-customizer',
        'xml_page_customizer_page'
    );
}
add_action('admin_menu', 'xml_page_customizer_menu');

function xml_page_customizer_page()
{
?>
    <div id="xml-validation">
        <h2>XML Validation</h2>

        <table>
            <tr>
                <td>Select Remittance Type:</td>
                <td>
                    <select id="remittance-type">
                        <option value="sepa-sct">SEPA SCT Transfer</option>
                        <option value="sepa-sdd">SEPA SDD Direct Debit</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Drop XML File:</td>
                <td>
                    <input type="file" id="xml-file" />
                </td>
            </tr>
        </table>

        <button onclick="validateXml()">Validate XML</button>

        <div id="validation-result"></div>
        <script>
    function validateXml() {
        var remittanceType = document.getElementById('remittance-type').value;
        var xmlFile = document.getElementById('xml-file').files[0];

        if (!xmlFile) {
            alert('Please select an XML file.');
            return;
        }

        var formData = new FormData();
        formData.append('action', 'validate_xml');
        formData.append('remittanceType', remittanceType);
        formData.append('xmlFile', xmlFile);

        // Add nonce to the formData
        var nonce = '<?php echo wp_create_nonce('validate_xml_nonce'); ?>';
        console.log('Generated Nonce:', nonce);
        formData.append('nonce', nonce);

        // Log FormData content for debugging
        console.log('FormData:', formData);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?php echo admin_url('admin-ajax.php'); ?>', true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    document.getElementById('validation-result').innerHTML = xhr.responseText;
                } else {
                    console.error('Error:', xhr.status, xhr.statusText);
                    console.log('Response Text:', xhr.responseText);
                }
            }
        };

        // Log XHR request content for debugging
        console.log('XHR Request:', xhr);

        xhr.send(formData);
    }
</script>




    </div>
<?php
}

function validate_xml()
{
    error_reporting(E_ALL); // Enable error reporting for debugging

    $receivedNonce = $_POST['nonce'];
    $remittanceType = $_POST['remittanceType'];

    // Log information for debugging
    error_log("Received Nonce: $receivedNonce");
    error_log("Remittance Type: $remittanceType");

    // Verify nonce
    check_ajax_referer('validate_xml_nonce', 'nonce') || wp_die('Nonce verification failed');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $remittanceType = $_POST['remittanceType'];

        // Log remittance type for debugging
        error_log("Remittance Type: $remittanceType");

        if ($remittanceType === 'sepa-sct') {
            $xsdFile = CONFIGX_PLUGIN_URL . 'pacs.008.001.08.xsd'; // Replace with the actual path to your SEPA SCT XSD file
        } elseif ($remittanceType === 'sepa-sdd') {
            $xsdFile = CONFIGX_PLUGIN_URL . 'pacs.008.001.08.xsd'; // Replace with the actual path to your SEPA SDD XSD file
        } else {
            wp_die('Invalid remittance type');
        }

        // Log XSD file path for debugging
        error_log("XSD File Path: $xsdFile");

        $xmlFile = $_FILES['xmlFile']['tmp_name'];

        libxml_use_internal_errors(true);

        $dom = new DOMDocument;
        $dom->load($xmlFile);

        $isValid = $dom->schemaValidate($xsdFile);

        if (!$isValid) {
            $errors = libxml_get_errors();
            libxml_clear_errors();
            echo 'Validation Result: Failure<br>';
            foreach ($errors as $error) {
                echo $error->message . '<br>';
            }
        } else {
            echo 'Validation Result: Success';
        }
    } else {
        wp_die('Invalid request method');
    }
}
add_action('wp_ajax_validate_xml', 'validate_xml');
add_action('wp_ajax_nopriv_validate_xml', 'validate_xml');
?>
