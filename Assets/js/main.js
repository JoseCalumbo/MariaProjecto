(function main(win, doc) {

    //get da tag img
    let img = doc.querySelector('.foto')

    // get do input file
    let input = doc.querySelector('#img')

    // evento para preview de uma imagem 
    input.addEventListener('change', preview, false);

    // metodo para fazer um preview de imagem 
    function preview(event) {
        img.innerHTML = '';
        let files = event.target.files;
        for (let i = 0; i < files.length; i++) {

            let reader = new FileReader();
            reader.onload = function (event) {
                let urlImg = event.target.result
                img.setAttribute("src", urlImg)
            }
            reader.readAsDataURL(files[i])
        }
    }

})(window, document)