document
    .addEventListener("DOMContentLoaded", () => {
        document.getElementById('intList')
            .addEventListener('click',
                function (e) {
                    removeFromList(e.target, 'int');
                }
        );

    document.getElementById('strList')
        .addEventListener('click',
            function (e) {
                    removeFromList(e.target, 'str');
            }
    );
});

function removeFromList(element, type) {
    let xhr = new XMLHttpRequest();
    const baseUrl = window.location.origin;
    const pathName = '/api/'.concat(type,'-remove/');
    const url = baseUrl.concat('', pathName, element.innerText);
    const method = 'DELETE';

    xhr.open(method, url, true);

    xhr.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            console.log(element.innerText.concat(' ', 'deleted'));
            element.remove();
        }
    }

    xhr.send();
}