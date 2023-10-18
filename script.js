//Bring in elemements from the dom
const addFieldBtn = document.getElementById('addFieldBtn');
const closeModalBtn = document.querySelector('.close');
const modal = document.getElementById('addFieldModal');
const fieldsList = document.getElementById('fieldListUl');
const dataSection = document.getElementById('dataSection');
const addFieldForm = document.getElementById('addFieldForm');
const addDataTypeBtn = document.getElementById('addDataTypeBtn');
const dataTypesList = document.getElementById('dataTypesList');

let fieldItemId;

// Call the function to check the database connection when the page loads
// Event listener to load fields when the page is loaded
window.addEventListener('load', () => {
    checkDatabaseConnection();
    loadFields();
} );
// window.addEventListener('load', loadFields);



// Event listener for the "Add a New Field" button
addFieldBtn.addEventListener('click', () => {
    openEditFieldModal();
});

// Event listener for the modal close button (the 'x' in the corner)
closeModalBtn.addEventListener('click', () => {
    closeAddFieldModal();
});
// Add New Data Type Button Click Event
addDataTypeBtn.addEventListener('click', () => {
    addDataType();
});

// Event listener for the form submission
addFieldForm.addEventListener('submit', (e) => {
    e.preventDefault();
    submitField(fieldItemId)
});

// Function to New Data Type Button field modal with pre-filled data
function addDataType(value, index) {

    let dataTypeIndex = dataTypesList.children.length;
    index ? dataTypeIndex = index  : dataTypeIndex;
    const listItem = document.createElement('li');
    
    const label = document.createElement('label');
    label.htmlFor = `Datatype${dataTypeIndex++}`;
    label.textContent = 'Add Field Data';
    listItem.appendChild(label);

    const input = document.createElement('input');
    input.type = 'text';
    input.id = `Datatype${dataTypeIndex++}`;
    input.required = true;

    const dataTypeSelect = document.createElement('select');
    const options = ['Text', 'Number', 'Date', 'Image', 'File'];
    
    for (const optionText of options) {
        const option = document.createElement('option');
        option.value = optionText.toLowerCase();
        option.textContent = optionText;
        dataTypeSelect.appendChild(option);
    }

    if (value) {
        input.value = value.field
        dataTypeSelect.value = value.type 
    }

    listItem.appendChild(input);
    listItem.appendChild(dataTypeSelect);

    dataTypesList.appendChild(listItem);
}

// Function to open the edit field modal with pre-filled data
function openEditFieldModal(fieldData) {

    if (fieldData) {
        let fieldName = fieldData.name;
        let fieldId = fieldData.id;
    
        const fieldNameInput = document.getElementById('fieldName');
        const oldFieldInput = document.getElementById('OldfieldName');

        fieldNameInput.value = fieldName;
        oldFieldInput.value = fieldName;
        fieldId ? fieldItemId = fieldId : fieldItemId = undefined;
        dataTypesList.innerHTML = '';
        populateDataSection(fieldData.columns);
    }
    modal.style.display = 'flex';
}
// Function to open the edit field modal
function closeAddFieldModal() {
    const fieldNameInput = document.getElementById('fieldName');
    fieldNameInput.value = '';
    dataTypesList.innerHTML = '';
    modal.style.display = 'none';
}

// Function to dynamically generate input elements based on data type
function populateDataSection(dataType) {
    dataType.forEach((dataColumn, index) => {
        addDataType(dataColumn, index)
    })
}

function editField(fieldTable) {

    fieldsList.addEventListener('click', function (e) {
        const fieldId = e.target.parentNode.dataset.fieldId;
        const fieldData = fieldTable.find(obj => {
            if (obj.id == fieldId) {
                return obj;
            }
        });

        // Event listener for the "Edit" icon click
        if (e.target && e.target.classList.contains('edit-field')) {
            openEditFieldModal(fieldData);
        }

        // Event listener for the "Delete" icon click
        if (e.target && e.target.classList.contains('delete-field')) {
            deleteField(fieldData);
        }
    });
}

