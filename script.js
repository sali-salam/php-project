function searchMovie() {
    let query = document.getElementById('movieSearch').value;
    if (query.length < 1) {
        document.getElementById('searchResults').innerHTML = "";
        return;
    }

    // Correcting the URL by using backticks for string interpolation
    fetch(`search.php?title=${encodeURIComponent(query)}`)
        .then(response => response.text())
        .then(data => {
            document.getElementById('searchResults').innerHTML = data;
        })
        .catch(error => console.log(error));
}
