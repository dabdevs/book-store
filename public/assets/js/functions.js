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
