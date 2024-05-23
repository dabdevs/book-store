function deleteItem(title, id, action) {
    Swal.fire({
        title: `Do you want to delete ${title}?`,
        showCancelButton: true,
        confirmButtonText: "Save",
    }).then(async (result) => {
        if (result.isConfirmed) {
            const form = document.getElementById("delete-form")
            const deleteId = document.getElementById("delete-id")

            // Set ID to delete
            deleteId.value = id

            // Set form action
            form.action = action

            // Submit form
            form.submit()
        }
    });
}