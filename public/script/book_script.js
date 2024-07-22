document.addEventListener('DOMContentLoaded', () => {
    // Check if we are on the books page
    if (window.location.pathname.includes('/books')) {
        const params = new URLSearchParams(window.location.search);
        const category = params.get('category');        
        if (category) {
            fetchBooksByCategory(category);
        }
    }

    // Check if we are on the categories_page
    if (document.getElementById('categories_page')) {
        const category = '{{ $category }}'; // Replace with actual category variable

        if (category) {
            fetchBooksByCategory(category);
        }
    }
});

function fetchBooksByCategory(category) {
    const url = `/proxy/books?category=${encodeURIComponent(category)}`;

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (window.location.pathname.includes('/books')) {
                displayBooks(data.books, 'books');
            } else if (document.getElementById('categories_page')) {
                displayBooks(data.books, 'books-container');
            }
        })
        .catch(error => console.error('Error fetching data:', error));
}

function displayBooks(books) {
    const booksContainer = document.getElementById('books-container');
    if (!booksContainer) {
        console.error('Books container not found');
        return;
    }
    booksContainer.innerHTML = ''; // Clear previous books

    books.forEach(book => {
        const bookElement = document.createElement('div');
        bookElement.classList.add('item_cover', 'col-6', 'col-md-4', 'col-lg-3');
        bookElement.innerHTML = `
            <a href="${book.url}">
                <div class="item_single">
                    <div class="cover_frame">
                    </div>
                    <h2 class="title px-2">${book.title}</h2>
                </div>
            </a>
        `;
        booksContainer.appendChild(bookElement);
    });
}
