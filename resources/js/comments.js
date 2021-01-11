module.exports = function (baseUri, name = '') {
    const drawer = document.createElement('div');
    drawer.classList.add('fixed', 'top-12', 'bottom-0', 'right-0', 'w-72', 'flex', 'flex-col', 'bg-gray-100', 'dark:bg-gray-800');
    document.body.append(drawer);
    const title = document.createElement('h4');
    title.classList.add('text-center', 'text-2xl');
    title.innerText = 'Comments';
    const scrollable = document.createElement('div');
    scrollable.classList.add('flex-1', 'overflow-y-auto');
    scrollable.append(title);
    drawer.append(scrollable);
    drawer.append(addCommentForm());
    
}

function addCommentForm(url, name = '') {
    const addComment = document.createElement('form');
    addComment.classList.add('h-48', 'p-1', 'border-t', 'border-gray-500');
    const nameInput = document.createElement('input');
    nameInput.type = 'text';
    nameInput.required = true;
    nameInput.placeholder = 'Your name';
    nameInput.value = name;
    nameInput.classList.add('w-full', 'mb-2')
    const commentBody = document.createElement('textarea');
    commentBody.required = true;
    commentBody.placeholder = 'Your comment';
    commentBody.rows = 3;
    commentBody.classList.add('w-full', 'resize-none', 'mb-1');
    const sendButton = document.createElement('button');
    sendButton.type = 'submit';
    sendButton.innerText = 'Send';
    sendButton.classList.add('btn', 'w-full')
    addComment.append(nameInput);
    addComment.append(commentBody);
    addComment.append(sendButton)
    return addComment;
}