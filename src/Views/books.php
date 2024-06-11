<div class="row my-4" style="overflow-x: hidden;">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="d-flex justify-content-between bg-gradient-primary shadow-primary border-radius-lg pt-4 p-3">
                    <h6 class="text-white text-capitalize mt-2">Books</h6>
                    <a class="btn btn-sm btn-white text-primary" href="/books/create">
                        <i class="material-icons opacity-10 fs-6">add_circle</i> Create
                    </a>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="table-responsive px-1">
                    <table id="books-table" class="table display align-items-center mb-0" id="books-table">
                        <input type="hidden" id="books-data" value="<?= htmlspecialchars(json_encode($books)) ?>">
                        <thead class="text-left">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">Code</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Title</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Author</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Genre</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Available</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Last Updated</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        const books = JSON.parse(document.getElementById('books-data').value);
        $('#books-table').DataTable({
            data: books,
            columns: [{
                    data: 'code'
                },
                {
                    render: function(data, type, row, meta) {
                        const container = document.createElement('div')
                        container.classList.add('d-flex', 'px-2', 'py-1')

                        const imgContainer = document.createElement('div')
                        const img = document.createElement('img')
                        img.src = row.cover
                        img.width = 40
                        img.classList.add('avatar', 'avatar-sm', 'me-3', 'border-radius-lg')
                        imgContainer.appendChild(img)

                        const textContainer = document.createElement('div')
                        textContainer.classList.add('d-flex', 'flex-column', 'justify-content-center')
                        textContainer.style.width = '180px'

                        const h6 = document.createElement('h6')
                        h6.classList.add('mb-0', 'text-sm', 'text-truncate')
                        h6.innerText = row.title

                        const p = document.createElement('p')
                        p.classList.add('text-xs', 'text-secondary', 'mb-0', 'text-truncate')
                        p.innerText = row.description ?? 'N/A'

                        textContainer.appendChild(h6)
                        textContainer.appendChild(p)

                        container.appendChild(imgContainer)
                        container.appendChild(textContainer)
                        return container
                    }
                },
                {
                    render: function(data, type, row, meta) {
                        const div = document.createElement('div')
                        div.classList.add('text-truncate')
                        div.style.width = '150px'
                        div.innerText = row.author ?? 'N/A'
                        return div
                    }
                },
                {
                    render: function(data, type, row, meta) {
                        const div = document.createElement('div')
                        div.classList.add('text-truncate')
                        div.style.width = '150px'
                        div.innerText = row.genre ?? 'N/A'
                        return div
                    }
                },
                {
                    data: 'available'
                },
                {
                    render: function(data, type, row, meta) {
                        return row.updated_at ?? 'N/A'
                    }
                },
                {
                    render: function(data, type, row, meta) {
                        const div = document.createElement('div')
                        div.classList.add('align-middle', 'w-100', 'd-flex', 'justify-content-around', 'mt-3')

                        const editBtn = document.createElement('a')
                        editBtn.classList.add('btn', 'btn-sm', 'btn-outline-primary', 'text-primary', 'font-weight-bold', 'text-xs')
                        const deleteBtn = editBtn.cloneNode(true)
                        editBtn.innerText = 'Edit'
                        editBtn.href = `/books/edit?id=${row.id}`
                        deleteBtn.innerText = 'Delete'

                        deleteBtn.addEventListener('click', function() {
                            deleteItem(`${row.title}`, row.id, '/books/delete')
                        })

                        div.appendChild(editBtn)
                        div.appendChild(deleteBtn)

                        return div
                    }
                },
            ],
            "iDisplayLength": 10, //Pagination
            "order": [
                [7, "DESC"]
            ]
        });
    })
</script>