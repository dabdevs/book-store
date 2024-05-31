function deleteItem(title, id, action) {
    const form = document.getElementById("delete-form")
    const itemTitle = document.getElementById("item-title")
    itemTitle.innerText = title
    const deleteId = document.getElementById("delete-id")

    // Set ID to delete
    deleteId.value = id

    // Set form action
    form.action = action

    const modal = new bootstrap.Modal("#delete-form")

    modal.show()
}

// Adjust select2 inputs
$(document).ready(function () {
    $('.select2').each(function () {
        $(this).select2().data('select2').$selection.css({
            'height': '40px',
            'padding-top': '5px'
        });
    })
});
