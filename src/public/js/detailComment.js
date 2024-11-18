document.querySelectorAll('#rating .star').forEach(function(star) {
    star.addEventListener('click', function() {
        var ratingValue = this.getAttribute('data-value');

        document.querySelectorAll('#rating .star').forEach(function(star) {
            star.classList.remove('selected');
        });

        document.querySelectorAll('#rating .star').forEach(function(star, index) {
            if (index < ratingValue) {
                star.classList.add('selected');
            }
        });

        document.getElementById('rating-input').value = ratingValue;
    });
});

function updateCharCount() {
    var content = document.getElementById('content').value;
    var charCount = content.length;
    document.getElementById('word-count').textContent = charCount + '/400(最大文字数)';
}

document.querySelector(".file-upload-placeholder").addEventListener("click", function() {
    document.getElementById("image").click();
});

document.getElementById("image").addEventListener("change", function(event) {
    var file = event.target.files[0];
    if (file) {
        console.log("選択したファイル:", file.name);
        document.querySelector(".file-upload-placeholder").textContent = file.name;
    }
});

document.querySelector(".file-upload").addEventListener("dragover", function(event) {
    event.preventDefault();
    this.style.borderColor = "#2a8dff";
});

document.querySelector(".file-upload").addEventListener("dragleave", function() {
    this.style.borderColor = "#ccc";
});


document.querySelector(".file-upload").addEventListener("drop", function(event) {
    event.preventDefault();
    this.style.borderColor = "#ccc";

    var file = event.dataTransfer.files[0];
    if (file) {
        console.log("ドロップされたファイル:", file.name);
        document.querySelector(".file-upload-placeholder").textContent = file.name;
    }
});