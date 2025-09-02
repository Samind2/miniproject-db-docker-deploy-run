$.extend($.summernote.options, {
    codemirror: {
        theme: 'tomorrow-night-eighties',
        htmlMode: true,
        lineNumbers: true,
        lineWrapping: true
    },
    lang: 'th-TH',
    dialogsInBody: true,
    disableDragAndDrop: true,
    minHeight: '100px',
    height: '100px',
    toolbar: [
        ['font', ['bold','italic','underline','clear']],
        ['para', ['ul','ol']],
        ['table', ['table']],
        ['insert', ['link','video']],
        ['view', ['fullscreen']]
    ],
    callbacks: {
        onPaste: function(e) {
            const bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
            e.preventDefault();
            setTimeout(function() {
                document.execCommand('insertText', false, bufferText);
            }, 10);
        }
    }
});