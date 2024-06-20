$(window).keydown(function (event) {
    if (event.keyCode == 13) {
        event.preventDefault();
        return false;
    }
});

function validateInput(inputId) {
    const $input = document.getElementById(inputId)
    const $error = document.getElementById(inputId + '_error')

    if ($input.value === '') {
        $error.innerText = inputId + ' is required'
    } else {
        $error.innerText = ''
    }
}

function validateLoanForm() {
    const $loanForm = document.getElementById('loan-form')
    const $book_id = document.getElementById('book_id')
    const $book_id_error = document.getElementById('book_id_error')
    const $member = document.getElementById('member')
    const $member_error = document.getElementById('member_error')
    const $due_date = document.getElementById('due_date')
    const $due_date_error = document.getElementById('due_date_error')

    if ($book_id.value === '') {
        $book_id_error.innerText = 'Book is required'
        return
    }

    if ($member.value === '') {
        $member_error.innerText = 'Member is required'
        return
    }

    if ($due_date.value === '') {
        $due_date_error.innerText = 'Due date is required'
        return
    }

    $loanForm.submit()
}

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

// Capitalize sentence
function capitalize(str) {

    // Split the string into an array of words
    const words = str.split(' ');

    // Map over each word in the array and capitalize the first letter
    const capitalizedWords = words.map(word => {
        // Capitalize the first letter and add the rest of the lowercase letters
        return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
    });

    // Join the array of capitalized words back into a single string
    return capitalizedWords.join(' ');
}

// Activate form edition
function editForm() {
    const inputs = document.querySelectorAll('.form-value')
    inputs.forEach(input => {
        if (input.classList.contains('d-none')) {
            input.classList.remove('d-none')
        } else {
            input.classList.add('d-none')
        }
    })

    const texts = document.querySelectorAll('.plain-value')
    texts.forEach(text => {
        if (text.classList.contains('d-none')) {
            text.classList.remove('d-none')
        } else {
            text.classList.add('d-none')
        }
    })
}

// Search Book
async function searchBook() {
    const search = capitalize(document.getElementById('title').value)
    const suggestions = document.getElementById('books-suggestions')
    const inputTitle = document.getElementById('title')
    const inputDescription = document.getElementById('description')
    const inputAuthor = document.getElementById('author')
    const inputPublisher = document.getElementById('publisher')
    const inputPublishedDate = document.getElementById('published_date')
    const inputRating = document.getElementById('rating')
    const inputPageCount = document.getElementById('page_count')
    const inputLanguage = $('#language')
    const inputGenre = $('#genre')
    const inputIsbn = document.getElementById('isbn')
    const inputCover = document.getElementById('cover')

    // If search is null reset all inputs and suggestions container
    if (search === '') {
        suggestions.innerHTML = ''
        inputTitle.value = ''
        inputDescription.value = ''
        inputAuthor.value = ''
        inputPublisher.value = ''
        inputPublishedDate.value = ''
        inputRating.value = ''
        inputPageCount.value = ''
        inputIsbn.value = ''
        inputLanguage.val('').trigger('change')
        inputGenre.val('').trigger('change')
        const errors = document.querySelectorAll('.error')
        errors.forEach(err => err.innerText = '')
        return
    }

    const res = await fetch(`https://www.googleapis.com/books/v1/volumes?q=${search}`)
    const data = await res.json()

    // Matches
    const books = data.items.filter(({ volumeInfo }) => {
        suggestions.innerHTML = ''
        return capitalize(volumeInfo.title)?.includes(search)
    })

    if (books.length > 0) {
        books.map(({ volumeInfo }) => {
            const title = capitalize(volumeInfo.title).substring(0, 150)
            const description = volumeInfo.description?.substring(0, 255) ?? ''
            const author = Array.isArray(volumeInfo.authors) ? volumeInfo.authors[0] : ''
            const language = volumeInfo.language ?? ''
            const publisher = volumeInfo.publisher ?? 'N/A'
            const publishedDate = volumeInfo.publishedDate ?? ''
            const pageCount = volumeInfo.pageCount
            const rating = volumeInfo.averageRating ?? ''
            const genre = Array.isArray(volumeInfo.categories) ? volumeInfo.categories[0] : ''
            const cover = volumeInfo.imageLinks.thumbnail ?? 'https://placehold.co/40x40'
            const isbn = Array.isArray(volumeInfo.industryIdentifiers) ? volumeInfo.industryIdentifiers[0].identifier : ''

            const option = document.createElement('p')
            option.role = 'button'
            option.innerHTML = title.replace(`${search}`, `<b>${search}</b>`)
            option.addEventListener('click', () => {
                inputTitle.value = title
                inputDescription.value = description
                inputAuthor.value = author
                inputPublisher.value = publisher
                inputPublishedDate.value = publishedDate
                inputRating.value = rating ?? ''
                inputPageCount.value = pageCount ?? ''
                inputLanguage.val(language).trigger('change')
                const newGenre = $('<option></option>').val(genre).text(genre);
                inputGenre.append(newGenre).val(genre).trigger('change')
                inputCover.value = cover
                inputIsbn.value = isbn

                document.getElementById('available').focus()
                suggestions.innerHTML = ''
            })

            suggestions.appendChild(option)
        })
    }
}

// Search member by document ID or email
async function getMember(search) {
    if (search === '') return

    const $error = document.getElementById('member_error')
    const $member_id = document.getElementById('member_id')
    const $memberName = document.getElementById('member')
    const $inputBtn = document.getElementById('search-member-btn')

    // Clear input and reset search button
    if ($inputBtn.innerText === 'CLEAR') {
        $memberName.value = ''
        $inputBtn.innerText = 'SEARCH'
        $memberName.focus = true
        return
    }

    const res = await fetch(`/member?q=${search}`)
    const member = await res.json()

    if (member === null) {
        $error.innerText = 'Member not found'
    } else {
        $error.innerText = ''
        $member_id.value = member.id
        $memberName.value = `${member.firstname} ${member.lastname}`
        $inputBtn.innerText = 'Clear'
    }
}
