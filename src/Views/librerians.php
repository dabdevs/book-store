<div class="row my-4" style="overflow-x: hidden;">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="d-flex justify-content-between bg-gradient-primary shadow-primary border-radius-lg pt-4 p-3">
                    <h6 class="text-white text-capitalize mt-2">Librerians</h6>
                    <a class="btn btn-sm btn-white text-primary" href="/librerians/create">
                        <i class="material-icons opacity-10 fs-6">add_circle</i> Create
                    </a>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="table-responsive px-2">
                    <table id="librerians-table" class="table display align-items-center mb-0">
                        <input type="hidden" id="librerians-data" value="<?= htmlspecialchars(json_encode($librerians)) ?>">
                        <thead class="text-left">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Birth Date</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date Created</th>
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
        const librerians = JSON.parse(document.getElementById('librerians-data').value);

        $('#librerians-table').DataTable({
            data: librerians,
            columns: [{
                    render: function(data, type, row) {
                        const nameColumn = document.createElement('div')
                        nameColumn.classList.add('d-flex', 'flex-column', 'justify-content-center')

                        const fullName = document.createElement('h6')
                        fullName.classList.add('mb-0', 'text-sm')
                        fullName.innerText = `${row.firstname} ${row.lastname}`

                        const email = document.createElement('p')
                        email.classList.add('text-xs', 'text-secondary', 'mb-0')
                        email.innerText = row.email

                        nameColumn.appendChild(fullName)
                        nameColumn.appendChild(email)

                        return nameColumn
                    }
                },
                {
                    data: 'birth_date'
                },
                {
                    data: 'role'
                },
                {
                    data: 'created_at'
                },
                {
                    render: function(data, type, row, meta) {
                        return row.updated_at ?? 'N/A'
                    }
                },
                {
                    render: function(data, type, row, meta) {
                        const div = document.createElement('div')
                        div.classList.add('align-middle', 'w-100', 'd-flex', 'gap-1', 'justify-content-around', 'mt-3')

                        const viewBtn = document.createElement('a')
                        viewBtn.classList.add('btn', 'btn-sm', 'btn-outline-primary', 'text-primary', 'font-weight-bold', 'text-xs')
                        viewBtn.innerHTML = '<i class="material-icons opacity-10 fs-5">visibility</i>'
                        viewBtn.href = `/librerians/show?id=${row.id}`

                        const deleteBtn = viewBtn.cloneNode(true)
                        deleteBtn.innerHTML = '<i class="material-icons opacity-10 fs-5">delete</i>'

                        deleteBtn.addEventListener('click', function() {
                            deleteItem(`${row.title}`, row.id, '/librerians/delete')
                        })

                        div.appendChild(viewBtn)
                        div.appendChild(deleteBtn)

                        return div
                    }
                },
            ],
            "autoWidth": true,
            "iDisplayLength": 10, //Pagination
            "order": [
                [5, "DESC"]
            ]
        });
    })
</script>