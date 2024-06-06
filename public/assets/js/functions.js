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

    if (search === '') {
        suggestions.innerHTML = ''
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
            const description = volumeInfo.description
            const author = volumeInfo.authors[0]
            const language = volumeInfo.language
            const publisher = volumeInfo.publisher
            const publishedDate = volumeInfo.publishedDate
            const rating = volumeInfo.averageRating
            const genre = Array.isArray(volumeInfo.categories) ? volumeInfo.categories[0] : volumeInfo.categories
            const cover = volumeInfo.imageLinks.thumbnail
            const isbn = Array.isArray(volumeInfo.industryIdentifiers) ? volumeInfo.industryIdentifiers[0].identifier : volumeInfo.industryIdentifiers

            const book = document.createElement('p')
            book.role = 'button'
            book.innerHTML = title.replace(`${search}`, `<b>${search}</b>`)
            book.addEventListener('click', () => {
                console.log(volumeInfo)
                document.getElementById('title').value = title
                document.getElementById('description').value = description
                document.getElementById('author').value = author
                document.getElementById('publisher').value = publisher
                document.getElementById('published_date').value = publishedDate
                document.getElementById('rating').value = rating ?? ''
                document.getElementById('coverFromApi').value = cover
                document.getElementById('isbn').value = isbn
                suggestions.innerHTML = ''
            })
            suggestions.appendChild(book)
        })
        
        console.log(suggestions)
    }
}
