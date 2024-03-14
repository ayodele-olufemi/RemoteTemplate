$(document).ready(function () {
	// Live Clock
	var clockElement = $("#currentDate")[0];

	function clock() {
		clockElement.innerHTML = new Date().toLocaleString("en-US");
	}
	

	setInterval(clock, 1000);
});

//////////////////////////////////////////////////////
//Functions for professor assignments page.php
docRoot = 'http://localhost/gradebookapp'

function makeAssignmentEditable(rowId) {
    const rowElement = document.getElementById(rowId);


    // Find the assignment_name, available_date, and due_date divs within this row
    const nameElement = rowElement.querySelector('.assignment_name p');
    const dateElement = rowElement.querySelector('.available_date');
    const dueDateElement = rowElement.querySelector('.due_date');

    
    // Disable the link to prevent navigation when the fields are clicked
    const anchorElement = rowElement.querySelector('.assignment_name a');
    anchorElement.setAttribute('data-original-href', anchorElement.getAttribute('href'));
    anchorElement.removeAttribute('href');  // Temporarily remove the href attribute to disable the link


    // Change text elements to editable fields
    if (nameElement) {
        const currentName = nameElement.innerText;
        nameElement.innerHTML = `<input type="text" id="${rowId}_name_input" value="${currentName}" />`;
    }
    if (dateElement) {
        const currentDate = dateElement.innerText;
        dateElement.innerHTML = `<input type="date" id="${rowId}_date_input" value="${currentDate}" />`;
    }
    if (dueDateElement) {
        const currentDueDate = dueDateElement.innerText;
        dueDateElement.innerHTML = `<input type="date" id="${rowId}_due_date_input" value="${currentDueDate}" />`;
    }

    // Change edit button to save button
    const editButton = rowElement.querySelector('td button');
    editButton.onclick = () => saveAssignment(rowId, anchorElement); // Simplified
    editButton.innerHTML = `<img src="${docRoot}/images/save.png" alt="Save" style="width: 20px; height: 20px;">`;
}

function saveAssignment(rowId, anchorElement) {
    const rowElement = document.getElementById(rowId);
    const nameInput = document.getElementById(`${rowId}_name_input`);
    const dateInput = document.getElementById(`${rowId}_date_input`);
    const dueDateInput = document.getElementById(`${rowId}_due_date_input`);

    // Change input fields back to text
    if (nameInput) {
        const newName = nameInput.value;
        anchorElement.innerHTML = `<p>${newName}</p>`
        //rowElement.querySelector('.assignment_name').innerHTML = `<p>${newName}</p>`;
    }
    if (dateInput) {
        const newDate = dateInput.value;
        rowElement.querySelector('.available_date').innerHTML = newDate;
    }
    if (dueDateInput) { // Now handling the due date
        const newDueDate = dueDateInput.value;
        rowElement.querySelector('.due_date').innerHTML = newDueDate;
    }

    // Enable the link
    const originalHref = anchorElement.getAttribute('data-original-href');
    if (originalHref || originalHref === '') {
        anchorElement.setAttribute('href', originalHref);
        anchorElement.removeAttribute('data-original-href'); // Clean up after restoring
    }

    // Change save button back to edit button
    const saveButton = rowElement.querySelector('td button');
    saveButton.onclick = () => makeAssignmentEditable(rowId);
    saveButton.innerHTML = `<img src="${docRoot}/images/edit.png" alt="Edit" style="width: 20px; height: 20px;">`;
}
