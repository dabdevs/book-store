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
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Borrowed Date - Due Date</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Return Date</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
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
                    render: function(data, type, row) {
                        const nameColumn = document.createElement('div')
                        nameColumn.classList.add('d-flex', 'flex-column', 'justify-content-center', 'text-truncate')

                        const title = document.createElement('h6')
                        title.classList.add('mb-0', 'text-sm')
                        title.innerText = row.title

                        const email = document.createElement('p')
                        email.classList.add('text-xs', 'text-secondary', 'mb-0')
                        email.innerText = row.email

                        nameColumn.appendChild(title)
                        nameColumn.appendChild(email)

                        return nameColumn
                    }
                },
                {
                    render: function(data, type, row, meta) {
                        const div = document.createElement('div')
                        const borrowDate = document.createElement('span')
                        const dueDate = borrowDate.cloneNode(true)
                        const upArrow = document.createElement('i')
                        const downArrow = upArrow.cloneNode(true)
                        upArrow.classList.add('material-icons', 'opacity-10', 'text-success')
                        upArrow.innerText = 'arrow_upward'
                        downArrow.classList.add('material-icons', 'opacity-10', 'text-danger')
                        downArrow.innerText = 'arrow_downward'

                        borrowDate.append(upArrow)
                        borrowDate.append(row.borrow_date)

                        dueDate.append(downArrow)
                        dueDate.append(row.due_date)

                        div.appendChild(borrowDate)
                        div.appendChild(document.createElement('br'))
                        div.appendChild(dueDate)

                        return div
                    }
                },
                {
                    render: function(data, type, row, meta) {
                        return row.return_date ?? 'N/A'
                    }
                },
                {
                    render: function(data, type, row, meta) {
                        let color = row.status === 'BORROWED' ? 'success' : 'danger'
                        let status = row.status

                        if (status === 'BORROWED' && Date.parse(row.due_date) < new Date()) {
                            status = 'OVERDUE'
                            color = 'warning'
                        }

                        status = (row.status === 'BORROWED' && Date.parse(row.due_date) < new Date()) ? 'OVERDUE' : row.status

                        return `<span class="w-100 badge badge-sm bg-gradient-${color}"> ${status} </span>`
                    }
                },
                {
                    render: function(data, type, row, meta) {
                        const div = document.createElement('div')
                        div.classList.add('align-middle', 'w-100', 'd-flex', 'gap-1', 'justify-content-around', 'mt-3')

                        const viewBtn = document.createElement('a')
                        viewBtn.classList.add('btn', 'btn-sm', 'btn-outline-primary', 'text-primary', 'font-weight-bold', 'text-xs')
                        viewBtn.innerHTML = '<i class="material-icons opacity-10 fs-5">edit</i>'
                        viewBtn.href = `/books/show?id=${row.id}`

                        const deleteBtn = viewBtn.cloneNode(true)
                        deleteBtn.innerHTML = '<i class="material-icons opacity-10 fs-5">delete</i>'

                        deleteBtn.addEventListener('click', function() {
                            deleteItem(`${row.id} - ${row.title}`, row.id, '/loans/delete')
                        })

                        div.appendChild(viewBtn)
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