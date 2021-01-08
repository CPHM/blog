window.showdown = require("./showdown.min");

window.initializeMdEditor = function (formId, editorId, previewDivId, hiddenInputId, previewBtnId, editBtnId) {

    showdown.setOption('emoji', true);
    showdown.setOption('tables', true);
    showdown.setOption('tasklists', true);
    showdown.setOption('strikethrough', true);
    showdown.setOption('simplifiedAutoLink', true);

    const form  = document.getElementById(formId);
    const editor = document.getElementById(editorId);
    const editBtn = document.getElementById(editBtnId);
    const previewBtn = document.getElementById(previewBtnId);
    const previewDiv = document.getElementById(previewDivId);
    const hiddenInput = document.getElementById(hiddenInputId);

    mountMarkdownEditorShortcuts(editor);
    mountMarkdownFormSubmitListener(form, editor, hiddenInput);
    attachPreviewFunctionsToWindow(editor, previewDiv, previewBtn, editBtn);
}

function mountMarkdownEditorShortcuts(editorElement) {
    editorElement.addEventListener('keydown', function (e) {
        if (e.key === 'Tab') {
            e.preventDefault();
            editorElement.value += "    ";
        } else if (e.key === 'Enter' && e.shiftKey) {
            e.preventDefault();
            editorElement.value += "\n<br />\n";
        }
    });
}

function mountMarkdownFormSubmitListener(formElement, editorElement, hiddenInput) {
    formElement.addEventListener('submit', function () {
        const markdown = editorElement.value;
        const converter = new showdown.Converter();
        hiddenInput.value = converter.makeHtml(markdown);
    })
}

function attachPreviewFunctionsToWindow(markdownEditor, previewDiv, previewOnBtn, previewOffBtn) {
    previewOnBtn.addEventListener('click', function () {
        const converter = new showdown.Converter();
        previewDiv.innerHTML = converter.makeHtml(markdownEditor.value);
        markdownEditor.classList.add('hidden');
        previewOnBtn.classList.add('hidden');
        previewDiv.classList.remove('hidden');
        previewOffBtn.classList.remove('hidden');
    });

    previewOffBtn.addEventListener('click', function () {
        previewDiv.classList.add('hidden');
        previewOffBtn.classList.add('hidden');
        markdownEditor.classList.remove('hidden');
        previewOnBtn.classList.remove('hidden');
    });
}
