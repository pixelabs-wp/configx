var modal = document.getElementById('myModal');
var btn = document.getElementById('importButton');
var span = document.getElementById('closeModal');
btn.onclick = function() {
  modal.style.display = 'block';
};
span.onclick = function() {
  modal.style.display = 'none';
};
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = 'none';
  }
};

// Update the button click event to trigger Admin Ajax
jQuery('#uploadButton').on('click', function() {
    var fileInput = document.getElementById('fileInput');
    var file = fileInput.files[0];

    if (file) {
        var formData = new FormData();
        formData.append('file', file);
        formData.append('action', 'handle_file_upload');

        // Perform Admin Ajax request
        jQuery.ajax({
            url: ajaxurl, // Ajax URL defined in WordPress
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Handle success
                location.reload();
                console.log(response);
                modal.style.display = 'none'; // Close the modal after successful upload
            },
            error: function(error) {
                // Handle error
                console.error(error);
            }
        });
    }
});


jQuery(document).ready(function() {
    // Function to handle read more button click
    function handleReadMoreClick(card) {
        var description = card.find('.description');
        description.toggle(); // Toggle visibility of description
    }
    jQuery('.card .read-more').on('click', function() {
        var card = jQuery(this).closest('.card');
        handleReadMoreClick(card);
    });
});

document.addEventListener("DOMContentLoaded", function() {
    var saveAllButton = document.querySelector(".save-all-button");
    saveAllButton.addEventListener("click", function() {
        var toggles = document.querySelectorAll(".status-toggle");
        var functionsData = [];

        var loaders = document.createElement("span");
            loaders.className = "loader";
            saveAllButton.appendChild(loaders);

            // Disable button during the AJAX request
            saveAllButton.disabled = true;

        toggles.forEach(function(toggle) {
            var checkbox = toggle.querySelector("input[type='checkbox']");
            var functionId = toggle.getAttribute("data-function-id");
            var currentStatus = toggle.getAttribute("data-current-status");
            var newStatus = checkbox.checked ? "active" : "inactive";

            // Collect data for all functions
            functionsData.push({
                functionId: functionId,
                newStatus: newStatus
            });
        });

        // Use fetch to send a request to update the status for all functions
        fetch(ajaxurl + '?action=update_all_functions_status', {
                method: "POST",
                headers: {
                    "Content-type": "application/json",
                },
                body: JSON.stringify(functionsData),
            })
            .then(response => response.json())
            .then(data => {

                // Hide loader
                saveAllButton.removeChild(loaders);

                // Enable button
                saveAllButton.disabled = false;
                if (data.success) {
                    console.log("Status updated successfully for all functions!");
                } else {
                    console.error("Error updating status for all functions!");
                }
            })
            .catch(error => {
                 // Hide loader
                 saveAllButton.removeChild(loaders);

                 // Enable button
                 saveAllButton.disabled = false;

                console.error("Fetch error:", error);
            });
    });

    // Export button JavaScript
    document.getElementById("exportButton").addEventListener("click", function() {
        fetch(ajaxurl + '?action=export_data', {
                method: 'GET',
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.blob();
            })
            .then(blob => {
                const url = window.URL.createObjectURL(new Blob([blob]));
                const a = document.createElement("a");
                a.href = url;
                a.download = "exported_data.json";
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);
            })
            .catch(error => {
                console.error('There has been a problem with your fetch operation:', error);
            });
    });


    var insertDataButton = document.getElementById("insertDataButton");

    if (insertDataButton) {
        insertDataButton.addEventListener("click", function() {
            // Show loader
            var loader = document.createElement("span");
            loader.className = "loader";
            insertDataButton.appendChild(loader);

            // Disable button during the AJAX request
            insertDataButton.disabled = true;

            // Use fetch to send a request to insert data
            fetch(ajaxurl, {
                    method: "POST",
                    headers: {
                        "Content-type": "application/x-www-form-urlencoded",
                    },
                    body: "action=insert_data_from_functions_folder",
                })
                .then(response => response.json())
                .then(data => {

                    // Hide loader
                    insertDataButton.removeChild(loader);

                    // Enable button
                    insertDataButton.disabled = false;

                    if (data.success) {
                        location.reload();
                        console.log(data.success);
                        console.log("Data inserted successfully!");
                    } else {
                        console.error("Error inserting data:", data.message);
                    }
                })
                .catch(error => {

                    // Hide loader
                    insertDataButton.removeChild(loader);

                    // Enable button
                    insertDataButton.disabled = false;
                    console.error("Fetch error:", error);
                });
        });
    }
});


document.addEventListener("DOMContentLoaded", function() {
    var buttons = document.querySelectorAll(".category-button");
    buttons.forEach(function(button) {
      button.addEventListener("click", function() {
        var category = this.getAttribute("data-category");
        window.location.href = "?page=config-x&category=" + encodeURIComponent(category);
      });
    });
  });