// Function to check the database connection
function checkDatabaseConnection() {
    fetch('./api/check.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Database connection is established
                console.log('Database connection is established.');
            } else {
                // Database connection failed
                console.error('Database connection failed:', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
// Function to load available fields from the API
function loadFields() {
    fetch('./api/getFields.php') // Adjust the API endpoint accordingly
        .then(response => response.json())
        .then(data => {
            fieldsList.innerHTML = ''; // Clear the existing list

            if (data.tables.length === 0) {
                const noFieldsMessage = document.createElement('p');
                noFieldsMessage.textContent = 'No fields available. Add a new field.';
                fieldsList.appendChild(noFieldsMessage);
            } else {
                data.tables.forEach(field => {
                    const fieldlistItem = document.createElement('li');
                    fieldlistItem.className = 'field';
                    fieldlistItem.dataset.fieldId = field.id; // Store the field ID as a data attribute

                    const fieldNameParagraph = document.createElement('p');
                    fieldNameParagraph.textContent = field.name;

                    const editField = document.createElement('a');
                    editField.className = 'edit-field';
                    editField.textContent = 'Edit Field';

                    const deleteField = document.createElement('a');
                    deleteField.className = 'delete-field';
                    deleteField.textContent = 'Delete Field';

                    fieldlistItem.appendChild(fieldNameParagraph);
                    fieldlistItem.appendChild(editField);
                    fieldlistItem.appendChild(deleteField);
                    fieldsList.appendChild(fieldlistItem);
                });
                editField(data.tables);
            }
        })
        .catch(error => {
            console.error('Error loading fields:', error);
            fieldsList.innerHTML = ''; // Clear the existing list

            // Handle errors here, e.g., display an error message
            const noFieldsMessage = document.createElement('p');
            noFieldsMessage.textContent = 'No fields available. Add a new field.';
            fieldsList.appendChild(noFieldsMessage);
        });
}
// Function to handle editing or adding fields to the database
function submitField(fieldId) {
    const fieldName = document.getElementById('fieldName').value;
    const OldfieldName = document.getElementById('OldfieldName').value;


    // Create an array to store data types and their names
    const dataTypes = [];
    const dataTypeElements = dataTypesList.querySelectorAll('select');
    const dataTypeNameElements = dataTypesList.querySelectorAll('input[type="text"]');
    
    for (let i = 0; i < dataTypeElements.length; i++) {
        const dataTypeValue = dataTypeElements[i].value;
        const dataTypeNameValue = dataTypeNameElements[i].value;
        dataTypes.push({ type: dataTypeValue, name: dataTypeNameValue });
    }

    // Depending on the presence of a field ID, determine whether to create or update
    const apiUrl = fieldId ? `./api/updateField.php/${fieldId}` : './api/addField.php';

    const formData = new FormData();
    formData.append('OldfieldName', OldfieldName);
    formData.append('fieldName', fieldName);
    formData.append('dataTypes', JSON.stringify(dataTypes)); // Send the list of data types

    for (var pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }
    
    fetch(apiUrl, {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        closeAddFieldModal();
        loadFields();
    })
    .catch(error => {
        console.error('Error posting/updating field:', error);
    });
}

// Function to delete a field by its ID
function deleteField(fieldData) {
    let fieldName = fieldData.name;
    let fieldId = fieldData.id;

    fetch(`./api/deleteField.php/?fieldName=${fieldName}`, {
        method: 'DELETE',
    })
    .then(response => response.json())
    .then(data => {
        // Handle success, e.g., remove the deleted field from the list
        const deletedField = document.querySelector(`li[data-field-id="${fieldId}"]`);
        if (deletedField) {
            // deletedField.remove();
        }
        loadFields();
    })
    .catch(error => {
        console.error('Error deleting field:', error);
    });
}

