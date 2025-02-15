import Quill from "quill";
import ResizeModule from "@ssumo/quill-resize-module";

// Quill.register("modules/resize", ResizeModule);
// Quill.register("modules/resize", QuillResizeModule);
Quill.register("modules/imageResize", ResizeModule);
// Quill.register("modules/imageResize", QuillResizeModule);


var toolbarOptions = [
    ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
    ['blockquote', 
        // 'code-block'
    ],
    ['link', 
        'image', 
        // 'video', 
        // 'formula'
    ],
  
    [{ 'header': 1 }, { 'header': 2 }],               // custom button values
    [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
    [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
    [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
    // [{ 'direction': 'rtl' }],                         
  
    [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
  
    [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
    // [{ 'font': [] }],
    [{ 'align': [] }],
  
    ['clean']                                         // remove formatting button
];

Alpine.data('quillEditor', (el, wire, wireModel) => {
    var quill = new Quill(el, {
        modules: {
            toolbar: toolbarOptions,
            imageResize: {
                
            }
        },
        theme: 'snow',
    });

    let previousImages = [];

    quill.root.innerHTML = wire.get(wireModel);

    quill.getModule('toolbar').addHandler('image', function () {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/png, image/jpeg');
        input.click();
  
        input.onchange = function () {
            var file = input.files[0];

            if (file) {
                var reader = new FileReader();
  
                reader.onload = function(event) {
                    var base64Data = event.target.result;

                    wire.uploadImage(base64Data);
                };

                reader.readAsDataURL(file);
            }
        };
    });
  
    quill.on('text-change', function(delta, oldDelta, source) {
        var currentImages = [];
  
        var container = quill.container.firstChild;
  
        container.querySelectorAll('img').forEach(function(img) {
            currentImages.push(img.src);
        });
  
        var removedImages = previousImages.filter(function(image) {
            return !currentImages.includes(image);
        });
  
        removedImages.forEach(function(image) {
            wire.deleteImage(image);

            // console.log('Image removed:', image);
        });
  
        previousImages = currentImages;
        // console.log(quill.root.innerHTML);
        wire.set(wireModel, quill.root.innerHTML);
    });
  
    Livewire.on('imageUploaded', function(imagePaths) {
        if (Array.isArray(imagePaths) && imagePaths.length > 0) {
            var imagePath = imagePaths[0];
            console.log('Received imagePath:', imagePath);

            if (imagePath && imagePath.trim() !== '') {
                var range = quill.getSelection(true);
                quill.insertText(range ? range.index : quill.getLength(), '\n', 'user');
                quill.insertEmbed(range ? range.index + 1 : quill.getLength(), 'image', imagePath);
            } else {
                console.warn('Received empty or invalid imagePath');
            }
        } else {
            console.warn('Received empty or invalid imagePaths array');
        }
    });
});