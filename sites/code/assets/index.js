(function () {
    'use strict';

    const mainImg = document.getElementsByClassName('main-img')[0];
    const thumbItemImgs = document.getElementsByClassName('thumb-item-img');

    [...thumbItemImgs].forEach(thumbItemImg => {
        thumbItemImg.onmouseover = (e) => {
            const newImgSrc = e.currentTarget.getAttribute('src');
            mainImg.setAttribute('src', newImgSrc);
            document.getElementsByClassName('is-active')[0].classList.remove('is-active');
            e.currentTarget.classList.add('is-active');
        };
    });

    var inputLocalFont = document.getElementById("file");
    inputLocalFont.addEventListener("change",previewImages,false);

    function previewImages(){
        var fileList = this.files;
        var anyWindow = window.URL || window.webkitURL;
        for(var i = 0; i < fileList.length; i++){
            var objectUrl = anyWindow.createObjectURL(fileList[i]);
            $('#imagePreview').append('<img src="' + objectUrl + '" />');
            window.URL.revokeObjectURL(fileList[i]);
        }
    }

    $('#imagePreview').on('click', 'img', function() {
        var images = $('#imagePreview img').removeClass('selected'),
            img = $(this).addClass('selected');
        
        $('#thumbnail').val(images.index(img));
    });
})();
