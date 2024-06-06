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

// Search Book
async function searchBook() {
    const search = document.getElementById('title').value.toLowerCase()
    const suggestions = document.getElementById('books-suggestions')
    const coverColumn = document.getElementById('cover-column')
    const inputTitle = document.getElementById('title')
    const inputDescription = document.getElementById('description')
    const inputAuthor = document.getElementById('author')
    const inputPublisher = document.getElementById('publisher')
    const inputPublishedDate = document.getElementById('published_date')
    const inputRating = document.getElementById('rating')
    const inputPageCount = document.getElementById('page_count')
    const inputLanguage = $('#language')
    const inputIsbn = document.getElementById('isbn')
    const inputCoverFromApi = document.getElementById('coverFromApi')

    // If search is null reset all inputs and suggestions container
    if (search === '') {
        suggestions.innerHTML = ''
        coverColumn.value = ''
        inputTitle.value = ''
        inputDescription.value = ''
        inputAuthor.value = ''
        inputPublisher.value = ''
        inputPublishedDate.value = ''
        inputRating.value = ''
        inputPageCount.value = ''
        inputLanguage.val('').trigger('change')
        const errors = document.querySelectorAll('.error')
        errors.forEach(err => err.innerText = '')
        return
    }
    
    const res = await fetch(`https://www.googleapis.com/books/v1/volumes?q=${search}`)
    const data = await res.json()
    
    // Matches
    const books = data.items.filter(({ volumeInfo }) => {
        suggestions.innerHTML = ''
        return volumeInfo.title.toLowerCase().startsWith(search)
    })

    if (books.length > 0) {
        books.map(({ volumeInfo }) => {
            const title = volumeInfo.title.toLowerCase()
            const description = volumeInfo.description.substring(0, 255) ?? ''
            const author = Array.isArray(volumeInfo.authors) ? volumeInfo.authors[0] : volumeInfo.authors
            const language = volumeInfo.language ?? ''
            const publisher = volumeInfo.publisher ?? ''
            const publishedDate = volumeInfo.publishedDate ?? ''
            const pageCount = volumeInfo.pageCount
            const rating = volumeInfo.averageRating ?? ''
            const genre = Array.isArray(volumeInfo.categories) ? volumeInfo.categories[0] : volumeInfo.categories
            const cover = volumeInfo.imageLinks.thumbnail ?? ''
            const isbn = Array.isArray(volumeInfo.industryIdentifiers) ? volumeInfo.industryIdentifiers[0].identifier : volumeInfo.industryIdentifiers

            const book = document.createElement('p')
            book.role = 'button'
            book.innerHTML = title.replace(`${search}`, `<b>${search}</b>`)
            book.addEventListener('click', () => {
                console.log(volumeInfo)
                inputTitle.value = title
                inputDescription.value = description
                inputAuthor.value = author
                inputPublisher.value = publisher
                inputPublishedDate.value = publishedDate
                inputRating.value = rating ?? ''
                inputPageCount.value = pageCount ?? ''
                inputLanguage.val(language).trigger('change')

                // Hide input file if cover image comes from api
                if (cover !== null && search !== '') coverColumn.classList.add('d-none')
                else coverColumn.classList.remove('d-none')

                inputCoverFromApi.value = cover
                inputIsbn.value = isbn
                document.getElementById('available').focus()
                suggestions.innerHTML = ''
            })

            suggestions.appendChild(book)
        })
        
        console.log(suggestions)
    }
}
