<div class="row my-4" style="overflow-x: hidden;">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="d-flex justify-content-between bg-gradient-primary shadow-primary border-radius-lg pt-4 p-3">
                    <h6 class="text-white text-capitalize mt-2">Loans</h6>
                    <a class="btn btn-sm btn-white text-primary" href="/loans/create">
                        <i class="material-icons opacity-10 fs-6">add_circle</i> Create
                    </a>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="table-responsive px-2">
                    <table id="loans-table" class="table display align-items-center mb-0">
                        <input type="hidden" id="loans-data" value="<?= htmlspecialchars(json_encode($loans)) ?>">
                        <thead class="text-left">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">ID</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">Book</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">User</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Borrowed Date</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Return Date</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
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
        const loans = JSON.parse(document.getElementById('loans-data').value);
        $('#loans-table').DataTable({
            data: loans,
            columns: [{
                    data: 'id'
                },
                {
                    data: 'title'
                },
                {
                    render: function(data, type, row) {
                        return `${row.email} - ${row.lastname}`
                    }
                },
                {
                    data: 'borrow_date'
                },
                {
                    data: 'return_date'
                },
                {
                    data: 'status'
                },
                {
                    data: 'updated_at'
                },
                {
                    render: function(data, type, row, meta) {
                        const div = document.createElement('div')
                        div.classList.add('align-middle', 'w-100', 'd-flex', 'justify-content-around', 'mt-3')

                        const editBtn = document.createElement('a')
                        editBtn.classList.add('btn', 'btn-sm', 'btn-outline-primary', 'text-primary', 'font-weight-bold', 'text-xs')
                        const deleteBtn = editBtn.cloneNode(true)
                        editBtn.innerText = 'Edit'
                        editBtn.href = `/loans/edit?id=${row.id}`
                        deleteBtn.innerText = 'Delete'

                        deleteBtn.addEventListener('click', function() {
                            deleteItem(`${row.id} - ${row.title}`, row.id, '/loans/delete')
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